<?php
	session_start();
	
	//format user input, prevent escaping
	function test_input($data) 
	{
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "vote";

	// connect
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
?>