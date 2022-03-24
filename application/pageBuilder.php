<?php

include 'offline.php';

//pageStart($title) - creates standard HTML page start, and puts $title as the page title in the header
function pageStart($title,$extraHead="")
{
echo <<<_END
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
        <LINK REL="SHORTCUT ICON" HREF="images/favicon.ico">
        
        <script src="js/tinybox.js" type="text/javascript"></script>
        <!--<script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>-->
        <script src="js/jquery-2.2.3.min.js" type="text/javascript"></script>
        <!--<script src="js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>-->
        <script src="js/jquery-ui.min.js" type="text/javascript"></script>
        <script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
        <script src="js/jquery.uitablefilter.js" type="text/javascript"></script>
        <script src="js/clinic.js" type="text/javascript"></script>
        
        <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.14.custom.css" type="text/css" />
		<link rel="stylesheet" href="css/tinybox2.css" type="text/css" />
		<link rel="stylesheet" href="css/tablesorter.css" type="text/css" />
		<link rel="stylesheet" href="css/main.css" type="text/css" />
		<link rel="stylesheet" href="css/print.css" type="text/css"  media="print"> 
		
		<!-- tags -->
		<script src="js/tag-it.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/myTag-it.js" type="text/javascript" charset="utf-8"></script>
        <link href="css/jquery.tagit.css" rel="stylesheet" type="text/css">
        <link href="css/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
_END;
echo $extraHead;
echo <<<_END
        <title>
_END;
echo $title;
echo <<<_END
        </title>
    </head>
    <Body>
<div id="Container">
<div id="Upper">
<div id="SiteLogo">
	<a href="/index.php"><img id="SiteLogoImage" src="/images/logo.jpg" alt="Havot-daat"></a>
</div>
<div id="Menu">
		
	<ul>
		<li><a href="aboutUs.php">אודות</a>&nbsp;&nbsp;|</li>
		<li><a href="policy.php">תנאי שימוש</a>&nbsp;&nbsp;|</li>
		<li><a href="contactUs.php">צור קשר</a>&nbsp;&nbsp;|</li>
		<li><a href="index.php?logoff=true">התנתק</a></li>
	</ul>
	<br /><br /><br />
	<div class="loginInfo">
_END;
echo "<span style=\"margin-left:10px\">משתמש: ".$_SESSION['userName']."</span><br />";
echo "<span style=\"margin-left:10px\">מרפאה: <b>".$_SESSION['clientName']."</b></span>";
echo <<<_END
</div>
</div>
</div>
<div id="LinksBanner">
	<span id="navLinks">
		<a href="addCase.php">תיק חדש</a>&nbsp;&nbsp;|
		<a href="browseCases.php"><img src="images/icon_case.png" height="20px" />&nbsp;חפש תיק</a>&nbsp;&nbsp;|
		<!-- <a href="calendar.php"><img src="images/icon_calendar.png" width="20px" />&nbsp;לו"ז מרפאה</a>&nbsp;&nbsp;| -->
		<a href="lawyerFirms.php">עורכי דין</a>&nbsp;&nbsp;|
		<a href="companies.php">חברות ביטוח</a>&nbsp;&nbsp;|
		<a href="courts.php">בתי משפט</a>&nbsp;&nbsp;|
		<a href="reports.php"><img src="images/icon_chart.png" width="30px" />&nbsp;דוחו"ת</a>&nbsp;&nbsp;|
		<a href="settings.php"><img src="images/icon_settings.png" width="20px" />&nbsp;הגדרות</a>
		<a href="mergeAndDelete.php"><img src="images/Join-Files-Icon.png" width="20px" />&nbsp;מזג תיקים</a>
	</span>
</div>
_END;
}

//pageEnd() - closes an HTML page started with pageStart($title)
function pageEnd()
{
echo <<<_END
<div id="Footer">
	<BR /><BR />
	<center>על המידע באתר זה חלה סודיות רפואית</center>
	<BR />
</div>	
</div>
</body>
</html>
_END;
}

?>