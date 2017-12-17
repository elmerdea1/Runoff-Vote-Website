<?php	
	//Elmer Dea
	//10/26/17
	//Display ballot
	
	include 'connect.php';
	
	$refInfo = array();
	$opts = array();
	$votes = array();
	$voters = array();
	$creator;
	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$ID = $_GET["ID"];
		//Ref info
		$refQ = "SELECT orgName, issue, description, deadline FROM referenda WHERE ID='$ID'";
		$ref= $conn->query($refQ)->fetch_assoc();
		$issue= $ref["issue"];
		$orgName = $ref["orgName"];
		$description = $ref["description"];
		$deadline = $ref["deadline"];
		array_push($refInfo, $issue, $orgName, $deadline, $description);		

		//Options info
		$optQ = "SELECT ID, optName, description, color FROM options WHERE refID='$_GET[ID]'";
		$result = $conn->query($optQ);
		$optCount = $result->num_rows;
		if ($optCount > 0)
		{
			while ($row = $result->fetch_assoc())
			{
				$opts[] = $row;
			}
		}
		
		//existing votes
		$voteQ = "SELECT votes.optID, votes.choiceRank, options.optName 
		FROM votes INNER JOIN options ON votes.optID=options.ID
		WHERE voter='{$_SESSION["user"]}' AND refID='$_GET[ID]' ORDER BY choiceRank ASC";
		$voteR = $conn->query($voteQ);
		$voteCount = $voteR->num_rows;
		if ($voteCount >0)
		{
			while ($row = $voteR->fetch_assoc())
			{
				$votes[] = $row;
			}
		}
		
		//voters
		$votersQ = "SELECT username FROM referenda_users WHERE refID='$_GET[ID]'";
		$votersR = $conn->query($votersQ);
		$votersCount = $votersR->num_rows;
		if ($votersCount >0)
		{
			while ($row = $votersR->fetch_assoc())
			{
				$voters[] = $row;
			}
		}
		
		//creator
		$creatorQ = "SELECT username FROM referenda_users WHERE refID='$_GET[ID]' AND creator=1";
		$votersR = $conn->query($votersQ);
		$votersCount = $votersR->num_rows;
		if ($votersCount >0)
		{
			$creator = $votersR->fetch_assoc();
		}
	}	
	//Format JSON output
	$outPut = new StdClass;
	$outPut->refInfo = $refInfo;
	$outPut->opts = $opts;
	$outPut->votes = $votes;
	$outPut->voters = $voters;
	$outPut->user = $_SESSION["user"];
	$outPut->creator = $creator;
	echo json_encode($outPut);
?>