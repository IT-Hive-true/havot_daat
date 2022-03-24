<?php 

require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

$caseId=sanitizeInput($_GET['caseId']);
//atached files 
	$eventsQuery = "SELECT t1.file_name, t1.file_desc
					FROM tbevents as t1
					WHERE  (t1.case_id = ".$caseId.") and
							(t1.file_name != \"\")
					ORDER BY t1.timestamp desc";
	$eventsResult = mysqli_query($db_server,$eventsQuery);
	if (!$eventsResult) die("Database access failed: " . mysqli_error());
	if (!mysqli_num_rows($eventsResult))
	{
		echo "אין קבצים מצורפים";
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="/js/jquery-1.6.2.min.js" type="text/javascript"></script>
        <script src="/js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
        <script src="/js/clinic.js" type="text/javascript"></script>
        <link rel="stylesheet" href="/css/ui-lightness/jquery-ui-1.8.14.custom.css" type="text/css" />
        <title>עריכת אירוע</title>
        <script type="text/javascript">
        $(document).ready(function() { 
        		$( "#tabs" ).tabs();
        	});
        
        </script>
</head>
<body>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>


<div id="tabs" style="width:95%;height:94%;" >
	<ul>
		<?php for ($i=0;$i<mysqli_num_rows($eventsResult);$i++)
		{
			$eventsRow = mysqli_fetch_row($eventsResult);
			if ($eventsRow[1] == "") {$eventsRow[1] = "ללא תיאור"; }
			echo "<li><a href=\"#tabs-".($i+1)."\">".$eventsRow[1]."</a></li>";
			$fileNames[($i+1)] = $eventsRow[0];
		}
		?>
	</ul>
	
	<?php for ($i=1;$i<=mysqli_num_rows($eventsResult);$i++)
	{
		echo "<div id=\"tabs-".$i."\" style=\"padding:0px;width:100%;height:95%;\" >";
		echo "<iframe  style=\"width:100%;height:100%;\" src=\"/files/".$fileNames[($i)]."\"></iframe>";
		echo "</div>";
		
		
	}
	?>
	
</div>



</body>
</html>