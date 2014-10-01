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
		<h3>Help</h3>
		<ol>
			<li>
				To use this website, you must be a user. If you are a new user, create an account with your credentials and login to the system. If you are already a user, then you can directly login.
			</li>
			<li>
				Once you login, there will be a pane in the left side, with the list of all books available. Click on the book you want and it plays automatically.
				
			</li>
			<li>
				If you can't find your book in the sidepane, press "q" and it takes you to search page where you can actually search for a book. From the search results, you can play or download any book. This downloaded book must be played by using our destop application.
			</li>
			<li>
				Once you selected the book you want to play, you can navigate using the following shortcuts
				<ol>
					<li>
					volume increase : + key
					</li>
					<li>
					volume decrease : - key
					</li>
					<li>
					previous sentence: left arrow
					</li>
					<li>
					next sentence : right arrow
					</li>
					<li>
					next paragraph: Ctrl+right arrow
					</li>
					<li>
					previous paragraph: Ctrl+left arrow
					</li>
					<li>
					previous chapter: ctrl+ up arrow
					</li>
					<li>
					next chapter: ctrl+down arrow
					</li>
					<li>
					previous page: up arrow
					</li>
					<li>
					next page: down arrow
					</li>
					<li>
					increase playback rate: ">" key
					</li>
					<li>
					decrease playback rate: "<" key
					</li>
					<li>
					default playback rate: "0" key
					</li>
					<li>
					create bookmark : B
					</li>
					<li>
					show bookmarks : K
					</li>
					<li>
					give feedback:F
					</li>
					<li>
					goto search page :Q
					</li>
					<li>
					logout: Alt+L
					</li>
					<li>
					shift focus to library : A
					</li>
					<li>
					stop audio : S
					</li>
					<li>
					play/pause -> space bar
					</li>
				</ol>
			</li>
			<li>
				If you are still having trouble with any of these, you can contact us. Our contact details are provided in the contact page.
			</li>
		</ol>
		</div>
		<?php include("html_includes/footer.html");?>
