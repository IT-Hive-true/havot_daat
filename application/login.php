<?php
ini_set('display_errors',1);
require_once 'db.php';
	
	// Connect to DB
	$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
	if (!$db_server) die("Unable to connect to MySQL: " . mysqli_error());
	mysqli_select_db($db_server,$db_database)
	or die("Unable to select database: " . mysqli_error());
	
	mysqli_set_charset($db_server,'utf8');
	$charset = mysqli_character_set_name($db_server);


if (isset($_POST['username']) &&
	isset($_POST['password']))
{
	
	$un = sanitizeInput($_POST['username']);
	$pw = md5(sanitizeInput($_POST['password']))."clean";
	$query = "	SELECT	 t1.id
						,t1.password,t1.client_id
						,t1.first_name
						,t1.last_name
						,t2.name
				FROM 	 tbusers as t1
						,tbclients as t2 
				WHERE 
						    (t1.client_id = t2.id) 
						and t1.username='$un'";
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);

		// check for password match
		if ($pw == $row[1])
		{
			session_start();
			
			$_SESSION['userId'] = $row[0];
			$_SESSION['clientId'] = $row[2];
			$_SESSION['userName'] = $row[3]." ".$row[4];
			$_SESSION['clientName'] = $row[5];
			$_SESSION['check'] = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']); // save user's ip and browser description for security reasons
			$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
			/* Redirect browser */
			header("Location: dashboard.php");
			/* Make sure that code below does not get executed when we redirect. */
			exit;
			
		}
		//else die("Invalid username/password combination");
		header("Location: index.php?fail=true");
	}
	//else die("Invalid username/password combination");
	header("Location: index.php?fail=true");
}
else
{
	header('WWW-Authenticate: Basic realm="Restricted Section"');
	header('HTTP/1.0 401 Unauthorized');
	die ("Please enter your username and password");
}

function sanitizeInput($str)
{
	$str = strip_tags($str);
	$str = stripslashes($str);
	$str = htmlentities($str,ENT_QUOTES,"UTF-8");
	return $str;
}
?>