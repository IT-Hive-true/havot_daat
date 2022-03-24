<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_GET['name']))
{
	$name = sanitizeInput($_GET['name']);
}
if (isset($_GET['courtId']))
{
	$idNumber = sanitizeMySQL($_GET['courtId']);
	$query = "SELECT t1.type,t1.address,t1.location
			FROM tbcourts as t1
			where t1.id = ".$idNumber; 
			
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		$title = "בית המשפט ה".$courtType[$row[0]]." ב".$row[2];
	}
}
if (isset($_GET['lawyerId']))
{
	$idNumber = sanitizeMySQL($_GET['lawyerId']);
	$query = "SELECT t1.name,t1.address
			FROM tblawyers as t1
			where t1.id = ".$idNumber; 
			
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		$title =$row[0];
	}
}
if (isset($_GET['companyId']))
{
	$idNumber = sanitizeMySQL($_GET['companyId']);
	$query = "SELECT t1.name,t1.address
			FROM tbcompanies as t1
			where t1.id = ".$idNumber; 
			
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		$name =$row[0];
		$title="";
	}
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="https://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />
        <LINK REL="SHORTCUT ICON" HREF="/images/favicon.ico">
        <script src="/js/jquery-1.6.2.min.js" type="text/javascript"></script>
        <script src="/js/clinic.js" type="text/javascript"></script>

		<title>מעטפה</title>
		<script type="text/javascript">
		var currentSetting = 0;
		var setting = [ {'width':380, 'height':870},{'width':680, 'height':945} ];  


		function nextSetting()
		{
			if (currentSetting < (setting.length - 1))
			{
				currentSetting++;
			}
			else
			{
				currentSetting = 0;
			}
			$('#envelope').height(setting[currentSetting].height);
			$('#envelope').width(setting[currentSetting].width);
		}
		function prevSetting()
		{
			if (currentSetting > 0)
			{
				currentSetting--;
			}
			else
			{
				currentSetting = (setting.length - 1);
			}
			$('#envelope').height(setting[currentSetting].height);
			$('#envelope').width(setting[currentSetting].width);
		}
		</script>
		<STYLE type="text/css">
		@page {
		    margin-top: 0mm;
		}
		div.rotated_text
		{
			-webkit-transform: rotate(90deg);	
			-moz-transform: rotate(90deg);
			-ms-transform: rotate(90deg);
			-o-transform: rotate(90deg);
			transform: rotate(90deg);
			position:relative;
		}
		#box
		{
			width:90px;
			height:20px;
			position:relative;
			right:40px;
			top:50px;
			position:relative;
			float:right;
		}
		#rightArrow
		{
			width:140px;
			float:right;
			height:900px;
			position:absolute;
			top:0px;
			cursor:pointer;
			right:0px;
		}
		#rightArrow:hover
		{
			background: url("/images/right_arrow.gif") no-repeat right center;
		}
		#leftArrow
		{
			width:140px;
			float:left;
			height:900px;
			position:absolute;
			top:0px;
			cursor:pointer;
			left:0px;
		}
		#leftArrow:hover
		{
			background: url("/images/left_arrow.gif") no-repeat left center;
		}
		</STYLE>
	</head>
<body>

<div id="envelope"  style="margin:0px auto;border: 1px solid #f2f2f2;width:380px;height:870px;">
<div id="box"><img src="/images/green-bg.jpg" width="90px" height="20px" />&nbsp</div>

<div class="rotated_text" style="top:160px;right:-110px;width:200px;float:right;">
	<span style="font-size:larger;"><b>
	<?php 
	echo $_SESSION['clientName'];
	?>
	</b></span><br /><br />
	<span>
	<?php 
	$clientQuery = "SELECT t1.address
			FROM tbclients as t1
			where t1.id = ".$clientId; 
	$clientResult = mysqli_query($db_server,$clientQuery);
	if (!$clientResult) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($clientResult))
	{
		$clientRow = mysqli_fetch_row($clientResult);
		echo nl2br($clientRow[0]);
	}
	?>
	</span><br />
</div>

<div class="rotated_text" style="bottom:-600px;text-align:left;width:300px;margin:0px auto;">
	
	<span><u>לכבוד:</u></span>
	<span><b><nobr><?=$name ?></nobr></b></span><br />
	<span><?=$title ?></span><br />
	<span><?=nl2br($row[1]) ?></span>
	<br />
</div>



</div>
<div id="rightArrow" onClick="nextSetting()">&nbsp</div>
<div id="leftArrow" onClick="prevSetting()">&nbsp</div>
</body>
</html>