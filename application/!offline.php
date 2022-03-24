<?php
session_start();
if (!isset($_SESSION['role']))
{
	if ($_SESSION['role'] != "admin")
	{
		
echo <<<_END

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>חוות דעת - האתר סגור כעת</title>
</head>
<body>
<div style="text-align:center;font-weight:bold;font-size:20px;font-family: Arial;">
<BR /><BR />
<IMG src="images/logo.jpg" width="300px" /><br/><br/>
<p>האתר סגור כעת עקב עבודות טכניות, עמכם הסליחה</p>
<BR />
אנו נשוב לפעול בקרוב
</div>
</body>
</HTML>
_END;

exit;
	}
}
else
{
	echo "<center><b>The site is offline.</b></center><br />";
}
?>