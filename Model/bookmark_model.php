<?php
require_once("../php_includes/db_conx.php");
$bookmarkname = preg_replace('#[^a-z0-9]#i', '', $_POST['bookmarkname']);
$bookaddress = preg_replace('#[^a-z0-9_]#i', '', $_POST['bookaddress']);
$bookmarktime = preg_replace('#[^a-z0-9.]#i', '', $_POST['bookmarktime']);
$audiofile = preg_replace('#[^a-z0-9.]#i', '', $_POST['audiofile']);
$userid = preg_replace('#[^a-z0-9]#i', '', $_POST['userid']);
$sql="SELECT BookId FROM bookdetails WHERE BookAddress='".$bookaddress."';";
$result=mysqli_query($db_conx,$sql);
$count=mysqli_num_rows($result);
if ($count!=1)
{
exit();
}
$row = mysqli_fetch_row($result);
$bookid = $row[0];
$sql="INSERT INTO bookmarks (UserId, BookId, audiofile, bookmarkname, bookmarktime) VALUES ('$userid','$bookid','$audiofile','$bookmarkname','$bookmarktime')";
if($query = mysqli_query($db_conx, $sql))
	echo "bookmark_success";
?>