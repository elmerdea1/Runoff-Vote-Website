<?php 
  include 'start.php';
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Hold a Vote</title>
		<meta charset="UTF-8">
		<meta name="description" content="For creating a new referendum">
		<meta name="author" content="Elmer Dea">
		<link rel="stylesheet" href="vote.css">
		<script src="vote.js"></script>
	</head>
	<body onload="populateVoters()">
		<div class="wrapper">
			<?php include 'titlebar.php';?>
			<div class="box content">	
			<!-- box for creating referenda -->
				<form id="referendum" action="newRef.php" method="post">
					<div class="title">Create a New Referendum</div>
					<input name="orgName" type="text" placeholder="Organization Name">
					<input name="issue" type="text" placeholder="Name of Issue" required="required">
					Voter Deadline:
					<input name="endDate" type="date" placeholder="MM/DD/YYYY">
					<textarea name="desc" rows="4" cols="50" placeholder="Description"></textarea>
					<div id="voterPick" class="voteSelect">
						Select Voters
						<br>
						<select size=10 class="inputClass" id ="voters" name = "voters[]" multiple>
							<!-- populated by script -->
						</select>	
					</div>
					<input id="refOpt" name="refOpt1" class="option" type="text" placeholder="Option" required="required">
						<button id="addOpt" class="addOpt" type="button" onclick="newOpt(this.id)">Add Option</button>
						<textarea name ="optDesc1" rows="3" cols="50" placeholder="Description of Option"></textarea>
						<input type="color" name="color1" value="#000066" placeholder="#000066">
					<input id="optCount" name="optCount" type="hidden" value="1">
					<button id="refBut" type="submit">Create</button>
				</form>
			</div>
			<?php 
				include 'loginPanel.php';
				include 'menu.php';
			?>
		</div>
	</body>
</html>