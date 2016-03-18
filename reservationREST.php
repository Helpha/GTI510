<?php
   include_once('db/BookReservationDB.php');
   include_once("sendMail.php");
   include_once("db/UserDB.php");
   include_once("db/BookDB.php");
   
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
            
            // Send Email to User
            $db = new DBHandler();
            $userDB = new UserDB($db);
            $bookDB = new BookDB($db);
            $book = $bookDB->GetBookById($_POST['bookId']);
            $user = $userDB->GetUser($_POST['userId']);
            $Email = new MailSMTP();
            echo ($Email->send($user['email'],"Nouvelle Réservation","Vous avec réservé le livre ". $book['title'] ." du ". $date_start . " au " . $date_end . ".")) ? 'true' : 'false';
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