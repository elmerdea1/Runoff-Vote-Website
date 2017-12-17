<?php
	include 'connect.php';	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//checks if logged in user is the creator
		$refID = (int)$_POST["refID"];
		$userQ = "SELECT username FROM referenda_users WHERE refID={$refID} && creator=1";
		$userR= $conn->query($userQ);
		$row = $userR->fetch_assoc();
		if ($row["username"] == $_SESSION["user"])
		{
			$stmt = $conn->prepare("UPDATE options SET optName=?, description=? WHERE refID=? AND ID=?");
			$orgName = test_input($_POST["updateOpt"]);
			$description = test_input($_POST["updateOptDesc"]); 
			$refID = (int)$_POST["refID"];
			$optID = (int)$_POST["optID"];
			$stmt->bind_param('ssii', $orgName, $description, $refID, $optID);
			$stmt->execute() or die(mysqli_error($conn));
		}
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>