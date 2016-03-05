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
		If(trim($email) == '' || trim($password) == '' || trim($confirmPwd) == ''|| $name == '' ||
		$email == NULL || $password == NULL || $name == NULL || $confirmPwd == NULL){
			if($errorMessage != '')$errorMessage = $errorMessage."<br />";
			$errorMessage = $errorMessage."Aucun champ ne peut être vide";
		}
		if($userDB->UserOwnEmail($email)){
			if($errorMessage != '')$errorMessage = $errorMessage."<br />";
			$errorMessage = $errorMessage."Email déjà associé à un compte, ";
		}
		if($password != $confirmPwd){
			if($errorMessage != '')$errorMessage = $errorMessage."<br />";
			$errorMessage = $errorMessage."Le mot de passe de concorde pas avec la confirmation, ";
		}
		if($errorMessage == ''){
			$userDB->Register($email, $name, $password);
			$userDB->SignIn($email, $password);
		}
		
		if($errorMessage == '' && isset($_SESSION['user']) && isset($_SESSION['user']['email']) && $_SESSION['user']['email'] == $email){
		?>
			{"status":"success", "message":"Compte créé"}
		<?php
		}else{
		?>
			{"status":"danger", "message":"<?php echo $errorMessage; ?>"}
		<?php
		}
		
	}
?>