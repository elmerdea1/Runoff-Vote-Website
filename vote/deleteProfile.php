<?php
	//Elmer Dea
	//11/26/17
	//delete your account
	
	include 'connect.php';	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//delete this user's referenda obligations
		$sql = "DELETE FROM referenda_users WHERE username='{$_SESSION["user"]}'  AND creator = 0";
		$conn->query($sql) or die(mysqli_error($conn));
		
		//delete the user itself
		$sql = "DELETE FROM users WHERE username='{$_SESSION["user"]}'";
		$conn->query($sql) or die(mysqli_error($conn));
		
		//delete this user's votes
		$sql = "DELETE FROM votes WHERE voter='{$_SESSION["user"]}'";
		$conn->query($sql) or die(mysqli_error($conn));
	}
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>