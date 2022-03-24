<?php
require_once 'generalPHP.php';

extract($GLOBALS);
require_once 'db.php';

// Connect to DB
$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);
if (isset($_POST['settings']))
{
	$updateSQL = "UPDATE tbusers  
					SET dashboard_json='".$_POST['settings']."'  
					WHERE id = ".$userId;
	$updateResult = mysqli_query($db_server,$updateSQL);
	if (!$updateResult) die("Database access failed: " . mysqli_error());
}
elseif (isset($_GET['reset']))
{
	$myFile = "jsonfeed/mywidgets.json";
	$fr = fopen($myFile, 'r') or die("can't open file");
	$theData = fread($fr,  filesize($myFile));
	fclose($fr);
	$query = "UPDATE tbusers 
			SET dashboard_json = '".$theData."' 
			WHERE id = ".$userId;
	$result = mysqli_query($query);
	if (!$result) die("Database access failed: " . mysqli_error());
	header("Location: dashboard.php");
	exit;
}
else 
{ 
    $query = "SELECT dashboard_json FROM tbusers WHERE id = ".$userId;
    $result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($result))
	{
    	$row = mysqli_fetch_row($result);
    	if ($row[0] != "")
    	{
    		echo $row[0];	
    	}
    	else
    	{
    		echo "none;";
    	}
	}
	else
	{
		echo "none";
	}
}

?>