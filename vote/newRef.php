<?php
	//Elmer Dea
	//10/23/17
	//Add New Referendum to db
	
	include 'connect.php';	
	
	//$prepRef = $conn->prepare("INSERT INTO referenda(publicVote, username, orgName, issue, description, deadline, created) VALUES (?, ?, ?, ?, ?, ?, ?");
	$prepRef = $conn->prepare("INSERT INTO referenda(orgName, issue, description, deadline, created) VALUES (?, ?, ?, ?, ?)");
	//prep statement
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$orgName = test_input($_POST["orgName"]);
		$issue = test_input($_POST["issue"]);
		$description = test_input($_POST["desc"]);
		$deadline = test_date($_POST["endDate"]);
		//created date set to current date ~EST
		date_default_timezone_set('America/New_York');
		$created = date('Y-m-d');
		//$prepRef->bind_param("issssss", $public,$username,$orgName,$issue,$description,$deadline,$created);
		$prepRef->bind_param("sssss", $orgName,$issue,$description,$deadline,$created);
		$prepRef->execute();
		$lastID = $conn->insert_id;
		//for redirecting to ballot page for this id, next process requires lastid
		
		//update referenda_users to show creator of this ref
		//10/30
		$prepRU = $conn->prepare("INSERT into referenda_users(username, refID, creator) VALUES (?, ?, ?)");
		$user = $_SESSION["user"];
		$last_ref = $conn->insert_id;
		$isCreator = 1;
		$prepRU->bind_param("ssi", $user, $last_ref, $isCreator);
		$prepRU->execute();
		
		//update referenda_users to show eligible voters for this ref
		$prepV = $conn->prepare("INSERT into referenda_users(username, refID, creator) VALUES (?, ?, ?)");
		$isNotCreator = 0;
		foreach ($_POST['voters'] as $v)
		{
			$prepV->bind_param("ssi", $v, $last_ref, $isNotCreator);
			$prepV->execute();
		}
		
		
		$options = $_POST["optCount"];
			for ($x = 1; $x <= $options; $x++)
			{
				$prepOpt = $conn->prepare("INSERT INTO options(optName, description, color, refID) VALUES (?,?,?,?)");
				$optName = test_input($_POST["refOpt".$x]);
				$description = test_input($_POST["optDesc".$x]);
				$color = test_input(substr($_POST["color".$x],1));
				// #truncate # from color id
				// #$lastID as refID
				$prepOpt->bind_param("sssi", $optName, $description, $color, $lastID);
				if ($optName!="") //Allows users to leave intermittent option values blank, processes the rest of the options
				{
					$prepOpt->execute();
				}
				$prepOpt->close();
				// #echo $optName.$description.$color.$lastID;
			}
		header("Location: ballot.php?ID={$lastID}");
	}
	
	function test_date($date)
	{
		$dt = DateTime::createFromFormat("Y-m-d", $date);
		if ($date!="")
		{
			$dt = $dt->format("Y-m-d");
		}
		return $dt;
	}
?>