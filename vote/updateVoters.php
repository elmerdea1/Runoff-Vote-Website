<?php
	//Elmer Dea
	//11/26/17
	//functions for updating a referendum
	
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
			//delete eligible users
			$stmt = $conn->prepare("DELETE FROM referenda_users WHERE creator=0 AND refID =?");
			$refID = (int)$_POST["refID"];
			$stmt->bind_param('i', $refID);
			$stmt->execute();
			
			//replenish from new selection
			$prepV = $conn->prepare("INSERT into referenda_users(username, refID, creator) VALUES (?, ?, ?)");
			$isNotCreator = 0;
			foreach ($_POST['voters'] as $v)
			{
				$prepV->bind_param("ssi", $v, $refID, $isNotCreator);
				$prepV->execute();
			}
		}
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>