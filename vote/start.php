<?php
	if(session_status() == PHP_SESSION_NONE)
  {
    session_start();
  }
  // Set session variables to empty if not already set
  $sess = array("login", "user", "pass");
  foreach($sess as &$var)
  {
	  if(!isset($_SESSION[$var])) 
	  {
		$_SESSION[$var]="";
	  }
  }
?>