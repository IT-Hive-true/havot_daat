<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

$caseIdKeep = sanitizeMySQL($_POST['caseIdKeep']);
$caseIdDel = sanitizeMySQL($_POST['caseIdDel']);

// 1. merge tbevents
$merge_tbevents_sql = "INSERT INTO tbevents ( `client_id`,`case_id`,`type`,`file_name`,`file_size`,`file_desc`,`method`,`timestamp`,`document_id`,`remarks`,`parm1`,`parm2`,`parm3`,`parm4`,`parm5`,`parm6`,`parm7`,`parm8`)
	SELECT 
    `tbevents`.`client_id`,
    " . $caseIdKeep . ",
    `tbevents`.`type`,
    `tbevents`.`file_name`,
    `tbevents`.`file_size`,
    `tbevents`.`file_desc`,
    `tbevents`.`method`,
    `tbevents`.`timestamp`,
    `tbevents`.`document_id`,
    `tbevents`.`remarks`,
    `tbevents`.`parm1`,
    `tbevents`.`parm2`,
    `tbevents`.`parm3`,
    `tbevents`.`parm4`,
    `tbevents`.`parm5`,
    `tbevents`.`parm6`,
    `tbevents`.`parm7`,
    `tbevents`.`parm8`
FROM  tbevents
	 ,tbcases
WHERE     tbcases.ID = " . $caseIdDel . "
	  AND tbcases.ID = tbevents.case_id
	  AND tbcases.status != 12";
  

$mergeCaseResult = mysqli_query($db_server,$merge_tbevents_sql);
if (!$mergeCaseResult) die("Database access failed: " . mysqli_error()." <br> SQL: ".$merge_tbevents_sql);

// 2. merge tbdocuments
$merge_tbdocuments_sql = "INSERT INTO tbdocuments (`client_id`,`case_id`,`event_id`,`date`,`method`,`to_who`,`cc`,`to_details`,`document`)
SELECT 	`tbdocuments`.`client_id`,
		" . $caseIdKeep . ",
		`tbdocuments`.`event_id`,
		`tbdocuments`.`date`,
		`tbdocuments`.`method`,
		`tbdocuments`.`to_who`,
		`tbdocuments`.`cc`,
		`tbdocuments`.`to_details`,
		`tbdocuments`.`document`
FROM tbdocuments
	 ,tbcases
WHERE     tbcases.ID = " . $caseIdDel . "
	  AND tbcases.ID = tbdocuments.case_id
	  AND tbcases.status != 12";
	  
$mergeCaseResult = mysqli_query($db_server,$merge_tbdocuments_sql);
if (!$mergeCaseResult) die("Database access failed: " . mysqli_error()." <br> SQL: ".$merge_tbdocuments_sql);
	  

// 3. in tbcases  update status = 16=>"מחיקת תיק" 
$query = "	UPDATE tbcases
			SET
				status = 12
			WHERE ID = ".$caseIdDel;

$result = mysqli_query($db_server,$query);
if (!$result) die("Database access failed: " . mysqli_error()." <br> SQL: ".$query);
	  
header("Location: showCase.php?id=".$caseIdKeep);
	exit;
