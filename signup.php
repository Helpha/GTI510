<?php
	session_start();
	
	include("db/UserDB.php");
	$userDB = new UserDB();
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$email = $_POST["email"];
		$password = $_POST["pwd"];
		$name = $_POST["name"];
		$confirmPwd = $_POST["confirmPwd"];
		
		$errorMessage = '';
		If(trim($email) == '' && trim($password) == '' && trim($confirmPwd) == ''&& $name == ''){
			$errorMessage += "Aucun champ ne peut être vide, ";
		}
		if($userDB->UserOwnEmail($email))
			$errorMessage += "Email déjà associé à un compte, ";
		if($password != $confirmPwd){
			$errorMessage += "Le mot de passe de concorde pas avec la confirmation, ";
		}
		
		$userDB->Register($email, $name, $password);
		
		if(isset($_SESSION['user']) && isset($_SESSION['user']['email']) && $_SESSION['user']['email'] == $email){
		?>
			{"status":"success", "message":"Compte créé"}
		<?php
		}else{
		?>
			{"status":"danger", "message":"Il y a aucun compte avec ce email et ce mot de passe."}
		<?php
		}
		
	}
?>