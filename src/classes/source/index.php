<?php

		# Step 6
		// *** Define your host, username, and password
		define('FTP_HOST', '192.168.1.88');
		define('FTP_USER', 'Blimpf');
		define('FTP_PASS', 'catfish');


		// *** Include the class
		include('ftp_class.php');

		// *** Create the FTP object
		$ftpObj = new FTPClient();


		// *** Connect
		if ($ftpObj -> connect(FTP_HOST, FTP_USER, FTP_PASS)) {

			
			## --------------------------------------------------------
			
			# Step 7

			$dir = 'httpdocs/photos';		
			
			// *** Make directory
			$ftpObj->makeDir($dir);

			print_r($ftpObj -> getMessages());

			## --------------------------------------------------------
			
			# Step 8

			$fileFrom = 'zoe.jpg';				
			$fileTo = $dir . '/' . $fileFrom;
		
			// *** Upload local file to new directory on server
			$ftpObj -> uploadFile($fileFrom, $fileTo);

			print_r($ftpObj -> getMessages());

			## --------------------------------------------------------
							
			# Step 9
	
			// *** Change to folder
			$ftpObj->changeDir($dir);

			// *** Get folder contents
			$contentsArray = $ftpObj->getDirListing();


			// *** Output our array of folder contents
			echo '<pre>';
			print_r($contentsArray);
			echo '</pre>';

			## --------------------------------------------------------
			
			# Step 10
			
			$fileFrom = 'zoe.jpg';		# The location on the server
			$fileTo = 'zoe-new.jpg';			# Local dir to save to

			// *** Download file
			$ftpObj->downloadFile($fileFrom, $fileTo);

		} 
?>
