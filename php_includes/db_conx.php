<?php
$db_found = false;
$db_conx = mysqli_connect("localhost", "root", "", "reader2");
if (mysqli_connect_errno()) 
{
    echo mysqli_connect_error();
    exit();
}
else 
{
	$db_found=true;
}
?>