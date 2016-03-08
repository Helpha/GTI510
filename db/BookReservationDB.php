<?php
include_once("connect.php");

class BookReservationDB{
	
	private $dbHandler;
	
	function __construct($db = NULL){
		if(isset($db))
			$this->dbHandler = $db;
		else
			$this->dbHandler = new DBHandler();
	}
	
	public function GetReservationsForBook($bookId){
		$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM reservation WHERE livre_id = ?");
		$stmt->execute(array($bookId));
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function GetReservationForUser($userId){
		$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM reservation WHERE user_id = ?");
		$stmt->execute(array($userId));
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function AddReservation($date_start, $date_end, $livre_id, $user_id, $status = 1){
		$stmt = $this->dbHandler->getInstance()->prepare("INSERT INTO reservation (date_start, date_end, active, livre_id, user_id) VALUES (:date_start, :date_end, :active, :livre_id, :user_id)");
		$stmt->bindParam(':date_start', $date_start);
		$stmt->bindParam(':date_end', $date_end);
		$stmt->bindParam(':active', $status);
		$stmt->bindParam(':livre_id', $livre_id);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->execute();
	}
	
	public function UpdateReservation($id, $date_start, $date_end, $livre_id, $user_id, $status = 1){
		$stmt = $this->dbHandler->getInstance()->prepare(
		"UPDATE reservation 
		SET date_start = :date_start, date_end = :date_end, active = :active, livre_id = :livre_id, user_id = :user_id
		WHERE reservation_id = :id"
		);
		$stmt->bindParam(':date_start', $date_start);
		$stmt->bindParam(':date_end', $date_end);
		$stmt->bindParam(':active', $status);
		$stmt->bindParam(':livre_id', $livre_id);
		$stmt->bindParam(':user_id', $user_id);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}
	
	public function DeleteReservation($id){
		$stmt = $this->dbHandler->getInstance()->prepare("DELETE FROM `gti510`.`reservation` WHERE `reservation_id`=:reservation_id");
		$stmt->bindParam(':reservation_id', $id);
		$stmt->execute();
	}
}
?>