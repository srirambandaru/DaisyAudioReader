<?PHP
include_once("php_includes/check_login_status.php");
if($user_ok == true)
{
}
else
{
	header("location: index.php");
}
?>
<html>
<head>
<title>Search</title>
<link rel="stylesheet" href="css/style2.css" />
<link href="css/cvit_style.css" rel="stylesheet" type="text/css">

</head>
<body>
	<div id="wrapper">		
		<div id="wrapper-body">
			<?php include("html_includes/header.html");?>
			<div class="grid" id="main">
			<h3>Search</h3>
			<h5>Enter your search query here</h5>
			<form action="search.php" method="get" name="search">
				<input type="text" name="searchquery" style="width:300px;height:36px;font-size:25px">
			</form>
			<p>* You can enter Bookname, Author Name or Language</p>
			<?php 
			if (isset($_GET['searchquery'])) 
			{	
				header("location: Model/searchResults_model.php?searchquery=".$_GET['searchquery']);
			}
			if(isset($_GET['result']))
			{
				try
				{
					$result = unserialize(urldecode($_GET['result']));
				}
				catch(Exception $e)
				{
					exit();
				}
				print "<table width='800' border='1'  cellpadding='13' style='border-color:white'>";
				print "<tr  align='center' bgcolor='#000' style='font-weight:bold;font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;;font-size:22px;color:orange;border-color:orange;border-width:medium;border-style:solid;';>";				
				print "<td>Book Name</td>";
				print "<td>Author</td>";				
				print "<td>Publisher</td>";
				print "<td>Language</td>";
				print "<td>Action</td>";
				print "<td>Action</td>";
				print "</tr>";						
				for($i=0;$i<sizeof($result);$i++)
				{
					print "<tr align='center' style='color:black;background-color:#eee;font-family: Trebuchet MS,Tahoma,Verdana,Arial,sans-serif;font-size:19px'>";
					foreach ($result[$i] as $key => $value) {
						//echo "Key: $key; Value: $value\n";
						if(($key!="CreatorName") and ($key!="BookAddress") and ($key!="BookId") and ($key!="BookUID"))
						{
						print "<td>".$value . "</td>";		
						}
					}
					$bookAddress = $result[$i]["BookAddress"];
					print "<td><a href=\"home.php?vid=".$bookAddress."\">Play</a></td>";
					$rows=array();
					$rows[0]=$_SESSION['userid'];
					$rows[1]=$bookAddress;
					$send=urlencode(serialize($rows));
					print "<td><a href=\"downloads.php?result=".$send."\">Download</a></td>";
					print "</tr>";
				}
			}
			?>			
			</div>
		<?php include("html_includes/footer.html");?>