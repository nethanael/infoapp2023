<?php

	include('server_params.php');	//user and password for DB connection

	// Create connection
	$conn = new mysqli($servername, $DBusername, $DBpassword, $myDB);
	$conn->set_charset("utf8");										//allows ñ´s and tildes to work when queried

	// Check connection
	if ($conn->connect_error) {
   	 	die("Connection failed: " . $conn->connect_error);
			//echo "Connection failed!";
	}
		else{
			//echo "Connected successfully";
		}

?>