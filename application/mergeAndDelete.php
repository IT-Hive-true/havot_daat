<?php

require_once 'generalPHP.php';
require_once 'pageBuilder.php';

if (isset($_GET['filterText']))
{
	$filterText = sanitizeMySQL($_GET['filterText']);
} else {
	// dudy 3/4/2016
	$filterText = '';
}

if (isset($_GET['prosecutor']))
{
	$prosecutorText = sanitizeMySQL($_GET['prosecutor']);
}

pageStart("איחוד תיקים");

?>
<script>
	function addCaseFormValidator()
	{
		var regInt = /^\d+$/;
		var valid;
		valid = true;
		
		if ((regInt.test($("#caseIdKeep").val()) == false) || ($("#caseIdKeep").val() == ""))
		{
			$("#caseIdKeepError").text("יש להשתמש רק בספרות");
			valid=false;
		}
		else { $("#caseIdDelError").text(""); }
		
		if ((regInt.test($("#caseIdDel").val()) == false) || ($("#caseIdDel").val() == ""))
		{
			$("#caseIdDelError").text("יש להשתמש רק בספרות");
			valid=false;
		}
		else { $("#caseIdDelError").text(""); }
		
		return valid;
	}
</script>
<center><h1>איחוד תיקים</h1></center>
<br />
<div id="CaseContent">
<form name="addCaseFrm" method="post" action="mergeAndDeleteAction.php" onsubmit="return addCaseFormValidator()">
<table class="case-table">
	<tr><td>
		<table class="case-table">
			<tr>
				<h3>תיק מוביל</h3>
			</tr>
			<tr>
				<td>מספר מזהה תיק אשר ישאר במערכת: <input name="caseIdKeep" id="caseIdKeep" type="text" maxlength="10" />&nbsp&nbsp&nbsp<span id="caseIdKeepError" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td>תיק זה יקבל את רשומות התיק השני לתוכו</td>
			</tr>
		</table>
	</td></tr>
	</td></tr>
	<tr><td>
		<table class="case-table">
			<tr>
				<h3>תיק למחיקה</h3>
			</tr>
			<tr>
				<td>מספר מזהה תיק למחיקה: <input name="caseIdDel" id="caseIdDel" type="text" maxlength="10" />&nbsp&nbsp&nbsp<span id="caseIdDelError" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td>תיק זה, יקבל סטטוס נמחק במערכת</td>
			</tr>
		</table>
	</td></tr>
	<tr>
		<td colspan="2" align="left"><input type="submit" value="אחד תיקים" /></td>
	</tr>
</table>
</form>
</div>
<?php 
pageEnd();
?>