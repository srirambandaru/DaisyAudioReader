<?PHP
include_once("php_includes/check_login_status.php");
if($user_ok == true){
$user = $_SESSION['username'];
}
else
{
header("location: index.php");
}
?>
<html>
<head>
<title>Help</title>
<link rel="stylesheet" href="css/style2.css" />
<link href="css/cvit_style.css" rel="stylesheet" type="text/css">
</head>
<body>
	<div id="wrapper">
		
		<?php include_once("html_includes/header.html");?>
		
		<div style="padding-top:110px;width:800px">
		
		<h3>
			Will be updated soon.
		</h3>		
		</div>
		<?php include("html_includes/footer.html");?>
