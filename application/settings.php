<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_POST['action']))
{
	$action = sanitizeInput($_POST['action']);
	switch ($action)
	{
		case "saveTemplate": saveTemplate($db_server);
		break;
		case "saveRegisters": saveRegisters($db_server);
		break;
		case "saveUserSettings": saveUserSettings();
		break;
		case "changePassword": doPasswordChange($db_server);
		break;
		
	}
	exit;
}
if (isset($_GET['action']))
{
	$action = sanitizeInput($_GET['action']);
	switch ($action)
	{
		case "deleteTemplate": deleteTemplate($db_server);
		break;
		case "duplicateTemplate": duplicateTemplate($db_server);
		break;
	}
	exit;
}

$page = "templates";

if (isset($_GET['page']))
	$page = sanitizeInput($_GET['page']);

	
pageStart("הגדרות","<script type=\"text/javascript\" src=\"/tiny_mce/jquery.tinymce.js\"></script>
					<link href=\"css/uploadify.css\" type=\"text/css\" rel=\"stylesheet\" />
					<script type=\"text/javascript\" src=\"js/swfobject.js\"></script>
					<script src=\"js/fileuploader.js\" type=\"text/javascript\"></script>
					<link rel=\"stylesheet\" href=\"css/fileuploader.css\" type=\"text/css\" />");
echo "<div id=\"secondaryHeader\">";
echo "<br>";
echo "<center><h1>הגדרות</h1></center>";
echo "<br><br>";
echo "</div>";
displayNavigation($page);





switch ($page)
{
	case "templates": displayTemplates($db_server);
	break;
	case "registers": displayRegisters($db_server);
	break;
	case "userSettings": displayUserSettings($db_server);
	break;
	case "DashboardSettings": displayDashboardSettings();
	break;
	case "passwordChange": displayPasswordChange();
	break;
	default: displayTemplates($db_server);
	break;
}
	
echo "<BR />";
echo <<<_END

<script type="text/javascript" >
$('textarea.tinymce').tinymce({
	// Location of TinyMCE script
	script_url : '/tiny_mce/tiny_mce.js',

	// General options
	theme : "advanced",
	plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,searchreplace,print,contextmenu,paste,directionality,noneditable,visualchars,nonbreaking,xhtmlxtras,contextmenu,advlist",

	// Theme options
	theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,fontselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,image,code,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,|,advhr,|,ltr,rtl",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking,pagebreak",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	pagebreak_separator : "<DIV CLASS=\"pageBreak\"/>",

	// Example content CSS (should be your site CSS)
	content_css : "/css/main.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js"
});
</script >

_END;


pageEnd();

function displayNavigation($page)
{
echo <<<_END

<div id="oldTabs">
<ul>
_END;

echo "<li";
	if ($page == "templates")
		echo " id=\"selectedSetting\" ";
echo "><a href=\"settings.php?page=templates\"><span>תבניות למסמכים</span></a></li>";

echo "<li";
	if ($page == "registers")
		echo " id=\"selectedSetting\" ";
echo "><a href=\"settings.php?page=registers\"><span>הגדרות מערכת</span></a></li>";

echo "<li";
	if ($page == "userSettings")
		echo " id=\"selectedSetting\" ";
echo "><a href=\"settings.php?page=userSettings\"><span>הגדרות משתמש</span></a></li>";

echo "<li";
	if ($page == "DashboardSettings")
		echo " id=\"selectedSetting\" ";
echo "><a href=\"settings.php?page=DashboardSettings\"><span>עמוד הבית</span></a></li>";

echo "<li";
	if ($page == "passwordChange")
		echo " id=\"selectedSetting\" ";
echo "><a href=\"settings.php?page=passwordChange\"><span>שינוי סיסמא</span></a></li>";

echo <<<_END

</ul>
</div>

_END;
}

function displayTemplates($db_server)
{
	if (isset($_GET['eventType']))
	$eventType = sanitizeInput($_GET['eventType']);
	else
	$eventType = 0;

	extract($GLOBALS);
	echo "<br><br>";
	echo "<BR /><BR />";
	echo "<div id=\"contentContainer\">";
	echo "<div id=\"eventTypeList\" >";
	
	echo "<ul>";
	echo "<li><a ";
	if ($eventType == 0) {echo " id=\"current\" ";}
	echo "href=\"settings.php?page=templates&eventType=0\">כללי</a></li>";
	foreach ($eventTypes as $i => $eventTypeValue) {
		echo "<li><a  ";
	if ($eventType == $i) {echo " id=\"current\" ";}
		echo "href=\"settings.php?page=templates&eventType=".$i."\">".$eventTypeValue."</a></li>";
	}
	echo "</ul>";	
	echo "</div>";
	
	echo "<div id=\"docTemplates\">";
	// check if need to show a list or edit screen
	if (isset($_GET['template']))
	{
		$templateId = sanitizeInput($_GET['template']);
		
		if ($templateId == "new")
		{
			$templateId = 0;
			$subjectCourt = "";
			$subjectNoCourt = "";
			$text = "";
			$signature_img = "";
			// $eventType = 1;
			$description = "";
		}
		else
		{
			$query = "SELECT t1.id, t1.subject_court, t1.subject_no_court, t1.text, t1.signature, t1.event_type, t1.description
							FROM tbletter_template as t1
							WHERE  (t1.id = ".$templateId.")";
			$result = mysqli_query($db_server,$query);
			if (!$result) die("Database access failed: " . mysqli_error());
			if (mysqli_num_rows($result))
			{
				$row = mysqli_fetch_row($result);
				$subjectCourt = $row[1];
				$subjectNoCourt = $row[2];
				$text = $row[3];
				$signature = $row[4];
				$eventType = $row[5];
				$description = $row[6];
			}
		}
		
		echo "<BR /><BR />";
		echo "<h1><center>עריכת תבנית</center></h1><BR /><BR />";
		echo "<a href=\"settings.php?page=templates&eventType=".$eventType."\">< חזרה (ללא שמירה)</a><br>";
		echo "<a id=\"tagsBtn\" onClick=\"TINY.box.show({url:'tagsList.php',width:400,height:500})\">רשימת תגיות</a>";
		echo "<script> $(\"#tagsBtn\").button({ icons: { secondary: \"ui-icon-comment\" }}); </script>";
		echo "<br>";
		echo "<div class=\"content\">";
		
		echo "<form name= \"editTemplateFrm\" action=\"settings.php\" method=\"post\">";
		
		echo "<input type=\"hidden\" id=\"action\" name=\"action\" value=\"saveTemplate\" />";
		echo "<input type=\"hidden\" id=\"id\" name=\"id\" value=\"".$templateId."\" />";
		echo "<h3>סוג אירוע:</h3>";
		echo "<select name=\"eventTypeSelect\" size=\"1\" >";
		echo "<option ";
		if ($eventType==0) {echo "selected";}
		echo " value=\"0\">כללי</option>";
		foreach ($eventTypes as $i => $eventTypeValue) {
			echo "<option ";
			if ($i==$eventType) { echo "selected"; }
			echo " value=\"".$i."\">".$eventTypeValue."</option>";
		}
		echo "</select><br><br>";
		echo "<h3>תיאור:</h3>";
		echo "<input type=\"text\" id=\"description\" name=\"description\" value=\"".htmlspecialchars($description)."\" maxlen=\"100\"/><br>";
		echo "<h3>נושא במינוי בית משפט:</h3>";
		echo "<textarea name=\"templateSubjectCourt\" cols=\"70\" rows=\"2\" class=\"tinymce\">".$subjectCourt."</textarea><br>";
		echo "<h3>נושא במינוי בהסכמה או פרטי:</h3>";
		echo "<textarea name=\"templateSubjectNoCourt\" cols=\"70\" rows=\"2\" class=\"tinymce\">".$subjectNoCourt."</textarea><br>";
		echo "<h3>תוכן:</h3>";
		echo "<textarea name=\"templateText\" cols=\"70\" rows=\"20\" class=\"tinymce\">".$text."</textarea><br>";
		echo "<h3>חתימה:</h3>";
		echo "<select name=\"signatureSelect\" id=\"signatureSelect\" size=\"1\">";
		$signatureSQL = "SELECT t1.id, t1.description 
						FROM tbsignatures as t1
						WHERE (t1.client_id = ".$clientId.")";
		$signatureResult = mysqli_query($db_server,$signatureSQL);
		if (!$signatureResult) die("Database access failed: " . mysqli_error());
		if (mysqli_num_rows($signatureResult))
		{	
			for ($i=0;$i<mysqli_num_rows($signatureResult);$i++)
			{
				$signatureRow = mysqli_fetch_row($signatureResult);
				echo "<option ";
					if ($signatureRow[0]==$signature) {echo "selected";}
					echo " value=\"".$signatureRow[0]."\">".$signatureRow[1]."</option>";
			}
		}
		echo "<select>";
		
		
		echo "<br /><input type=\"submit\" value=\"שמור\" />";
		echo "</form>";
		echo "</div>";
	}
	else
	{
		echo "<BR /><BR />";
		
		if ( isset($eventTypes[$eventType]) ) {
			echo "<h3>תבניות לאירוע: $eventTypes[$eventType]</h3><BR /><BR />";
		} else {
			echo "<h3>תבניות לאירוע: </h3><BR /><BR />";
		}
		
		//query templates 
		$query = "SELECT t1.id, t1.description
						FROM tbletter_template as t1
						WHERE (t1.event_type = ".$eventType.") and
						      (t1.client_id = ".$clientId.")";
		$result = mysqli_query($db_server,$query);
		if (!$result) die("Database access failed: " . mysqli_error());
		if (mysqli_num_rows($result))
		{	
			for ($i=0;$i<mysqli_num_rows($result);$i++)
			{
				$row = mysqli_fetch_row($result);
				echo "<a class=\"editBtn\" title=\"ערוך\" href=\"settings.php?page=templates&eventType=".$eventType."&template=".$row[0]."\" >ערוך</a>";
				echo "<a class=\"deleteBtn\" title=\"מחק\"  onclick=\"if (confirm('האם אתה בטוח שברצונך למחוק?')) {location.href = 'settings.php?page=templates&action=deleteTemplate&eventType=".$eventType."&template=".$row[0]."'} \">מחק</a>";
				echo "<a class=\"copyBtn\" title=\"שכפל\" href=\"settings.php?page=templates&action=duplicateTemplate&eventType=".$eventType."&template=".$row[0]."\" >שכפל</a>";
				echo "<span class=\"list ui-state-default ui-corner-all\">".$row[1]."</span><br>";
			}	
		}
		else
		{
			echo "<center>אין תבניות לאירוע זה</center>";	
		}
		echo "<BR /><BR /><a id=\"addBtn\" href=\"settings.php?page=templates&eventType=".$eventType."&template=new\">צור תבנית חדשה</a><br><br>";
		echo "<script>";
		echo " $(\"#addBtn\").button({ icons: { secondary: \"ui-icon-plus\" }});";
		echo " $(\".editBtn\").button({ icons: { primary: \"ui-icon-pencil\" },text:true});";
		echo " $(\".deleteBtn\").button({ icons: { primary: \"ui-icon-trash\" },text:true});";
		echo " $(\".copyBtn\").button({ icons: { primary: \"ui-icon-arrowreturnthick-1-s\" },text:true});";
		echo "</script>";
	}	
		
	echo "</div>";
	echo "</div>";

}

function displayRegisters($db_server)
{
	extract($GLOBALS);
	
	echo "<div class=\"content\"><br>";
	echo "<h1>הגדרות מערכת</h1><br><br>";
	echo "<h3>הגדרות כלליות</h3>";
	echo "<form name= \"editRegistersFrm\" action=\"settings.php\" method=\"post\">";
	echo "<input type=\"hidden\" id=\"action\" name=\"action\" value=\"saveRegisters\" />";
	//query templates 
	$query = "SELECT t1.id, t1.value, t1.description, t1.measurment
			  FROM tbsettings as t1 
			  WHERE (t1.client_id = ".$clientId.") ";
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($result))
	{
		echo "<table>";
		for ($i=0;$i<mysqli_num_rows($result);$i++)
		{
			$row = mysqli_fetch_row($result);
			echo "<tr>";
				echo "<td>".$row[2]."</td>";
				echo "<td><input name=\"reg".$row[0]."\" type=\"text\" value=\"".$row[1]."\"/>&nbsp&nbsp".$row[3]."</td>";
			echo "</tr>";	
		}
		echo "</table>";
		echo "<br /><input type=\"submit\" value=\"שמור\" />";
		if (isset($_GET['saved'])) 
		{
			if ($_GET['saved'] == "true")
			{
				echo "&nbsp&nbsp<img src=\"/images/check.jpg\" width=\"20px\" />&nbsp<span style=\"color:green;\">נשמר</span>";
			}
		}
	}
	echo "</form>";
	
	//signatures
	echo "<br><br><h3>חתימות</h3>";
	echo "<table>";
	$signatureSQL = "SELECT t1.id, t1.description, t1.image 
					 FROM tbsignatures as t1
					 WHERE t1.client_id = ".$clientId;
	$signatureResult = mysqli_query($db_server,$signatureSQL);
	if (!$signatureResult) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($signatureResult))
	{	
		for ($i=0;$i<mysqli_num_rows($signatureResult);$i++)
		{
			$signatureRow = mysqli_fetch_row($signatureResult);
			echo "<tr>";
			echo "<td style=\"border:solid 1px #8dbdd8;border-right:0px;border-left:0px;\">";
			echo "<a class=\"deleteBtn\" title=\"מחק\"  onclick=\"if (confirm('האם אתה בטוח שברצונך למחוק?')) {deleteSignature(".$signatureRow[0].")} \">מחק</a>";
			echo "</td>";
			echo "<td style=\"border:solid 1px #8dbdd8;border-right:0px;border-left:0px;\"><img src=\"file.php?f=".$signatureRow[2]."\" /></td>";
			echo "<td style=\"border:solid 1px #8dbdd8;border-right:0px;border-left:0px;\">".$signatureRow[1]."</td>";
			echo "</tr>";
		}
	}
	echo "</table>";
	echo "<BR /><BR /><a id=\"addBtn\" onClick=\"TINY.box.show({url:'newSignature.php',width:400,height:270,openjs:function(){initUploader();},closejs:function(){ window.location.reload( true ); }})\">הוסף חתימה</a><br><br>";
	echo "<script>";
	echo " $(\"#addBtn\").button({ icons: { secondary: \"ui-icon-plus\" }});";
	echo " $(\".deleteBtn\").button({ icons: { primary: \"ui-icon-trash\" },text:false});";
	echo "</script>";
	echo "</div>";
}

function saveTemplate($db_server)
{
	extract($GLOBALS);
	$id = sanitizeInput($_POST['id']);
	$subjectCourt = sanitizeMySQL($_POST['templateSubjectCourt']);
	$subjectNoCourt = sanitizeMySQL($_POST['templateSubjectNoCourt']);
	$text = sanitizeMySQL($_POST['templateText']);
	$signature = sanitizeMySQL($_POST['signatureSelect']);
	$description = sanitizeMySQL($_POST['description']);
	$eventType = sanitizeInput($_POST['eventTypeSelect']);
	
	// new template or an update?
	if ($id == 0)
	{		
		$query = "INSERT into tbletter_template (client_id,event_type, description, subject_court, subject_no_court, text, signature)  
					VALUES (".$clientId.",".$eventType." , '".$description."', '".$subjectCourt."', '".$subjectNoCourt."', '".$text."', '".$signature."')"; 				
		$result = mysqli_query($db_server,$query);
		if (!$result) die("Database access failed: " . mysqli_error());
	}
	else
	{
		$query = "UPDATE tbletter_template 
					SET event_type = ".$eventType." , description = '".$description."', subject_court = '".$subjectCourt."', subject_no_court = '".$subjectNoCourt."', text = '".$text."', signature = '".$signature."' 
					WHERE id = ".$id;
		$result = mysqli_query($db_server,$query);
		if (!$result) die("Database access failed: " . mysqli_error());
	}
	
	header("Location: settings.php?page=templates&eventType=".$eventType);
	exit;
	
}

function saveRegisters($db_server)
{
	//
	$i=1;
	while (isset($_POST['reg'.$i]))
	{
		$query = "UPDATE tbsettings 
					SET value = '".sanitizeMySQL($_POST['reg'.$i])."' 
					WHERE id = ".$i;
		
		$result = mysqli_query($db_server,$query);
		if (!$result) die("Database access failed: " . mysqli_error());
		$i++;
	}
	
	header("Location: settings.php?page=registers&saved=true");
	exit;
	
}

function displayDashboardSettings()
{
	extract($GLOBALS);
	echo "<script type=\"text/javascript\" src=\"js/dashboardSettings.js\"></script>";
	echo "<div class=\"content\"><br>";
	echo "<h1>הגדרות עמוד הבית</h1><br>";
	echo "<form name= \"editDashboardSettingsFrm\" action=\"settings.php\" method=\"post\">";
	echo "<table class=\"dashboardSettings\"><tr>";
	
	echo "<td>";
	echo "<table id=\"secondColumn\"><tbody>";
	echo "</tbody></table>";
	echo "</td>";
	
	echo "<td>";
	echo "<table id=\"firstColumn\"><tbody>";
	echo "</tbody></table>";
	echo "</td>";
	
	echo "</tr></table>";
	echo "<br /><input type=\"submit\" value=\"שמור\" />";
	if (isset($_GET['saved'])) 
	{
		if ($_GET['saved'] == "true")
		{
			echo "&nbsp&nbsp<img src=\"/images/check.gif\" width=\"20px\" />&nbsp<span style=\"color:green;\">נשמר</span>";
		}
	}
	echo "</form>";
	echo "</div>";
}
function displayUserSettings($db_server)
{
	extract($GLOBALS);
	echo "<div class=\"content\"><br>";
	echo "<h1>הגדרות משתמש</h1><br>";
	
	echo "<form name= \"editUserSettingsFrm\" action=\"settings.php\" method=\"post\">";
	echo "<input type=\"hidden\" id=\"action\" name=\"action\" value=\"saveUserSettings\" />";
	//query templates 
	$query = "SELECT t1.username, t1.first_name, t1.last_name, t1.email, t1.role
					FROM tbusers as t1
					WHERE t1.id = ".$userId;
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		echo "<table>";
		
			
			echo "<tr>";
				echo "<td>".$row[2]."</td>";
				echo "<td><input name=\"reg".$row[0]."\" type=\"text\" value=\"".$row[1]."\"/>&nbsp&nbsp".$row[3]."</td>";
			echo "</tr>";	
		
		echo "</table>";
		echo "<br /><input type=\"submit\" value=\"שמור\" />";
		if (isset($_GET['saved'])) 
		{
			if ($_GET['saved'] == "true")
			{
				echo "&nbsp&nbsp<img src=\"/images/check.gif\" width=\"20px\" />&nbsp<span style=\"color:green;\">נשמר</span>";
			}
		}
	}
	echo "</form>";
	echo "</div>";
}

function saveUserSettings()
{
	
}

function deleteTemplate($db_server)
{
	if (isset($_GET['template']))
	{
		$templateId = sanitizeInput($_GET['template']);
	
		$query = "DELETE from tbletter_template 
					WHERE id = ".$templateId;
		$result = mysqli_query($db_server,$query);
		if (!$result) die("Database access failed: " . mysqli_error());
	}
	header("Location: settings.php?page=templates&eventType=".$_GET['eventType']);
	exit;
}

function duplicateTemplate($db_server)
{
	if (isset($_GET['template']))
	{
		$templateId = sanitizeInput($_GET['template']);
	
		$query = "INSERT into tbletter_template (client_id,event_type,description,subject_court,subject_no_court,text,signature)
					select client_id,event_type,CONCAT(description,\" (2)\"),subject_court,subject_no_court,text,signature from tbletter_template
					WHERE id = ".$templateId;
		$result = mysqli_query($db_server,$query);
		if (!$result) die("Database access failed: " . mysqli_error());
	}
	header("Location: settings.php?page=templates&eventType=".$_GET['eventType']);
	exit;
}

function displayPasswordChange()
{	
	echo "<div class=\"content\"><br>";
	echo "<h1>שינוי סיסמא</h1><br><br>";
	echo "<form name= \"changePasswordFrm\" action=\"settings.php\" method=\"post\">";
	echo "<input type=\"hidden\" id=\"action\" name=\"action\" value=\"changePassword\" />";
	if (isset($_GET['change'])) 
	{
		if ($_GET['change'] == "true")
		{
			echo "&nbsp&nbsp<img src=\"/images/check.jpg\" width=\"20px\" />&nbsp<span style=\"color:green;\">הסיסמא הוחלפה בהצלחה</span>";
		}
		else
		{
			echo "&nbsp&nbsp<p class=\"errorMsg\"><span class=\"ui-icon ui-icon-alert\" style=\"float: right; margin-left: .3em;\"></span>הסיסמא לא הוחלפה.</p>";
		}
	}
	echo "<br><br>";
	echo "<table>";
	
	echo "<tr>";
		echo "<td>סיסמא נוכחית:</td>";
		echo "<td><input name=\"currPass\" type=\"password\" />&nbsp</td>";
	echo "</tr>";	
	echo "<tr>";
		echo "<td>סיסמא חדשה:</td>";
		echo "<td><input name=\"newPass1\" type=\"password\" />&nbsp</td>";
	echo "</tr>";
	echo "<tr>";
		echo "<td>סיסמא חדשה שוב:</td>";
		echo "<td><input name=\"newPass2\" type=\"password\" />&nbsp</td>";
	echo "</tr>";
	
	
	echo "</table>";
	echo "<br /><input id=\"submit\" type=\"submit\" value=\"החלף\" />";
	
	
	echo "</form>";
	echo "<br><br>";
	echo "<script>";
	echo " $(\"#submit\").button({ icons: { primary: \"ui-icon-trash\" },text:false});";
	echo "</script>";
	echo "</div>";
}

function doPasswordChange($db_server)
{
	extract($GLOBALS);
	
	$currPass = sanitizeInput($_POST['currPass']);
	$newPass1 = sanitizeInput($_POST['newPass1']);
	$newPass2 = sanitizeInput($_POST['newPass2']);

	if ($newPass1 != $newPass2)
	{
		header("Location: settings.php?page=passwordChange&change=fail");
		exit;
	}
	
	$query = "SELECT t1.password FROM tbusers as t1 WHERE t1.id='$userId'";
	$result = mysqli_query($db_server,$query);
	if (!$result) die("Database access failed: " . mysqli_error());
	elseif (mysqli_num_rows($result))
	{
		$row = mysqli_fetch_row($result);
		// check for password match
		if (md5($currPass)."clean" == $row[0])
		{
			$updateSQL = "UPDATE tbusers set password = '".md5($newPass1)."clean' WHERE t1.id='$userId'";
			$updateResult = mysqli_query($db_server,$updateSQL);
			if (!$updateResult)
			{
				header("Location: settings.php?page=passwordChange&change=fail");
				exit;
			}
			else
			{
				header("Location: settings.php?page=passwordChange&change=true");
				exit;
			}
		}
		else
		{
			header("Location: settings.php?page=passwordChange&change=fail");
			exit;
		}
	}
	else
	{
		header("Location: settings.php?page=passwordChange&change=fail");
		exit;
	}
}
