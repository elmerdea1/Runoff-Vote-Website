<?php
	//11/6
	//retreive all votes for a ref for display
	include 'connect.php';
	
	$votes = array();
	$opts = array();
	$voters = array();
	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		//get options
		$optQ= "SELECT ID, optName, color FROM options WHERE refID ='{$_GET["ID"]}' 
			ORDER BY ID ASC";
		$optR= $conn->query($optQ);
		while ($row = $optR->fetch_assoc())
		{
			$opts[] = $row;
		}
		//getVotes
		$refQ= "SELECT votes.optID, votes.voter, votes.choiceRank, options.optName, options.color 
		FROM votes INNER JOIN options ON votes.optID = options.ID 
			INNER JOIN referenda ON options.refID = referenda.ID 
		WHERE referenda.ID ='{$_GET["ID"]}' AND votes.choiceRank<>0 
		ORDER BY votes.OptID ASC, choiceRank ASC";
		$voteR = $conn->query($refQ);
		$voteCount = $voteR->num_rows;
		while ($row = $voteR->fetch_assoc())
		{
			$votes[] = $row;
		}
		//get list of voters
		$votersQ= "SELECT username FROM referenda_users WHERE refID='{$_GET["ID"]}'";
		$votersR= $conn->query($votersQ);
		while ($row = $votersR->fetch_assoc())
		{
			$voters[] = $row;
		}
		$outPut = new StdClass;
		$outPut->votes = $votes;
		$outPut->opts = $opts;
		$outPut->voters = $voters;
		echo json_encode($outPut);
	}
?>