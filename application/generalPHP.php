<?php
#########################################################################
ini_set("memory_limit", "-1");
ini_set('max_execution_time', -1);
ini_set('display_errors', '1');
error_reporting(E_STRICT | E_ALL ^ E_DEPRECATED);
#########################################################################
session_start();

require 'db.php';

// Connect to DB
$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
if (!$db_server) die("Unable to connect to MySQL: " . mysqli_error());
mysqli_select_db($db_server,$db_database)
or die("Unable to select database: " . mysqli_error());

mysqli_set_charset($db_server,'utf8');
$charset = mysqli_character_set_name($db_server);

if (isset($_SESSION['userId']))
{
	// dudy 04/09/2016 - I expanded the logout time to 12 hours, as David requested
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 43200)) {
	// dudy 19/8/2016 - I expanded the logout time to 4 hours, as David requested
	//if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 14400)) {
	// check if the session hasn't been active for 30 minutes
	//if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 7200)) {
	
	    // last request was more than 30 minates ago
	    destroy_session_and_data();
	    header("Location: index.php?loginAgain=true");
		exit;
	}
	
	// Check it's still the same user (ip & user agent)
	if ($_SESSION['check'] = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) 
	{
		//  *** Valid session
		global $userId; $userId = $_SESSION['userId'];
		global $clientId; $clientId = $_SESSION['clientId'];
		$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	}
	else
	{
		destroy_session_and_data();
		header("Location: index.php");
		exit;
	}
}
else
{
	header("Location: index.php");
	exit;
}

# aws s3 params
$bucket = 'havot-daat';
$folder = 'files/';
$aws_key = 'AKIAJQUIRM5FDMNIQPJQ';
$aws_secret = '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';

//globals
global $caseType; $caseType = array(1 => "מינוי על-ידי שופט", 2 => "מינוי בהסכמה", 3 => "חוות דעת פרטית");
global $courtType; $courtType = array(1 => "שלום", 2=> "מחוזי", 3 => "לענייני משפחה", 4 => "לעניינים מקומיים", 5 => "לנוער", 6 => "עליון");
global $payedText; $payedText = array(0 => "לא", 1 => "חלקית", 2 => "כן");
global $sexText; $sexText = array("M" => "זכר", "F" => "נקבה");
global $booleanText; $booleanText = array(0 => "לא", 1 => "כן");
global $methodText; $methodText = array(1 => "דואר", 2 => "פקס", 3 => "טלפון", 4 => "אי-מייל", 5 => "אחר");
global $casesInPage; $casesInPage = 1000;
global $objectTypes; $objectTypes = array(1 => "אירוע", 2 => "תיק");
global $eventTypes; $eventTypes = array(1=>"הוספת מסמכים",
										2=>"ביקור פציינט",
										3=>"זימון פציינט",
										4=>"דרישת תשלום",
										5=>"כתיבת חוו\"ד",
										6=>"ניפוק חוו\"ד",
										7=>"הפניה לבדיקה",
										8=>"שאלות הבהרה",
										9=>"ביטול חוו\"ד",
										10=>"השהיית חוו\"ד",
										11=>"תשלום",
										12=>"שינוי סטטוס",
										13=>"קביעת תור",
										14=>"בקשה\הודעה כללית",
										15=>"אירוע אחר"
										);
global $eventsParms;
global $eventsOptions;

$eventsOptions = array(
	1 => array(
		1 => array(1 => "כתב מינוי",2 => "חומר רפואי",99 => "אחר"),
		2 => array(1 => "תובע",2 => "נתבע",3 => "ביהמ\"ש",4 => "המרפאה",99 => "אחר"),
		3 => array(0 => "לא", 1 => "כן")
			),
	2 => array(
		1 => array(0 => "לא", 1 => "כן"),
		2 => array(1 => "ימין", 2 => "שמאל")
			),
	8 => array(
		1 => array(1 => "שאלה", 2 => "תשובה"),
		2 => array(1 => "תובע",2 => "נתבע",3 => "ביהמ\"ש",4 => "המרפאה",99 => "אחר")
			),
	9 => array(
		1 => array(1 => "ביהמ\"ש",2 => "המרפאה",99 => "אחר")
			),
	10 => array(
		1 => array(1 => "תובע",2 => "נתבע",3 => "ביהמ\"ש",4 => "המרפאה",99 => "אחר")
			),
	11 => array(
		1 => array(1 => "תובע",2 => "נתבע",99 => "אחר")
			),
	12 => array(
		2 => array(1 => "ידני",2 => "אוטומטי")
			),
	13 => array(
		1 => array(1 => "אלישע",2 => "מדיקליניק")
			),
	14 => array(
		1 => array(4 => "המרפאה",1 => "תובע",2 => "נתבע",3 => "ביהמ\"ש",99 => "אחר")
			)
);

connectDB($db_database,$db_hostname, $db_username, $db_password);

//populate event 12, parm 1 - statuses

$query = "SELECT name 
			FROM tbstatus   
			ORDER BY id asc";
$result = mysqli_query($db_server,$query);
if (!$result) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($result))
{
	for ($i=1;$i<=mysqli_num_rows($result);$i++)
	{
		$row = mysqli_fetch_row($result);
		$eventsOptions[12][1][$i] = $row[0];
	}
}
			
			
//TODO populate event 13, parm 1 - clinics


$eventsParms = array(
	1 => array(
		1 => "סוג",
		2 => "מקור",
		3 => "הגיע כל החומר" ,
		6 => "רשימת מסמכים" 
			),
	2 => array(
		1 => "הזדהה עם תעודה",
		2 => "יד דומיננטית",
		6 => "תולדות התאונה" ,
		7 => "תולדות המטופל" ,
		8 => "מהלך הבדיקה" 
			),
	3 => array(

			),
	4 => array(
		
			),
	5 => array(

		6 => "בדיקות עזר" ,
		7 => "דיון ומסקנות" 
			),
	6 => array(
		
			),
	7 => array(
		5 => "סוג בדיקה" 
			),
	8 => array(
		1 => "שאלה \ תשובה",
		2 => "מי שאל",
		6 => "השאלה \ תשובה" 
			),
	9 => array(
		1 => "בוטל ע\"י",
		4 => "תאריך הביטול" ,
		6 => "סיבה" 
			),
	10 => array(
		1 => "יוזם ההשהייה",
		4 => "עד תאריך" ,
		6 => "סיבה"  
			),
	11 => array(
		1 => "מי שילם",
		4 => "תאריך התשלום" ,
		5 => "סכום התשלום"
			),
	12 => array(
		1 => "סטטוס חדש",
		2 => "איך בוצע",
		5 => "בוצע ע\"י" ,
		6 => "סיבה לשינוי"  
			),
	13 => array(
		1 => "מרפאה",
		4 => "תאריך" ,
		5 => "שעה" ,
			),
	14 => array(
		1 => "מי שלח",
		5 => "כותרת" ,
		6 => "תוכן" 
			),
	15 => array(
		4 => "תאריך" ,
		5 => "כותרת" ,
		6 => "תוכן" ,
		7 => "תוכן נוסף" 
			)
);


// connectDB() - creates connection to DB with parameters from db.php
function connectDB($db_database,$db_hostname, $db_username, $db_password)
{
	require_once 'db.php';
	
	// Connect to DB
	$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
	if (!$db_server) die("Unable to connect to MySQL: " . mysqli_error());
	mysqli_select_db($db_server,$db_database)
	or die("Unable to select database: " . mysqli_error());

	mysqli_set_charset($db_server,'utf8');
	$charset = mysqli_character_set_name($db_server);
}

function updateStatus($caseId,$statusName)
{
	extract ($GLOBALS);
	
	$statusQuery = "SELECT t1.id
			FROM tbstatus as t1
			where t1.name = '".$statusName."'"; 
			
	$statusResult = mysqli_query($statusQuery);
	if (!$statusResult) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($statusResult))
	{
		$statusRow = mysqli_fetch_row($statusResult);
		$statusId = $statusRow[0];
	
		$query = "UPDATE tbcases  
				SET status = ".$statusId." , status_last_changed = CURRENT_TIMESTAMP() 
				WHERE ID = ".$caseId;
		$result = mysqli_query($query);
		if (!$result) die("Database access failed: " . mysqli_error());
		
		$query = "INSERT INTO tbevents
					(client_id,case_id, type, timestamp, parm1, parm2, parm4, parm5, parm6) 
					VALUES (".$clientId.",".$caseId.", 12, CURRENT_TIMESTAMP, ".$statusId.", 2,NULL, '0', 'שינוי סטטוס אוטומטי ל-".$statusName."')";
		
		$result = mysqli_query($query);
		if (!$result) die("Database access failed: " . mysqli_error());
	}
}

function sanitizeInput($str)
{
	//$str = strip_tags($str);
	$str = stripslashes($str);
	//$str = htmlentities($str,ENT_QUOTES,"UTF-8");
	return $str;
}

function sanitizeMySQL($var)
{
	require 'db.php';

	// Connect to DB
	$db_server = mysqli_connect($db_hostname, $db_username, $db_password);
	$var = sanitizeInput($var);
	$var = mysqli_real_escape_string($db_server,$var);
	return $var;
}

function destroy_session_and_data()
{
	$_SESSION = array();
	if (session_id() != "" || isset($_COOKIE[session_name()]))
		setcookie(session_name(), '', time() - 2592000, '/');
	session_destroy();
}

function get_user_ip()
{
	//Test if it is a shared client
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	  $ip=$_SERVER['HTTP_CLIENT_IP'];
	//Is it a proxy address
	}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
	  $ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

// returns the current page's name
function curPageName() 
{
	return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

function sendMail($to,$subject,$content,$ccMail="ccmail@havot-daat.co.il")
{	
	$message = 	"<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
        			<title>New eMail from www.havot-daat.co.il</title>
					<style>
						body{
							direction:rtl;
							margin:0px;
						    padding:0px;
							font-size: 12px;
							color: #333333;
							font-style: normal;
							font-family: Arial;
							letter-spacing: normal;
							font-variant: normal;
							text-decoration: none;
							overflow-x:hidden;
						}
						a{
							text-decoration:none;
							cursor:hand;
						}
						a:hover { text-decoration:underline;}
						p{  margin:0px; padding:0px; }
						h1, h2, h3{ margin:0px; }
						img{ border:none; }
						.comment {color:#808080;font-size:small;}
					</style>
				</head>
				<body style=\"direction:rtl;\">
					<br />
					<h1>".$subject."</h1>
					<BR /><BR /><BR />
					".$content."
					<BR /><BR /><BR /><BR /><BR /><BR />
					<span class=\"comment\">הודעה זאת נשלחה מאתר חוות דעת <a href=\"http://www.havot-daat.co.il\">http://www.havot-daat.co.il/</a></span><br />
					<a href=\"http://www.havot-daat.co.il\"><img src=\"http://www.havot-daat.co.il/images/logo.jpg\" height=\"60px\" /></a>
				</body>
				</html>";
	
	// In case any of our lines are larger than 70 characters, we should use wordwrap()
	$message = wordwrap($message, 70); 

	$headers = "From: אתר חוות דעת <message-center@havot-daat.co.il>\r\n";
	$headers .= "Reply-To: yarnitskyd@gmail.com\r\n";
	$headers .= "Cc: ".$ccMail."\r\n";
	$headers .= "Content-type: text/html\r\n";

	mail($to, $subject, $message, $headers);
}

function getSetting($str)
{
	extract ($GLOBALS);
	
	$query = "SELECT t1.value
			FROM tbsettings as t1
			where (t1.key = '".$str."') and
			      (t1.client_id = ".$clientId.")"; 
			
	$result = mysqli_query($query);
	if (!$result) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		return $row[0];
	}
	else
	{
		return "No setting found ";
	}
}

?>
