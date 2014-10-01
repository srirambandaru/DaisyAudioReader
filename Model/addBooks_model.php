<?php
include_once("../php_includes/db_conx.php");
$bookaddress = preg_replace('#[^a-z0-9_]#i', '', $_POST['bookaddress']);
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
$SQL = "SELECT * FROM mybooks WHERE UserId='".$userid."' AND BookId='".$bookid."' LIMIT 1;";
$result = mysqli_query($db_conx, $SQL);
$count=mysqli_num_rows($result);
if($count!=0)
{
	exit();
}
$sql="INSERT INTO mybooks (UserId, BookId) VALUES ('$userid','$bookid')";
$query = mysqli_query($db_conx, $sql);
echo "add_success";
?>