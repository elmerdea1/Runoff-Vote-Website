<?php
//Elmer Dea
//11/1
//puts votes into vote table
	include 'connect.php';
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$opts = $_POST["optCount"];
		$dupeArray = array_fill(0,$opts, 0); //for validating duplicate ranks
		//default 0 is abstain
		$prep = $conn->prepare("INSERT into votes(optID, voter, choiceRank) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE choiceRank=VALUES(choiceRank)");
		for ($i =0; $i < $opts ; $i++)
		{
			$dupeArray[] += 1; //number of duplicates for that rank; should only ever be 0 or 1 unless javascript is disabled in which case this script shouldn't be able to be called but just in case i guess
		}
		$dupe = 0;
		for ($i =0; $i < $opts ; $i++)
		{
			if ($dupeArray[$i]>1)
			{
				$dupe=1;
			}
		}
		if ($dupe ==1)
		{
			//output duplicate error
		}
		else
		{
			$voter = $_SESSION["user"];
			for ($i =0; $i < $opts ; $i++)
			{
				$ID = (int)$_POST["optID{$i}"];
				$rank = $_POST["optRank{$i}"];
				$prep->bind_param("isi", $ID, $voter, $rank);
				$prep->execute();
			}
		}
	}
	header('Location: ' . $_SERVER['HTTP_REFERER']);
?>