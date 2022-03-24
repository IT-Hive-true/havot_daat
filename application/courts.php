<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_GET['filterText']))
{
	$filterText = sanitizeMySQL($_GET['filterText']);
} else {
	$filterText = '';
}

pageStart("מערכת קליניקה - בתי משפט");

echo <<<_END
<br /><br />
<form id="filterForm" name="filterForm" action="browseCases.php">
<img src="images/Search.png" width="30px" />&nbsp&nbsp&nbsp<input name="filterText" id="filterText" type="text" />
</form>
<br /><br />
_END;

echo "<div id=\"casesTableDiv\">";
echo <<<_END
 
<table id="casesTable" class="tablesorter">
<thead>
<tr> 
	<th>מס' מזהה</th>
    <th>סוג</th> 
    <th>עיר</th>
    <th>כתובת</th> 
    <th>טלפון</th>
</tr> 
</thead>
<tbody>
_END;

$query = "SELECT t1.id,t1.type,t1.location,t1.address,t1.phone
			FROM tbcourts as t1
			where (t1.location like '%".$filterText."%') and 
			      (t1.id <> 0) and
			      (t1.client_id = ".$clientId.")";
			
$result = mysqli_query($db_server,$query);
if (!$result) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($result))
{
	$rowsNum = mysqli_num_rows($result);
	for ($i=0;(($i<$rowsNum) && ($i<$casesInPage));$i++)
	{
		$caseRow = mysqli_fetch_row($result);
		echo "<tr class=\"linkble\" onclick=\"TINY.box.show({url:'editCourt.php?id=".$caseRow[0]."',width:400,height:270,closejs:function(){ window.location.reload( true ); }})\">";
			echo "<td>";
				echo $caseRow[0];
			echo "</td>";
			echo "<td>";
				echo $courtType[$caseRow[1]];
			echo "</td>";
			echo "<td>";
				echo $caseRow[2];
			echo "</td>";
			echo "<td>";
				echo $caseRow[3];
			echo "</td>";
			echo "<td>";
				echo $caseRow[4];
			echo "</td>";
		echo "</tr>";
	}
}
else
{
	echo "<BR /><BR /><center><b><p>אין בתי משפט במערכת</p></b></center><BR /><BR /><BR />";
}

echo "</tbody>";
echo "</table>";
echo "</div>";

echo <<<_END

<script>
$(function() { 
	var theTable = $('#casesTable');
	$("#filterText").keyup(function() {
	    $.uiTableFilter( theTable, this.value );
	  })
}); 
$(document).ready(function() { 
    // call the tablesorter plugin 
	$("#casesTable").tablesorter({ 
        // sort on the first column and third column, order asc 
        sortList: [[1,0],[2,0]] 
    }); 
	
}); 
</script>
_END;

pageEnd();

