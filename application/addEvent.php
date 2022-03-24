<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

$caseId=sanitizeInput($_GET['caseId']);
if (isset($_GET['eventType']))
{
	$eventType = sanitizeInput($_GET['eventType']);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
        <script src="js/jquery-ui-1.8.14.custom.min.js" type="text/javascript"></script>
        <script src="js/fileuploader.js" type="text/javascript"></script>
        <script src="js/clinic.js" type="text/javascript"></script>
        <link rel="stylesheet" href="css/fileuploader.css" type="text/css" />
        <title>הוספת אירוע</title>
        <script type="text/javascript">
        //$(document).bind('keydown', 'ctrl+s', function(){ if(courtFormValidator()) {addEventSend(false);} return false; });
        var unsavedFile = false;
        var fileDoneUploading = true;
        $(document).ready(function() { 
        	addEventScript()
        	var uploader = new qq.FileUploader({
        	    // pass the dom node (ex. $(selector)[0] for jQuery users)
        	    element: document.getElementById('file-uploader'),
        	    // path to server-side upload script
        	    action: 'upload-server/php.php',
        	    sizeLimit: 0,
        	    debug: false,
        	    onComplete: function(id, fileName, responseJSON)
        	    {
            	  //alert(JSON.stringify(responseJSON));
            	  if (!responseJSON.success)
            	  {
                	alert('תקלה בהעלאת הקובץ לשרת');
                	unsavedFile = false;
            	  }
            	  else
            	  {
	            	  $('#fileName').val(responseJSON.fileName);
	            	  $('#file-uploader').hide();
	            	  fileDoneUploading = true;
	            	  $('#fileUploadedMessage').fadeIn();
            	  }
            	},
            	onSubmit: function(id, fileName){
						$('.qq-upload-button').hide();
						unsavedFile = true;
						fileDoneUploading = false;
                	},
            	onCancel: function(id, fileName){
                		$('.qq-upload-button').show();
                		unsavedFile = false;
                		fileDoneUploading = true;
                    }
        	
        	}); 
        	});
        
        </script>
</head>
<body>
<div id="content">

<form id="AddEventForm" name="AddEventForm" method="post">


<h1>הוסף אירוע</h1>
<BR />
<table class="formTable">
<input type="hidden" id="id" name="caseId" value="<?php echo $caseId; ?>" />
<input type="hidden" id="actionType" name="actionType" value="add" />
<tr>
	<td>
		<label>סוג</label>
	</td>
	<td>
		<?php 
		if (isset($eventType))
		{
			echo "<p>".$eventTypes[$eventType]."</p>";
			echo "<input type=\"hidden\" name=\"eventTypeSelect\" value=\"".$eventType."\" />";	
			echo "<script>generateDynamicForm(); populateTemplateList();</script>";
		}
		else
		{
			echo "<select name=\"eventTypeSelect\" size=\"1\" onChange=\"generateDynamicForm(); populateTemplateList()\">";
			
			foreach ($eventTypes as $i => $eventTypeValue) {
				// don't add "write review"
				if ($i != 5)
				{
					echo "<option ";
					if ($i==1) {echo "selected";}
					echo " value=\"".$i."\">".$eventTypeValue."</option>";
				}
			}
			echo "</select>";
		}
		?>
		
	</td>
	<td></td>
</tr>
<tr>
	<td>
		<label>מקור</label>
	</td>
	<td>
		<select name="eventMethodSelect" size="1">
		<?php 
		foreach ($methodText as $i => $methodValue) {
			echo "<option ";
			if ($i==1) {echo "selected";}
			echo " value=\"".$i."\">".$methodValue."</option>";
		}
		?>
		</select>
	</td>
	<td></td>
</tr>
<tr>
	<td>
		<label>צירוף קובץ:</label>
	</td>
	<td>
		<span id="fileUploadedMessage" style="display:none;"><img src="/images/check.gif" width="15px" />&nbsp&nbspהקובץ הועלה בהצלחה</span>
		<?php /* &nbsp&nbsp&nbsp<input id="file_upload" name="file_upload" type="file" />
		<P id="fileNameLabel"></P> */ ?>
		<div id="file-uploader">       
		    <noscript>          
		        <p>Please enable JavaScript to use file uploader.</p>
		        <!-- or put a simple form for upload here -->
		    </noscript>         
		</div>
		<input type="hidden" id="fileName" name="fileName"/>
		<p>תיאור הקובץ: </p><input name="fileDesc" type="text" maxlength="50" />
	</td>
</tr>


</table>

<div id="dynamicForm"></div>
<table class="formTable">
<tr>
	<td>
		<label>הערות</label>
	</td>
	<td colspan="3">
		<textarea name="remarks" cols="36" rows="2" maxlength="200"></textarea>
	</td>
</tr>
<tr>
	<td>
		<input type="checkbox" name="addAlert" value="true">&nbsp&nbsp<label>התראה ל-</label>
	</td>
	<td>
		<select name="userAlertSelect" size="1">
		<?php 
		
			$userQuery = "SELECT t1.id,t1.first_name,t1.last_name 
								FROM tbusers as t1
								WHERE (t1.client_id = ".$clientId.")
								      AND status IS NULL
								ORDER BY t1.id desc";
								// dudy 24/4/2016 add: where user is active
			$userResult = mysqli_query($db_server,$userQuery);
			if (!$userResult) die("Database access failed: " . mysqli_error());
			elseif (mysqli_num_rows($userResult))
			{
				for ($i=0;$i<mysqli_num_rows($userResult);$i++)
				{
					$userRow = mysqli_fetch_row($userResult);
					echo "<option value=\"".$userRow[0]."\">".$userRow[1]." ".$userRow[2]."</option>";
				}
			}
		?>
		
		</select>
	</td>
	<td>
		<input type="checkbox" name="alertMethod" value="website" checked> דרך האתר<br>
		<input type="checkbox" name="alertMethod" value="email"> דרך אי-מייל
	</td>
</tr>
<tr id="addLetterTr">
<td colspan="3"><a id="addBtn" onClick="$('#addLetterTr').fadeOut(); $('#letterTr').fadeIn(); $('#letterTr2').fadeIn(); ">הוסף מכתב</a></td>
</tr>

<tr id="letterTr" style="display:none;">
	<td><label>לכבוד:</label></td>
	<td>
		<input type="checkbox" name="toWho" value="court"> ביהמ"ש<br>
		<input type="checkbox" name="toWho" value="prosecutor"> תובע<br>
		<input type="checkbox" name="toWho" value="defenseLawyer"> נתבע<br>
		<input type="checkbox" name="toWho" value="other"> אחר: <br><textarea name="toOther" cols="15" rows="2" maxlength="50"></textarea>
	</td>
	<td><label>העתק:</label></td>
	<td>
		<input type="checkbox" name="cc" value="court"> ביהמ"ש<br>
		<input type="checkbox" name="cc" value="prosecutor"> תובע<br>
		<input type="checkbox" name="cc" value="defenseLawyer"> נתבע<br>
	</td>
</tr>
<tr id="letterTr2" style="display:none;">
	<td><label>באמצעות:</label></td>
	<td>
		<select name="letterMethodSelect" size="1" >
		<?php 
		foreach ($methodText as $i => $methodValue) {
			echo "<option ";
			if ($i==1) {echo "selected";}
			echo " value=\"".$i."\">".$methodValue."</option>";
		}
		?>
		</select>
	</td>
	<td><label>תבנית:</label></td>
	<td>
		<select name="letterTemplateSelect" size="1" ></select>
	</td>
</tr>
</table>
<a><input id="submitBtn" type="button" onClick="if(courtFormValidator()) {addEventSend(false);}" value="שמור" /></a>&nbsp&nbsp<img id="checkImg" style="display:none;" src="images/check.gif" width="20px" />
<img id="savingImg" style="display:none;" src="images/loading-small-orange.gif" width="20px" />
</form>

</div>

</body>
</html>
