<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_GET['from']))
{
	$from = "'".sanitizeMySQL($_GET['from'])."'";
	$from = "STR_TO_DATE(".$from.",'%d-%m-%Y')";
}
else
{
	$from = "(DATE(NOW()) - INTERVAL 1 YEAR)";
}
if (isset($_GET['to']))
{
	$to = "'".sanitizeMySQL($_GET['to'])."'";
	$to = "STR_TO_DATE(".$to.",'%d-%m-%Y')";
}
else
{
	$to = "DATE(NOW())";
}

?>

        <script type="text/javascript" src="/js/raphael/raphael-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.raphael-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.bar-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.dot-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.line-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.pie-min.js"></script>
		<title>דו"ח 2 - מינויים</title>
		
		<table class="eventsTable">
		<th>מינויים לפי חודשים</th>
		<?php 
			$query = "select count(*),concat(month(appointment_date),\"/\",year(appointment_date))
						from tbcases as t1
						where (t1.appointment_date is not null) and
							  (t1.appointment_date >= ".$from.") and 
						      (t1.appointment_date <= ".$to.") and
						      (t1.client_id = ".$clientId.") 
						group by month(t1.appointment_date), year(t1.appointment_date)";
			$result = mysqli_query($db_server,$query);
			if (!$result) die("Database access failed: " . mysqli_error());
			elseif (mysqli_num_rows($result))
			{
				for ($i=0;$i<mysqli_num_rows($result);$i++)
				{
					echo "<tr>";
					$row = mysqli_fetch_row($result);
					echo "<td>".$row[1]."</td>";
					echo "<td>".$row[0]."</td>";
					echo "</tr>";
				}
			}
			else
			{
				echo "אין נתונים רלוונטיים להצגה";
			}
		?>
		</table>
				
	</head>
<body class="raphael">
<nobr>
<span id="graph2-1"></span>
<span id="graph2-2"></span>
</nobr>
<br />
<nobr>
<span id="graph2-3"></span>
<span id="graph2-4"></span>
</nobr>
</body>

