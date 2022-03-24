<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_GET['id']))
{
	$idNumber = sanitizeMySQL($_GET['id']);
}
else
{
	header("Location: index.php");
	exit;
}

$AllEvents = "false";

if (isset($_GET['showAllEvents']))
{
	$AllEvents = sanitizeInput($_GET['showAllEvents']);

}



	
//                0      1                2                                      3                                                  4                          5                6         7             8            9                                   10                                11             12               13           14                      15                   16                17              18                   19                   20                              21                                                22                          23              24                 25 
$query = "SELECT t1.ID, t1.patient_seen, t1.court_num, DATE_FORMAT(date(t1.appointment_date),'%d/%m/%Y'), DATE_FORMAT(date(t1.creation_date),'%d/%m/%Y'), t1.appointment_type, t6.type, t6.location, t1.patient_id, t1.patient_name, DATE_FORMAT(date(t1.patient_birthdate),'%d/%m/%Y'), t1.patient_sex, t1.judge_name, t1.judge_sex, t1.defence_lawyer_name, t1.prosecutor_name, t1.payment_amount, t1.with_tax, t1.prosecutor_payment, t1.defence_payment, t1.extra_demands,DATE_FORMAT(date(t1.case_deadline),'%d/%m/%Y') , DATE_FORMAT(date(t1.court_date),'%d/%m/%Y'), t1.payed, t1.all_material_recieved, t1.remarks,".
//            26       27          28       29        30       31       32         33         34        35     36       37        38                     39                         40                       41        42          43       44        45       46                          47                    48    49                   50                        51                       52             53                     54
		"	t2.name, t2.address, t2.email, t2.phone, t2.fax, t3.name, t3.address, t3.email, t3.phone, t3.fax, t4.name, t5.name, t1.prosecutor_firm_id, t1.defence_lawyer_firm_id, t1.defence_lawyer_name_2, t7.name, t7.address, t7.email, t7.phone, t7.fax, t1.defence_lawyer_firm_id_2, t1.defence_2_payment, t6.id,t1.prosecutor_number,t1.defence_lawyer_number,t1.defence_lawyer_2_number,t1.client_id,t1.defence_company_2_id,t8.name
			FROM tbcases as t1, tblawyers as t2, tblawyers as t3, tbcompanies as t4, tbstatus as t5, tbcourts as t6, tblawyers as t7, tbcompanies as t8
			where (t1.prosecutor_firm_id = t2.id) and 
					(t1.defence_lawyer_firm_id = t3.id) and
					(t1.defence_lawyer_firm_id_2 = t7.id) and
					(t1.defence_company_id = t4.id) and
					(t1.defence_company_2_id = t8.id) and
					(t1.status = t5.id) and
					(t1.court_id = t6.id) and
				  	t1.id = ".$idNumber; 
			
$result = mysqli_query($db_server,$query);
if (!$result) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($result))
{
	$row = mysqli_fetch_row($result);
	
	// check if this case belongs to this client
	if ($row[52] != $clientId)
	{
		header("Location: /index.php");
		exit;
	}
		
	pageStart("מערכת קליניקה - התיק של ".$row[9],"<script type=\"text/javascript\" src=\"js/jquery.expandcollapse.js\"></script><script type=\"text/javascript\" src=\"js/jstorage.js\"></script>");

	// check if needed to clear local storage
	if (isset($_GET['clearLocalStorages']))
	{
		if ($_GET['clearLocalStorages'] == "true")
		{
			echo "<script>";
			echo "$.jStorage.deleteKey('case".$idNumber."')";
			echo "</script>";
		}
	}
	
	echo "<BR />";
		
}
else
{
	header("Location: /index.php");
	exit;
}
?>
<table class="case-table2">
	<tr><td>
	<span style="font-size:24px;font-weight:bold;">&nbsp&nbsp&nbsp&nbsp&nbsp&nbspהתיק של <?php echo $row[9];?></span>&nbsp&nbsp&nbsp&nbsp&nbsp(#<?php echo $row[0];?>)
	</td></tr>
</table>
</br>

<div id="CaseContent">
<table class="case-table">
	<tr>
	<td>&nbsp&nbsp<u>סטטוס:</u><b> <?php echo $row[37]?></b>
	<a title="ערוך" class="editCase" href="editCase.php?caseId=<?php echo $idNumber;?>">ערוך</a>
	</td>
	</tr>
	<tr><td>
		<table class="sub-case-table">
			<tr>
			<td width="20px"><img src="images/icon_contact.png" height="20px"/></td>
			<td><u>שם פציינט:</u> <?php echo $row[9]?></td>
			<td><u>ת"ז:</u> <?php echo $row[8]?></td>
			<td><u>תאריך לידה:</u> <?php echo $row[10]?></td>
			<td><u>מין:</u> <?php echo $sexText[$row[11]]?></td>
			</tr>
		</table>
	</td></tr>
	<tr><td>
		<table class="sub-case-table">
			<tr>
				<td><table>
				<td width="20px"><img src="images/icon_court.png" height="20px"/></td>
				<td><u>סוג מינוי:</u> <?php echo $caseType[$row[5]]?></td>
				<?php 
					if ($row[5] == 1)
					{
						echo "<td><a class=\"envelope\" href=\"/envelope.php?name=כב' השופט"; if ($row[13] == 'F') echo "ת"; 
						echo " ".$row[12]."&courtId=".$row[48]."\" target=\"_blank\">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a>";
						echo "<u>שם השופט";
							if ($row[13] == 'F') echo "ת"; 
							echo ":</u> ";
							echo $row[12];
						echo "</td>";
						
						echo "<td><a class=\"envelope\" href=\"/envelope.php?name=מזכירות בית המשפט&courtId=".$row[48]."\" target=\"_blank\">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a>";
						echo "בית המשפט ה".$courtType[$row[6]]." ב".$row[7]."</td>";
					}
				?>
				<td><?php if ($row[2] != "") echo "<u>ת.א.</u> ".$row[2]; ?></td>
				<td><?php echo "<u>תאריך מינוי:</u> ".$row[3]; ?></td>
				</table></td>
			</tr>
			<tr>
				<td><table><tr>
				<td style="text-align:left;"><img src="images/icon_tie.png" height="20px"/>&nbsp<u>עו"ד תובע:</u><br /><br />
				<a href="/envelope.php?name=עו&quotד <?php echo $row[15]?>&lawyerId=<?php echo $row[38]?>" target="_blank"><img src="/images/mail_icon.gif" width="20px" /></a>&nbsp&nbsp&nbsp
				</td>
									<td >
										<?php echo $row[15]?><br /><?php if ($row[26] != "") echo $row[26]."<br />"; ?>
										<?php if ($row[27] != "") echo nl2br($row[27])."<br />"; ?>
										<?php if ($row[28] != "") echo $row[28]."<br />"; ?>
										<?php if ($row[29] != "") echo "טלפון: ".$row[29]."<br />"; ?>
										<?php if ($row[30] != "") echo "פקס:   ".$row[30]."<br />"; ?>
										<?php if ($row[49] != "") echo "מספרם:   ".$row[49]."<br />"; ?></td>
				<?php if (($row[5] == 1) || ($row[5] == 2)) 
				{ 
				echo "<td style=\"text-align:left;\"><img src=\"images/icon_tie.png\" height=\"20px\"/>&nbsp<u>עו\"ד נתבע:</u><br /><br />
				<a href=\"/envelope.php?name=עו&quotד ".$row[14]."&lawyerId=".$row[39]."\" target=\"_blank\"><img src=\"/images/mail_icon.gif\" width=\"20px\" /></a>&nbsp&nbsp&nbsp
				</td>
					<td>";}?>
							<?php echo $row[14]?><br /><?php if ($row[31] != "") echo $row[31]."<br />"; ?>
							<?php if ($row[32] != "") echo nl2br($row[32])."<br />"; ?>
							<?php if ($row[33] != "") echo $row[33]."<br />"; ?>
							<?php if ($row[34] != "") echo "טלפון: ".$row[34]."<br />"; ?>
							<?php if ($row[35] != "") echo "פקס:   ".$row[35]."<br />"; ?>
							<?php if ($row[50] != "") echo "מספרם:   ".$row[50]."<br />"; ?>
					<?php if (($row[5] == 1) || ($row[5] == 2)) 
					{ echo "</td>"; } ?>

			<?php if (($row[40] != "") || ($row[46] != 0))
			{				
				echo "<td style=\"text-align:left;\"><img src=\"images/icon_tie.png\" height=\"20px\"/>&nbsp<u>עו\"ד נתבע 2:</u><br /><br />";
				echo "<a href=\"/envelope.php?name=עו&quotד ".$row[40]."&lawyerId=".$row[46]."\" target=\"_blank\"><img src=\"/images/mail_icon.gif\" width=\"20px\" /></a>&nbsp&nbsp&nbsp";
				echo "</td>";
									echo "<td>";
										echo $row[40]."<br />";
										if ($row[41] != "") echo $row[41]."<br />";
										if ($row[42] != "") echo nl2br($row[42])."<br />"; 
										if ($row[43] != "") echo $row[43]."<br />"; 
										if ($row[44] != "") echo "טלפון: ".$row[44]."<br />"; 
										if ($row[45] != "") echo "פקס:   ".$row[45]."<br />";
										if ($row[51] != "") echo "מספרם:   ".$row[51]."<br />";  
										echo "</td>";
			}
			?>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<?php if (($row[5] == 1) || ($row[5] == 2)) { echo "<td style=\"text-align:left;\"><u>נתבעת:</u></td><td>".$row[36]."</td>"; } ?>
					<?php if ($row[53] != 0) { echo "<td style=\"text-align:left;\"><u>נתבעת 2:</u></td><td>$row[54]</td>"; } ?>
				</tr>
				</table></td>
			</tr>
			<tr>
				<td><table>
				<td width="20px"><img src="images/icon_money.png" height="20px"/></td>
				<td><u>תשלום:</u> <?php echo $row[16]?>
					<?php if ($row[17] == 1) echo "כולל מע\"מ"; else echo "ללא מע\"מ";?></td>
				<td><u>חלוקה:</u> תובע: <?php echo $row[18];?>% נתבע: <?php echo $row[19];?>%<?php if (($row[40] != "") || ($row[46] != 0)) { echo "  נתבע 2: ".$row[47]."%";} ?></td>
				<td><img src="images/icon_check.png" height="20px"/>&nbsp;<u>שולם:</u> <?php echo $payedText[$row[23]]?></td>
				<td><u>תאריך למסירת חוו"ד:</u> <?php echo $row[21]?></td>
				<td><u>תאריך למסירת החומר הרפואי:</u> <?php echo $row[22]?></td>
				</table></td>
			</tr>
			<tr>
				<td><table>
				<td><u>דרישות נוספות:</u><br /> <?php echo $row[20]?></td>
				</table></td>
			</tr>
		</table>
	</td></tr>
	<tr><td>
		<table class="sub-case-table">
			<tr>
			<td><img src="images/icon_notes.png" height="20px"/>&nbsp;<u>הערות:</u><br /><?php echo nl2br($row[25]); ?></td>
			</tr>
		</table>
	</td></tr>
	<tr><td>
		<table class="sub-case-table">
			<tr>
				<td><img src="images/icon_books.png" height="20px"/>&nbsp;<u>הוגש כל החומר:</u> <?php echo $booleanText[$row[24]]?></td>
				<td><img src="images/icon_doctor.png" height="20px"/>&nbsp;<u>הפציינט נבדק:</u> <?php echo $booleanText[$row[1]]?></td>
			</tr>
		</table>
	</td></tr>	
	
	
	<?php
	//atached files 
	$eventsQuery = "SELECT t1.file_name, t1.file_desc, t1.file_size
					FROM tbevents as t1
					WHERE  (t1.case_id = ".$idNumber.") and
							(t1.file_name != \"\") and
							(t1.client_id = ".$clientId.") 
					ORDER BY t1.timestamp desc";
	$eventsResult = mysqli_query($db_server,$eventsQuery);

	if (!$eventsResult) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($eventsResult))
	{
echo <<<_END
	<tr><td>
		<table class="sub-case-table">
			<tr>
				<td><p><u>ריכוז קבצים</u></p><br>
_END;
 				for ($i=0;$i<mysqli_num_rows($eventsResult);$i++)
				{
					$eventsRow = mysqli_fetch_row($eventsResult);
					
					/* it's less then 1mb */
					if (($eventsRow[2]/1024/1024) < 1)
					{
						$fileSize = round(($eventsRow[2]/1024),1)."kb";
					}
					else
					{
						$fileSize = round(($eventsRow[2]/1024/1024),1)."mb";
					}
					
					$fileType =  substr($eventsRow[0],strripos($eventsRow[0],".")+1);
					if ($eventsRow[1] == "") { $eventsRow[1] = "קובץ ללא תיאור"; }
					echo "<a href=\"/file.php?f=".$eventsRow[0]."\" target=\"_blank\"><img src=\"/images/icon_".$fileType.".png\" width=\"20px\" /> ".$eventsRow[1]." (".$fileSize.")</a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				}
echo <<<_END
 				<div class="showDocumentsDialog">show all</div>
				</td>
			</tr>
		</table>
	</td></tr>
_END;
	}

	//attached documents 
	$docQuery = "SELECT t1.id, t2.type
					FROM tbdocuments as t1, tbevents as t2
					WHERE  (t1.case_id = ".$idNumber.") and
							(t1.event_id = t2.id) and
							(t2.client_id = ".$clientId.") 
					ORDER BY t1.date desc";
	$docResult = mysqli_query($db_server,$docQuery);
	if (!$docResult) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($docResult))
	{
echo <<<_END
	<tr><td>
		<table class="sub-case-table">
			<tr>
				<td><p><u>ריכוז מסמכים</u></p>
_END;
	
 				for ($i=0;$i<mysqli_num_rows($docResult);$i++)
				{
					$docRow = mysqli_fetch_row($docResult);
					echo "<a href=\"showDocument.php?id=".$docRow[0]."\" target=\"_blank\"><img src=\"/images/mail_icon.gif\" width=\"20px\" /> ".$eventTypes[$docRow[1]]."</a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
				}
echo <<<_END
				
 				</td>
			</tr>
		</table>
	</td></tr>
_END;
	}
	
	
	//attached tags to case 
	/*
	$docQuery = "SELECT t1.id, t2.type
					FROM tbdocuments as t1, tbevents as t2
					WHERE  (t1.case_id = ".$idNumber.") and
							(t1.event_id = t2.id) and
							(t2.client_id = ".$clientId.") 
					ORDER BY t1.date desc";
	$docResult = mysqli_query($db_server,$docQuery);
	if (!$docResult) die("Database access failed: " . mysqli_error());
	if (mysqli_num_rows($docResult))
	{
		*/
echo <<<_END
	<tr><td>
		<table class="sub-case-table">
			<tr>
				<td><p><u>תגיות בתיק - (לחץ <b>Enter</b> לעדכון תגית)</u></p>
		<form class="form1">
            <p></p>
_END;
            echo '<ul id="allowSpacesTags" data-case_id="'. $idNumber . '"></ul>';
echo <<<_END
        </form>
				
 				</td>
			</tr>
		</table>
	</td></tr>
_END;
	//}
	
	
	
?>
</table>
<br />

<div id="CaseContent">
<table class="case-table2">
	<tr>
	<td><center><h3>אירועים בתיק</h3></center></td>
	</tr>
	<tr><td>
	<a class="addBtn" href="addEvent.php?caseId=<?php echo $idNumber; ?>" >הוסף אירוע</a><div class="editDialog"></div>
	<a class="btn" href="createReview.php?id=<?php echo $idNumber; ?>" >כתוב חוו"ד</a><br /><br />
</td>
</tr>
</table>
</br>

<script>

$showAllDocumentsHTML = "";



$(".addBtn, .btn").button({ icons: { secondary: "ui-icon-plus" }});
$(document).ready(function() {
	var $loading = $('<img src="/images/loading.gif" alt="loading">');
	$('.addBtn').each(function() {
		var $link = $(this);
		var $nextDiv = $(this).next('.editDialog');
		$(this).data('divObject', $nextDiv);
			$nextDiv.dialog({
					autoOpen: false,
					title: $link.attr('title'),
					width: 700,
					height: 700,
					beforeClose: function(event, ui) { if ((unsavedFile == true) || (fileDoneUploading == false)) { if (confirm('האם ברצונך לסגור ללא שמירת הקובץ?')) { return true; } else { return false; }}}, 
					close: function(event, ui) { window.location.reload( true ); }
				}  
		); 
	}).click(function() {  
		var $divObject = $(this).data('divObject');
		$.get($(this).attr('href'),  function(data){ $divObject.html(data); });
	    $divObject.dialog('open');
	      return false;  
	  });

	
		$('.editBtn').each(function() {
			var $link = $(this);
			var $dialog = $('<div></div>');
			$dialog.append($loading.clone());
			$dialog.dialog({
					autoOpen: false,
					title: $link.attr('title'),
					width: 700,
					height: 700,
					beforeClose: function(event, ui) { if ((unsavedFile == true) || (fileDoneUploading == false)) { if (confirm('האם ברצונך לסגור ללא שמירת הקובץ?')) { return true; } else { return false; }}},
					close: function(event, ui) { window.location.reload( true ); }
				});
			$link.click(function() {
				$dialog.load($link.attr('href'));
				$dialog.dialog('open');
				return false;
			});
		});
	
	
	
	$('.showDocumentsDialog').dialog({
		autoOpen: false,
		title: 'show documents',
		width: 500,
		height: 300
		});
	$('.showDocuments').click(function(){
		// $('.showDocumentsDialog').load('/showAllDocuments.php?caseId=1 ');
		$.get('/showAllDocuments.php?caseId=1',  function(data){ $('.showDocumentsDialog').html(data); });
		$('.showDocumentsDialog').dialog('open');
		});
	
});
</script>
<table id="omer" class="eventsTable">
					
<?php 

if ($AllEvents == "false")
{
	$events_where = "(2,3,4,5,6,7,8,9,10,11,13,14,15,16)";
}
else
{
	$events_where = "(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16)";
}


$eventsQuery = "SELECT t1.id, t1.type, t1.file_name, t1.file_desc, t1.method,  DATE_FORMAT(date(t1.timestamp),'%d/%m/%Y'), document_id, remarks, parm1, parm2, parm3, DATE_FORMAT(date(t1.parm4),'%d/%m/%Y'), parm5, parm6, parm7, parm8
					FROM tbevents as t1
					WHERE t1.type in ".$events_where." and
						  t1.case_id = ".$idNumber." and
						  t1.client_id = ".$clientId." 
					ORDER BY t1.timestamp desc";
$eventsResult = mysqli_query($db_server,$eventsQuery);
if (!$eventsResult) die("Database access failed: " . mysqli_error());
elseif (mysqli_num_rows($eventsResult))
{
	echo "<script> var numberOfEvents = ".mysqli_num_rows($eventsResult)."; </script>";
	for ($i=0;$i<mysqli_num_rows($eventsResult);$i++)
	{
		$eventsRow = mysqli_fetch_row($eventsResult);
		echo "<tr><td>";
		echo "<table>";
			echo "<tr>";
				echo "<td width=\"400px\" ><h3>".$eventTypes[$eventsRow[1]]."</h3></td>";
				echo "<td>".$eventsRow[5]."</td>";
				// dudy 29/3/2016
				//echo "<td><p><u>באמצעות:</u> ".$methodText[$eventsRow[4]]."</p></td>";
				if ( empty($methodText[$eventsRow[4]]) ) {
					echo "<td><p><u>באמצעות:</u></p></td>";
				} else {
					echo "<td><p><u>באמצעות:</u> ".$methodText[$eventsRow[4]]."</p></td>";
				}
				echo "<td width=\"30px\"><a title=\"ערוך\" class=\"editBtn\" href=\"editEvent.php?eventId=".$eventsRow[0]."\">ערוך</a></td>";
			echo "</tr>";
			//attached file
			echo "<tr>";
				if ($eventsRow[2] != NULL)
				{
					$fileType =  substr($eventsRow[2],strripos($eventsRow[2],".")+1);
					if ($eventsRow[3] == "") { $eventsRow[3] = "קובץ ללא תיאור"; }
					echo "<td colspan=\"2\"><u>קובץ מצורף:</u>  <a href=\"/file.php?f=".$eventsRow[2]."\" target=\"_blank\"><img src=\"/images/icon_".$fileType.".png\" width=\"20px\" />".$eventsRow[3]."</a> </td>";
				}
				if ($eventsRow[6] != NULL)
				{
					echo "<td colspan=\"2\"><u>מכתב מצורף:</u> <a href=\"showDocument.php?id=".$eventsRow[6]."\" target=\"_blank\"><img src=\"/images/mail_icon.gif\" width=\"20px\" title=\"הצג\" /></a> <a href=\"editDocument.php?id=".$eventsRow[6]."\" ><img src=\"/images/pencil_icon.png\" width=\"18px\" title=\"ערוך\" /></a>&nbsp;";
					if($row[28] !="") { echo "<span> <a onclick=\"sendDocumentByMail(".$eventsRow[6].",'".$row[28]."')\"><img src=\"/images/send_mail_icon.gif\" height=\"20px\" title=\"שלח במייל\" /></a><span id=\"mailDocSpinner".$eventsRow[6]."\"></span></span>"; }
					echo "</td>";
				}
				
			echo "</tr>";
			//boolean parms
			echo "<tr>";
				if (array_key_exists(1, $eventsParms[$eventsRow[1]]))
				{
					echo "<td><u>".$eventsParms[$eventsRow[1]][1].":</u> ".$eventsOptions[$eventsRow[1]][1][$eventsRow[8]]."</td>";
				}
				if (array_key_exists(2, $eventsParms[$eventsRow[1]]))
				{
					echo "<td><u>".$eventsParms[$eventsRow[1]][2].":</u> ".$eventsOptions[$eventsRow[1]][2][$eventsRow[9]]."</td>";
				}
				if (array_key_exists(3, $eventsParms[$eventsRow[1]]))
				{
					echo "<td><u>".$eventsParms[$eventsRow[1]][3].":</u> ".$eventsOptions[$eventsRow[1]][3][$eventsRow[10]]."</td>";
				}
			echo "</tr>";
			//timestamp parm and varchar(100) parm
			echo "<tr>";
				if (array_key_exists(4, $eventsParms[$eventsRow[1]]))
				{
					echo "<td><u>".$eventsParms[$eventsRow[1]][4].":</u> ".$eventsRow[11]."</td>";
				}
				if (array_key_exists(5, $eventsParms[$eventsRow[1]]))
				{
					echo "<td colspan=\"2\"><u>".$eventsParms[$eventsRow[1]][5].":</u> ".$eventsRow[12]."</td>";
				}
			echo "</tr>";
			// parm 6 - varchar(1000)
			echo "<tr>";
				if (array_key_exists(6, $eventsParms[$eventsRow[1]]))
				{
					echo "<td colspan=\"3\"><u>".$eventsParms[$eventsRow[1]][6].":</u> <p class=\"expandable\">".nl2br(strip_tags($eventsRow[13]))."</p></td>";
				}
			echo "</tr>";
			// parm 7 - varchar(1000)
			echo "<tr>";
				if (array_key_exists(7, $eventsParms[$eventsRow[1]]))
				{
					echo "<td colspan=\"3\"><u>".$eventsParms[$eventsRow[1]][7].":</u> <p class=\"expandable\">".nl2br(strip_tags($eventsRow[14]))."</p></td>";
				}
			echo "</tr>";
			// parm 8 - varchar(1000)
			echo "<tr>";
				if (array_key_exists(8, $eventsParms[$eventsRow[1]]))
				{
					echo "<td colspan=\"3\"><u>".$eventsParms[$eventsRow[1]][8].":</u> <p class=\"expandable\">".nl2br(strip_tags($eventsRow[15]))."</p></td>";
				}
			echo "</tr>";
			echo "<tr>";
				if ($eventsRow[7] != NULL)
				{
					echo "<td><p><u>הערות:</u></p>".nl2br($eventsRow[7])."</td>";
				}
			echo "</tr>";
		echo "</table>";
		
		echo "</td></tr>";
	}
}
echo "<script>";
echo " $(\".editBtn, .editCase\").button({ icons: { primary: \"ui-icon-pencil\" },text:true});";
echo "</script>";
?>
</table>

<table class="case-table2">
	<tr><td>
	<?php
	if ($AllEvents == "false") 
	{
		echo "<a href=\"/showCase.php?id=".$idNumber."&showAllEvents=true\">הצג את כל האירועים</a>";
	}
	else
	{
		echo "<a href=\"/showCase.php?id=".$idNumber."\">הצג חלק מהאירועים</a>";
	}	
	?>
	</td></tr>
</table>


</div>
<script>
$('.expandable').expandCollapse({ startHidden : true,expandText: "+ הצג",collapseText: "- החבא" }); 
</script>
<?php 
pageEnd();

