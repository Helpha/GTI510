<?php
include_once('db/BookReservationDB.php');
include_once('db/BookDB.php');
include_once('db/GenericDB.php');
include_once('db/UserDB.php');


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method'])){
	if($_POST['method'] == "DELETE" && isset($_POST['id'])){
		$reservationDB = new BookReservationDB();
		$reservationDB->DeleteReservation($_POST['id']);
	}else if($_POST['method'] == "PUT" && isset($_POST['bookId']) && isset($_POST['userId']) && isset($_POST['reservationLength'])){
		$db = new DBHandler();
		$reservationDB = new BookReservationDB($db);
		$bookDB = new BookDB($db);
		$genericDB = new GenericDB($db);
		$settings = $genericDB->GetSettings();
		$errorMessage = Array();
		
		$date_start = date("Y-m-d");
        $date_end  = date('Y-m-d', strtotime('+'.$_POST['reservationLength']));
		$reservations = $reservationDB->GetReservationsForBook($_POST['bookId']);
		$book = $bookDB->GetBookById($_POST['bookId']);
		if(count($reservations)>=$book['Count']){
			$errorMessage[]= "Aucun exemplaire disponible.";
		}
		$reservations = $reservationDB->GetReservationForUser($_POST['userId']);
		if(count($reservations)>=$settings['MaxReservationCount']){
			$errorMessage[]= "Nombre maximum de réservations atteint.";
		}
		
		if(count($errorMessage) == 0){
			$reservationDB->AddReservation($date_start, $date_end, $_POST['bookId'], $_POST['userId']);
			// Send Email to User
			$userDB = new UserDB($db);
			$user = $userDB->GetUser($_POST['userId']);
			$Email = new MailSMTP();
			$Email->send($user['email'],"Nouvelle Réservation","Vous avec réservé le livre ". $book['title'] ." du ". $date_start . " au " . $date_end . ".");

		?>
			<span class="label label-success center-block">Réservé avec succès</span>
		<?php
		} else {
			for($i = 0; $i < count($errorMessage); $i++){
			?>
				<span class="label label-danger center-block"><?php echo $errorMessage[$i]; ?></span>
			<?php
			}
		}
	}
}