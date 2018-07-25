<?php require_once("../../includes/function.php");?>
<?php
session_start();
$_SESSION=array();
if(isset($COOKIE[session_name()]))
{
	setcookie(session_name(),'',time()-4200,'/');
}
session_destroy();
redirect_to("login.php?logout=1");
?>