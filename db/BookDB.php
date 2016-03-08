<?php
include_once("connect.php");

class BookDB{
	
	private $dbHandler;
	
	function __construct($db = NULL){
		if(isset($db))
			$this->dbHandler = $db;
		else
			$this->dbHandler = new DBHandler();
	}

	public function GetAllBooks($orderBy = NULL, $where = NULL, $value = NULL){
		$query = "SELECT * FROM livres";
		if($where != NULL && $value != NULL){
			$query = $query." WHERE ".$where.' LIKE "%'.$value.'%"';
		}
		if($orderBy != NULL){
			$query = $query." ORDER BY ".$orderBy;
		}else{
			$query = $query." ORDER BY title";
		}
		$stmt = $this->dbHandler->getInstance()->prepare($query);
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function AddBook($isbn, $title, $description, $imageUrl, $author, $publishedDate, $count){
		$stmt = $this->dbHandler->getInstance()->prepare("INSERT INTO livres (isbn, title, description, Image_url, author, date_publish, Count) VALUES (:isbn, :title, :description, :Image_Url, :author, :date_publish, :Count)");
		$stmt->bindParam(':isbn', $isbn);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':Image_Url', $imageUrl);
		$stmt->bindParam(':author', $author);
		$stmt->bindParam(':date_publish', $publishedDate);
		$stmt->bindParam(':Count', $count);
		$stmt->execute();
	}
	
	public function UpdateBook($id, $isbn, $title, $description, $imageUrl, $author, $publishedDate, $count){
		$stmt = $this->dbHandler->getInstance()->prepare(
		"UPDATE livres 
		SET isbn = :isbn, title = :title, description = :description, Image_url = :Image_url, author = :author, date_publish = :date_publish, Count = :count 
		WHERE livre_id = :livre_id"
		);
		$stmt->bindParam(':isbn', $isbn);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':Image_url', $imageUrl);
		$stmt->bindParam(':author', $author);
		$stmt->bindParam(':date_publish', $publishedDate);
		$stmt->bindParam(':count', $count);
		$stmt->bindParam(':livre_id', $id);
		$stmt->execute();
	}
	
	public function GetBookById($id){
		$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM livres where livre_id = ?");
		$stmt->execute(array($id));
		$result = $stmt->fetch();
		return $result;
	}
	
	public function GetBookByISBN($isbn){
		$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM livres where isbn = ?");
		$stmt->execute(array($isbn));
		$result = $stmt->fetch();
		return $result;
	}
}	
?>