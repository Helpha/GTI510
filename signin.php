<?php
	session_start();
	
	include("db/UserDB.php");
	$userDB = new UserDB();
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$email = $_POST["email"];
		$password = $_POST["pwd"];
		
		$userDB->SignIn($email, $password);
		
		if(isset($_SESSION['user']) && isset($_SESSION['user']['email']) && $_SESSION['user']['email'] == $email){
		?>
			<span class="label label-success">Connexion en cours</span>
		<?php
		}else{
		?>
			<span class="label label-danger">Veuillez vérifier vos informations </span>
		<?php
		}	
	}
?>