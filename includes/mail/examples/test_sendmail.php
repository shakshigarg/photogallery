<?php

include_once('../class.phpmailer.php');

$mail             = new PHPMailer();
//$body             = $mail->getFile('contents.html');
///$body             = eregi_replace("[\]",'',$body);
$body="hiii";

$mail->IsSendmail(); // telling the class to use SendMail transport

$mail->From       = "shakshigarg9416858875@gmail.com";
$mail->FromName   = "sakshi";

$mail->Subject    = "PHPMailer Test Subject via smtp";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->AddAddress("ritusingla222@gmail.com", "ritu");

//$mail->AddAttachment("images/phpmailer.gif");             // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>
