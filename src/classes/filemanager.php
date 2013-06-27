<?php
/**
 * Class to handle some file management functions
 * @author Paul Scott
 * @version 0.9
 * @package filemanager
 */
class c_fm
{
    /**
      * Recursive version of glob
      * @return array containing all pattern-matched files.
      * @param string $sDir      Directory to start with.
      * @param string $sPattern  Pattern to glob for.
      * @param int $nFlags      Flags sent to glob.
      */

     private $_path = "";

    // Default excluded files, dir and extension
    private $_exclude_extension = array('entries', 'all-wcprops', 'DS_Store');
    private $_exclude_file = array('.DS_Store', 'all-wcprops', 'DS_Store');
    private $_exclude_dir = array('.svn', 'all-wcprops', 'DS_Store');

    /********************* CONSTRUCT *********************/

    /**
     * Constructor
     *
     * @access public
     * @return void
     */
    public function __construct($path = null)
    {
        if ($path) {
            $this->setPath($path);
        }

        return $this;
    }

    public function __get($file)
    {
        $file = $this->_path.DS.$file;

        return new m_fileExplorer($file);

    }

    /********************* PRIVATE *********************/

        /**
     * Get extension from a string
     *
     * @access private
     * @param  string $file
     * @return string
     */
    private function getExtension($file)
    {
        $parts = explode(".", $file);

        return end($parts);
    }

    /**
     * Sort an arry based on the strings length
     *
     * @access private
     * @param  string $val_1
     * @param  string $val_2
     * @return int
     */
    private function lengthSort($val_1, $val_2)
    {
        // initialize the return value to zero
        $retVal = 0;

        // compare lengths
        $firstVal = strlen($val_1);
        $secondVal = strlen($val_2);

        if ($firstVal > $secondVal) {
            $retVal = 1;
        } elseif ($firstVal < $secondVal) {
            $retVal = -1;
        }

        return $retVal;

    }

    /********************* PUBLIC **********************/

    /**
     * Set the explorer path
     *
     * @access public
     * @param  string $path
     * @return void
     */
    public function setPath($path="")
    {
        if ($path != "") {
            $this->_path = str_replace("\\", DS, $path);
            $this->_path = (substr($this->_path, -1) == DS) ? substr($this->_path, 0, -1) : $this->_path;
        }
    }

    /**
     * Read file content
     *
     * @access public
     * @param  string $filename
     * @return string
     */
    public function read()
    {
        $handle = fopen($this->_path, "r");
        $contents = fread($handle, filesize($this->_path));
        fclose($handle);

        return $contents;
    }

    /**
     * Write content to file
     *
     * @access public
     * @param  string $filename
     * @param  string $data
     * @return bool
     */
    public function save($data)
    {
        if ($handle = fopen($this->_path,"w")) {
            fwrite($handle, $data);
            fclose($handle);

            return true;
        }

        return false;
    }

    /**
     * Create file
     *
     * @access public
     * @param  bool $is_dir
     * @param  bool $create_if_exists If true existing file is overwrited
     * @return bool
     */
    public function create($is_dir=false, $create_if_exists=false)
    {
        if(file_exists($this->_path) && !$create_if_exists) return false;
        if (!$is_dir) {
            $parts = explode(DS, $this->_path);
            $path = "";
            foreach ($parts as $part) {
                if($part == end($parts)) break;
                $path .= $part . DS;
                @mkdir($path, "0700");
            }
            if ($handle = fopen($this->_path, 'w')) {
                fclose($handle);
            }
        } else {
            $parts = explode(DS, $this->_path);
            $path = "";
            foreach ($parts as $part) {
                $path .= $part . DS;
                @mkdir($path, "0700");
            }
        }

        return file_exists($this->_path);
    }

    /**
     * Delete a file or directory
     *
     * @access public
     * @return bool
     */
    public function delete()
    {
        if (is_dir($this->_path) && $this->_path != "") {
            $result = $this->scan();

            // Bring maps to back
            // This is need otherwise some maps
            // can't be deleted
            $sort_result = array();
            foreach ($result as $item) {
                if ($item['type'] == "file") {
                    array_unshift($sort_result, $item);
                } else {
                    $sort_result[] = $item;
                }
            }

            // Start deleting
            while (file_exists($this->_path)) {
                if (is_array($sort_result)) {
                    foreach ($sort_result as $item) {
                        if ($item['type'] == "file") {
                            @unlink($item['fullpath']);
                        } else {
                            @rmdir($item['fullpath']);
                        }
                    }
                }
                @rmdir($this->_path);
            }

            return !file_exists($this->_path);
        } else {
            @unlink($this->_path);

            return !file_exists($this->_path);
        }
    }

    /**
     * Copy directory's or files
     *
     * @access public
     * @param  string $destination
     * @return bool
     */
    public function copy($destination)
    {
        if($destination == "") throw new Exception("Destination is not specified.");

        $destination = str_replace("\\", DS, $destination);
        $destination = (substr($destination, -1) == DS) ? substr($destination, 0, -1) : $destination;
        if (is_dir($this->_path)) {

            // Create paths recursively
            $result = $this->scan();
            $paths = array();
            $files = array();
            foreach ($result as $item) {
                if ($item["type"] == "dir") {
                    $paths[] = str_replace($this->_path, "", $item['fullpath']);
                } else {
                    $file = str_replace($this->_path, "", $item['fullpath']);
                    $files[] = (substr($file, 0, 1) == DS) ? $file : DS . $file;
                }
            }
            uasort($paths, array($this, "lengthSort"));

            // Create directory structure
            foreach ($paths as $path) {
                $path = (substr($path, 0, 1) == DS) ? $path : DS . $path;
                $new_directory = $destination . $path;
                @mkdir($destination);
                if (!file_exists($new_directory)) {
                    @mkdir($new_directory, "0700");
                }
            }

            // Copy files
            foreach ($files as $file) {
                @copy($this->_path . $file, $destination . $file);
            }

            return file_exists($destination);
        } else {
            @copy($this->_path, $destination);

            return file_exists($destination);
        }

    }

    /**
     * Move directory or file
     *
     * @access public
     * @param string $destination
     * @access void
     */
    public function move($destination)
    {
        $this->Copy($destination);
        $this->Delete();

        return (file_exists($destination) && !file_exists($this->_path));
    }

    /**
     * List directory content
     *
     * @access public
     * @param  array $exclude
     * @param  bool  $recursive
     * @return array
     */
    public function scan($context = true, &$list=array(), $exclude_extension = array(), $exclude_file=array(), $exclude_dir=array(),   $dir="")
    {
        if (is_array($context)) {
            foreach ($context as $key=>$item) {
                ${$key} = $item;
            }
        } else {
            $recursive = $context;
        }

        if(!$exclude_extension) $exclude_extension = $this->_exclude_extension;
        if(!$exclude_file) $exclude_file = $this->_exclude_file;
        if(!$exclude_dir) $exclude_dir = $this->_exclude_dir;

        // Lowercase exclude arrays
        $exclude_extension = array_map("strtolower", $exclude_extension);
        $exclude_file = array_map("strtolower", $exclude_file);
        $exclude_dir = array_map("strtolower", $exclude_dir);

        $dir = ($dir == "") ? $this->_path : $dir;
        if(substr($dir, -1) != DS) $dir .= DS;

        // Open the folder
        $dir_handle = @opendir($dir) or die("Unable to open $dir");

        // Loop through the files
        while ($file = readdir($dir_handle)) {

            // Strip dir pointers and extension exclude
            $extension = $this->getExtension($file);
            if($file == "." || $file == ".." || in_array($extension, $exclude_extension)) continue;

            if (is_dir($dir . $file)) {
                if (!in_array(strtolower($file), $exclude_dir)) {
                    $info				= "";
                    $info["type"]		= "dir";
                    $info["path"]		= $dir;
                    $info["fullpath"]	= $dir . $file;
                    $info["folder"]	= str_replace($dir, '', $info["fullpath"]);
                    $list[] = $info;
                }
            } else {
                if (!in_array(strtolower($file), $exclude_file)) {
                    $info				= "";
                    $info["extension"] = $extension;
                    $info["type"]		= "file";
                    $info["path"]		= $dir;
                    $info["filename"]	= $file;
                    $info["fullpath"]	= $dir . $file;
                    $list[] = $info;
                }
            }

            if ($recursive && is_dir($dir . $file) && !in_array(strtolower($file), $exclude_dir)) {
                $this->scan($recursive, $list, $exclude_extension, $exclude_file, $exclude_dir, $dir . $file);
            }

        }

        // Close
        closedir($dir_handle);

        return $list;

    }

    /**
     * List directory content
     *
     * @access public
     * @param  array $exclude
     * @param  bool  $recursive
     * @return array
     */
    public function scan_only($extension=array(), $file=array(), $dir=array(), $recursive=true, &$list=array(), $dir="")
    {
        // Lowercase exclude arrays
        $extension = array_map("strtolower", $extension);
        $file = array_map("strtolower", $file);
        $dir = array_map("strtolower", $dir);

        $dir = ($dir == "") ? $this->_path : $dir;
        if(substr($dir, -1) != DS) $dir .= DS;

        // Open the folder
        $dir_handle = @opendir($dir) or die("Unable to open $dir");

        // Loop through the files
        while ($file = readdir($dir_handle)) {

            // Strip dir pointers and extension exclude
            $extension = $this->getExtension($file);
            if($file == "." || $file == ".." || in_array($extension, $extension)) continue;

            if (is_dir($dir . $file)) {
                if (in_array(strtolower($file), $dir)) {
                    $info				= "";
                    $info["type"]		= "dir";
                    $info["path"]		= $dir;
                    $info["fullpath"]	= $dir . $file;
                    $list[] = $info;
                }
            } else {
                if (in_array(strtolower($file), $file)) {
                    $info				= "";
                    $info["extension"] = $extension;
                    $info["type"]		= "file";
                    $info["path"]		= $dir;
                    $info["filename"]	= $file;
                    $info["fullpath"]	= $dir . $file;
                    $list[] = $info;
                }
            }

            if ($recursive && is_dir($dir . $file) && in_array(strtolower($file), $dir)) {
                $this->scan($recursive, $list, $extension, $file, $dir, $dir . $file);
            }

        }

        // Close
        closedir($dir_handle);

        return $list;

    }

    /**
     * Get extension of a file
     *
     * @access public
     * @return string
     */
    public function get_extension()
    {
        if (!is_dir($this->_path)) {
            return $this->getExtension($this->_path);
        }

        return false;
    }

     public static function getInfo($c = '')
     {
         $aInfo = array(
                          'Name'=>"A FileManager"
                         ,'Description' => "Class to handle some file management functions"
                         ,'Author' => "Paul Scott"
                         ,'Filename' => __FILE__
                         ,'Licence' => "GPL"
                     );

         if(!empty($c))	return $aInfo[$c];

         return $aInfo;
     }

     public static function find($path, $pattern = '*', $flags = 0, $depth = 0)
     {
         self::globf($path, $pattern, $flags, $depth);
     }

     public static function findIn($path, $c = null)
     {
        $result = null;
        if(!is_array($c)) $c = json_decode($c, TRUE);

        $flags = GLOB_BRACE;

        $add = '*';

        $ext = '';

        if(!empty($c['pattern']))	$add = $c['pattern'];

        if(!empty($c['dir']))	$path = $c['dir'] . '/';

        if(!empty($c['type']))	$ext = '.'.$c['type'];

        $pattern = $add.$ext;

        $query = str_replace('//','/', $path.$pattern);

        $query = str_replace('//','/', $query);

        if (!empty($c['recursive'])) {
         foreach (glob($path.'*', GLOB_ONLYDIR) as $dir) {
             foreach (glob($dir.$pattern) as $file) {
                 $result[]= ($file);
             }
         }
        } else
         $result = glob($query);

        if (isset($c['debug'])) {
         $d['context'] = $c;
         $d['path'] = $query;
         $d['result'] = $result;
         pre($d);
        }
        //pre($result);
        return $result;
   }

   public static function findrIn($path, $c = null)
   {
       if(!is_array($c)) $c = json_decode($c, TRUE);

       $c['recursive'] = true;

       return self::findIn($path, $c);
   }

    public static function globf($path, $pattern = '*', $flags = 0, $depth = 0)
    {
        $matches = array();
        $folders = array(rtrim($path, DS));

        while ($folder = array_shift($folders)) {
            $matches = array_merge($matches, glob($folder.DS.$pattern, $flags));
            if ($depth != 0) {
                $moreFolders = glob($folder.DS.'*', GLOB_ONLYDIR);
                $depth   = ($depth < -1) ? -1: $depth + count($moreFolders) - 2;
                $folders = array_merge($folders, $moreFolders);
            }
        }

        return $matches;
   }

    public static function globr($sDir , $sPattern, $nFlags = NULL, $depth = 0)
    {
        $sDir = escapeshellcmd($sDir);
        // Get the list of all matching files currently in the
        // directory.
        $aFiles = glob("$sDir/$sPattern", $nFlags);
        // Then get a list of all directories in this directory, and
        // run ourselves on the resulting array.  This is the
        // recursion step, which will not execute if there are no
        // directories.
        foreach (@glob("$sDir/*", GLOB_ONLYDIR) as $sSubDir) {
            $aSubFiles = self::globr($sSubDir, $sPattern, $nFlags);
            $aFiles = array_merge($aFiles, $aSubFiles);
        }
        // The array we return contains the files we found, and the
        // files all of our children found.
        return $aFiles;
    }//end function

    /**
     * Method to get the parent directory
     * @param void
     * @return the full path to the parent dir
     */
    public static function parentDir()
    {
        $parentDir = join(array_slice(split( DS ,dirname($_SERVER['PHP_SELF'])),0,-1),DS).'/';

        return $parentDir;
    }

    public static function filterRoot($element)
    {
        if(in_array($a))

         return false;
        else
         return true;
    }

    /**
     * Method to change the mode of a file or directory
     * @param mixed $file
     * @param int   $octal
     * @example $this->changeMode('/var/www/html/test.php',0777);
     * @return true on success
     */
    public static function changeMode($file,$octal)
    {
        chmod($file,$octal);

        return true;
    }

    /**
     * Method to perform a Recursive chmod
     * @param  mixed $path
     * @param  int   $filemode
     * @return bool  TRUE on success
     */
    public static function chmod_R($path, $filemode)
    {
        if (!is_dir($path))
        return chmod($path, $filemode);

        $dh = opendir($path);
        while ($file = readdir($dh)) {
            if ($file != '.' && $file != '..') {
                $fullpath = $path.'/'.$file;
                if (!is_dir($fullpath)) {
                    if (!chmod($fullpath, $filemode))
                    return FALSE;
                } else {
                    if (!$this->chmod_R($fullpath, $filemode))
                    return FALSE;
                }
            }
        }

        closedir($dh);

        if(chmod($path, $filemode))

        return TRUE;
        else
        return FALSE;
    }

    /**
     * Methiod to convert UNIX style permissions (--rxwrxw) to an octal
     * @param  mixed $mode
     * @return int   $newmode
     */
    public static function chmodnum($mode)
    {
        $mode = str_pad($mode,9,'-');
        $trans = array('-'=>'0','r'=>'4','w'=>'2','x'=>'1');
        $mode = strtr($mode,$trans);
        $newmode = '';
        $newmode .= $mode[0]+$mode[1]+$mode[2];
        $newmode .= $mode[3]+$mode[4]+$mode[5];
        $newmode .= $mode[6]+$mode[7]+$mode[8];

        return $newmode;
    }

    /**
     * Method to recursively chown files
     * @param  mixed $mypath
     * @param  int   $uid
     * @param  int   $gid
     * @return void
     */
    public static function recurse_chown_chgrp($mypath, $uid, $gid)
    {
        $d = opendir ($mypath) ;
        while (($file = readdir($d)) !== false) {
            if ($file != "." && $file != "..") {
                $typepath = $mypath . DS . $file ;
                if (filetype ($typepath) == 'dir') {
                    $this->recurse_chown_chgrp ($typepath, $uid, $gid);
                }

                chown($typepath, $uid);
                chgrp($typepath, $gid);
            }
        }

    }

    /**
          * Copy a file, or recursively copy a folder and its contents
          * @author      Aidan Lister <aidan@php.net>
          * @author      Paul Scott
          * @version     1.0.1
          * @param       string   $source    Source path
          * @param       string   $dest      Destination path
          * @return      bool     Returns TRUE on success, FALSE on failure
          */
    public static function copyr($source, $dest)
    {
        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }
        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
        }

        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            // Deep copy directories
            if ($dest !== "$source/$entry") {
                self::copyr("$source/$entry", "$dest/$entry");
            }
        }
        // Clean up
        $dir->close();

        return true;
    }

    /**
     * Method to determine disk free space
     * NOTE: On UNIX like filesystems make sure that the param is given
     * @param  string $drive
     * @return int    $df
     */
    public static function df($drive = "C:")
    {
        if (PHP_OS == 'WINNT' || PHP_OS == 'WIN32') {
            $df = disk_free_space($drive);
        } else {
            $df = disk_free_space(DS);
        }

        return $df;
    }

}//end class

class c_filemanager extends c_fm
{
}
