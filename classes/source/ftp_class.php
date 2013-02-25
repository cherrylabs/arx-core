<?php

	# Step 2
	Class FTPClient
	{
		// *** Class variables # Step 3
		private $connectionId;
		private $loginOk = false;
		private $messageArray = array();


		public function __construct() {	}

		## --------------------------------------------------------

		# Step 4
		private function logMessage($message, $clear=true) 
		{
			if ($clear) {$this->messageArray = array();}

			$this->messageArray[] = $message;
		}

		## --------------------------------------------------------
		
		# Step 4
		public function getMessages()
		{
			return $this->messageArray;
		}
	
		## --------------------------------------------------------
		
		# Step 5
		public function connect ($server, $ftpUser, $ftpPassword, $isPassive = false)
		{

			// *** Set up basic connection
			$this->connectionId = ftp_connect($server);

			// *** Login with username and password
			$loginResult = ftp_login($this->connectionId, $ftpUser, $ftpPassword);

			// *** Sets passive mode on/off (default off)
			ftp_pasv($this->connectionId, $isPassive);

			// *** Check connection
			if ((!$this->connectionId) || (!$loginResult)) {
				$this->logMessage('FTP connection has failed!');
				$this->logMessage('Attempted to connect to ' . $server . ' for user ' . $ftpUser, true);
				return false;
			} else {
				$this->logMessage('Connected to ' . $server . ', for user ' . $ftpUser);
				$this->loginOk = true;
				return true;
			}
		}

		## --------------------------------------------------------
		
		# Step 7
		public function makeDir($directory)
		{
			// *** If creating a directory is successful...
			if (ftp_mkdir($this->connectionId, $directory)) {

				$this->logMessage('Directory "' . $directory . '" created successfully');
				return true;

			} else {

				// *** ...Else, FAIL.
				$this->logMessage('Failed creating directory "' . $directory . '"');
				return false;
			}
		}

		## --------------------------------------------------------
	
		# Step 8
		public function uploadFile ($fileFrom, $fileTo)
		{
			// *** Set the transfer mode
			$asciiArray = array('txt', 'csv');
			$extension = end(explode('.', $fileFrom));
			if (in_array($extension, $asciiArray)) {
				$mode = FTP_ASCII;		
			} else {
				$mode = FTP_BINARY;
			}

			// *** Upload the file
			$upload = ftp_put($this->connectionId, $fileTo, $fileFrom, $mode);

			// *** Check upload status
			if (!$upload) {

					$this->logMessage('FTP upload has failed!');
					return false;

				} else {
					$this->logMessage('Uploaded "' . $fileFrom . '" as "' . $fileTo);
					return true;
				}
		}

		## --------------------------------------------------------
		
		# Step 9
		public function changeDir($directory)
		{
			if (ftp_chdir($this->connectionId, $directory)) {
				$this->logMessage('Current directory is now: ' . ftp_pwd($this->connectionId));
				return true;
			} else { 
				$this->logMessage('Couldn\'t change directory');
				return false;
			}
		}

		## --------------------------------------------------------
		
		# Step 9
		public function getDirListing($directory = '.', $parameters = '-la')
		{
			// get contents of the current directory
			$contentsArray = ftp_nlist($this->connectionId, $parameters . '  ' . $directory);

			return $contentsArray;
		}

		## --------------------------------------------------------

		# Step 10
		public function downloadFile ($fileFrom, $fileTo)
		{

			// *** Set the transfer mode
			$asciiArray = array('txt', 'csv');
			$extension = end(explode('.', $fileFrom));
			if (in_array($extension, $asciiArray)) {
				$mode = FTP_ASCII;		
			} else {
				$mode = FTP_BINARY;
			}

			// open some file to write to
			//$handle = fopen($fileTo, 'w');

			// try to download $remote_file and save it to $handle
			if (ftp_get($this->connectionId, $fileTo, $fileFrom, $mode, 0)) {

				return true;
				$this->logMessage(' file "' . $fileTo . '" successfully downloaded');
			} else {

				return false;
				$this->logMessage('There was an error downloading file "' . $fileFrom . '" to "' . $fileTo . '"');
			}

		}
	
		## --------------------------------------------------------
		
		# Step 11
		public function __deconstruct()
		{
			if ($this->connectionId) {
				ftp_close($this->connectionId);
			}
		}
		
		## --------------------------------------------------------
					
	}

?>
