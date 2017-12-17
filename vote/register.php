<?php
//Elmer Dea
//10/12/17
//Login/Registration form processing

include 'connect.php';

// Create database
// $sql = "CREATE DATABASE myDB";
// if ($conn->query($sql) === TRUE) {
    // echo "Database created successfully";
// } else {
    // echo "Error creating database: " . $conn->error;
// }

$stmt = $conn->prepare("INSERT INTO users(username, password, fullname, email, phone) VALUES (?, ?, ?, ?, ?)");

if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$username = test_input($_POST["username"]);
		$nameCheck = "SELECT username, password FROM users WHERE username = '$username'";
		$result= $conn->query($nameCheck);
		
		//if username is unique
		if ($result->num_rows == 0)
		{	
			// set parameters and execute
			if ($_SERVER["REQUEST_METHOD"] == "POST")
			{
				$username = test_input($_POST["username"]);
				$passwordIn = test_input($_POST["passwordIn"]);
				$passHash = password_hash($passwordIn, PASSWORD_DEFAULT);					

				$fullname = test_input($_POST["fullname"]);
				$email = test_input($_POST["email"]);
				$phone =test_input($_POST["phone"]);
				$stmt->bind_param("sssss", $username, $passHash, $fullname, $email, $phone);
				$stmt->execute();
			}
		}
	}
//echo "New records created successfully";
header('Location: ' . $_SERVER['HTTP_REFERER']);

//$stmt->close();
$conn->close();
?>