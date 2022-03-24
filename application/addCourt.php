<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="/js/clinic.js" type="text/javascript"></script>
        <link rel="stylesheet" href="/css/tinybox2.css" type="text/css" />
        <title>New court</title>
</head>
<body>
<div id="content">

<form id="AddCourtForm" name="AddCourtForm" method="post">
<h1>הוסף בית משפט</h1>
<BR />
<table>

<tr>
	<td>
		<label>סוג</label>
	</td>
	<td>
		<select name="courtTypeSelect" size="1">
		<?php 
		foreach ($courtType as $i => $courtTypeValue) {
			echo "<option ";
			if ($i==1) {echo "selected";}
			echo " value=\"".$i."\">".$courtTypeValue."</option>";
		}
		?>
		</select>
	</td>
	<td></td>
</tr>
<tr>
	<td>
		<label>עיר</label>
	</td>
	<td>
		<input name="location" type="text" maxlength="20" />
	</td>
	<td id="locationError" class="errorMsg"></td>
</tr>
<tr>
	<td>
		<label>כתובת</label>
	</td>
	<td>
		<textarea name="address" cols="36" rows="2" maxlength="100"></textarea>
	</td>
	<td id="addressError" class="errorMsg"></td>
</tr>
<tr>
<tr>
	<td>
		<label>טלפון</label>
	</td>
	<td>
		<input name="phone" type="text" maxlength="13" />
	</td>
	<td id="phoneError" class="errorMsg"></td>
</tr>
<tr>
	<td>
		<label>פקס</label>
	</td>
	<td>
		<input name="fax" type="text" maxlength="13" />
	</td>
	<td id="faxError" class="errorMsg"></td>
</tr>
<tr>
	<td align="left">
		<a><button type="button" onClick="if(courtFormValidator()) {addCourtSend();}">הוסף</button>
	</td>
</tr>
</table>
</form>

</div>

</body>
</html>
