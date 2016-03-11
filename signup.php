<?php
	session_start();
	
	include("db/UserDB.php");
	$userDB = new UserDB();
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$email = $_POST["email"];
		$password = $_POST["pwd"];
		$name = $_POST["name"];
		$confirmPwd = $_POST["confirmPwd"];
		
		$errorMessage = Array();;
		If(trim($email) == '' || trim($password) == '' || trim($confirmPwd) == ''|| $name == '' ||
		$email == NULL || $password == NULL || $name == NULL || $confirmPwd == NULL){
			$errorMessage[] = "Aucun champ ne peut &ecirctre vide.";
		}
		if($userDB->UserOwnEmail($email)){
			$errorMessage[] = "Email d&eacutej&agrave associ&eacute &agrave un compte.";
		}
		if($password != $confirmPwd){
			$errorMessage[] = "Le mot de passe ne concorde pas avec la confirmation.";
		}
		$errors = $userDB->PasswordIsValid($password);
		for($i = 0; $i < count($errors);$i++){
		$errorMessage[] = $errors[$i];
		}
		
		if(count($errorMessage) == 0){
			$userDB->Register($email, $name, $password);
			$userDB->SignIn($email, $password);
		}
		
		if(count($errorMessage) == 0 && isset($_SESSION['user']) && isset($_SESSION['user']['email']) && $_SESSION['user']['email'] == $email){
		?>
			<span class="label label-success">Compte cr&eacute&eacute</span>
		<?php
		}else{
			for($i = 0; $i < count($errorMessage); $i++){
		?>
			<span class='label label-danger'><?php echo $errorMessage[$i]; ?></span>
		<?php
			}
		}
		
	}
?>