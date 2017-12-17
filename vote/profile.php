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
	<body onload="showProfile('<?php echo $_GET["username"];?>')">
		<div class="wrapper">
			<?php include 'titlebar.php';?>
			<div class="box content">	
				<div id="profile"></div>
			</div>
			
			<?php 
				include 'loginPanel.php';
				include 'menu.php';
			?>
		</div>
	</body>
</html>