<?php
header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=excel.xls");
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);


if (isset($_GET['from']))
{
	$from = "'".sanitizeInput($_GET['from'])."'";
	$from = "STR_TO_DATE(".$from.",'%d-%m-%Y')";
}
else
{
	$from = "(DATE(NOW()) - INTERVAL 1 YEAR)";
}
if (isset($_GET['to']))
{
	$to = "'".sanitizeInput($_GET['to'])."'";
	$to = "STR_TO_DATE(".$to.",'%d-%m-%Y')";
}
else
{
	$to = "DATE(NOW())";
}

?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Excel Report</title>
<style>
body
{
	direction:rtl;
}
#reportTable {
    border-collapse: collapse;
    font-family: "Trebuchet MS",Arial,Helvetica,sans-serif;

}

#reportTable td, #reportTable th {
    border: 1px solid #98BF21;
    font-size: 1.2em;
    padding: 3px 7px 2px;
}
#reportTable th {
    background-color: #A7C942;
    color: #FFFFFF;
    font-size: 1.4em;
    padding-bottom: 4px;
    padding-top: 5px;
    text-align: left;
}
</style>
</head>
<body>
<table id="reportTable">
<tr>
<th>#</th>
<th>שם פציינט</th>
<th>ת.ז. פצינט</th>
<th>סטטוס</th>
<th>תאריך יצירת תיק</th>
<th>תאריך מינוי</th>
<th>סוג מינוי</th>
<th>ת.א.</th>
<th>סוג בית משפט</th>
<th>מיקום בית משפט</th>
<th>שופט</th>
<th>עו"ד תובע</th>
<th>עו"ד נתבע</th>
<th>עו"ד נתבע 2</th>
<th>תשלום</th>
<th>מע"מ</th>
<th>שולם?</th>
<th>דרישות נוספות</th>

</tr>

<?php 
	$taxText = array("0" => "ללא מע\"מ", "1" => "כולל מע\"מ");
	
	$query = "select t1.id, t1.patient_name, t1.patient_id, t2.name, t1.creation_date, t1.appointment_date, t1.appointment_type, t1.court_num, t3.type, t3.location, t1.judge_name, t1.prosecutor_name, t1.defence_lawyer_name, t1.defence_lawyer_name_2, t1.payment_amount, t1.with_tax, t1.payed, t1.extra_demands
				from tbcases as t1, tbstatus as t2, tbcourts as t3
				where (t1.status = t2.id) and
				      (t1.court_id = t3.id) and
				      (t1.creation_date >= ".$from.") and 
					  (t1.creation_date <= ".$to.") and
					  (t1.client_id = ".$clientId.")";
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($result))
	{
		for ($i=0;$i<mysqli_num_rows($result);$i++)
		{
			$row = mysqli_fetch_row($result);
			echo "<tr>";
			echo "<td>".$row[0]."</td>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
			echo "<td>".$row[3]."</td>";
			echo "<td>".$row[4]."</td>";
			echo "<td>".$row[5]."</td>";
			echo "<td>".$caseType[$row[6]]."</td>";
			echo "<td>".$row[7]."</td>";
			echo "<td>".$courtType[$row[8]]."</td>";
			echo "<td>".$row[9]."</td>";
			echo "<td>".$row[10]."</td>";
			echo "<td>".$row[11]."</td>";
			echo "<td>".$row[12]."</td>";
			echo "<td>".$row[13]."</td>";
			echo "<td>".$row[14]."</td>";
			echo "<td>".$taxText[$row[15]]."</td>";
			echo "<td>".$payedText[$row[16]]."</td>";
			echo "<td>".$row[17]."</td>";
			
			echo "</tr>";
		}
	}
?>
<tr style="border:0px;"><td style="border:0px;">&nbsp</td></tr>
<tr style="border:0px;"><td style="border:0px;">&nbsp</td></tr>
<tr style="border:0px;"><td style="border:0px;">&nbsp</td></tr>
<tr style="border:0px;"><td style="border:0px;"></td><td style="border:0px;"></td><td style="border:0px;" colspan="3"><font size="5">הופק ע"י חוות דעת</font></td></tr>
<tr style="border:0px;"><td style="border:0px;"></td><td style="border:0px;"></td><td style="border:0px;" colspan="3"><font size="5">www.havot-daat.co.il</font></td></tr>
</table>
</body>
</html>