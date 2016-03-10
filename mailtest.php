<?php
   
   class MailSMTP{
      
      
      function __construct($email, $messageBody) {
         
         $USERNAME = "autobookets@gmail.com";
         $PASSWORD = "4m7Wt9nL2vCy";
         $HOST = "smtp.gmail.com";
         $PORT = 587;
         $SUBJECT = "BookÉTS";
         
         
         require_once("PHPMailer/PHPMailerAutoload.php");
         
         $mail = new PHPMailer();
         $mail->IsSMTP();
         $mail->CharSet = 'UTF-8';
         
         $mail->Host       = $HOST; // SMTP server example
         $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
         $mail->SMTPAuth   = true;                  // enable SMTP authentication
         $mail->SMTPSecure = "tls";                 // sets the prefix to the servier
         $mail->Port       = $PORT;                    // set the SMTP port for the GMAIL server
         $mail->Username   = $USERNAME; // SMTP account username example
         $mail->Password   = $PASSWORD;        // SMTP account password example
         $mail->MsgHTML($messageBody);
         $mail->AddAddress($email);
         $mail->Subject    = $SUBJECT;
         $mail->Send();
      }
      public function send(){
         
      }
   }
   echo ($Email = new MailSMTP("frederic@somci.ca","allo")) ? 'true' : 'false';
   $Email->send();
   
?>
Done