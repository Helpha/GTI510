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

	public function GetAllBooks(){
		$stmt = $this->dbHandler->getInstance()->prepare("SELECT * FROM livres ORDER BY title");
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function AddBook($isbn, $title, $description, $imageUrl, $author, $publishedDate, $count){
		$stmt = $this->dbHandler->getInstance()->prepare("INSERT INTO livres (isbn, title, description, Image_Url, author, date_publish, Count) VALUES (:isbn, :title, :description, :Image_Url, :author, :date_publish, :Count)");
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
		"UPDATE users 
		SET isbn = :isbn, title = :title, description = :description, Image_Url = :Image_Url, author = :author, date_publish = :data_publish, Count = :Count 
		WHERE livre_id = :id"
		);
		$stmt->bindParam(':isbn', $isbn);
		$stmt->bindParam(':title', $title);
		$stmt->bindParam(':description', $description);
		$stmt->bindParam(':Image_Url', $imageUrl);
		$stmt->bindParam(':author', $author);
		$stmt->bindParam(':date_publish', $publishedDate);
		$stmt->bindParam(':Count', $count);
		$stmt->bindParam(':id', $id);
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