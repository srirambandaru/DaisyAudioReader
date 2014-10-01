<?php
if (isset($_GET['result']))
{ 
	$result = unserialize(urldecode($_GET['result']));
	$status = "success";
	include_once("php_includes/db_conx.php");
	$userid=$result[0];
	$bookaddress=$result[1];
	$zip = new ZipArchive;	
	$file=fopen("bookmark.txt","w");
	
	$sql = "SELECT * FROM bookmarks,bookdetails WHERE UserId='".$userid."' AND bookaddress='".$bookaddress."' AND bookmarks.BookId=bookdetails.BookId";
	$result = mysqli_query($db_conx, $sql);
	while($db_field = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{			
		fwrite($file,$db_field['bookmarkname']);
		fwrite($file,"$");
		fwrite($file,$db_field['audiofile']);
		fwrite($file,"$");
		fwrite($file,$db_field['bookmarktime']);
		fwrite($file,"$");
	}
	fclose($file);
	$file=fopen("metadata.txt","w");
	$sql = "SELECT * FROM bookdetails WHERE bookaddress='".$bookaddress."'";
	$result = mysqli_query($db_conx, $sql);
	while($db_field = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{			
		fwrite($file,$db_field['BookName']);
		fwrite($file,"$");
		fwrite($file,$db_field['Author']);
		fwrite($file,"$");
		fwrite($file,$db_field['Publisher']);
		fwrite($file,"$");
		fwrite($file,$db_field['Publisher']);
		fwrite($file,"$");
	}
	fclose($file);
	$zipPath = "compressed_books/".$bookaddress.".zip";
	if ($zip->open($zipPath) === TRUE) 
	{
		$zip->deleteName($bookaddress."/".'bookmark.dlf');
		$zip->deleteName($bookaddress."/".'metadata.dlf');
		$zip->close();
		echo 'ok';
	} 
	else 
	{
		echo 'failed';
		$status="fail";
	}
	

	$res = $zip->open($zipPath, ZipArchive::CREATE);
	if ($res === TRUE) 
	{
		$zip->addFile("bookmark.txt", $bookaddress."/".'bookmark.dlf');
		$zip->addFile("metadata.txt", $bookaddress."/".'metadata.dlf');
		$zip->close();
		echo 'ok';
	} 
	else 
	{
		echo 'failed';
		$status="fail";
	}
	if (unlink("bookmark.txt"))
	{
	}
	else
	{
	$status="fail";
	}
	if (unlink("metadata.txt"))
	{
	}
	else
	{
	$status="fail";
	}
	if($status=="success")
	{
		if (file_exists($zipPath)) 
		{   	
			header("location: ".$zipPath);
			
		}
		else
		{
			echo "failed";
		}
	}

}
?>
