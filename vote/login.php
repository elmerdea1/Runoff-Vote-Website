<?php
	//Elmer Dea
	//10/16/17
	//Login processing
	
	include 'connect.php';	
	//changes user session variables if user/password combo is correct, message variable if not
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$username = test_input($_POST["username"]);
		$nameCheck = "SELECT username, password FROM users WHERE username = '$username'";
		$result= $conn->query($nameCheck);
		
		if ($result->num_rows == 1)
		{	
			$passwordIn = test_input($_POST["password"]);
			$row = $result->fetch_assoc();
			if (password_verify($passwordIn, $row["password"]))
			{
				$_SESSION['user'] = $row["username"];
				$_SESSION['pass'] = $row["password"];
				$_SESSION["login"]="active";
			}
			else
			{
				$_SESSION["login"]="Password is incorrect";
			}
		}
		else{
			$_SESSION["login"]="Username does not exist";
		}
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
?>