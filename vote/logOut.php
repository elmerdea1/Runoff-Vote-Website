<?php
//Elmer Dea
//10/23/17
//reset revelant session vars

session_start();

echo "T1";
$_SESSION['user'] = "";
$_SESSION['pass'] = "";
$_SESSION["login"] = "";
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>