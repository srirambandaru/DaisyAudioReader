<?php
include_once("../php_includes/db_conx.php");
$feedbackValue = preg_replace('#[^0-5]#i', '', $_POST['feedbackValue']);
if(strlen($feedbackValue)>1)
{
	$feedbackValue=substr($feedbackValue,strlen($feedbackValue)-2);
}
else if(strlen($feedbackValue)==0)
{	
	exit();
}
$bookaddress = preg_replace('#[^a-z0-9_]#i', '', $_POST['bookaddress']);
$feedbacktime = preg_replace('#[^a-z0-9.]#i', '', $_POST['feedbacktime']);
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
$sql="INSERT INTO feedbacks (UserId, BookId, audiofile, feedbacktime, feedbackValue) VALUES ('$userid','$bookid','$audiofile','$feedbacktime','$feedbackValue')";
if($query = mysqli_query($db_conx, $sql))
	echo "feedback_success";
?>