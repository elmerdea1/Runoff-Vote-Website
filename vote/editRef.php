<?php 
  include 'start.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Vote Now</title>
		<meta charset="UTF-8">
		<meta name="description" content="">
		<meta name="author" content="Elmer Dea">
		<link rel="stylesheet" href="vote.css">
		<script src="vote.js"></script>
	</head>
	<body onload="showEditRef(<?php echo $_GET["ID"];?>)">
		<div class="wrapper">
			<?php include 'titlebar.php';?>
			<div class="box content">	
				<div id="display"></div>
				<form id="referendum" action="updateRef.php" method="post">
					<div class="title">Update Description</div>
					<input name="orgName" type="text" placeholder="Organization Name">
					<input name="issue" type="text" placeholder="Name of Issue" required="required">
					Voter Deadline:
					<input name="endDate" type="date" placeholder="MM/DD/YYYY">
					<textarea name="desc" rows="4" cols="50" placeholder="Description"></textarea>
					<input id="refID" name="refID" type="hidden" value=<?php echo $_GET["ID"];?>>
					<button id="refBut" type="submit">Update</button>
				</form>
				<br>
				<div class="title">Eligible Voters</div>
				<div id="eligible"></div>
				<div class="title">Change Eligible Voters</div>
				<form id="votersForm" action= "updateVoters.php" method="post">
					<select size=10 class="inputClass" id ="voters" name = "voters[]" multiple>
								<!-- populated by script -->
					</select>	
					<input id="refID" name="refID" type="hidden" value=<?php echo $_GET["ID"];?>>
				<button id="votersBut" type="submit">Update</button>
				</form>
				<br>
				<div id="displayOpts"></div>
				</form>
				<!--<div class="title">Transfer Control of This Referendum to Another User</div>
				<form action= "cedeCreator.php" method="post">
					<select size=10 class="inputClass" id ="manager" name = "voters[]">
						<!-- populated by script 
					</select>
				</form> -->
				<br>
				<br>
				<br>
				<form action="deleteRef.php" method="post">
					<input id="refID" name="refID" type="hidden" value=<?php echo $_GET["ID"];?>>
					<button id="deleteBut" type="submit">DELETE THIS REFERENDUM</button>
				</form>
			</div>
			<?php 
				include 'loginPanel.php';
				include 'menu.php';
			?>
		</div>
	</body>
</html>