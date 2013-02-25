<?php
/**
 * This class allows a user to upload and
 * validate their files.
 *
 * @author John Ciacia <Sidewinder@extreme-hq.com>
 * @version 1.0
 * @copyright Copyright (c) 2007, John Ciacia
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class aUpload
{
    /**
     *@var string contains the name of the file to be uploaded.
     */
    public $FileName;
    /**
     *@var string contains the temporary name of the file to be uploaded.
     */
    public $TempFileName;
    /**
     *@var string contains directory where the files should be uploaded.
     */
    public $UploadDirectory;
    /**
     *@var string contains an array of valid extensions which are allowed to be uploaded.
     */
    public $ValidExtensions;
    /**
     *@var string contains a message which can be used for debugging.
     */
    public $Message;
    /**
     *@var integer contains maximum size of fiels to be uploaded in bytes.
     */
    public $MaximumFileSize;
    /**
     *@var bool contains whether or not the files being uploaded are images.
     */
    public $IsImage;
    /**
     *@var string contains the email address of the recipient of upload logs.
     */
    public $Email;
    /**
     *@var integer contains maximum width of images to be uploaded.
     */
    public $MaximumWidth;
    /**
     *@var integer contains maximum height of images to be uploaded.
     */
    public $MaximumHeight;

    public function Upload()
    {

    }

    /**
     *@method bool ValidateExtension() returns whether the extension of file to be uploaded
     *    is allowable or not.
     *@return true the extension is valid.
     *@return false the extension is invalid.
     */
    public function ValidateExtension()
    {

        $FileName = trim($this->FileName);
        $FileParts = pathinfo($FileName);
        $Extension = strtolower($FileParts['extension']);
        $ValidExtensions = $this->ValidExtensions;

        if (!$FileName) {
            $this->SetMessage("ERROR: File name is empty.");

            return false;
        }

        if (!$ValidExtensions) {
            $this->SetMessage("WARNING: All extensions are valid.");

            return true;
        }

        if (in_array($Extension, $ValidExtensions)) {
            $this->SetMessage("MESSAGE: The extension '$Extension' appears to be valid.");

            return true;
        } else {
            $this->SetMessage("Error: The extension '$Extension' is invalid.");

            return false;
        }

    }

    /**
     *@method bool ValidateSize() returns whether the file size is acceptable.
     *@return true the size is smaller than the alloted value.
     *@return false the size is larger than the alloted value.
     */
    public function ValidateSize()
    {
        $MaximumFileSize = $this->MaximumFileSize;
        $TempFileName = $this->GetTempName();
        $TempFileSize = filesize($TempFileName);

        if ($MaximumFileSize == "") {
            $this->SetMessage("WARNING: There is no size restriction.");

            return true;
        }

        if ($MaximumFileSize <= $TempFileSize) {
            $this->SetMessage("ERROR: The file is too big. It must be less than $MaximumFileSize and it is $TempFileSize.");

            return false;
        }

        $this->SetMessage("Message: The file size is less than the MaximumFileSize.");

        return true;
    }

    /**
     *@method bool ValidateExistance() determins whether the file already exists. If so, rename $FileName.
     *@return true can never be returned as all file names must be unique.
     *@return false the file name does not exist.
     */
    public function ValidateExistance()
    {
        $FileName = $this->FileName;
        $UploadDirectory = $this->UploadDirectory;
        $File = $UploadDirectory . $FileName;

        if (file_exists($File)) {
            $this->SetMessage("Message: The file '$FileName' already exist.");
            $UniqueName = rand() . $FileName;
            $this->SetFileName($UniqueName);
            $this->ValidateExistance();
        } else {
            $this->SetMessage("Message: The file name '$FileName' does not exist.");

            return false;
        }
    }

    /**
     *@method bool ValidateDirectory()
     *@return true the UploadDirectory exists, writable, and has a traling slash.
     *@return false the directory was never set, does not exist, or is not writable.
     */
    public function ValidateDirectory()
    {
        $UploadDirectory = $this->UploadDirectory;

        if (!$UploadDirectory) {
            $this->SetMessage("ERROR: The directory variable is empty.");

            return false;
        }

        if (!is_dir($UploadDirectory)) {
            $this->SetMessage("ERROR: The directory '$UploadDirectory' does not exist.");

            return false;
        }

        if (!is_writable($UploadDirectory)) {
            $this->SetMessage("ERROR: The directory '$UploadDirectory' does not writable.");

            return false;
        }

        if (substr($UploadDirectory, -1) != "/") {
            $this->SetMessage("ERROR: The traling slash does not exist.");
            $NewDirectory = $UploadDirectory . "/";
            $this->SetUploadDirectory($NewDirectory);
            $this->ValidateDirectory();
        } else {
            $this->SetMessage("MESSAGE: The traling slash exist.");

            return true;
        }
    }

    /**
     *@method bool ValidateImage()
     *@return true the image is smaller than the alloted dimensions.
     *@return false the width and/or height is larger then the alloted dimensions.
     */
    public function ValidateImage()
    {
        $MaximumWidth = $this->MaximumWidth;
        $MaximumHeight = $this->MaximumHeight;
        $TempFileName = $this->TempFileName;

    if ($Size = @getimagesize($TempFileName)) {
        $Width = $Size[0];   //$Width is the width in pixels of the image uploaded to the server.
        $Height = $Size[1];  //$Height is the height in pixels of the image uploaded to the server.
    }

        if ($Width > $MaximumWidth) {
            $this->SetMessage("The width of the image [$Width] exceeds the maximum amount [$MaximumWidth].");

            return false;
        }

        if ($Height > $MaximumHeight) {
            $this->SetMessage("The height of the image [$Height] exceeds the maximum amount [$MaximumHeight].");

            return false;
        }

        $this->SetMessage("The image height [$Height] and width [$Width] are within their limitations.");

        return true;
    }

    /**
     *@method bool SendMail() sends an email log to the administrator
     *@return true the email was sent.
     *@return false never.
     *@todo create a more information-friendly log.
     */
    public function SendMail()
    {
        $To = $this->Email;
        $Subject = "File Uploaded";
        $From = "From: Uploader";
        $Message = "A file has been uploaded.";
        mail($To, $Subject, $Message, $From);

        return true;
    }

    /**
     *@method bool UploadFile() uploads the file to the server after passing all the validations.
     *@return true the file was uploaded.
     *@return false the upload failed.
     */
    public function UploadFile()
    {

        if (!$this->ValidateExtension()) {
            die($this->GetMessage());
        } elseif (!$this->ValidateSize()) {
            die($this->GetMessage());
        } elseif ($this->ValidateExistance()) {
            die($this->GetMessage());
        } elseif (!$this->ValidateDirectory()) {
            die($this->GetMessage());
        } elseif ($this->IsImage && !$this->ValidateImage()) {
            die($this->GetMessage());
        } else {

            $FileName = $this->FileName;
            $TempFileName = $this->TempFileName;
            $UploadDirectory = $this->UploadDirectory;

            if (is_uploaded_file($TempFileName)) {
                move_uploaded_file($TempFileName, $UploadDirectory . $FileName);

                return true;
            } else {
                return false;
            }

        }

    }

    #Accessors and Mutators beyond this point.
    #Siginificant documentation is not needed.
    public function SetFileName($argv)
    {
        $this->FileName = $argv;
    }

    public function SetUploadDirectory($argv)
    {
        $this->UploadDirectory = $argv;
    }

    public function SetTempName($argv)
    {
        $this->TempFileName = $argv;
    }

    public function SetValidExtensions($argv)
    {
        $this->ValidExtensions = $argv;
    }

    public function SetMessage($argv)
    {
        $this->Message = $argv;
    }

    public function SetMaximumFileSize($argv)
    {
        $this->MaximumFileSize = $argv;
    }

    public function SetEmail($argv)
    {
        $this->Email = $argv;
    }

    public function SetIsImage($argv)
    {
        $this->IsImage = $argv;
    }

    public function SetMaximumWidth($argv)
    {
        $this->MaximumWidth = $argv;
    }

    public function SetMaximumHeight($argv)
    {
        $this->MaximumHeight = $argv;
    }
    public function GetFileName()
    {
        return $this->FileName;
    }

    public function GetUploadDirectory()
    {
        return $this->UploadDirectory;
    }

    public function GetTempName()
    {
        return $this->TempFileName;
    }

    public function GetValidExtensions()
    {
        return $this->ValidExtensions;
    }

    public function GetMessage()
    {
        if (!isset($this->Message)) {
            $this->SetMessage("No Message");
        }

        return $this->Message;
    }

    public function GetMaximumFileSize()
    {
        return $this->MaximumFileSize;
    }

    public function GetEmail()
    {
        return $this->Email;
    }

    public function GetIsImage()
    {
        return $this->IsImage;
    }

    public function GetMaximumWidth()
    {
        return $this->MaximumWidth;
    }

    public function GetMaximumHeight()
    {
        return $this->MaximumHeight;
    }
}
