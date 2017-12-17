		<div id="title1" class="box titlebar">
				<img src="ballot.jpg" alt="ballot box">
				<div id="nameLog" class="account hide">
					Logged in as : <span id ="accName" class="username"><?php echo $_SESSION["user"]?></span>
					<a href="profile.php?username=<?php echo $_SESSION["user"]?>">[ My Profile ] </a>
					<a type ="logOut" href="logOut.php"> [ Log Out ] </a>
					
				</div>
		</div>