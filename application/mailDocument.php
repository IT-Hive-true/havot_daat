<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

$documentID = $_GET['docID'];
$email = $_GET['email'];

// get document
$documentQuery = "SELECT t1.case_id, t1.document
			FROM tbdocuments as t1
			WHERE 	(t1.id = ".$documentID.")";
$docResult = mysqli_query($db_server,$documentQuery);
if (!$docResult) die("Database access failed: " . mysqli_error());
if (mysqli_num_rows($docResult))
{
	$docRow = mysqli_fetch_row($docResult);
}
// get case details
$caseQuery = "SELECT t1.patient_name, t1.patient_sex, t1.court_num, t2.name
			FROM tbcases as t1
			LEFT JOIN tbcompanies as t2
			ON t1.defence_company_id = t2.id
			WHERE (t1.id = ".$docRow[0].")";
$caseResult = mysqli_query($db_server,$caseQuery);
if (!$caseResult) die("Database access failed: " . mysqli_error());
if (mysqli_num_rows($caseResult))
{
	$caseRow = mysqli_fetch_row($caseResult);
}


$mailSubject = "";
if ($caseRow[2] != "")
{
	$mailSubject .= "ת.א. ".$caseRow[2];
}
if ($caseRow[1] != "M")
{
	$mailSubject .= "גב' ".$caseRow[0];
}
else
{
	$mailSubject .= "מר ".$caseRow[0];
}
if ($caseRow[3] != "")
{
	$mailSubject .= " נ' ".$caseRow[3];
}

$mailContent = $docRow[1]."<br><span>בברכה,<br>פרופ' ירניצקי</span>";
sendMail($email,$mailSubject,$mailContent);

echo "sucsess!";