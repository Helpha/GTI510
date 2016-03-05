<?php
   class reservation {
      
      
      private function get_db_instance() {
         //define( 'ROOT_DIR', dirname(__FILE__) );
         require_once(dirname(__FILE__).'/../connect.php'); // Require needed classes
         $dbh = new DBHandler(); // Create DBHandler
         
         // Check if database connection established successfully
         if ($dbh->getInstance() === null) {
            die("Fatal error : no database connection");
         }
         
         return $dbh;
         
      }
      
      public function query_reservation_list_id($id) {
      
               $dbh = $this->get_db_instance();
         
         try {
            
            if($dbh->getInstance()) {
               echo ('Connected <br />');
            }
            
            $sql = "SELECT * FROM reservation WHERE user_id='".$id."' AND active='1'";
            $stmt = $dbh->getInstance();
            $result = $stmt->query($sql);
            
            foreach  ($result as $row) {
               print $row['reservation_id'] . " | ";
               print $row['date_start']. "	| ";
               print $row['livre_id']. "	| ";
               print $row['user_id']. "	| ";
               print $row['date_end'] . "<br />";
            }
            
         } 
         catch(PDOException $e) {
            echo $e;
         }
      
      
  /*       
         $dbh = $this->get_db_instance();
         
         
         $stmt = $dbh->getInstance()->prepare("SELECT * FROM reservation WHERE user_id=:id");
         $stmt->bindParam(':id', $id);
         $stmt->execute();
         $result = $stmt->fetch();
 
         foreach  ($result as $row) {
            print $row['reservation_id'] . " | ";
            print $row['date_start']. "	| ";
            print $row['date_end'] . "<br />";
         }
         
     */    
         //$stmt = $dbh->getInstance()->prepare("SELECT * FROM reservation WHERE user_id=:id");
         //$stmt->bindParam(':id', $id);
         /*
            $reservation_id = "12";
            $stmt = $dbh->getInstance()->prepare("SELECT * FROM reservation WHERE reservation_id=:id");
            $stmt->bindParam(':id', $reservation_id);
            echo $stmt->queryString;
            $stmt->execute();
            
            foreach  ($result as $row) {
            print $row['reservation_id'] . " | ";
            print $row['date_start']. "	| ";
            print $row['date_end'] . "<br />";
            }
         */           
         
         
         // un return de quel type?
      }
      
      public function query_reservation_list() {
         
         $dbh = $this->get_db_instance();
         // $datetime = date("Y-m-d H:i:s");
         
         try {
            
            if($dbh->getInstance()) {
               echo ('Connected <br />');
            }
            
            $sql = "SELECT * FROM reservation WHERE active='1'";
            $stmt = $dbh->getInstance();
            $result = $stmt->query($sql);
            
            foreach  ($result as $row) {
               print $row['reservation_id'] . " | ";
               print $row['date_start']. "	| ";
               print $row['livre_id']. "	| ";
               print $row['user_id']. "	| ";
               print $row['date_end'] . "<br />";
            }
            
         } 
         catch(PDOException $e) {
            echo $e;
         }
         
         
      }
      public function addReservation($livre_id, $user_id){
         $dbh = $this->get_db_instance();
         
         $sql = "INSERT INTO RESERVATION (date_start, date_end, livre_id, client_id , active) VALUES (:date_start, :date_end, :livre_id, :client_id, :active)";
         //$stmt = $dbh->getInstance();
         //$stmt->prepare($sql);
         
         $stmt = $dbh->getInstance()->prepare("INSERT INTO RESERVATION (date_start, date_end, livre_id, user_id , active) VALUES (:date_start, :date_end, :livre_id, :user_id, '1')");
         
         $date_start = date("Y-m-d");
         $date_end  = date('Y-m-d', strtotime('+5 days'));
         
         
         //$date_end = date("Y-m-d H:i:s", $date_end);
         
         $stmt->bindParam(':date_start', $date_start);
         $stmt->bindParam(':date_end', $date_end);
         
         $stmt->bindParam(':livre_id', $livre_id);
         $stmt->bindParam(':user_id', $user_id);
         
         //$stmt->bindParam(':active', 1);
         
         $stmt->execute();
      }
      
      public function removeReservation($reservation_id){
         // $stmt = $this->dbHandler->getInstance()->prepare("DELETE FROM RESERVATION WHERE reservation_id=':reservation_id'");
         
         $dbh = $this->get_db_instance();
         
         //$sql = "DELETE FROM RESERVATION WHERE reservation_id=':reservation_id'";
         $stmt = $dbh->getInstance()->prepare("DELETE FROM `gti510`.`reservation` WHERE `reservation_id`=:reservation_id");
         $stmt->bindParam(':reservation_id', $reservation_id);
         $stmt->execute();
      }
      
      
   }
   
?>
