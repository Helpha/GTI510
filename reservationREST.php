<?php
include_once('db/BookReservationDB.php');


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method'])){
	if($_POST['method'] == "DELETE" && isset($_POST['id'])){
		$reservationDB = new BookReservationDB();
		$reservationDB->DeleteReservation($_POST['id']);
	}else if($_POST['method'] == "PUT" && isset($_POST['bookId']) && isset($_POST['userId']) && isset($_POST['date']) && isset($_POST['reservationLength'])){
		$reservationDB = new BookReservationDB();
		$date = strtotime($_POST['date']);
		$dateEnd = strtotime("+".$_POST['reservationLength'], $date);
		$dateEnd = date('Y-m-d', $dateEnd);
		$reservationDB->AddReservation($_POST['date'], $dateEnd, $_POST['bookId'], $_POST['userId']);
		?>
			<span class="label label-success center-block">Réservé avec succès</span>
		<?php
	}
}
?>