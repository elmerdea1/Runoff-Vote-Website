<?php
	include 'connect.php';
	$voters = array();
	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$userQ = "SELECT username, creator FROM referenda_users WHERE refID={$_GET["ID"]} ORDER BY creator DESC";
		$userR= $conn->query($userQ);
		while ($row = $userR->fetch_assoc())
		{
			$voters[] = $row;
		}
	}
	echo json_encode($voters);
?>