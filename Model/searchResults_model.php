<?php
$query=$_GET['searchquery'];
if(strlen($query)==0)
{
	$query=" ";
}
include_once("../php_includes/db_conx.php");

$SQL = "SELECT * FROM bookdetails WHERE BookName LIKE '%".$query."%' OR Author LIKE '%".$query."%' OR Language LIKE '%".$query."%' OR Publisher LIKE '%".$query."%';";
$result = mysqli_query($db_conx, $SQL);
$rows=array();
while ($db_field = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
{
	$rows[] = $db_field;
}
mysqli_free_result($result);
mysqli_close($db_conx);
header("location: ../search.php?result=".urlencode(serialize($rows)));
?>
