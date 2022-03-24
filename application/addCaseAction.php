<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

$patientName = sanitizeMySQL($_POST['patientName']);
$patientId = sanitizeMySQL($_POST['patientId']);
$patientBirthdate = sanitizeMySQL($_POST['patientBirthDate']);
$patientSex = sanitizeMySQL($_POST['patientSex']);
$appointmentType = sanitizeMySQL($_POST['appointmentTypeSelect']);
$appointmentDate = sanitizeMySQL($_POST['appointmentDate']);
$courtType = sanitizeMySQL($_POST['courtTypeSelect']);
$judgeName = sanitizeMySQL($_POST['judgeName']);
$judgeSex = sanitizeMySQL($_POST['judgeSex']);
$courtId = sanitizeMySQL($_POST['courtLocationSelect']);
$courtNum = sanitizeMySQL($_POST['court_num']);
$payment = sanitizeMySQL($_POST['payment']);
$tax = sanitizeMySQL($_POST['tax']);
$prosecutorPayment = sanitizeMySQL($_POST['prosecutorPayment']);
$defencePayment = sanitizeMySQL($_POST['defencePayment']);
$defence2Payment = sanitizeMySQL($_POST['defence2Payment']);
$deadline = sanitizeMySQL($_POST['deadline']);
$courtDate = sanitizeMySQL($_POST['courtDate']);
$prosecutorName = sanitizeMySQL($_POST['prosecutorName']);
$prosecutorNumber = sanitizeMySQL($_POST['prosecutorNumber']);
$prosecutorFirmId = sanitizeMySQL($_POST['prosecutorFirmId']);
$defenceName = sanitizeMySQL($_POST['defenceName']);
$defenceNumber = sanitizeMySQL($_POST['defenceNumber']);
$defenceFirmId = sanitizeMySQL($_POST['defenceFirmId']);
$defenceName2 = sanitizeMySQL($_POST['defenceName2']);
$defenceNumber2 = sanitizeMySQL($_POST['defenceNumber2']);
$defenceFirmId2 = sanitizeMySQL($_POST['defenceFirmId2']);
$companyId= sanitizeMySQL($_POST['companyId']);
$company2Id= sanitizeMySQL($_POST['company2Id']);
$extraDemands = sanitizeMySQL($_POST['extraDemands']);
$remarks = sanitizeMySQL($_POST['remarks']);

if ($defenceFirmId == "") { $defenceFirmId = 0; }
if ($defenceFirmId2 == "") { $defenceFirmId2 = 0; }
if ($prosecutorFirmId == "") { $prosecutorFirmId = 0; }
if ($companyId == "") { $companyId = 0; }
if ($company2Id == "") { $company2Id = 0; }
if ($payment == "") { $payment = "NULL"; }
if ($prosecutorPayment == "") { $prosecutorPayment = 0; }
if ($defencePayment == "") { $defencePayment = 0; }
if ($defence2Payment == "") { $defence2Payment = 0; }

// Insert the case
$addCaseSQL = "INSERT INTO tbcases 
			(client_id, status, court_num, creation_date, appointment_type, court_id, patient_id, patient_name, patient_sex, judge_name, judge_sex, defence_lawyer_name, defence_lawyer_number, defence_lawyer_firm_id, defence_lawyer_name_2, defence_lawyer_2_number, defence_lawyer_firm_id_2, prosecutor_name, prosecutor_number, prosecutor_firm_id, defence_company_id, defence_company_2_id, payment_amount, with_tax, prosecutor_payment, defence_payment, defence_2_payment, extra_demands, ";
if ($appointmentDate != "")
{
	$addCaseSQL .= " appointment_date, ";
}
if ($deadline != "")
{
	$addCaseSQL .= "case_deadline, ";
}
if ($courtDate != "")
{
	$addCaseSQL .= "court_date, ";
}
if ($patientBirthdate != "")
{
	$addCaseSQL .= "patient_birthdate, ";
}
$addCaseSQL .= "payed, all_material_recieved, remarks, patient_seen) 
			VALUES (".$clientId.",1,'".$courtNum."',CURRENT_DATE,".$appointmentType.",".$courtId.",'".$patientId."','".$patientName."','".$patientSex."','".$judgeName."','".$judgeSex."','".$defenceName."','".$defenceNumber."',".$defenceFirmId.",'".$defenceName2."','".$defenceNumber2."',".$defenceFirmId2.",'".$prosecutorName."','".$prosecutorNumber."',".$prosecutorFirmId.",".$companyId.",".$company2Id.",".$payment.",".$tax.",".$prosecutorPayment.",".$defencePayment.",".$defence2Payment.",'".$extraDemands."',";
if ($appointmentDate != "")
{
	$addCaseSQL .= "'".$appointmentDate."',";
}
if ($deadline != "")
{
	$addCaseSQL .= "'".$deadline."',";
}
if ($courtDate != "")
{
	$addCaseSQL .= "'".$courtDate."',";
}
if ($patientBirthdate != "")
{
	$addCaseSQL .= "'".$patientBirthdate."',";
}
$addCaseSQL .= "0,0,'".$remarks."',0)"; 
$addCaseResult = mysqli_query($db_server,$addCaseSQL);
if (!$addCaseResult) die("Database access failed: " . mysqli_error()." <br> SQL: ".$addCaseSQL);
// Get the case's ID
$caseId = mysqli_insert_id();


header("Location: showCase.php?id=".$caseId);
	exit;