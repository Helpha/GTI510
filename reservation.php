<?php
   class reservation {
      
      public function query_reservation_list() {
         
         
         $dbh = get_db_instance();
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
               print $row['date_end'] . "<br />";
            }
            
         } 
         catch(PDOException $e) {
            echo $e;
         }
         
         
      }
      private function get_db_instance() {
         
         require_once('connect.php'); // Require needed classes
         $dbh = new DBHandler(); // Create DBHandler
         
         // Check if database connection established successfully
         if ($dbh->getInstance() === null) {
            die("Fatal error : no database connection");
         }
         
         return $dbh;
         
      }
   }
   
?>
