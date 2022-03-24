<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_GET['id']))
{
	$id=sanitizeInput($_GET['id']);
}
else
{
	echo "תקלה בהעלאת פרטי החברה";
	exit;
}

$query = "SELECT t1.id, t1.name, t1.address, t1.email, t1.phone, t1.fax
					FROM tbcompanies as t1
					WHERE t1.id = ".$id;
$result = mysqli_query($db_server,$query);
if (!$result) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($result))
{
	$row = mysqli_fetch_row($result);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/clinic.js" type="text/javascript"></script>
        <link rel="stylesheet" href="css/tinybox2.css" type="text/css" />
        <title>ערוך פרטי חברת ביטוח</title>
</head>
<body>
<div id="content">

<form id="editCompanyForm" name="editCompanyForm" method="post">
<h1>ערוך משרד עו"ד</h1>
<BR />
<table>
<input name="id" type="hidden" maxlength="20" value="<?= $row[0] ?>" />
<tr>
	<td>
		<label>שם משרד</label>
	</td>
	<td>
		<textarea name="name" cols="36" rows="1" maxlength="50"><?= $row[1] ?></textarea>
	</td>
	<td id="NameError" class="errorMsg"></td>
</tr>
<tr>
	<td>
		<label>כתובת</label>
	</td>
	<td>
		<textarea name="address" cols="36" rows="2" maxlength="100"><?= $row[2] ?></textarea>
	</td>
	<td id="addressError" class="errorMsg"></td>
</tr>
<tr>
	<td>
		<label>כתובת דוא"ל</label>
	</td>
	<td>
		<input name="email" type="text" maxlength="40" value="<?= $row[3] ?>"  />
	</td>
	<td id="emailError" class="errorMsg"></td>
</tr>
<tr>
<tr>
	<td>
		<label>טלפון</label>
	</td>
	<td>
		<input name="phone" type="text" maxlength="13" value="<?= $row[4] ?>"  />
	</td>
	<td id="phoneError" class="errorMsg"></td>
</tr>
<tr>
	<td>
		<label>פקס</label>
	</td>
	<td>
		<input name="fax" type="text" maxlength="13" value="<?= $row[5] ?>"  />
	</td>
	<td id="faxError" class="errorMsg"></td>
</tr>
<tr>
	<td align="left">
		<a><button type="button" onClick="if(companyFormValidator()) {editCompanySend();}">שמור</button>
	</td>
</tr>
</table>
</form>

</div>

</body>
</html>
