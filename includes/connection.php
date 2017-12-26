<?php 
	$server = "127.0.0.1";
	$usermname = "root";
	$password = "";
	$db = "addressbook";
	
	$conn = mysqli_connect($server, $usermname, $password, $db);
	if (!conn) {
		die("Connection Failed: ".mysqli_connect_error());
	}
?>