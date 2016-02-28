<?php
include_once("connect.php");

class UserDB{
	
	private $dbHandler;
	
	function __construct($db = NULL){
		if($db)
			$dbHandler = $db;
		else
			$db = new DBHandler();
		
		
	}
	
	public function Register($email, $name, $password, $role = NULL, $isEnable = true, $isSecured = false){
		$stmt = $this->dbHandler->getInstance()->prepare("INSERT INTO USERS (email, role, name, password, isenable) VALUES (:email, :role, :name, :password, :isenable)");
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':role', $role);
		$stmt->bindParam(':value', $value);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':password', $isSecured ? $password : md5($password));
		$stmt->bindParam(':isenable', $isEnable);

		$stmt->execute();
	}
	
	public function GetUser($userId){
		$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM users where id = ?");
		$stmt->execute(array($userId));
		$result = $stmt->fetchAll();
		return $result;
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
		SET isenable = :isenable 
		WHERE id = :id"
		);
		$stmt->bindParam(':isenable', $isEnable);
		$stmt->bindParam(':id', $userId);
		$stmt->execute();
	}
	
	public function SignIn($email, $password){
		$stmt = $this->dbHandler->getInstance()->prepare("SELECT user FROM users where email = ? AND password = ?");
		$stmt->execute(array($email, md5($password)));
		$result = $stmt->fetchAll();
		
		if($result != NULL && $result[0] != NULL){
			$_SESSION['user'] = $result[0];
		}else{
			$this->SignOut();
		}
	}
	
	public function SignOut(){
		$_SESSION['user'] = NULL;
		header("Location: index.php");
	}
	
	public function UpdateUser($userId, $email, $name, $password, $role, $isEnable = true, $isSecured = false){
		$stmt = $this->dbHandler->getInstance()->prepare(
		"UPDATE users 
		SET email = :email, name = :name, password = :password, role = :role, isenable = :isenable 
		WHERE id = :id"
		);
		$stmt->bindParam(':email', $email);
		$stmt->bindParam(':role', $role);
		$stmt->bindParam(':value', $value);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':password', $isSecured ? $password : md5($password));
		$stmt->bindParam(':isenable', $isEnable);
		$stmt->bindParam(':id', $userId);
	}
}
?>