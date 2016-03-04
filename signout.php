<?php
	session_start();
	
	include_once('db/UserDB.php');
	$user = (new UserDB());
	$user->SignOut();
?>