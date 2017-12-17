<?php
	include 'connect.php';
	$voters = array();
	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$userQ = "SELECT username FROM users ORDER BY username";
		$userR= $conn->query($userQ);
		while ($row = $userR->fetch_assoc())
		{
			$voters[] = $row;
		}
	}
	echo json_encode($voters);
?>