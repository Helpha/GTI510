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
			{"status":"success", "message":"Connexion réussit <?php echo $_SESSION['user']['name']; ?>"}
		<?php
		}else{
		?>
			{"status":"danger", "message":"Il y a aucun compte avec ce email et ce mot de passe."}
		<?php
		}	
	}
?>