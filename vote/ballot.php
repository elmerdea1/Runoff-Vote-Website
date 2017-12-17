<?php	
	//Elmer Dea
	//10/26/17
	//Display ballot
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
	</head>
	<!--most content here is dynamically generated-->
	<body onload="showRef(<?php echo $_GET["ID"];?>)" >
		<div class="wrapper">
			<?php include 'titlebar.php';?>
			<div class="box content">	
				<div id="display"></div>
				<div id="alternate"></div>
			</div>
			<div id="charts" class="box chart c">
				<div id="winner">Winner: </div>
			</div>
			<?php 
				include 'loginPanel.php';
				include 'menu.php';?>
		</div>
	</body>
</html>