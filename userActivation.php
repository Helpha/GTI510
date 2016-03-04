<?php
	session_start();
	$userId = $_POST['user'];
	$action = $_POST['action'];
	if(isset($_SESSION['user']) && ($_SESSION['user']['role'] = "admin" || $_SESSION['user']['id'] == $userId)){
		include_once("db/UserDB.php");
		
		$db = new UserDB();
		$db->Activate($userId, ($action ? 1 : 0));
	}
	else{
		header("Location: index.php");
	}
?>