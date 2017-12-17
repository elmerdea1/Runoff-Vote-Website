<div id="logPan" class="box b">
			<!-- box for login/register forms -->
				<form id="login" action="login.php" method="post">
					<div class="title">Log In</div>
					<input name="username" type="text" placeholder="Username">
					<input name="password" type="password" placeholder="Password">
					<label id="loginFail"><?php echo $_SESSION["login"]?></label>
					<button type="submit">Login</button>
				</form>
				<form id="register" class="hide" action="register.php" method="post">
					<div class="title">New Account</div>
					<input id="username" name="username" type="text" placeholder="Username" maxlength="15" required="required">
					<input id="password" name="passwordIn"type="password" placeholder="Password" maxlength="15" required="required">
					<input id="repeatPass" type="password" placeholder="Repeat Password" onchange="passMatch(this)">
					<!-- contact info optional -->
					<input name="fullname" type="text" placeholder="Full Name" maxlength="30">
					<input id="emailAddress" name="email" type="email" placeholder= "Email Address" maxlength="30">
					<input id="phone" name="phone" type="tel" placeholder= "Phone Number" minlength="9" maxlength="14">
					<label id="warn"></label>
					
					<button type="submit">Create</button>
				</form>
				<button id="reg" class="regSwitch" type="button" onclick="regTog()">Register Now</button>
			</div>