<?php

require_once("mail2/class.phpmailer.php");
require_once("mail2/class.smtp.php");
require_once("mail2/language/phpmailer.lang-el.php");

$to_name="ritu";
$to="ritusingla222@gmail.com";
$subject="MAIL TEST AT ".strftime("%T",time());
$message="hlo ";
$message=wordwrap($message,70);
$from_name="saki";
$from="shakshigarg9416858875@gmail.com";


$mail=new PHPMailer;
$mail->FromName=$from_name;
$mail->From=$from;
$mail->AddAddress($to,$to_name);
$mail->Subject=$subject;
$mail->Body=$message;

// $res=$mail->Send();

// echo $res?'sent':'error';

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>