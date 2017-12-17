<?php 
	include 'connect.php';
	$voters = array();
	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$name = $_GET["name"];
		$userQ = "SELECT username FROM users WHERE username LIKE '%{$name}%' ORDER BY username";
		$userR= $conn->query($userQ);
		while ($row = $userR->fetch_assoc())
		{
			$voters[] = $row;
		}
	}
	echo json_encode($voters);
?>