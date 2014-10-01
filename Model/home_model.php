<?php
require_once("php_includes/db_conx.php");
function showBookmarks($user,$bookaddress)
{
	global $db_conx;
	$sql="SELECT * FROM bookmarks,bookdetails WHERE bookmarks.UserId=".$user." AND bookdetails.BookAddress='".$bookaddress."' AND bookmarks.BookId=bookdetails.BookId;";
	$result = mysqli_query($db_conx, $sql);
	return $result;
}
function showAllBooks()
{
	global $db_conx;
	$SQL = "SELECT * FROM bookdetails";
	$result = mysqli_query($db_conx, $SQL);
	return $result;
}
function showMyBooks($user)
{
	global $db_conx;
	$sql="SELECT * FROM mybooks,bookdetails WHERE mybooks.UserId=".$user." AND mybooks.BookId=bookdetails.BookId;";	
	$result = mysqli_query($db_conx, $sql);
	return $result;
}
//showBookmarks(1,"Nirmala_Premchand");
//echo "sucess";
?>