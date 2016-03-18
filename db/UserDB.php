<?php
include_once("connect.php");

class UserDB{
	
	private $dbHandler;
	
	function __construct($db = NULL){
		if(isset($db))
			$this->dbHandler = $db;
		else
			$this->dbHandler = new DBHandler();
		
		
	}
	
	public function Register($email, $name, $password, $role = "none", $isEnable = true, $isSecured = false){
		$stmt = $this->dbHandler->getInstance()->prepare("INSERT INTO USERS (email, role, name, password, isEnabled) VALUES (:email, :role, :name, :password, :isEnabled)");
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':role', $role);
		$stmt->bindParam(':name', $name);
		if($isSecured == false)
			$password = md5($password);
		$stmt->bindParam(':password', $password);
		$enabled = $isEnable ? 1 : 0;
		$stmt->bindParam(':isEnabled', $enabled);

		$stmt->execute();
	}
	
	public function GetUser($userId){
		$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM users where id = ?");
		$stmt->execute(array($userId));
		$result = $stmt->fetch();
		return $result;
	}
	
	public function UserOwnEmail($email){
		if(isset($email) && trim($email) != ''){
			$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM users where email = ?");
			$stmt->execute(array($email));
			$result = $stmt->fetchAll();
			return isset($result) && isset($result[0]);
		
		}
		return false;
	}
	
	public function GetAllUsers(){
		$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM users");
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function Activate($userId, $isEnabled){
		$stmt = $this->dbHandler->getInstance()->prepare(
		"UPDATE users 
		SET isEnabled = :isEnabled 
		WHERE id = :id"
		);
		$stmt->bindParam(':isEnabled', $isEnabled);
		$stmt->bindParam(':id', $userId);
		$stmt->execute();
	}
	
	public function SignIn($email, $password){
		$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM users where email = ? AND password = ? AND isEnabled = TRUE");
		$stmt->execute(array($email, md5($password)));
		$result = $stmt->fetch();
		
		if($result != NULL){
			$_SESSION['user'] = $result;
		}
	}
	
	public function SignOut(){
		$_SESSION['user'] = NULL;
		unset($_SESSION['user']);
		header("Location: index.php");
	}
	
	public function UpdateUser($userId, $email, $name, $role, $isEnable = 1){
		$stmt = $this->dbHandler->getInstance()->prepare(
		"UPDATE users 
		SET email = :email, name = :name, role = :role, isEnabled = :isenable 
		WHERE id = :id"
		);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':role', $role);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':isenable', $isEnable);
		$stmt->bindParam(':id', $userId);
		$stmt->execute();
		
		if($_SESSION['user']['id'] == $userId)
			$_SESSION['user'] = $this->GetUser($userId);
	}
	
	public function ChangePassword($userId, $password){
		$stmt = $this->dbHandler->getInstance()->prepare(
		"UPDATE users 
		SET password = :password 
		WHERE id = :id"
		);
		$stmt->bindParam(':password', md5($password));
		$stmt->bindParam(':id', $userId);
		$stmt->execute();
	}
	
	public function PasswordIsValid($password){
		$errors = Array();
		if(strlen($password)<8){
			$errors[] = "Le mot de passe doit contenir un minimum de 8 caractères.";
		}
		$match = Array();
		if( preg_match_all( "/[0-9]/", $password,$match) < 2){
			$errors[] = "Le mot de passe doit contenir un minimum de 2 chiffres.";
		}
		return $errors;
	}
}
?>