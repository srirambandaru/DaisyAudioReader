<?php
if(isset($_POST["usernamecheck"]))
{
	include_once("php_includes/db_conx.php");
	$username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);
	$sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
    $uname_check = mysqli_num_rows($query);
    if (strlen($username) < 3 || strlen($username) > 16) 
	{
	    echo '<strong style="color:#F00;">3 - 16 characters please</strong>';
	    exit();
    }
	if (is_numeric($username[0])) 
	{
	    echo '<strong style="color:#F00;">Usernames must begin with a letter</strong>';
	    exit();
    }
    if ($uname_check < 1) 
	{
	    echo '<strong style="color:#009900;">' . $username . ' is OK</strong>';
	    exit();
    } 
	else 
	{
	    echo '<strong style="color:#F00;">' . $username . ' is taken</strong>';
	    exit();
    }
}
?>
<?php
if(isset($_POST["u"]))
{
	include_once("php_includes/db_conx.php");
	$u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = $_POST['p'];
    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));
	$sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$u_check = mysqli_num_rows($query);
	$sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
    $query = mysqli_query($db_conx, $sql); 
	$e_check = mysqli_num_rows($query);
	if($u == "" || $e == "" || $p == "")
	{
		echo "The form submission is missing values.";
        exit();
	}
	else if ($u_check > 0)
	{ 
        echo "The username you entered is alreay taken";
        exit();
	}
	else if ($e_check > 0)
	{ 
        echo "That email address is already in use in the system";
        exit();
	}
	else if (strlen($u) < 3 || strlen($u) > 16) 
	{
        echo "Username must be between 3 and 16 characters";
        exit(); 
    }
	else if (is_numeric($u[0])) 
	{
        echo 'Username cannot begin with a number';
        exit();
    }
	else 
	{
		$p_hash = md5($p);
		$sql = "INSERT INTO users (username, email, password, ip, signup, lastlogin) VALUES('$u','$e','$p_hash','$ip',now(),now())";
		$query = mysqli_query($db_conx, $sql); 
		$uid = mysqli_insert_id($db_conx);
		/*if (!file_exists("user/$u")) 
		{
			mkdir("user/$u", 0755);
		}*/
		echo "signup_success";
		exit();
	}
	exit();
}
?>