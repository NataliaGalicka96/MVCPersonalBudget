<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use App\Config;
//use PHPMailer\PHPMailer\Exception;

class Mail
{
   /**
     * Send a message
     *
     * @param string $to Recipient
     * @param string $subject Subject
     * @param string $text Text-only content of the message
     * @param string $html HTML content of the message
     *
     * @return mixed
     */

    public static function send($to, $subject, $text, $html)
    {

      $mail = new PHPMailer;
      $mail->CharSet = "UTF-8";
      $mail->IsSMTP();
      $mail->Host = "smtp.gmail.com";
      $mail->SMTPAuth = true; # Enable SMTP authentication 
      
      $mail->SMTPSecure = "tls";
      $mail->Port       = 587;
      
      $mail->Username   = Config::SMTP_USERNAME;                     //SMTP username
      $mail->Password   = Config::SMTP_PASSWORD;     

            //Recipients
            $mail->setFrom('from@gmail.com', 'Mailer');
            //Add a recipient
            $mail->addAddress($to);  
            $mail->Subject = $subject;
            $content = $html;

            $mail->MsgHTML($content);

            $mail->Send();

            /*
            if(!$mail->Send()) {
              echo "Error while sending Email.";
              var_dump($mail);
            } else {
              echo "Email sent successfully";
            }
            */
    }

}
 