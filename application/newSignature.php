<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/clinic.js" type="text/javascript"></script>
        <link rel="stylesheet" href="css/tinybox2.css" type="text/css" />
        <title>New Signature</title>
</head>
<body>
<div id="content">

<form id="AddSignatureForm" name="AddSignatureForm" method="post">
<h1>הוסף חתימה</h1>
<BR />
<table style="padding:10px;">
<tr>
	<td>
		<label>שם\תיאור</label>
	</td>
	<td>
		<input name="description" type="text" maxlength="35" /><br>
	</td>
	<td id="descError" class="errorMsg"></td>
</tr>
<tr>
	<td colspan="2">
		<div id="file-uploader">       
		    <noscript>          
		        <p>Please enable JavaScript to use file uploader.</p>
		        <!-- or put a simple form for upload here -->
		    </noscript>         
		</div>
		<input type="hidden" id="fileName" name="fileName" />
	</td>
	<td id="addressError" class="errorMsg"></td>
</tr>
<tr>
	<td align="left">
		<a><button type="button" onClick="if(lawyerFormValidator()) {addSignatureSend();}">הוסף</button>
	</td>
</tr>
</table>
</form>

</div>

</body>
</html>
