<?php
if(isset($_POST['loguser']))
{
	$user = $_POST['loguser'];
	$logmessage = $_POST['logmessage'];
	$folder = "logs";
	$file="logs/".$user.".log";
	if(file_exists($folder))
	{
		$file = fopen($file,"a");
		date_default_timezone_set('Asia/Kolkata');
		$message = date('m/d/Y h:i:s a', time());
		$logmessage = $message." : ".$logmessage."\n";
		echo fwrite($file,$logmessage);
		fclose($file);
		echo "success";		
	}
	else
	{
		echo "failed";		
	}
}
?>