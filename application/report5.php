<?php
require_once 'generalPHP.php';

if (isset($_GET['from']))
{
	//$from = "'".sanitizeMySQL($_GET['from'])."'";
	$from = sanitizeMySQL($_GET['from']);
	// $from = "STR_TO_DATE(".$from.",'%d-%m-%Y')";
	
}
else
{
	$from = "(DATE(NOW()) - INTERVAL 1 YEAR)";
}
if (isset($_GET['to']))
{
	//$to = "'".sanitizeMySQL($_GET['to'])."'";
	$to = sanitizeMySQL($_GET['to']);
	// $to = "STR_TO_DATE(".$to.",'%d-%m-%Y')";
}
else
{
	$to = "DATE(NOW())";
}

?>
<span class="excel1">
	<a class="excel1_href" href="reportExcel1.php?from=<?php echo $from; ?>&to=<?php echo $to; ?>" target="_BLANK">
		<img src="images/icon_xls.png" width="30px" />&nbsp&nbspרשימת תיקים כוללת לפי תאריך יצירת תיק
	</a>
</span>

