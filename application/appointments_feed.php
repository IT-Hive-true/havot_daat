<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_GET['id'])) {
	$clinicId = sanitizeMySQL($_GET['id']);
	$clinicWhere = "(t1.parm1 = ".$clinicId.") and ";
} else {
	$clinicId= 0;
	//$clinicWhere = "(1=1)";
	$clinicWhere = "";
}

if (isset($_GET['start']))
{
	$start = $_GET['start'];
	$end = $_GET['end'];
}
else
{
	$start = "649934016";
	$end = "2133162816";
}

$query = "SELECT t1.id,date(t1.parm4),t1.parm5,t2.name,t3.patient_name,t3.id
			FROM tbevents as t1,tbclinics as t2,tbcases as t3
			WHERE ".$clinicWhere." 
					(t1.case_id = t3.id) and
					(t1.parm1 = t2.id) and
					(t1.type = 13) and
					(t1.parm4 > FROM_UNIXTIME(".$start.")) and
					(t1.parm4 < FROM_UNIXTIME(".$end.")) and
					(t1.client_id = ".$clientId.") 
			ORDER BY t1.parm4 desc";			
$result = mysqli_query($db_server,$query);
if (!$result) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($result))
{
	for ($i=0;$i<mysqli_num_rows($result);$i++)
	{
		$row = mysqli_fetch_row($result);
		
		// check if it's a spaceholder for a clinic day
		if ($row[2] == "allDay")
		{
			$events[$i] = array(
				'id' => 0,
				'title' => $row[3],
				'start' => $row[1],
				'allDay' => true
				);
		}
		else
		{
			$events[$i] = array(
				'id' => $row[5],
				'title' => $row[4],
				'start' => $row[1]."T".$row[2].":00"
				);
		}
	}
	echo json_encode($events);
		
}
exit(0);