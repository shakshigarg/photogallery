<?php
function redirect_to($to)
{
header("Location: ".$to);
exit;
}

function datetime_to_text($datetime="")
{
	$unixdatetime=strtotime($datetime);
	return strftime("%B %d,%Y at %I:%M %p",$unixdatetime);
}


function log_action($action,$message="")
{
	$file="../../logs/logs.txt";
	if(!file_exists($file))
	{
		$handle=fopen($file,'w+');
		fclose($handle);
	}
	if(!is_writable($file))
	{
		die("file does not have write permissions");
	}
    $content=strftime("%y-%m-%d %H %M %S",time());
    $content.="|";
    $content.=$action;
    $content.=" : ";
    $content.=$_SESSION['username'];
    $content.=" ".$message."\n";
	$handle=fopen($file, 'a');
	fwrite($handle, $content);
	fclose($handle);

}
?>