<?php
//Elmer Dea
//11/19/17
//updates profile info for a user
	include 'connect.php';
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$stmt = $conn->prepare("UPDATE users SET fullname=?, email=?, phone=? WHERE username='{$_SESSION["user"]}'");
		$fullname = test_input($_POST["newName"]);
		$email= test_input($_POST["newEmail"]);
		$phone = test_input($_POST["newPhone"]); 
		$stmt->bind_param('sss', $fullname, $email, $phone);
		$stmt->execute() or die(mysqli_error($conn));
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>