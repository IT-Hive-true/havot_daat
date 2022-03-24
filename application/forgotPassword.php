<?php 
session_start();
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_POST['username']))
{
	newPassword($db_server);
	exit;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
        <LINK REL="SHORTCUT ICON" HREF="/images/favicon.ico">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel="stylesheet" href="css/main.css" type="text/css" />
		<link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.14.custom.css" type="text/css" />
		<title>מערכת קליניקה - כניסה</title>
	</head>
<body>
<div id="Container">
<div id="Upper">
<div id="SiteLogo">
	<a href="/index.php"><img id="SiteLogoImage" src="/images/logo.jpg" alt="Havot-daat"></a>
</div>
</div>
<br /><br /><br /><br /><br /><br /><br />
<center><p>אנא מלא את שם המשתמש וכתובת האי-מייל שלך,</p>
<p>אנו נשלח לך חזרה מייל עם פרטי ההתחברות.</p><br></center>
<div id="loginFormDiv">


<form method="post" id="resetForm"  name="resetForm" action="forgotPassword.php">
	<table>
	<tr>
		<td>שם משתמש:</td>
		<td><input type="text" name="username"></td> 
	</tr>
	<tr>
		<td>כתובת אי-מייל:</td>
		<td><input type="text" name="email"></td>
	</tr>
	</table>
	<br />
	<?php 
	if (isset($_GET['fail']))
	{
		echo "<p class=\"errorMsg\"><span class=\"ui-icon ui-icon-alert\" style=\"float: right; margin-left: .3em;\"></span>פרטיך לא מזוהים ע\"י המערכת.</p>";
	}
	?>
	<br />
	<center><input id="resetFormSubmit" type="submit" value="אפס סיסמא"></center>
</form>
<br /><br /><br /><br /><br /><br /><br />
<script>
$("#loginFormSubmit").button({ icons: { secondary: "ui-icon-check" }});
</script>
</div>
</div>
</body>
</html>

<?php 
function newPassword($db_server)
{
	session_start();
	$_SESSION['userId'] = 0;
	$_SESSION['clientId'] = 0;
	require_once 'generalPHP.php';
	
	$userName = sanitizeInput($_POST['username']);
	$email = sanitizeInput($_POST['email']);
	
	$query = "SELECT t1.email,t1.first_name,t1.last_name 
				FROM tbusers as t1 
				WHERE (t1.username='".$userName."')";
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		if ($row[0] == $email)
		{
			$newPass = substr(md5(rand().rand()), 0, 6);
			$updateSQL = "update tbusers SET password = '".md5($newPass)."clean' 
						  WHERE (username='".$userName."')";
			$updateResult = mysqli_query($db_server,$updateSQL);
			if (!$updateResult) die("Database access failed: " . mysqli_error());
			
			sendMail($row[0],'איפוס סיסמא לאתר חוות דעת', $row[1]." ".$row[2].",<br>לבקשתך איפסנו לך סיסמא.<br>סיסמתך החדשה היא:&nbsp;&nbsp;<b>".$newPass."</b>");
			
			header("Location: index.php?reset=true");
			exit;
		}
		else
		{
			header("Location: forgotPassword.php?fail=true");
			exit;
		}
	}
	else
	{
		header("Location: forgotPassword.php?fail=true");
		exit;
	}
}
