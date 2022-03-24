<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

$caseQuery = "SELECT t1.id,t1.case_id,t1.file_name,t1.file_desc
		FROM tbevents as t1
		where (t1.file_name is not NULL) and (t1.file_name <> '')"; 
		
$caseResult = mysqli_query($db_server,$caseQuery);
if (!$caseResult) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($caseResult))
{
	for ($i=0;$i<mysqli_num_rows($caseResult);$i++)
	{
		$caseRow = mysqli_fetch_row($caseResult);
		echo $caseRow[0]."(case #".$caseRow[1].") - ".$caseRow[2]." - ".$caseRow[3];
		
		$fileSize = filesize("files/".$caseRow[2]);
		echo " - ".$fileSize."<br>";
		
		$updateQuery = "UPDATE tbevents
						SET file_size = '".$fileSize."'
						WHERE id = ".$caseRow[0]; 
				
		$updateResult = mysqli_query($db_server,$updateQuery);
		if (!$updateResult) die("Database access failed: " . mysqli_error());
	}
}
