<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';

if (isset($_GET['caseId']))
{
	$caseId = sanitizeMySQL($_GET['caseId']);
}
else
{
	header("Location: index.php");
	exit;
}
if (isset($_GET['eventId']))
{
	$eventId = sanitizeMySQL($_GET['eventId']);
}
else
{
	header("Location: index.php");
	exit;
}
if (isset($_GET['method']))
{
	$method = sanitizeMySQL($_GET['method']);
}
else
{
	$method = "letter";
}

function generateDocument($db_server,$caseId, $eventId, $method, $templateId, $to, $cc, $toDetails)
{
$patientSexText = array("M" => "מר", "F" => "גב'");

// TEMP
$eventType = 1;
$eventDate = "24/07/2011";


// document settings
$documentSettingsQuery = "SELECT t1.header,t1.footer
							FROM tbdocument_settings as t1
							WHERE is_default= 1";
$documentSettingsResult = mysqli_query($db_server,$documentSettingsQuery);
if (!$documentSettingsResult) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($documentSettingsResult))
{
	$documentSettingsRow = mysqli_fetch_row($documentSettingsResult);
}

// document template
$templateQuery = "SELECT t1.subject,t1.text,t1.signature_img
							FROM tbletter_template as t1
							WHERE t1.id = ".$templateId;
$templateResult = mysqli_query($db_server,$templateQuery);
if (!$templateResult) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($templateResult))
{
	$templateRow = mysqli_fetch_row($templateResult);
}

// case details
$caseQuery = "SELECT t1.ID, t1.patient_seen, t1.court_num, DATE_FORMAT(date(t1.appointment_date),'%d/%m/%Y'), DATE_FORMAT(date(t1.creation_date),'%d/%m/%Y'), t1.appointment_type, t6.type, t6.location, t1.patient_id, t1.patient_name, DATE_FORMAT(date(t1.patient_birthdate),'%d/%m/%Y'), t1.patient_sex, t1.judge_name, t1.judge_sex, t1.defence_lawyer_name, t1.prosecutor_name, t1.payment_amount, t1.with_tax, t1.prosecutor_payment, t1.defence_payment, t1.extra_demands,DATE_FORMAT(date(t1.case_deadline),'%d/%m/%Y') , DATE_FORMAT(date(t1.court_date),'%d/%m/%Y'), t1.payed, t1.all_material_recieved, t1.remarks,
			t2.name, t2.address, t2.email, t2.phone, t2.fax, t3.name, t3.address, t3.email, t3.phone, t3.fax, t4.name, t5.name
			FROM tbcases as t1, tblawyers as t2, tblawyers as t3, tbcompanies as t4, tbstatus as t5, tbcourts as t6
			where (t1.prosecutor_firm_id = t2.id) and 
					(t1.defence_lawyer_firm_id = t3.id) and
					(t1.defence_company_id = t4.id) and
					(t1.status = t5.id) and
					(t1.court_id = t6.id) and
				  	t1.id = ".$caseId; 
			
$caseResult = mysqli_query($db_server,$caseQuery);
if (!$caseResult) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($caseResult))
{
	$caseRow = mysqli_fetch_row($caseResult);
}

//build document

//header
$documentString = $documentSettingsRow[0];


//to
$documentString .= "לכבוד<br>עו\"ד ".$caseRow[15]."<br>".$caseRow[26]."<br>";
switch ($method)
	{
		//mail
		case 1: $documentString .= $caseRow[27];
		break;
		//fax
		case 2: $documentString .= "פקס: ".$caseRow[30];
		break;
		//email
		case 4: $documentString .= $caseRow[28];
		break;
		case 5: $documentString .= $caseRow[27]."<br>"."טלפון: ".$caseRow[29]."<br>"."פקס: ".$caseRow[30]."<br>".$caseRow[28];
		break;
		default: $documentString .= $caseRow[27]."<br>"."טלפון: ".$caseRow[29]."<br>"."פקס: ".$caseRow[30]."<br>".$caseRow[28];
		break;
	}
	
$documentString .= "<br><br><br>שלום רב,<br><br>";

//subject
$documentString .= "<center><u>".$templateRow[0]."</u></center><br><br>";

//text
$documentString .= $templateRow[1]."<br><br>";

$documentString .= "<img src='/images/".$templateRow[2]."' />";

//footer
$documentString .= $documentSettingsRow[1];

// fill tags
$documentString = str_replace("[תאריך]", $eventDate, $documentString);
$documentString = str_replace("[תא]", $caseRow[2], $documentString);
$documentString = str_replace("[סוג_ביהמש]", $courtType[$caseRow[6]], $documentString);
$documentString = str_replace("[מיקום_ביהמש]", $caseRow[7], $documentString);
$documentString = str_replace("[מין_פציינט]", $patientSexText[$caseRow[11]], $documentString);
$documentString = str_replace("[שם_פציינט]", $caseRow[9], $documentString);
$documentString = str_replace("[שם_חברה]", $caseRow[36], $documentString);

// save the document
$insertDocumentSQL = "INSERT INTO tbdocuments 
			(case_id, event_id, method, to_who, cc, to_details, document) 
			VALUES (".$caseId.",".$eventId.",".$method.",'".$to."','".$cc."','".$toDetails."','".sanitizeMySQL($documentString)."')"; 
	$insertDocumentResult = mysqli_query($db_server,$insertDocumentSQL);
	if (!$insertDocumentResult) die("Database access failed: " . mysqli_error());
	// Need to retrieve a new user id
	$documentId = mysqli_insert_id();
	return $documentId;
}

// TEMP - display document
echo <<<_END
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    	<link rel="stylesheet" href="/css/main.css" type="text/css" />
    	<title>
_END;

echo <<<_END
</title>
</head>
<body>
<div class="document">
_END;

echo $documentString;

echo <<<_END
</div>
</body>
</html>
_END;
