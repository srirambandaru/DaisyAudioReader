<?php
if(isset($_POST["u"])){
	include_once("php_includes/db_conx.php");
	$u = mysqli_real_escape_string($db_conx, $_POST['u']);	
	$p = md5($_POST['p']);	
    $ip = preg_replace('#[^0-9.:]#', '', getenv('REMOTE_ADDR'));
	if($u == "" || $p == ""){
		echo "login_failed";
        exit();
	} 
	else 
	{
		$sql = "SELECT id, email, password FROM users WHERE username='$u' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);
		$db_id = $row[0];
		$db_email = $row[1];
        $db_pass_str = $row[2];
		$db_username = $u;
		if($p != $db_pass_str)
		{
			echo "login_failed";
            exit();
		}
		else 
		{
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE); 
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
			echo $db_username;
		    exit();
		}
	}
	exit();
}
?>