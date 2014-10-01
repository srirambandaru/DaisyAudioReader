<?php
if (isset($_GET['result']))
{ 
	$result = unserialize(urldecode($_GET['result']));
	$status = "success";
	include_once("php_includes/db_conx.php");
	$user=$result[0];
	$book=$result[1];
	$zip = new ZipArchive;	
	$file=fopen("bookmark.txt","w");	
	$sql = "SELECT * FROM bookmarks WHERE username='".$user."' AND bookname='".$_GET['book']."'";
	$result = mysqli_query($db_conx, $sql);
	while($db_field = mysqli_fetch_array($result, MYSQLI_ASSOC))
	{			
		fwrite($file,$db_field['bookmarkname']);
		fwrite($file,"\n");
		fwrite($file,$db_field['audiofile']);
		fwrite($file,"\n");
		fwrite($file,$db_field['bookmarktime']);
		fwrite($file,"\n");
	}
	fclose($file);

	$zipPath = "compressed_books/".$book.".zip";
	if ($zip->open($zipPath) === TRUE) 
	{
		$zip->deleteName('bookmark.txt');
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
		$zip->addFile("bookmark.txt", 'bookmark.dlf');
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
