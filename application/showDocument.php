<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';


$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);
if (isset($_GET['id']))
{
	$documentId = sanitizeInput($_GET['id']);
}
else
{
	header("Location: index.php");
	exit;
}

$query = "SELECT t1.id
				,t1.document
				,t2.patient_name
				,t1.client_id
			FROM    tbdocuments as t1
				   ,tbcases as t2
			where (t2.id = t1.case_id) 
				and t1.id = ".$documentId; 
			
$result = mysqli_query($db_server,$query);


if (!$result) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($result))
{
	$row = mysqli_fetch_row($result);
	//check if this document belongs to this client
	if ($row[3] != $clientId) {
		header("Location: index.php");
		exit;
	}
}	

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<link rel="stylesheet" href="/css/main.css" type="text/css" />
		<link rel="stylesheet" href="css/print.css" type="text/css"  media="print">
		<script src="/js/jquery-1.6.2.min.js" type="text/javascript"></script>
    	<title><?php 
				// dudy 29/3/2016
				// $row[2] 
				$s = trim($row[2]);
				echo $s; ?></title>
	</head>
<body>
<div class="document">
<?php 
// dudy 24/4/2016

// fix size of לכבוד
$str = str_replace("font-size: 12px;","font-size: medium;",$row[1]);
$str = str_replace('bc6b58cadabb1baad6db34825c2ded73.jpg"','bc6b58cadabb1baad6db34825c2ded73.jpg" id="signature" ',$str);
$str = str_replace('cf5a63746d52d4ab8f26750beab5fa41.jpg"','cf5a63746d52d4ab8f26750beab5fa41.jpg" id="signature" ',$str);

// fix date
$str = str_replace('<P ALIGN="left"','<P ALIGN="left" style="margin-left: 30px; "' , $str );
// fix space at the begining of the line
$str = str_replace('<p dir="RTL">&nbsp;<strong>מסמכים שעמדו לרשותי בעת הכנת חוות הדעת:</strong></p>','<p dir="RTL"><strong>מסמכים שעמדו לרשותי בעת הכנת חוות הדעת:</strong></p>' , $str );

echo $str;

?>
</div>
<script>
// dudy
// #signature_p is used in print.css
jQuery( document ).ready(function( $ ) {
  $('#signature').parent().parent().attr('id','signature_p');
});
</script>
</body>
</html>



