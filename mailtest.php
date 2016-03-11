<?php
   
   class MailSMTP{
      private  $USERNAME = "autobookets@gmail.com";
      private  $PASSWORD = "4m7Wt9nL2vCy";
      private  $HOST = "smtp.gmail.com";
      private  $PORT = 587;
      private  $SENDER = "BookÉTS";
      private  $FROMEMAIL = "autobookets@gmail.com";
      private $mail;
      
      function __construct() {
         require_once("PHPMailer/PHPMailerAutoload.php");
         
         $mail = new PHPMailer();
         $mail->IsSMTP();
         $mail->CharSet = 'UTF-8';
         $mail->Host       = $this->HOST; 
         $mail->SMTPDebug  = 0;                     
         $mail->SMTPAuth   = true; 
         $mail->SMTPSecure = "tls";  
         $mail->Port       = $this->PORT;  
         $mail->Username   = $this->USERNAME; 
         $mail->Password   = $this->PASSWORD;    
         $mail->SetFrom($this->FROMEMAIL, $this->SENDER);
         $this->mail = $mail;
      }
      public function send($email, $messageBody, $subject){
         $this->mail->Subject = $subject;
         $this->mail->MsgHTML($messageBody);
         $this->mail->AddAddress($email);
         return $this->mail->Send();
         
      }
   }
   $Email = new MailSMTP();
   echo ($Email->send("marqfrederic@gmail.com","allo","Reservation")) ? 'true' : 'false';
   
?>