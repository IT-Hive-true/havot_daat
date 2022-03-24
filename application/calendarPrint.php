<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_GET['date']))
{
	$date = sanitizeMySQL($_GET['date']);
}
else
{
	echo "לא נבחר תאריך";
	exit;
}

$query = "SELECT t1.id,t1.parm5,t2.name,t3.patient_name,t3.id
			FROM tbevents as t1,tbclinics as t2,tbcases as t3
			WHERE 	(t1.case_id = t3.id) and
					(t1.parm1 = t2.id) and
					(t1.type = 13) and
					(date(t1.parm4) = '".$date."') and
         			(t1.parm5 <> 'allDay') and
         			(t1.client_id = ".$clientId.") 
			ORDER BY t1.parm5 asc";			
$result = mysqli_query($db_server,$query);
if (!$result) die("Database access failed: " . mysqli_error());

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
       <script src="js/clinic.js" type="text/javascript"></script>
       <link rel="stylesheet" href="/css/main.css" type="text/css" />
       <title>הדפסת רשימת תורים</title>
       <script type="text/javascript">
        $(document).ready(function() { window.print(); });
       </script>
	</head>
<body>
<div id="content">
<center>
<h1>רשימת תורים לתאריך <?=$date ?></h1>
<br />
<br />
<table class="solidTable">
<th style="width:100px;">שעה</th>
<th style="width:400px;">שם</th>
<?php 

if (mysqli_num_rows($result))
{
	for ($i=0;$i<mysqli_num_rows($result);$i++)
	{
		$row = mysqli_fetch_row($result);
		
		echo "<tr>";
		echo "<td>".$row[1]."</td>";
		echo "<td>".$row[3]."</td>";
		echo "</tr>";
	}
}
else
{
	echo "אין תורים בתאריך זה";
}
?>
</table>
<br><br>
<img src="images/logo.jpg" width="200px" />
</center>
<A HREF="javascript:window.print()">הדפס</A>
</div>
</body>
</html>