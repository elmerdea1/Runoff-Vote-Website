<?php 
  if(session_status() == PHP_SESSION_NONE)
  {
    session_start();
  }
  // Set session variables to empty if not already set
  $sess = array("login", "user", "pass","refSearch");
  foreach($sess as &$var)
  {
	  if(!isset($_SESSION[$var])) 
	  {
		$_SESSION[$var]="";
	  }
  }
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
	<body>
		<div class="wrapper">
			<?php include 'titlebar.php';?>
			<div class="box content">	
				<div class="title">Vote Now</div>
				<form action="refSearch.php" method="get">
					<input name="refName" type="text" placeholder="Referendum Name">
					<input name="orgName" type="text" placeholder="Organization Name">
					<button name="searchBut" type="submit">Search</button>
				</form>
				<div>
						<?php echo $_SESSION["refSearch"] ?>
				</div>
			</div>
			<?php 
				include 'loginPanel.php';
				include 'menu.php';
			?>
		</div>
	</body>
</html>