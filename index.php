<?php
//This part checks if, the user is already logged in. If yes, then it redirects directly to the home.php. This is common for all the php files.
include_once("php_includes/check_login_status.php");
if($user_ok == true){	
	header("location: home.php");
    exit();
}
?>
<?php include_once("Model/login_model.php");
//Using login_model.php for user login credentials validation. The included file has sql statements and everything goes correctly, it creates sessions and cookies too.
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/style2.css" />
<link href="css/cvit_style.css" rel="stylesheet" type="text/css">
<title>Reading System</title>
<style><!--Styling for this page-->
#main {  
        width: 500px;  
        margin:auto;  
        background: #ececec;  
        padding: 20px;  
        border: 1px solid #ccc;  
    }  
</style>
<script src="js/ajax.js"></script>
<script>
function _(elem)
{
	return document.getElementById(elem);
}
function emptyElement(x)
{
	_(x).innerHTML = "";
}
function login()//This function is called onclicking submit of the form
{
	var u = _("username").value;
	var p = _("password").value;
	if(u == "" || p == "")
	{
		_("status").innerHTML = "Fill out all of the form data";
	}
	else
	{
		_("loginbtn").style.display = "none";
		_("status").innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "index.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) 
			{
	            if(ajax.responseText == "login_failed")
				{					
					_("status").innerHTML = "Login unsuccessful, please try again.";
					_("loginbtn").style.display = "block";
				} 
				else
				{
					window.location = "home.php";
				}
	        }
        }
        ajax.send("u="+u+"&p="+p);
	}
}
</script>
</head>

<body>  

<div class="Header">Reading System developed by CVIT, IIITH</div>
<br>
<br>
<br>



<br>
<br>
<br>
<table width=950px>
	<tr>
		<td><a href="http://cvit.iiit.ac.in/index.php?page=home"><img src="images/cvit.jpg" width=110px height=130px border="0"></a></td>
		<td width='900px' align='center'></td>
		<td><a href="http://cvit.iiit.ac.in/index.php?page=home"><img src="images/iiith_logo.jpg" width=150px height=100px border="0"></a></td>
	</tr>
</table>

<br>
<br>

<div class="Content" style="padding-left:120px;">
	<table cellpadding="5" cellspacing="5"><tbody><tr><td align="left" valign="top" width="128px">
		<!-- Left tab of links here-->
		<!-- logo here -->
		<br><br>
		<!-- links here-->
		<table bgcolor="#ccddee" cellspacing="5" width=100px><tbody><tr><td>
			
			<br>- <a href="about.php">About</a><br>
			<br>- <a href="help.php">Help</a><br>
			<br>- <a href="contact.php">Contact</a><br>
			
			<br>
		</td></tr></tbody></table>
		<!-- link end here -->
		<!-- left tab ends here -->
	
		</td><td align="left" valign="top">
		<!--the actual content of page goes here-->
		<table>
<tbody><tr><td valign="top">
	<table>
		<tbody>
<tr><td text-align:justify="">
		<br><br><br><br><br><br><br><br>
		<div id="main">  
		<center>
        <h1>Kindly Login...</h1>  
        </center>
        <form id="loginform" onsubmit="return false;">
		<table height=160px>			
			<tr>
				<td width=150px style="font-size:20px">
					Username:
				</td>
				<td>
					<input id="username" type="text" name="usern"  onfocus="emptyElement('status')" maxlength="88">
				</td>
			</tr>
			<tr>
				<td style="font-size:20px">
					Password:
				</td>
				<td>
					<input id="password" type="password" name="pwd"  onfocus="emptyElement('status')" maxlength="100">
				</td>
			</tr>
			<tr align="center">
				<td>
					<button id="loginbtn" onclick="login()">Login</button> 
				</td>
				<td>
					<input type="reset" name="login_submit" value="Reset" id="reset" align="center">
				</td>
			</tr>
			<tr>
				<td colspan=2 align="center">
					<a href="signup.php" id="register">New User? Register here</a>
				</td>
			</tr>
		</table>
	</form>   
	<p id="status"></p>
      </div>
</td></tr>

</tbody></table> 
</td>

</tr></tbody></table>
		<!-- page content ends here -->
	</td></tr>	
	</tbody></table>

	<br>
	<table width=1000px bgcolor="#ccddee" ><tbody><tr><td align="right"><font size="-2">Center for Visual Information Technology, IIIT, Hyderabad</font>
	</td><td>TTS developed by <a href="http://speech.iiit.ac.in/">Speech lab IIITH</a></td></tr></tbody></table>	
	<table width=1000px><tbody><tr><td align="right"><font size="-2"><em>Last Modified: Fri July 05 17:40:05 IST 2013</em></font>
	</td></tr></tbody></table>

</div>

</body>
</html>
