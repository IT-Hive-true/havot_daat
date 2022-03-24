<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
<body>
<?php


$caseQuery = "SELECT t1.id,t1.case_id,t1.file_name,t1.file_desc, t2.patient_name
		FROM tbevents as t1, tbcases as t2
		where (t1.file_name is not NULL) and (t1.file_name <> '')
		      and (t1.file_size = 0)
		      and (t1.case_id = t2.id)"; 
		
$caseResult = mysqli_query($db_server,$caseQuery);
if (!$caseResult) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($caseResult))
{
	for ($i=0;$i<mysqli_num_rows($caseResult);$i++)
	{
		$caseRow = mysqli_fetch_row($caseResult);
		echo $caseRow[0]."(case #".$caseRow[1].") - ".$caseRow[2]." - ".$caseRow[3]." - ".$caseRow[4];
		
		$fileSize = filesize("files/".$caseRow[2]);
		echo " - ".$fileSize."<br>";
		
	}
}

?>

</body>
</html>