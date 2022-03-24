<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_POST['documentText']))
{
	$documentText = sanitizeMySQL($_POST['documentText']);
	$documentId = sanitizeInput($_POST['id']);
	$caseId = sanitizeMySQL($_POST['caseId']);
	editArticle($db_server,$documentId,$documentText,$caseId)	;
}
elseif (isset($_GET['id']))
{
	$documentId = sanitizeMySQL($_GET['id']);
	displayForm($db_server,$documentId);
}
else
{
	header("Location: index.php");
	exit;
}

function displayForm($db_server,$documentId)
{
pageStart("עריכת מסמך","<script type=\"text/javascript\" src=\"/tiny_mce/jquery.tinymce.js\"></script>");

$query = "SELECT t1.id,t1.document,t1.case_id
			FROM tbdocuments as t1
			where t1.id = ".$documentId; 
			
$result = mysqli_query($db_server,$query);
if (!$result) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($result))
{
	$row = mysqli_fetch_row($result);
}	

echo "<div class=\"content\">";

echo "<h1>עריכת מסמך #".$documentId."</h1>";

echo "<form name= \"editDocumentFrm\" action=\"editDocument.php\" method=\"post\">";

echo "<input type=\"hidden\" id=\"id\" name=\"id\" value=\"".$documentId."\" />";
echo "<input type=\"hidden\" id=\"caseId\" name=\"caseId\" value=\"".$row[2]."\" />";
echo "<textarea name=\"documentText\" cols=\"100\" rows=\"50\" class=\"tinymce\">".$row[1]."</textarea>";

echo "<br /><input type=\"submit\" value=\"Save\" />&nbsp;&nbsp;";
echo "<a href=\"showCase.php?id=".$row[2]."\">בטל</a>";
echo "</form>";
echo "</div>";

echo <<<_END

<script type="text/javascript" >
$('textarea.tinymce').tinymce({
	// Location of TinyMCE script
	script_url : '/tiny_mce/tiny_mce.js',

	// General options
	theme : "advanced",
	plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

	// Theme options
	theme_advanced_buttons1 : "save,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
	theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
	theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,
	pagebreak_separator : "<DIV CLASS=\"pageBreak\"/>",

	// Example content CSS (should be your site CSS)
	content_css : "css/main.css",

	// Drop lists for link/image/media/template dialogs
	template_external_list_url : "lists/template_list.js",
	external_link_list_url : "lists/link_list.js",
	external_image_list_url : "lists/image_list.js",
	media_external_list_url : "lists/media_list.js",

	// Replace values for the template plugin
	template_replace_values : {
		username : "Some User",
		staffid : "991234"
	}
});
</script >

_END;

//pageEnd;
}

function editArticle($db_server,$documentId,$documentText,$caseId)
{
	
	$updateSQL = "UPDATE tbdocuments 
				SET document = '".$documentText."' 
				WHERE id = ".$documentId;
	$updateResult = mysqli_query($db_server,$updateSQL);
	if (!$updateResult) die("Database access failed: " . mysqli_error()." SQL: ".$updateSQL);
	
	// go to the case page
	header("Location: showCase.php?id=".$caseId);
	exit;
}
?>