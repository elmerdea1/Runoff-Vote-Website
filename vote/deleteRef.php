<?php
	//Elmer Dea
	//11/26/17
	//delete an entire referendum, including options and assigned voters
	
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
			// voters in referenda_users 
			$stmt = $conn->prepare("DELETE FROM referenda_users WHERE refID=?");
			$stmt->bind_param('i', $refID);
			$stmt->execute();
			
			//options
			$stmt = $conn->prepare("DELETE FROM options WHERE refID=?");
			$stmt->bind_param('i', $refID);
			$stmt->execute();
			
			//delete the ref
			$stmt = $conn->prepare("DELETE FROM referenda WHERE ID=?");
			$stmt->bind_param('i', $refID);
			$stmt->execute();
		}
	}
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>