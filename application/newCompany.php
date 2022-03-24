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
        <title>New Company</title>
</head>
<body>
<div id="content">

<form id="AddCompanyForm" name="AddCompanyForm" method="post">
<h1>הוסף חברה חדשה</h1>
<BR />
<table>
<input name="id" type="hidden" maxlength="20" />
<tr>
	<td>
		<label>שם חברה</label>
	</td>
	<td>
		<textarea name="name" cols="36" rows="1" maxlength="50"></textarea>
	</td>
	<td id="NameError" class="errorMsg"></td>
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
	<td>
		<label>כתובת דוא"ל</label>
	</td>
	<td>
		<input name="email" type="text" maxlength="20" />
	</td>
	<td id="emailError" class="errorMsg"></td>
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
		<a><button type="button" onClick="if(companyFormValidator()) {addCompanySend();}">הוסף</button>
	</td>
</tr>
</table>
</form>

</div>

</body>
</html>
