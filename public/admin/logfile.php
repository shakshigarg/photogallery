<?php
require_once("../../includes/database.php");
require_once("../../includes/user.php");
require_once("../../includes/session.php");
require_once("../../includes/function.php");
if(!$session->is_logged_in())
{
	redirect_to("login.php");
}
$file="../../logs/logs.txt";
if(isset($_GET['clear']))
{
	unlink($file);
}

require_once("../layout/admin_header.php");?>
<h2 style="color: #1A446C; border: 2px solid #1A446C; padding: 10px; margin-right:10px;margin-top:  10px;margin-bottom:  10px; display: inline-block;"><strong>ALL LOGGED USERS</strong></h2><br><br>
<?php
$file="../../logs/logs.txt";
	if(!file_exists($file))
	{
		$handle=fopen($file,'w+');
		fclose($handle);
	}
	if(!is_readable($file))
	{
		die("file does not have read permissions");
	}
	log_action("login","logged in");
	$content=file_get_contents($file);
	echo nl2br($content);
	echo '<BR><br><a href="logfile.php?clear=1">CLEAR LOG FILE</a>';
	?>
	<br><br>
	<a href="index.php">&laquo;BACK</a><br><br>
	</div>
	<?php
	require_once("../layout/footer.php");
	?>