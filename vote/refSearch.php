<?php
	//Elmer Dea
	//10/24/17
	//Search db for referenda
//OLD
	
	include 'connect.php';	
	
	$_SESSION["refSearch"]="";
	//clear previous search results
	
	//place results into a session var
	//uses one search criteria if only one is provided
	//uses %criteria% wildcard
	if ($_SERVER["REQUEST_METHOD"] == "GET")
	{
		$refName = test_input($_GET["refName"]);
		$orgName = test_input($_GET["orgName"]);
		$refCheck = "SELECT ID, orgName, issue, description, deadline FROM referenda WHERE ";
		if ($orgName=="")//only refname provided
		{
			$refCheck.= "issue LIKE '%".$refName."%'";
		}
		if ($refName=="") //only orgname provided
		{
			$refCheck .= "orgName LIKE '%". $orgName."%'";
		}
		if ($orgName != "" && $refName!="")//both provided
		{
			$refCheck .= "issue LIKE '%".$refName."%' AND orgName LIKE '%".$orgName."%'";
		}
		//check if all fields were left blank

		if ($orgName=="" && $refName=="")
		{
			$_SESSION["refSearch"]= "No values entered";
		}
		else
		{
			//turns every match into a get-form for that particular id
			$result= $conn->query($refCheck);
			while ($row = $result->fetch_assoc())
			{
				
				$_SESSION["refSearch"].= "<div class=\"results\"> <form action=\"ballot.php\">". 
				"<input name=\"ID\" type=\"hidden\" value=\"" . $row["ID"]. "\">".
				$row["issue"]."<br>".$row["orgName"]. "<br>Deadline: ". $row["deadline"] . "<br>". $row["description"]. "<br>".
				"<button type=\"submit\">Vote Now</button></form> </div>";
			}
			
		}
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}	
?>