<?php
require_once 'generalPHP.php';
require_once 'db.php';

// Connect to DB
$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

$query = "SELECT t1.ID, t1.object_type, t1.object_id, DATE_FORMAT(date(t1.creation_date),'%d/%m/%Y'), t2.first_name, t2.last_name
			FROM tbalerts as t1, tbusers as t2
			where t1.from_user = t2.id and
         		  t1.to_user = ".$userId." and 
				  t1.hold_until <= date(now())"; 			
$result = mysqli_query($db_server,$query);
if (!$result) die("Database access failed: " . mysqli_error());
if (!mysqli_num_rows($result))
{
	echo "<span class=\"gray\">אין התראות</span>";
	exit;		
}	


echo "<ul class=\"no-decoration-ul\">";
for ($i=0;$i<mysqli_num_rows($result);$i++)
{
	$row = mysqli_fetch_row($result);
	
	// alert about an event
	if ($row[1]==1)
	{
		$eventQuery = "SELECT t1.type, t1.case_id, t2.patient_name
					FROM tbevents as t1, tbcases as t2
					where t1.case_id = t2.id and
						t1.id = ".$row[2]; 
				
		$eventResult = mysqli_query($db_server,$eventQuery);
		if (!$eventResult) die("Database access failed in eventQuery: " . mysqli_error());
		if (mysqli_num_rows($eventResult))
		{
			$eventRow = mysqli_fetch_row($eventResult);
			echo "<li id=\"alert".$row[0]."\">";
			echo "<a class=\"ui-icon ui-icon-clock icon-clickable\" title=\"החבא ל-30 יום\" onclick=\"hideAlert(".$row[0].",30);\">&nbsp</a>";
			echo "<a class=\"ui-icon ui-icon-close icon-clickable\" title=\"מחיקה\" onclick=\"deleteAlert(".$row[0].");\">&nbsp</a>";
			echo "&nbsp&nbsp<a href=\"showCase.php?id=".$eventRow[1]."\">".$eventTypes[$eventRow[0]]." - ".$eventRow[2]." (".$row[4]." ".$row[5]." ".$row[3].")</a></li>";
		}
		else
		{
			echo "<li id=\"alert".$row[0]."\">";
			echo "<a class=\"ui-icon ui-icon-clock icon-clickable\" title=\"החבא ל-30 יום\" onclick=\"hideAlert(".$row[0].",30);\">&nbsp</a>";
			echo "<a class=\"ui-icon ui-icon-close icon-clickable\" title=\"מחיקה\" onclick=\"deleteAlert(".$row[0].");\">&nbsp</a>";
			echo "&nbsp&nbspהתראה על אירוע שאינו קיים במערכת (".$row[4]." ".$row[5]." ".$row[3].")</li>";
		}
	}
	
}
echo "</ul>";
