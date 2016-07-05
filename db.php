<?php
//This document contains mysql related functions

function con(){
	$servername = "localhost";
	$username = "web";
	$password = "33KKvvKK33";
	$dbname = "hackers";
	// Create connection
	$con = new mysqli($servername, $username, $password, $dbname);
	
	// Check connection
	if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
	}
	else{
		//echo "connection succesful <br />";
	}
	return $con;
}



?>