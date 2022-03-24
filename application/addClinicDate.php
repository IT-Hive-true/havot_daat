<?php
require_once 'generalPHP.php';

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="/js/clinic.js" type="text/javascript"></script>
        <link rel="stylesheet" href="/css/tinybox2.css" type="text/css" />
        <title>הוספת תאריך למרפאה</title>
</head>
<body>
<div id="content">

<form id="AddEventForm" name="AddEventForm" method="post">


<h1>הוספת תאריך למרפאה</h1>
<BR />

<input type="hidden" id="id" name="caseId" value="0" />
<input type="hidden" id="actionType" name="actionType" value="add" />
<input type="hidden" name="eventTypeSelect" value="13" />
<input type="hidden" name="eventMethodSelect" value="1" />	
<input type="hidden" name="parm5" value="allDay" />	
<input type="hidden" name="fileName" value="" />	
<input type="hidden" name="fileDesc" value="" />
<input type="hidden" name="remarks" value="" />
<input type="hidden" name="toWho" value="" />
<input type="hidden" name="cc" value="" />
<input type="hidden" name="toOther" value="" />
<input type="hidden" name="letterMethodSelect" value="" />
<input type="hidden" name="letterTemplateSelect" value="" />
<input type="hidden" name="addAlert" value="" />
<input type="hidden" name="userAlertSelect" value="" />
<input type="hidden" name="alertMethod" value="" />



<table class="formTable">
<tr>
	<td>
		<label> מרפאה : </label>
	</td>
	<td>
		<select name="parm1" size="1">
			<?php 
			foreach ($eventsOptions[13][1] as $i => $valueName) {
					echo "<option ";
					if ($i==1) {echo "selected";}
					echo " value=\"".$i."\">".$valueName."</option>";
				}
			?>
		</select>
	</td>
</tr>
<tr>
	<td>
		<label>תאריך</label>
	</td>
	<td>
		<input name="parm4" id="parm4" type="text" />
	</td>
</tr>
</table>
<a><button type="button" onClick="if(courtFormValidator()) {addEventSend(true);}">הוסף</button>
</form>

</div>

</body>
</html>
