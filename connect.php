<?php
   // http://stackoverflow.com/questions/30396328/access-the-php-pdo-object-in-another-file
   // http://www.ncls.biz/webmasters/requetes_sql_pdo_php.php?id_article=8
   
   class DBHandler {
      
      private $db;
      
      function __construct() {
         $this->connect_database();
      }
      
      public function getInstance() {
         return $this->db;
      }
      
      private function connect_database() {
         define('USER', 'gti510_dev');
         define('PASSWORD', 'XoHnAK5QVIXfNRfyN70v');
         
         // Database connection
         try {
            $connection_string = 'mysql:host=gti510.techfred.ca;port=13306;dbname=gti510';
            $connection_array = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            );
            $this->db = new PDO($connection_string, USER, PASSWORD, $connection_array);
            //echo 'Database connection established <br />';
         }
         catch(PDOException $e) {
            $this->db = null;
         }
      }   
   }
?>
