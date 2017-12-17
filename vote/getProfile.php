<?php
	include 'connect.php';
	$profile = "";
	$creatorOf = array();
	$voterIn = array();
	$self = 0;
	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		//profile info
		$name = $_GET["username"];
		$userQ = "SELECT username, fullname, email, phone FROM users WHERE username='{$name}'";
		$userR= $conn->query($userQ);
		while ($row = $userR->fetch_assoc())
		{
			$profile = $row;
		}
		
		//creator of x refs
		$creatorQ = "SELECT referenda.issue, referenda_users.refID FROM referenda_users 
			INNER JOIN referenda ON referenda.ID = referenda_users.refID 
			WHERE username = '{$name}' AND creator = 1";
		$creatorR= $conn->query($creatorQ);
		while ($row = $creatorR->fetch_assoc())
		{
			$creatorOf[] = $row;
		}
		
		//eligible for y refs
		$voterQ = "SELECT referenda.issue, refID FROM referenda_users 
			INNER JOIN referenda ON referenda.ID = referenda_users.refID 
			WHERE username = '{$name}' AND creator = 0";
		$voterR= $conn->query($voterQ);
		while ($row = $voterR->fetch_assoc())
		{
			$voterIn[] = $row;
		}
		
		if ($name == $_SESSION['user'])
		{
			$self=1;
		}
	}
	$outPut = new StdClass;
	$outPut->profile = $profile;
	$outPut->self = $self;
	$outPut->creatorOf = $creatorOf;
	$outPut->voterIn = $voterIn;
	echo json_encode($outPut);
?>