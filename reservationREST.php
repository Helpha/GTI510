<?php
include_once('db/BookReservationDB.php');


if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['method'])){
	if($_POST['method'] == "DELETE" && isset($_POST['id'])){
		$reservationDB = new BookReservationDB();
		$reservationDB->DeleteReservation($_POST['id']);
	}else if($_POST['method'] == "PUT" && isset($_POST['bookId']) && isset($_POST['userId']) && isset($_POST['reservationLength'])){
		$reservationDB = new BookReservationDB();
		$date_start = date("Y-m-d");
        $date_end  = date('Y-m-d', strtotime('+'.$_POST['reservationLength']));
		if(true){
		$reservationDB->AddReservation($date_start, $date_end, $_POST['bookId'], $_POST['userId']);
		?>
			<span class="label label-success center-block">Réservé avec succès</span>
		<?php
		} else {
			?>
				<span class="label label-danger center-block">Aucun exemplaire disponible</span>
			<?php
		}
	}
}
?>