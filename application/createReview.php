<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);
if (isset($_POST['reviewParm6']))
{
	$caseId = sanitizeMySQL($_POST['caseId']);
	
	$reviewEventId = sanitizeInput($_POST['reviewEventId']);
	$reviewParm6 = $_POST['reviewParm6'];
	$reviewParm7 = $_POST['reviewParm7'];
	
	if (isset($_POST['visitEventId']))
	{
		$visitEventId = sanitizeMySQL($_POST['visitEventId']);
		$visitEventParm6 = sanitizeMySQL($_POST['visitEventParm6']);
		$visitEventParm7 = sanitizeMySQL($_POST['visitEventParm7']);
		$visitEventParm8 = sanitizeMySQL($_POST['visitEventParm8']);
	}
	else
	{
		$visitEventId = "";
		$visitEventParm6 = "";
		$visitEventParm7 = "";
		$visitEventParm8 = "";
	}
	
	editReview($db_server,$caseId,$reviewEventId,$reviewParm6,$reviewParm7,$visitEventId,$visitEventParm6,$visitEventParm7,$visitEventParm8,$clientId);
	exit;
}
elseif (isset($_GET['id']))
{
	$caseId = sanitizeMySQL($_GET['id']);
	$caseQuery = "SELECT patient_name 
					FROM tbcases
					WHERE  (id = ".$caseId.") and
							(client_id = ".$clientId.")";
	$caseResult = mysqli_query($db_server,$caseQuery);
	if (!$caseResult) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($caseResult))
	{
		$caseRow = mysqli_fetch_row($caseResult);
		$patientName = $caseRow[0];
	}
	else
	{
		header("Location: index.php");
		exit;
	}
}
else
{
	header("Location: index.php");
	exit;
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
        <script src="/js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
        <script src="/js/jstorage.min.js" type="text/javascript"></script>
        <script src="/js/clinic.js" type="text/javascript"></script>
        <script type="text/javascript" src="/tiny_mce/jquery.tinymce.js"></script>
        <link rel="stylesheet" href="/css/ui-lightness/jquery-ui-1.8.14.custom.css" type="text/css" />
		<link rel="stylesheet" href="/css/main.css" type="text/css" />
		<title>כתיבת חוות דעת</title>
		<script>
		function autoIframe(frameId) {
	       try {
	          frame = document.getElementById(frameId);
	          innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document;
	          objToResize = (frame.style) ? frame.style : frame;
	          objToResize.height = (innerDoc.body.scrollHeight + 50) + "px";
	       }
	       catch(err) {
	          window.status = err.message;
	       }
	    }
		</script>
		<script>
		 $(document).ready(function() { 
			$("#leftPane").height($(window).height());
			$("#tabsContainer").width($("#leftPane").width()-5);
	        $("#tabs").tabs();
	        $(".saveBtn").button({ icons: { secondary: "ui-icon-disk" }});
	        $(".doneBtn").button({ icons: { secondary: "ui-icon-mail" }});
        	
        	
        	// Localstorage
	      	var caseId = <?=$caseId ?>;
			var patientName = "<?=$patientName ?>";
			
			var localData = $.jStorage.get("case"+caseId);
			
			if (localData)
			{
				//alert('restored data: '+localData);
				var localDataObj = new Object();
				
				// this case is in storage
				localDataObj = jQuery.parseJSON(localData);

				//alert('reviewParm7: '+localDataObj.reviewParm7);
				// set form fields
				$("#visitEventParm6").val(localDataObj.visitEventParm6);
			 	$("#visitEventParm7").val(localDataObj.visitEventParm7);
			 	$("#visitEventParm8").val(localDataObj.visitEventParm8);
			 	$("#reviewParm6").val(localDataObj.reviewParm6);
			 	$("#reviewParm7").val(localDataObj.reviewParm7);	 	
			}

			// check if needs to autosave every 10 seconds
			window.setInterval(checkSave, 10000);

			$('textarea.tinymce').tinymce({
        		// Location of TinyMCE script
        		script_url : '/tiny_mce/tiny_mce.js',

        		// General options
        		theme : "advanced",
        		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

        		// Theme options
        		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,fontselect,fontsizeselect,styleprops,|,ltr,rtl,|,hr,|,sub,sup,|,charmap,",
        		theme_advanced_buttons2 : "cut,copy,paste,pasteword,bullist,numlist,|,outdent,indent,|,image,|,forecolor,backcolor,|,tablecontrols",
        		theme_advanced_buttons3 : "",
        		theme_advanced_buttons4 : "",
        		theme_advanced_toolbar_location : "top",
        		theme_advanced_toolbar_align : "left",
        		theme_advanced_statusbar_location : "bottom",
        		theme_advanced_resizing : true,
        		pagebreak_separator : "<DIV CLASS=\"pageBreak\"/>",

        		// Example content CSS (should be your site CSS)
        		content_css : "/css/main.css"

        	});
			
						
				
		 });
		 
		 function saveLocalStorage()
			{
				var localDataObj = new Object();
				localDataObj.visitEventParm6 = $("#visitEventParm6").val();
				localDataObj.visitEventParm7 = $("#visitEventParm7").val();
				localDataObj.visitEventParm8 = $("#visitEventParm8").val();
				localDataObj.reviewParm6 = $("#reviewParm6").val();
				localDataObj.reviewParm7 = $("#reviewParm7").val();

				$.jStorage.set("case"+$("#caseId").val(),JSON.stringify(localDataObj));
				//alert ('storage set: '+JSON.stringify(localDataObj));
				tinymce.activeEditor.isNotDirty = true;
			}
		 function checkSave() { 
			 if (tinymce.activeEditor.isDirty())
				 saveLocalStorage();
			  }
		 
		</script>
	</head>
<body >
<div id="wideContainer" >
	<div id="leftPane" >
	<?php 
	//atached files 
	$eventsQuery = "SELECT t1.file_name, t1.file_desc
					FROM tbevents as t1
					WHERE  (t1.case_id = ".$caseId.") and
							(t1.client_id = ".$clientId.") and
							(t1.file_name != \"\")
					ORDER BY t1.timestamp desc";
	$eventsResult = mysqli_query($db_server,$eventsQuery);
	if (!$eventsResult) die("Database access failed: " . mysqli_error());
	if (!mysqli_num_rows($eventsResult))
	{
		echo "אין קבצים מצורפים";
	}

	?>
	<div id="tabsContainer" style="height:94%;position:fixed;" >
	<div id="tabs" style="width:100%;height:100%;" >
		<ul>
			<?php for ($i=0;$i<mysqli_num_rows($eventsResult);$i++)
			{
				$eventsRow = mysqli_fetch_row($eventsResult);
			if ($eventsRow[1] == "") {$eventsRow[1] = "ללא תיאור"; }
				echo "<li><a href=\"#tabs-".($i+1)."\">".$eventsRow[1]."</a></li>";
				$fileNames[($i+1)] = $eventsRow[0];
			}
			?>
		</ul>
		
		<?php for ($i=1;$i<=mysqli_num_rows($eventsResult);$i++)
		{
			// load files - on document ready
			echo "<div id=\"tabs-".$i."\" style=\"padding:0px;width:100%;height:95%;\" >";
			echo "<iframe  style=\"width:100%;height:100%;\" src=\"/file.php?f=".$fileNames[($i)]."#view=FitV\"></iframe>";
			echo "</div>";	
		}
		?>
		
	</div>
	</div>
	</div>
<div id="rightPane" >
<script type="text/javascript">
function formValidator()
{
	var valid;
	valid = true;
		
	if ( $("#visitEventParm6").length && $("#visitEventParm6").val().length > 10000)
	{
		alert("סעיף תולדות התאונה ארוך מדי");
		valid=false;
	}
	if ( $("#visitEventParm7").length && $("#visitEventParm7").val().length > 5000)
	{
		alert("סעיף תולדות המטופל ארוך מדי");
		valid=false;
	}
	if ( $("#visitEventParm8").length && $("#visitEventParm8").val().length > 6000)
	{
		alert("סעיף מהלך הבדיקה ארוך מדי");
		valid=false;
	}
	
	if (testIsValidObject($("#reviewParm6")))
	{
		if ( $("#reviewParm6").length && $("#reviewParm6").val().length > 5000)
		{
			alert("סעיף בדיקות עזר ארוך מדי");
			valid=false;
		}
		if ( $("#reviewParm7").length && $("#reviewParm7").val().length > 5000)
		{
			alert("סעיף דיון ומסקנות ארוך מדי");
			valid=false;
		}
	}
	
	return valid;
}
</script>
<h1>כתיבת חוו"ד עבור <?php echo $patientName; ?></h1>
<form name="reviewForm" action="createReview.php" method="post" onsubmit="return formValidator()">

<?php
echo "<input type=\"hidden\" id=\"caseId\" name=\"caseId\" value=\"".$caseId."\" />"; 

$visitQuery = "SELECT id, case_id, type, remarks, parm1, parm2, parm6, parm7, parm8 
				FROM tbevents
				WHERE  (case_id = ".$caseId.") and
						(client_id = ".$clientId.") and
						(type = 2)
				ORDER BY timestamp desc";
$visitResult = mysqli_query($db_server,$visitQuery);
if (!$visitResult) die("Database access failed: " . mysqli_error());
if (mysqli_num_rows($visitResult))
{
	$visitRow = mysqli_fetch_row($visitResult);
	echo "<input type=\"hidden\" id=\"visitEventId\" name=\"visitEventId\" value=\"".$visitRow[0]."\" />";
	echo "<p><b>".$eventsParms[2][1].":</b> ".$eventsOptions[2][1][$visitRow[4]]."</p>";
	echo "<p><b>".$eventsParms[2][2].":</b> ".$eventsOptions[2][2][$visitRow[5]]."</p>";
}
else
{
	echo "<p><b>לא קיים אירוע ביקור פציינט בתיק זה</b></p><br /><br />";
}
#######################################################
#### Start edit part ##################################
echo '<div id="editScrollPart" style="position:relative; height:100%; margin-bottom:50%;  ">';
if (mysqli_num_rows($visitResult))
{
	echo "<br><h3>".$eventsParms[2][6].":</h3><br>";
	echo "<textarea id=\"visitEventParm6\" name=\"visitEventParm6\" cols=\"80\" rows=\"10\" class=\"tinymce\" >".$visitRow[6]."</textarea><br>";
	echo "<h3>".$eventsParms[2][7].":</h3><br>";
	echo "<textarea id=\"visitEventParm7\" name=\"visitEventParm7\" cols=\"80\" rows=\"10\" class=\"tinymce\">".$visitRow[7]."</textarea><br>";
	echo "<h3>".$eventsParms[2][8].":</h3><br>";
	echo "<textarea id=\"visitEventParm8\" name=\"visitEventParm8\" cols=\"80\" rows=\"10\" class=\"tinymce\">".$visitRow[8]."</textarea><br>";
}

$reviewQuery = "SELECT id, case_id, type, parm6, parm7
				FROM tbevents
				WHERE  (case_id = ".$caseId.") and
						(client_id = ".$clientId.") and
						(type = 5)
				ORDER BY timestamp desc";
$reviewResult = mysqli_query($db_server,$reviewQuery);
if (!$reviewResult) die("Database access failed: " . mysqli_error());
if (mysqli_num_rows($reviewResult))
{
	$reviewRow = mysqli_fetch_row($reviewResult);
	$reviewEventId = $reviewRow[0];
	$reviewParm6 = $reviewRow[3];
	$reviewParm7 = $reviewRow[4];
}
else
{
	$reviewEventId = "";
	$reviewParm6 = "";
	$reviewParm7 = "";
}

echo "<input type=\"hidden\" id=\"reviewEventId\" name=\"reviewEventId\" value=\"".$reviewEventId."\" />";
echo "<p><b>בדיקות עזר:</b><br>";
echo "<textarea name=\"reviewParm6\" id=\"reviewParm6\" cols=\"80\" rows=\"10\" class=\"tinymce\">".$reviewParm6."</textarea><bR>";

echo "</div>";
#### End edit part ####################################
#######################################################
#### Start bottom part ####################################
echo '<div id="editBottomPart" style="height:auto; position:fixed; bottom:0; background:#fdfef9;">';
echo "<p><b>דיון ומסקנות:</b><br>";
echo "<textarea name=\"reviewParm7\" id=\"reviewParm7\" cols=\"80\" rows=\"10\" class=\"tinymce\">".$reviewParm7."</textarea><br>";
?>

<center><input class="saveBtn" type="submit" name="saveBtn" value="שמור" />&nbsp&nbsp<input class="doneBtn" type="submit" name="doneBtn" value="שמור ושלח להפצה" /></center>
<a href="#" onclick="saveLocalStorage()">save LocalStorage</a>
<?php
#### End edit part ####################################
####################################################### 
?>
</form>
</div>
</div>
</div>
</body>
</html>

<?php 
###  end of html page
#################################################################################################
#################################################################################################
#################################################################################################

function sendPost($data) {
    $ch = curl_init();
    // you should put here url of your getinfo.php script
    curl_setopt($ch, CURLOPT_URL, "ajaxEngine.php");
    curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $result = curl_exec ($ch); 
    curl_close ($ch); 
    return $result; 
}

function editReview($db_server,$caseId,$reviewEventId,$reviewParm6,$reviewParm7,$visitEventId,$visitEventParm6,$visitEventParm7,$visitEventParm8,$clientId)
{
	extract($GLOBALS);
	require_once 'ajaxEngine.php';
	
	if ($visitEventId != "")
	{
		$updateQuery = "UPDATE tbevents 
				SET parm6 = '".$visitEventParm6."', parm7 = '".$visitEventParm7."', parm8 = '".$visitEventParm8."' 
				WHERE id = ".$visitEventId;
		$updateResult = mysqli_query($db_server,$updateQuery);
		if (!$updateResult) die("Database access failed in update visit details: " . mysqli_error());
	}

	if ($reviewEventId != "")
	{
		$updateQuery = "UPDATE tbevents 
				SET parm6 = '".sanitizeMySQL($reviewParm6)."', parm7 = '".sanitizeMySQL($reviewParm7)."' 
				WHERE id = ".$reviewEventId;
		$updateResult = mysqli_query($db_server,$updateQuery);
		if (!$updateResult) die("Database access failed in update review event: " . mysqli_error());
		
		// is the review done? - change status
		if(!empty($_REQUEST['doneBtn']))
		{
			// wait for payment
			if (!getSetting('wait_for_payment'))
			{
				// has the case been payed
				$caseSQL = "SELECT payed FROM tbcases   
									WHERE ID = ".$caseId;
				$caseResult = mysqli_query($db_server,$caseSQL);
				if (!$caseResult) die("Database access failed createReview(isPayed): " . mysqli_error());
				$row = mysqli_fetch_row($caseResult);
				if ($row[0] == 2)
				{
					updateStatus($caseId,"מוכן להפצה");
				}
				else
				{
					updateStatus($caseId,"מחכה לתשלום");
				}
			}
			else
			{
				updateStatus($caseId,"מוכן להפצה");
			}
			
			// get template Id for the review
			$templateSQL = "SELECT id FROM tbletter_template   
								WHERE (event_type = 5) and
								      (client_id = ".$clientId.") 
								ORDER BY description asc";
			$templateResult = mysqli_query($db_server,$templateSQL);
			if (!$templateResult) die("Database access failed createReview(template): " . mysqli_error());
			$templateRow = mysqli_fetch_row($templateResult);
			$letterTemplate = $templateRow[0];
			
			// generate the review
			$documentId = generateDocument($db_server,$caseId, $reviewEventId, 1, $letterTemplate, NULL, NULL, "", "");
			
			// update the event with the review's document ID
			$query = "update tbevents
						SET document_id = ".$documentId."
						WHERE id = ".$reviewEventId;
			$result = mysqli_query($db_server,$query);
			if (!$result) die("Database access failed createReview(updateEvent): " . mysqli_error());
		}
	}
	else
	{
		$parms['parm6'] = $reviewParm6;
		$parms['parm7'] = $reviewParm7;
		$parms['toWho'] = "";
		$parms['cc'] = "";
		$parms['alertMethod'] = "";
		$parms['id'] = $caseId;
		$parms['type'] = 5;
		$parms['fileName'] = "";
		$parms['fileDesc'] = "";
		$parms['method'] = 1;
		$parms['remarks'] = "";
		$parms['actionType'] = "add";
		
		if(!empty($_REQUEST['doneBtn']))
		{
			$parms['reviewDone'] = true;
		}
		
		
		
		// I moved this to post call
		addEvent($parms);
		//$data_arr =  array_merge ( array ('action'=>'addEvent') , $_POST );
		//$data = sendPost( $data_arr );
		//var_dump($data);
		//exit();
	}

	header("Location: showCase.php?id=".$caseId."&clearLocalStorages=true");
	exit();
}
