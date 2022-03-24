<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_GET['type']))
{
	$queryType = sanitizeMySQL($_GET['type']);
}
else
{
	exit;
}

// Cases in a specific status
if ($queryType == 1)
{
	$status = sanitizeMySQL($_GET['status']);
	$query = "SELECT t1.ID, t1.patient_name, DATE_FORMAT(date(t1.status_last_changed),'%d/%m/%Y')
				FROM tbcases as t1
				where status = ".$status." and
				      t1.client_id = ".$clientId; 
				
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	if (!mysqli_num_rows($result))
	{
		echo "<span class=\"gray\">אין תיקים בסטטוס זה</span>";		
	}	
}

// Cases in a specific status for a period of time
if ($queryType == 2)
{
	$status = sanitizeMySQL($_GET['status']);
	$days =  sanitizeMySQL($_GET['days']);
	$query = "SELECT t1.ID, t1.patient_name,  DATE_FORMAT(date(t1.status_last_changed),'%d/%m/%Y')
				FROM tbcases as t1
				where (status = ".$status.") and
					  (status_last_changed <= (DATE(NOW()) - INTERVAL ".$days." DAY)) and
				      (t1.client_id = ".$clientId.") "; 
				
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	if (!mysqli_num_rows($result))
	{
		echo "<span class=\"gray\"> אין תיקים בסטטוס זה מעל ".$days." ימים</span>";		
	}	
}


echo "<ul>";
for ($i=0;$i<mysqli_num_rows($result);$i++)
{
	$row = mysqli_fetch_row($result);
	echo "<li><a href=\"showCase.php?id=".$row[0]."\">".$row[1]." <span class=\"gray\">(".$row[2].")</span></a></li>";
}
echo "</ul>";
