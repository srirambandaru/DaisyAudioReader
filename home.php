<?PHP
include_once("php_includes/check_login_status.php");
if($user_ok == true){
$user = $_SESSION['username'];
}
else
{
header("location: index.php");
}
if(isset($_POST['allBooks']))
{
}
else
{
//header("location: Controller/home_controller.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Reading System</title>
<link rel="stylesheet" href="css/style2.css" />
<link href="css/cvit_style.css" rel="stylesheet" type="text/css">
<link href="css/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui-1.10.3.custom.js"></script>
<script src="js/functionality.js"></script>
<script src="js/ajax.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<style>
.grid
{
	display:inline;
	float: left;
	position: relative;	
}
#feedback
{
	padding:20px;
	z-index:1;
	width:400px;
	height:80px;
	margin: -100px 0 0 -200px;
	top: 50%;
	left: 50%;
	position:absolute;
	border:2px solid #000; 
	background-color:#eee;
}
#bookmark
{
	padding:20px;
	z-index:1;
	position:absolute;
	margin: -100px 0 0 -200px;
	width:300px;
	height:80px;
	top: 50%;
	left: 50%;
	border:2px solid #000; 
	background-color:#eee;
}
#bookmarkdisplay
{
	padding:30px 0;
	padding-right:20px;
	width:200px;
	z-index:1;
	margin: -100px 0 0 -200px;
	top: 50%;
	left: 50%;
	position:absolute;
	border:2px solid #000; 
	background-color:#eee;
}
#main 
{  
    width: 700px;  
    margin:auto;      
    padding: 20px;      
}  
.btnStyle
{
	width:30px;
	border:none;
}
 </style>
<script>
v=document.getElementById('video'); 
document.addEventListener('keyup', pop, false); 
clickState=0;
function playAndFocus()//function is used by hidebookmark, hidefeedback, hidebookmarkdisplay
{
	$("#wrapper").fadeTo("slow",1);
	$('#wrapper').unbind('click');
	$("body").css("overflow", "scroll");
	if(v)
	{
		if(v.networkState!=3)
		{
			if (clickState==0)
			{
				//v.pause();
			}
			else
			{
				//v.play();
			}
		}
		v.focus();
	}
}
function showFeedback()//show the feedback pane
{
	$("#feedback").show();		
	$("#bookmarkdisplay").hide();
	$("#wrapper").fadeTo("slow",0.25);
	$('#wrapper').click(function(e){
		e.preventDefault();
	});
	$("body").css("overflow", "hidden");
	$("#feedvalue").focus();
	if(v)
	{
		
	}
	//window.clickState=
	v.pause();
}
function showBookmark()//shows the bookmark pane
{
	$("#bookmarkdisplay").hide();
	$("#bookmark").show();		
	$("#wrapper").fadeTo("slow",0.25);
	$('#wrapper').click(function(e){
		e.preventDefault();
	});
	$("body").css("overflow", "hidden");
	$("#bookvalue").focus();
	v.pause();
}
function showBookmarkDisplay()//shows the bookmarkdisplay pane
{
	$("#bookmarkdisplay").show();		
	$("#wrapper").fadeTo("slow",0.25);
	$('#wrapper').click(function(e){
		e.preventDefault();
	});
	$("body").css("overflow", "hidden");
	v.pause();
	$("#bookmarkdisplay").focus();		
}
 function hideFeedback()//hides the feedback pane
{
	$("#feedback").hide();		
	playAndFocus();
}
function hideBookmark()//hides the bookmark pane
{
	$("#bookmark").hide();		
	playAndFocus();
}
function hideBookmarkDisplay()//hides the bookmarkdisplay pane
{
	$("#bookmarkdisplay").hide();		
	playAndFocus();
}
function hideall()//hides all the panes, and shifts focus to video
{
	hideBookmark();	
	hideFeedback();
	hideBookmarkDisplay();
}
function pop(e)//keyboard shortcuts for this page
{
	k=e.keyCode;
	if(k==70)//f key
	{
		if(v.networkState!=3)
		{
			if(document.activeElement.id!="bookvalue")
			{
				showFeedback();
			}
		}
	}
	else if(k==66)//b key
	{
		if(v.networkState!=3)
		{
			if(document.activeElement.id!="feedvalue")
			{
				showBookmark();
			}
		}
	}
	else if(k==75)//k key
	{
		if(v.networkState!=3)
		{
			if(document.activeElement.id!="feedvalue" && document.activeElement.id!="bookvalue")
			{
				showBookmarkDisplay();
			}
		}
	}
	else if(k==27)//esc key
	{
	hideall();
	}
}
function createbookmark()//uses ajax to create bookmarks. calls the bookmarkdisplay with the neccessary values and waits for the response. if response text is successful, then...
{
	var bookmarkname=document.getElementById("bookvalue").value;
	var arr=String(v.src).split("/");
	var audiofile=arr[arr.length-1];
	var bookmarktime=v.currentTime;
	var userid="<?php echo $_SESSION['userid']?>";
	var bookaddress=document.getElementById("booktitle").innerHTML;	
	var ajax = ajaxObj("POST", "Model/bookmark_model.php");
	ajax.onreadystatechange = function() 
	{
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "bookmark_success")
			{
				document.getElementById("bookvalue").value="bookmark1";
				
				message=_("autoBookmark").innerHTML;
				count=message.split("<li>");				
				if (count.length==1)
				{
					_("autoBookmark").innerHTML="";
				}
				
				_("autoBookmark").innerHTML+="<li><a href='javascript:goToLocation(\""+bookaddress+"\",\""+audiofile+"\",\""+bookmarktime+"\")'>"+bookmarkname+"</a></li>";
				v.focus();
			}			
			else
			{			
				alert("bookmarking unsuccessful");
				//alert(ajax.responseText);
			}
		}
		hideBookmark();
		createLog("create bookmark for "+bookname);
	}
	ajax.send("bookmarkname="+bookmarkname+"&bookmarktime="+bookmarktime+"&bookaddress="+bookaddress+"&audiofile="+audiofile+"&userid="+userid);
}
function saveFeedback()//same as createBOokmark
{
	var feedbackValue=document.getElementById("feedvalue").value;
	var arr=String(v.src).split("/");
	var audiofile=arr[arr.length-1];
	var feedbacktime=v.currentTime;
	var userid="<?php echo $_SESSION['userid']?>";
	var bookaddress=document.getElementById("booktitle").innerHTML;	
	var ajax = ajaxObj("POST", "Model/feedback_model.php");
	ajax.onreadystatechange = function() 
	{
		if(ajaxReturn(ajax) == true) {		
			if(ajax.responseText == "feedback_success")
			{
				document.getElementById("feedvalue").value="3";
				v.focus();
			}			
			else
			{		
				//alert("feedback recording failed");
				alert(ajax.responseText);
			}
		}
		hideFeedback();
		createLog("gave feedback for "+bookaddress);
	}
	ajax.send("feedbackValue="+feedbackValue+"&feedbacktime="+feedbacktime+"&bookaddress="+bookaddress+"&audiofile="+audiofile+"&userid="+userid);
}
function addBook()//same as createBookmark
{
	var userid="<?php echo $_SESSION['userid']?>";
	var bookaddress=document.getElementById("booktitle").innerHTML;
	if(bookaddress=="")
	{
		return 0;
	}
	var ajax = ajaxObj("POST", "Model/addBooks_model.php");
	ajax.onreadystatechange = function() 
	{
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "add_success")
			{				
				v.focus();
				message=_("myBooks").innerHTML;
				count=message.split("<li>");				
				if (count.length==1)
				{
					_("myBooks").innerHTML="";
				}
				_("myBooks").innerHTML+="<li><a href='home.php?vid="+bookaddress+"'>"+bookaddress+"</a></li>";
				
			}
			else if(ajax.responseText == "failed")
			{			
			}
			else
			{			
			}
		}
		hideFeedback();
		createLog("added book "+bookaddress+" to mybooks");
	}
	ajax.send("bookaddress="+bookaddress+"&userid="+userid);
}
function createLog(message)//uses ajax and calls a php file where logs are created as a text file
{
	var user="<?php echo $_SESSION['username']?>";
//	var bookname=document.getElementById("booktitle").innerHTML;
	var ajax = ajaxObj("POST", "log.php");
	//alert(1);
	ajax.onreadystatechange = function() 
	{
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "failed")
			{
				alert("failed to create log");
			}
			else
			{			
				//alert(ajax.responseText);
			}
		}
		
	}
	ajax.send("logmessage="+message+"&loguser="+user);
}
function restrict()//feedbackvalue validation
{
	var tf = _("feedvalue");
	var rx = new RegExp;	
	rx = /[^1-5]/gi;	
	tf.value = tf.value.replace(rx, "");
	if (tf.value.length>1)
		tf.value=tf.value[0];
}
 </script>
 </head>
<body onload="hideall();">
<div id="bookmarkdisplay" tabindex=0><!--a seperate layer for boomarkdisplay. displays all the available bookmarks from the resultset returned by showbookmarks function in home_model.php. This is only view part. -->
	<?php// include_once("showbookmarks.php");?>
	<?php
	require_once("Model/home_model.php");
	if(isset($_GET["vid"]))
	{
		$result = showBookmarks($_SESSION['userid'],$_GET["vid"]);
		$count=mysqli_num_rows($result);
		echo "<ol id='autoBookmark'>";
		if($count==0)
		{
			echo "<h4>No bookmarks</h4>";
		}		
		while ($db_field=mysqli_fetch_array($result,MYSQLI_ASSOC))
		{					
			
			
			echo "<li><a href='javascript:goToLocation(\"".$db_field['BookAddress']."\",\"".$db_field['audiofile']."\",\"".$db_field['bookmarktime']."\")'>".$db_field['bookmarkname']."</a></li>";
		}
		echo "</ol>";
	}	
	?>		
</div>

<div id="feedback" tabindex=0><!--feedback pane, on submit calls create feedback-->
	<div style="padding-left:25px;">
		<h3>Give your rating to the current video (1 to 5)</h3>
		<form action="" method="post" name="feedbackform" onsubmit="return false">
			<input type="text" name="feedbackvalue" value="3" id="feedvalue" tabindex=0 onblur="" onkeyup="restrict()"/>
			<input type="submit" value="submit" onclick="saveFeedback()"/>
		</form>
	</div>
</div>
<div id="bookmark"  tabindex=0><!--same as feedback-->
	<div style="padding-left:25px;">
		<h3>Bookmark name?</h3>
		<form action="" method="post" name="bookmarkform" onsubmit="return false">
			<input type="text" name="bookmarkvalue" value="bookmark1" id="bookvalue" tabindex=0 onblur=""/>
			<input type="submit" value="submit" onclick="createbookmark()"/>
		</form>
	</div>
</div>
<div id="wrapper" onclick="hideall()">
	
	<?php
	if (isset($_GET['vid'])) //checks if the vid is set, if set it sends the value to the given js function
	{ 
		$var=(string)$_GET['vid'];
		echo "<script>createLog('playing ".$var."')</script>";
		echo "<script>all_sequential_audio_files(\"".$var."\")</script>";
	}
	?>	
	<?php include_once("html_includes/header.html");?><!--an external file-->	
	<div id="main"><!--all the video navigation buttons are here-->
		<div id="video-navigation" style="padding-bottom:20px;border: 1px solid #ccc;">
		<div style="padding-top:20px;text-align:center">
			<img src="images/previousChapter.png" id=btnPrevPage class="btnStyle" title="Previous Chapter" onclick="navRest(-1,2)"></img> 
			<img src="images/previousPage.png" id=btnPrevPage class="btnStyle" title="Previous Page" onclick="navRest(-1,1)"></img> 
			<img src="images/previous.png" id=btnPrevParagraph class="btnStyle" title="Previous Page" onclick="navRest(-1,0)"></img> 
			<img src="images/left.png" id=btnPrev class="btnStyle" title="Previous Sentence" onclick="sentence(1)"></img>
			<img src="images/play.png" id=play class="btnStyle" title="Play" onclick="document.getElementById('video').play()"></img>
			<img src="images/stop.png" id=stop class="btnStyle" title="Stop" onclick="document.getElementById('video').pause();document.getElementById('video').currentTime=0"></img>
			<img src="images/pause.png" id=pause class="btnStyle" title="Pause" onclick="document.getElementById('video').pause();"></img>  
			<img src="images/right.png" id=btnNxt class="btnStyle" title="Next Sentence" onclick="sentence(1)"></img>  
			<img src="images/next.png" id=btnNxtPage class="btnStyle" title="Next Paragraph" onclick="navRest(1,0)"></img> 
			<img src="images/nextPage.png" id=btnNxtPage class="btnStyle" title="Next Page" onclick="navRest(1,1)"></img> 
			<img src="images/nextChapter.png" id=btnNxtPage class="btnStyle" title="Next Chapter" onclick="navRest(1,2)"></img> 
			<img src="images/book.png" id=bookmarkimg class="btnStyle" title="Bookmark" onclick="showBookmark()"></img>
			<img src="images/add.png" id=addToMyBooks class="btnStyle" title="Add to MyBooks" onclick="addBook()"></img>										
			</br>
			</br>
		</div>
		</div>	
		<div>						
			<h3 align=left>Book Title: <span id="booktitle"><?php if(isset($_GET['vid'])){echo $_GET['vid'];} ;?></span></h3>				
			<video tabindex=0 align=center id="video" controls autoplay src="1.mp3" width=0px height=0px >
			</video>		
			</div>
		<div class="grid" id="left-accordion" tabindex=0><!--Same as bookmarkdisplay. Here displaying available books from showallbooks function in home_model.php-->
			<div id="accordion" tabindex=1 style="width:300px">
				<?php// include("allBooks.php")?>
				<?php
				echo "<h3 tabindex=0 id='focusable'>Library</h3><div><ul>";
				$result = showAllBooks();				
				while ($db_field = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
				{
					if($db_field["Language"]=="Malayalam")
					{						
						echo "<li><a href=\"home.php?vid=".$db_field['BookAddress']."\">".$db_field['BookName']."</a></li>";
					}
				}				
				echo "</ul></div>";
				?>
			</div><!--accordion-->
		</div>
		<div class="grid" id="right-accordion" style="padding-left:100px">
			<div id="accordion1" style="width:300px"><!--Same as bookmarkdisplay. Here displaying mybooks from showamybooks function in home_model.php-->
				<h3>My Books</h3>
				<div>		 
					<ul id="myBooks">
					<?php 
						//include_once("showMyBooks.php");
						$result = showMyBooks($_SESSION["userid"]);
						$count=mysqli_num_rows($result);
						if($count==0)
						{
							echo "<h4>No books are added</h4>";
						}						
						while ($db_field=mysqli_fetch_array($result))
						{							
							echo "<li><a href='home.php?vid=".$db_field['BookAddress']."'>".$db_field['BookName']."</a></li>";
						}
						
					?>
					</ul>
				</div>		
			</div><!--accordion-->
		</div>
	</div>
	<?phpinclude("html_includes/footer.html");?>
