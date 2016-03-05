<?php
	include_once('connect.php');
	
	class GenericDB{
	
	private $dbHandler;
	
		function __construct($db = NULL){
			if(isset($db))
				$this->dbHandler = $db;
			else
				$this->dbHandler = new DBHandler();
			
			
		}
		
		public function GetSettings(){
				$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM settings where id = 1");
				$stmt->execute();
				$result = $stmt->fetch();
				$_SESSION['settings'] = $result;
			return $_SESSION['settings'];
		}
		
		public function PersistSettings(){
			if(isset($_SESSION['settings'])){
				$stmt = $this->dbHandler->getInstance()->prepare(
				"UPDATE settings 
				SET MaxReservationCount = :maxRCount, SystemMessage = :message
				WHERE id = :id"
				);
				$stmt->bindParam(':maxRCount', $_SESSION['settings']['MaxReservationCount']);
				$stmt->bindParam(':message', $_SESSION['settings']['SystemMessage']);
				$id = 1;
				$stmt->bindParam(':id', $id);
				$stmt->execute();
			}
		}
	}


?>