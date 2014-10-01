<?php
include_once("php_includes/check_login_status.php");
if($user_ok == true)
{
	header("location: home.php");
}
else
{
}
?>
<?php
require_once("Model/signup_model.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
<style type="text/css">
td
{
	width:200px;
	font-size:20px;
	height:60px;
}
#signupbtn, input
{
	font-size:20px;
	width:196px;
	height:30px;
}
#wrap
{
	width:700px;
	margin:0 auto;
}
#status
{
	color:red;
}
</style>
<script src="js/ajax.js"></script>
<script>
emailStatus=1;
function _(elem)
{
	return document.getElementById(elem);
}
function restrict(elem){
	var tf = _(elem);
	var rx = new RegExp;
	if(elem == "email"){
		rx = /[' "]/gi;
	} else if(elem == "username"){
		rx = /[^a-z0-9]/gi;
	}
	tf.value = tf.value.replace(rx, "");
}
function emptyElement(x){
	_(x).innerHTML = "";
}
function checkusername(){
	var u = _("username").value;
	if(u != ""){
		_("unamestatus").innerHTML = 'checking ...';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            _("unamestatus").innerHTML = ajax.responseText;
	        }
        }
        ajax.send("usernamecheck="+u);
	}
}
function checkEmail()
{
	_("emailstatus").innerHTML = "";
	window.emailStatus=1;
	var x=_("email").value;
	var atpos=x.indexOf("@");
	var dotpos=x.lastIndexOf(".");
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
	{
	_("emailstatus").innerHTML = "Not a vaild email id";
	window.emailStatus=0;
	}
}
function signup(){
	var u = _("username").value;
	var e = _("email").value;
	var p1 = _("pass1").value;
	var p2 = _("pass2").value;
	var status = _("status");
	if(u == "" || e == "" || p1 == "" || p2 == ""){
		status.innerHTML = "Fill out all of the form data";
	}
	else if(window.emailStatus==0)
	{
		status.innerHTML= "Email id provided is not valid";
	}
	else if(p1 != p2){
		status.innerHTML = "Your password fields do not match";
	} else {
		//alert("inside");
		_("signupbtn").style.display = "none";
		status.innerHTML = 'please wait ...';
		var ajax = ajaxObj("POST", "signup.php");
        ajax.onreadystatechange = function() {
	        if(ajaxReturn(ajax) == true) {
	            if(ajax.responseText != "signup_success"){
					//alert(ajax.responseText);
					status.innerHTML = ajax.responseText;
					_("signupbtn").style.display = "block";
				} else {
					window.location="index.php";
					//_("signupform").innerHTML = "OK "+u+", check your email inbox and junk mail box at <u>"+e+"</u> in a moment to complete the sign up process by activating your account. You will not be able to do anything on the site until you successfully activate your account.";
				}
	        }
        }
        ajax.send("u="+u+"&e="+e+"&p="+p1);
	}
}

</script>
</head>
<body>
	<div id="wrap">
		<h3>Sign Up Here</h3>
		<form name="signupform" id="signupform" onsubmit="return false;">
			<table cellpadding=0 border=0>
				<tr>
					<td>
						Username
					</td>
					<td>
						<input id="username" type="text" onblur="checkusername()" onkeyup="restrict('username')" maxlength="16">
					</td>
					<td width="300px">
						<span id="unamestatus"></span>
					</td>
				</tr>
				<tr>
					<td>
						Email Id
					</td>
					<td>
						<input id="email" type="text" onfocus="emptyElement('status')" onkeypress="checkEmail()" onkeydown="checkEmail()" onkeyup="restrict('email')" maxlength="88">
					</td>
					<td>
						<span id="emailstatus"></span>
					</td>
				</tr>
				<tr>
					<td>
						Create Password
					</td>
					<td>
						<input id="pass1" type="password" onfocus="emptyElement('status')" maxlength="100">
					</td>
					<td>
					</td>
				</tr>
				<tr>
					<td>
						Confirm Password
					</td>
					<td>
						<input id="pass2" type="password" onfocus="emptyElement('status')" maxlength="100">
					</td>
					<td>
					</td>
				</tr>
				<tr align=center>
					<td colspan=3>
						<span id="status"></span>
					</td>
				</tr>
				<tr align='center' height=100px>
					<td colspan=3>
						<button id="signupbtn" onclick="signup()">Create Account</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>