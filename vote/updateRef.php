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
			$stmt = $conn->prepare("UPDATE referenda SET orgName=?, issue=?, description=?, deadline=? WHERE ID=?");
			$orgName = test_input($_POST["orgName"]);
			$issue= test_input($_POST["issue"]);
			$description = test_input($_POST["desc"]); 
			$deadline = test_input($_POST["endDate"]); 
			//refID
			$stmt->bind_param('ssssi', $orgName, $issue, $description, $deadline, $refID);
			$stmt->execute();
		}
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>