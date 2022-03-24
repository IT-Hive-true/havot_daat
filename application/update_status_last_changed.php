<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

$caseQuery = "SELECT t1.id,t1.patient_name
		FROM tbcases as t1"; 
		
$caseResult = mysqli_query($db_server,$caseQuery);
if (!$caseResult) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($caseResult))
{
	for ($i=0;$i<mysqli_num_rows($caseResult);$i++)
	{
		$caseRow = mysqli_fetch_row($caseResult);
		echo $caseRow[1]." - ";
		
		$eventQuery = "SELECT t1.timestamp
						FROM tbevents as t1
						WHERE case_id = ".$caseRow[0]." and
						      type = 12
						ORDER BY timestamp desc
						LIMIT 0,1"; 
				
		$eventResult = mysqli_query($db_server,$eventQuery);
		if (!$eventResult) die("Database access failed: " . mysqli_error());
		elseif (mysqli_num_rows($eventResult))
		{
			$eventRow = mysqli_fetch_row($eventResult);
			$timestamp = $eventRow[0];
		}
		else
		{
			$timestamp = '0000-00-00';
		}
		echo $timestamp."<br>";
		
		$updateQuery = "UPDATE tbcases
						SET status_last_changed = '".$timestamp."'
						WHERE id = ".$caseRow[0]; 
				
		$updateResult = mysqli_query($db_server,$updateQuery);
		if (!$updateResult) die("Database access failed: " . mysqli_error());
	}
}