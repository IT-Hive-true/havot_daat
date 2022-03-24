<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

// got changes from form to save
if (isset($_POST['caseId']))
{
	saveChanges($db_server);
	header("Location: showCase.php?id=".sanitizeInput($_POST['caseId']));
	exit;
}

// show form

//is there a case to edit?
if (isset($_GET['caseId']))
{
	$caseId = sanitizeInput($_GET['caseId']);
}
else
{
	header("Location: index.php");
	exit;
}


//query 1
//                0       1                2              3                              4                       5                6       7             8          9                   10                             11            12            13            14                       15                    16              17           18                       19                20                   21                  22                 23          24                      25         
$query = "SELECT t1.ID, t1.patient_seen, t1.court_num, date(t1.appointment_date), date(t1.creation_date), t1.appointment_type, t6.type, t6.id, t1.patient_id, t1.patient_name, date(t1.patient_birthdate), t1.patient_sex, t1.judge_name, t1.judge_sex, t1.defence_lawyer_name, t1.prosecutor_name, t1.payment_amount, t1.with_tax, t1.prosecutor_payment, t1.defence_payment, t1.extra_demands,date(t1.case_deadline) , date(t1.court_date), t1.payed, t1.all_material_recieved, t1.remarks,
			t2.id, t2.name, t3.id, t3.name, t4.id, t4.name, t5.name, t1.defence_lawyer_name_2, t7.id, t7.name, t1.defence_2_payment,t1.prosecutor_number,t1.defence_lawyer_number,t1.defence_lawyer_2_number,t1.client_id, t8.name, t8.id
			FROM tbcases as t1, tblawyers as t2, tblawyers as t3, tbcompanies as t4, tbstatus as t5, tbcourts as t6, tblawyers as t7, tbcompanies as t8
			where (t1.prosecutor_firm_id = t2.id) and 
					(t1.defence_lawyer_firm_id = t3.id) and
					(t1.defence_lawyer_firm_id_2 = t7.id) and
					(t1.defence_company_id = t4.id) and
					(t1.defence_company_2_id = t8.id) and
					(t1.status = t5.id) and
					(t1.court_id = t6.id) and
				  	t1.id = ".$caseId; 
			
$result = mysqli_query($db_server,$query);
if (!$result) die("Database access failed on query 1: " . mysqli_error());
elseif (mysqli_num_rows($result))
{
	$row = mysqli_fetch_row($result);
	
	// check if this case belongs to this client
	if ($row[40] != $clientId)
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
pageStart("מערכת קליניקה - עריכת התיק של ".$row[9]);
?>
<script>
	$(document).ready(function() {
		changeAppointmentType();
	}); 
	$(function() {
		var dates = $( "#deadline, #courtDate, #appointmentDate" ).datepicker({
			defaultDate: "-1m",
			dateFormat:"yy-mm-dd",
			changeMonth: true,
			numberOfMonths: 3,
			onSelect: function( selectedDate ) {
				var option = this.id == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});								
	});
	
</script>
<script>
	$(function() {
		var availableLawyerFirms = [	             		
		    <?php 
		    	// Insert lawyer firms into array used by auto-complete
		    	$lawyerQuery = "SELECT t1.id, t1.name 
								FROM tblawyers as t1 
								WHERE (t1.client_id = ".$clientId.") 
								ORDER BY t1.name asc";
				$lawyerResult = mysqli_query($db_server,$lawyerQuery);
				if (!$lawyerResult) die("Database access failed: " . mysqli_error());
				elseif (mysqli_num_rows($lawyerResult))
				{
					for ($i=0;$i<mysqli_num_rows($lawyerResult);$i++)
					{
						$lawyerRow = mysqli_fetch_row($lawyerResult);
						$lawyerName = str_replace("\n", " ", $lawyerRow[1]);
						$lawyerName = str_replace("\r", " ", $lawyerName);
						$lawyerName = addslashes($lawyerName);
						
						echo "{ value:\"".$lawyerRow[0]."\", label:\"".$lawyerName."\"}";
						
						
						// check if need to print "," (print for all rows except last one)
						if ($i < (mysqli_num_rows($lawyerResult) - 1))
						{
							echo ",
							 ";
						}
					}
				} 
		    ?>
		];

		var availableCompanies = [
				             		
                    <?php 
                    	// Insert companies into array used by auto-complete
                    	$companyQuery = "SELECT t1.id, t1.name 
                						FROM tbcompanies as t1 
                						WHERE (t1.client_id = ".$clientId.") 
                						ORDER BY t1.name asc";
                		$companyResult = mysqli_query($db_server,$companyQuery);
                		if (!$companyResult) die("Database access failed: " . mysqli_error());
                		elseif (mysqli_num_rows($companyResult))
                		{
                			for ($i=0;$i<mysqli_num_rows($companyResult);$i++)
                			{
                				$companyRow = mysqli_fetch_row($companyResult);
                				$companyName = str_replace("\n", " ", $companyRow[1]);
                				$companyName = str_replace("\r", " ", $companyName);
                				$companyName = addslashes($companyName);
                				
                				echo "{ value:\"".$companyRow[0]."\", label:\"".$companyName."\"}";
                				
                				
                				// check if need to print "," (print for all rows except last one)
                				if ($i < (mysqli_num_rows($companyResult) - 1))
                				{
                					echo ",
                					 ";
                				}
                			}
                		} 
                    ?>
                ];
		$( "#prosecutorFirmName" ).autocomplete({ 
			source: availableLawyerFirms,
			select: function( event, ui ) {
						$( "#prosecutorFirmName" ).val( ui.item.label );
						$( "#prosecutorFirmId" ).val( ui.item.value );
						return false;
					}
		});
		$( "#defenceFirmName" ).autocomplete({ 
			source: availableLawyerFirms,
			select: function( event, ui ) {
						$( "#defenceFirmName" ).val( ui.item.label );
						$( "#defenceFirmId" ).val( ui.item.value );
						return false;
					}
		});
		$( "#defenceFirmName2" ).autocomplete({ 
			source: availableLawyerFirms,
			select: function( event, ui ) {
						$( "#defenceFirmName2" ).val( ui.item.label );
						$( "#defenceFirmId2" ).val( ui.item.value );
						return false;
					}
		});
		$( "#companyName" ).autocomplete({ 
			source: availableCompanies,
			select: function( event, ui ) {
						$( "#companyName" ).val( ui.item.label );
						$( "#companyId" ).val( ui.item.value );
						return false;
					}
		});
		$( "#company2Name" ).autocomplete({ 
			source: availableCompanies,
			select: function( event, ui ) {
						$( "#company2Name" ).val( ui.item.label );
						$( "#company2Id" ).val( ui.item.value );
						return false;
					}
		});
	});
	function addCaseFormValidator()
	{
		var regDec = /^\d+$|^\d+\.\d{1,2}$/;
		var regDate = /^\d{4}-(0[0-9]|1[0,1,2])-([0,1,2][0-9]|3[0,1])$/;
		var valid;
		valid = true;
		
		if ($('#patientName').val().length == 0)
		{
			$("#patientNameError").text("חובה להוסיף שם פציינט");
			valid=false;
		}
		else { $("#patientNameError").text(""); }
		
		if ((regDec.test($("#patientId").val()) == false) && ($("#patientId").val() != ""))
		{
			$("#patientIdError").text("יש להשתמש רק בספרות");
			valid=false;
		}
		else { $("#patientIdError").text(""); }
		
		if ((regDate.test($("#patientBirthDate").val()) == false) && ($("#patientBirthDate").val() != ""))
		{
			$("#patientBirthDateError").text("תאריך לא תקין");
			valid=false;
		}
		else { $("#patientBirthDateError").text(""); }
		
		if ((regDate.test($("#appointmentDate").val()) == false) && ($("#appointmentDate").val() != ""))
		{
			$("#appointmentDateError").text("תאריך לא תקין");
			valid=false;
		}
		else { $("#appointmentDateError").text("");	}
		
		if ((regDate.test($("#deadline").val()) == false) && ($("#deadline").val() != ""))
		{
			$("#deadlineError").text("תאריך לא תקין");
			valid=false;
		}
		else { $("#deadlineError").text(""); }
		
		if ((regDate.test($("#courtDate").val()) == false) && ($("#courtDate").val() != ""))
		{
			$("#courtDateError").text("תאריך לא תקין");
			valid=false;
		}
		else { $("#courtDateError").text(""); }
		
		if ((regDec.test($("#payment").val()) == false) && ($("#payment").val() != ""))
		{
			$("#paymentError").text("יש להשתמש רק בספרות");
			valid=false;
		}
		else { $("#paymentError").text(""); }
			
		if (((regDec.test($("#prosecutorPayment").val()) == false) && ($("#prosecutorPayment").val() != "")) ||
			((regDec.test($("#defencePayment").val()) == false) && ($("#defencePayment").val() != "")) ||
			((regDec.test($("#defence2Payment").val()) == false) && ($("#defence2Payment").val() != "")))
		{
			$("#paymentDivisionError").text("יש להשתמש רק בספרות");
			valid=false;
		}
		else { $("#paymentDivisionError").text("");	}
		
		if ((parseInt($("#prosecutorPayment").val(),10) + parseInt($("#defencePayment").val(),10) + parseInt($("#defence2Payment").val(),10)) > 100)
		{
			$("#paymentDivisionError").text("המקסימום הוא 100%");
			valid=false;
		}
		else { $("#paymentDivisionError").text("");	}

		if (($("#prosecutorFirmName").val().length != 0) && ($("#prosecutorFirmId").val().length == 0))
		{
			$("#prosecutorFirmError").text("יש לבחור מהרשימה");
			valid=false;
		}
		else { $("#prosecutorFirmError").text("");	}

		if (($("#defenceFirmName").val().length != 0) && ($("#defenceFirmId").val().length == 0))
		{
			$("#defenceFirmError").text("יש לבחור מהרשימה");
			valid=false;
		}
		else { $("#defenceFirmError").text("");	}

		if (($("#defenceFirmName2").val().length != 0) && ($("#defenceFirmId2").val().length == 0))
		{
			$("#defenceFirm2Error").text("יש לבחור מהרשימה");
			valid=false;
		}
		else { $("#defenceFirm2Error").text(""); }

		if (($("#companyName").val().length != 0) && ($("#companyId").val().length == 0))
		{
			$("#companyError").text("יש לבחור מהרשימה");
			valid=false;
		}
		else { $("#companyError").text(""); }

		if (($("#company2Name").val().length != 0) && ($("#company2Id").val().length == 0))
		{
			$("#company2Error").text("יש לבחור מהרשימה");
			valid=false;
		}
		else { $("#company2Error").text(""); }
		
		return valid;
	}
</script>
<center><h1>עריכת התיק של <?php echo $row[9];?></h1></center>
<br />
<div id="CaseContent">
<form name="addCaseFrm" method="post" action="editCase.php" onsubmit="return addCaseFormValidator()">
<input type="hidden" id="caseId" name="caseId" value="<?=$caseId?>" />
<table class="case-table">
	<tr><td>
		<table class="case-table">
			<tr>
				<td>שם פציינט: <input name="patientName" id="patientName" type="text" maxlength="35" value="<?=htmlspecialchars($row[9])?>"/>&nbsp&nbsp&nbsp<span id="patientNameError" class="errorMsg"></span></td>
				<td>ת"ז: <input name="patientId" id="patientId" type="text" maxlength="10" value="<?=$row[8]?>" />&nbsp&nbsp&nbsp<span id="patientIdError" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td>תאריך לידה: <input name="patientBirthDate" id="patientBirthDate" type="text" maxlength="20" value="<?=$row[10]?>" /> (YYYY-MM-DD)&nbsp&nbsp&nbsp<span id="patientBirthDateError" class="errorMsg"></span></td>
				<td>מין: זכר <input type="radio" name="patientSex" value="M" <?php if ($row[11] == "M") echo "checked";?> />
					נקבה <input type="radio" name="patientSex" value="F" <?php if ($row[11] == "F") echo "checked";?> /></td>
			</tr>
		</table>
	</td></tr>
	<tr><td>
		<table class="case-table">
			<tr>
				<td>סוג מינוי: <select name="appointmentTypeSelect" id="appointmentTypeSelect" size="1" onChange="changeAppointmentType()">
				<?php 
				foreach ($caseType as $i => $caseTypeValue) {
					echo "<option ";
					if ($i==$row[5]) {echo "selected";}
					echo " value=\"".$i."\">".$caseTypeValue."</option>";
				}
				?>
				</select>
				</td>
				<td>תאריך מינוי: <input name="appointmentDate" id="appointmentDate" type="text" value="<?=$row[3]?>" />&nbsp&nbsp&nbsp<span id="appointmentDateError" class="errorMsg"></span></td>
			</tr>
			<tr id="judgeTR">
				<td>שם השופט: <input name="judgeName" type="text" maxlength="20" value="<?=htmlspecialchars($row[12])?>" /></td>
				<td>מין: זכר <input type="radio" name="judgeSex" value="M" <?php if ($row[13] == "M") echo "checked";?> />
					נקבה <input type="radio" name="judgeSex" value="F" <?php if ($row[13] == "F") echo "checked";?> /></td>
			</tr>
			<tr  id="courtTR">
				<td>בית המשפט: <select name="courtTypeSelect" size="1" onChange="refreshCourtLocations()">
				<?php
					$courtQuery = "SELECT distinct t1.type 
										FROM tbcourts as t1
										WHERE (t1.client_id = ".$clientId.") 
										ORDER BY t1.ID asc";
					$courtResult = mysqli_query($db_server,$courtQuery);
					if (!$courtResult) die("Database access failed: " . mysqli_error());
					elseif (mysqli_num_rows($courtResult))
					{
						for ($i=0;$i<mysqli_num_rows($courtResult);$i++)
						{
							$courtRow = mysqli_fetch_row($courtResult);
							echo "<option ";
							if ($courtRow[0]==$row[6]) {echo "selected";}
							echo " value=\"".$courtRow[0]."\">".$courtType[$courtRow[0]]."</option>";
						}
					}
				?>
				</select> ב <select name="courtLocationSelect" size="1">
				<?php
					$courtQuery = "SELECT distinct t1.id,t1.location 
										FROM tbcourts as t1
										where (t1.type = ".$row[6].") and
										      (t1.client_id = ".$clientId.")  
										ORDER BY t1.ID asc";
					$courtResult = mysqli_query($db_server,$courtQuery);
					if (!$courtResult) die("Database access failed: " . mysqli_error());
					elseif (mysqli_num_rows($courtResult))
					{
						for ($i=0;$i<mysqli_num_rows($courtResult);$i++)
						{
							$courtRow = mysqli_fetch_row($courtResult);
							echo "<option ";
							if ($courtRow[0]==$row[7]) {echo "selected";}
							echo " value=\"".$courtRow[0]."\">".$courtRow[1]."</option>";
						}
					}
				?>
				</select>
				&nbsp<a onClick="TINY.box.show({url:'addCourt.php',width:400,height:270})">הוסף בית משפט</a>
				</td>
				
				<td>ת.א: <input name="court_num" type="text" maxlength="20" value="<?=$row[2]?>" /></td>
			</tr>
			<tr>
				<td>תשלום: <input name="payment" id="payment" type="text" maxlength="6" value="<?=$row[16]?>" /> כולל מע"מ <input type="radio" name="tax" value="1" <?php if ($row[13] == 1) echo "checked";?> />
					ללא מע"מ <input type="radio" name="tax" value="0" <?php if ($row[13] != 1) echo "checked";?> /><span id="paymentError" class="errorMsg"></span></td>
				<td>חלוקת תשלום:  תובע %<input name="prosecutorPayment" id="prosecutorPayment" type="text" size="3" maxlength="3" value="<?=$row[18]?>" /> נתבע %<input name="defencePayment" id="defencePayment" type="text" size="3" maxlength="3" value="<?=$row[19]?>" /> נתבע 2 %<input name="defence2Payment" id="defence2Payment" type="text" size="3" maxlength="3" value="<?=$row[36]?>" />
				<span id="paymentDivisionError" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td>תאריך למסירת חוו"ד: <input name="deadline" id="deadline" type="text" value="<?=$row[21]?>" />&nbsp&nbsp&nbsp<span id="deadlineError" class="errorMsg"></span></td>
				<td>תאריך למסירת החומר הרפואי: <input name="courtDate" id="courtDate" type="text" value="<?=$row[22]?>" />&nbsp&nbsp&nbsp<span id="courtDateError" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td><u>עו"ד תובע:</u> שם:<input name="prosecutorName" type="text" maxlength="35" value="<?=htmlspecialchars($row[15])?>" /><br />
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמשרד: <input name="prosecutorFirmName" id="prosecutorFirmName" type="text" maxlength="50" value="<?=htmlspecialchars($row[27])?>" />
					<input type="hidden" id="prosecutorFirmId" name="prosecutorFirmId" value="<?=$row[26]?>" />
				<a onClick="TINY.box.show({url:'newLawyerFirm.php',width:400,height:270,closejs:function(){ $('#prosecutorFirmName').val(document.AddLawyerForm.name.value); $('#prosecutorFirmId').val(document.AddLawyerForm.id.value); }})">הוסף משרד</a>
				&nbsp&nbsp&nbsp<span id="prosecutorFirmError" class="errorMsg"></span>
				<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמספרם: <input name="prosecutorNumber" type="text" maxlength="12" value="<?=htmlspecialchars($row[37])?>" />
				</td>
			</tr>
			<tr>
				<td><u>עו"ד נתבע:</u> שם:<input name="defenceName" type="text" maxlength="35" value="<?=htmlspecialchars($row[14])?>" /><br />
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמשרד: <input name="defenceFirmName" id="defenceFirmName" type="text" maxlength="50" value="<?=htmlspecialchars($row[29])?>" />
					<input type="hidden" id="defenceFirmId" name="defenceFirmId" value="<?=$row[28]?>" />
				<a onClick="TINY.box.show({url:'newLawyerFirm.php',width:400,height:270,closejs:function(){ $('#defenceFirmName').val(document.AddLawyerForm.name.value); $('#defenceFirmId').val(document.AddLawyerForm.id.value); }})">הוסף משרד</a>
				&nbsp&nbsp&nbsp<span id="defenceFirmError" class="errorMsg"></span>
				<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמספרם: <input name="defenceNumber" type="text" maxlength="12" value="<?=htmlspecialchars($row[38])?>" />
				</td>
				<td><u>חברה נתבעת: </u><input name="companyName" id="companyName" type="text" maxlength="50" value="<?=htmlspecialchars($row[31])?>" /><input type="hidden" id="companyId" name="companyId" value="<?=$row[30]?>" />
					<a onClick="TINY.box.show({url:'newCompany.php',width:400,height:270,closejs:function(){ $('#companyName').val(document.AddCompanyForm.name.value); $('#companyId').val(document.AddCompanyForm.id.value); }})">הוסף חברה</a>
					&nbsp&nbsp&nbsp<span id="companyError" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td><u>עו"ד נתבע 2:</u> שם:<input name="defenceName2" type="text" maxlength="35" value="<?=htmlspecialchars($row[33])?>" /><br />
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמשרד: <input name="defenceFirmName2" id="defenceFirmName2" type="text" maxlength="50" value="<?=htmlspecialchars($row[35])?>" />
					<input type="hidden" id="defenceFirmId2" name="defenceFirmId2" value="<?=$row[34]?>" />
				<a onClick="TINY.box.show({url:'newLawyerFirm.php',width:400,height:270,closejs:function(){ $('#defenceFirmName2').val(document.AddLawyerForm.name.value); $('#defenceFirmId2').val(document.AddLawyerForm.id.value); }})">הוסף משרד</a>
				&nbsp&nbsp&nbsp<span id="defenceFirm2Error" class="errorMsg"></span>
				<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמספרם: <input name="defenceNumber2" type="text" maxlength="12" value="<?=htmlspecialchars($row[39])?>" />
				</td>
				<td><u>חברה נתבעת 2: </u><input name="company2Name" id="company2Name" type="text" maxlength="50" value="<?=htmlspecialchars($row[41])?>" /><input type="hidden" id="company2Id" name="company2Id" value="<?=$row[42]?>" />
					<a onClick="TINY.box.show({url:'newCompany.php',width:400,height:270,closejs:function(){ $('#company2Name').val(document.AddCompanyForm.name.value); $('#company2Id').val(document.AddCompanyForm.id.value); }})">הוסף חברה</a>
					&nbsp&nbsp&nbsp<span id="company2Error" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td colspan="2">דרישות נוספות: <textarea name="extraDemands" cols="36" rows="1"><?=htmlspecialchars($row[20])?></textarea></td>
			</tr>
		</table>
	</td></tr>
	<tr><td>
		<table class="case-table">
			<tr>
				<td>הערות: <textarea name="remarks" cols="40" rows="2"><?=htmlspecialchars($row[25])?></textarea></td>
			</tr>
		</table>
	</td></tr>
	<tr>
		<td colspan="2" align="left"><input type="submit" value="שמור" /></td>
	</tr>
</table>
</form>
</div>
<?php 
pageEnd();

function saveChanges($db_server)
{
	$caseId = sanitizeMySQL($_POST['caseId']);
	$patientName = sanitizeMySQL($_POST['patientName']);
	$patientId = sanitizeMySQL($_POST['patientId']);
	$patientBirthdate = sanitizeMySQL($_POST['patientBirthDate']);
	$patientSex = sanitizeMySQL($_POST['patientSex']);
	$appointmentType = sanitizeMySQL($_POST['appointmentTypeSelect']);
	$appointmentDate = sanitizeMySQL($_POST['appointmentDate']);
	$courtType = sanitizeMySQL($_POST['courtTypeSelect']);
	$judgeName = sanitizeMySQL($_POST['judgeName']);
	$judgeSex = sanitizeMySQL($_POST['judgeSex']);
	$courtId = sanitizeMySQL($_POST['courtLocationSelect']);
	$courtNum = sanitizeMySQL($_POST['court_num']);
	$payment = sanitizeMySQL($_POST['payment']);
	$tax = sanitizeMySQL($_POST['tax']);
	$prosecutorPayment = sanitizeMySQL($_POST['prosecutorPayment']);
	$defencePayment = sanitizeMySQL($_POST['defencePayment']);
	$defence2Payment = sanitizeMySQL($_POST['defence2Payment']);
	$deadline = sanitizeMySQL($_POST['deadline']);
	$courtDate = sanitizeMySQL($_POST['courtDate']);
	$prosecutorName = sanitizeMySQL($_POST['prosecutorName']);
	$prosecutorNumber = sanitizeMySQL($_POST['prosecutorNumber']);
	$prosecutorFirmId = sanitizeMySQL($_POST['prosecutorFirmId']);
	$defenceName = sanitizeMySQL($_POST['defenceName']);
	$defenceNumber = sanitizeMySQL($_POST['defenceNumber']);
	$defenceName2 = sanitizeMySQL($_POST['defenceName2']);
	$defenceNumber2 = sanitizeMySQL($_POST['defenceNumber2']);
	$defenceFirmId = sanitizeMySQL($_POST['defenceFirmId']);
	$defenceFirmId2 = sanitizeMySQL($_POST['defenceFirmId2']);
	$companyId= sanitizeMySQL($_POST['companyId']);
	$company2Id= sanitizeMySQL($_POST['company2Id']);
	$extraDemands = sanitizeMySQL($_POST['extraDemands']);
	$remarks = sanitizeMySQL($_POST['remarks']);
	
	
		
	
	
	// Insert the case
	$addCaseSQL = "UPDATE tbcases
					SET ";
	if ($courtNum != "") { $addCaseSQL .= "court_num='".$courtNum."', "; }
	if ($appointmentDate != "") { $addCaseSQL .= "appointment_date='".$appointmentDate."', "; }
	if ($appointmentType != "") { $addCaseSQL .= "appointment_type=".$appointmentType.", "; }
	if ($courtId != "") { $addCaseSQL .= "court_id=".$courtId.", "; }
	if ($patientId != "") { $addCaseSQL .= "patient_id='".$patientId."', "; }
	if ($patientName != "") { $addCaseSQL .= "patient_name='".$patientName."', "; }
	if ($patientBirthdate != "") { $addCaseSQL .= "patient_birthdate='".$patientBirthdate."', "; }
	if ($patientSex != "") { $addCaseSQL .= "patient_sex='".$patientSex."',  "; }
	if ($judgeName != "") { $addCaseSQL .= "judge_name='".$judgeName."', "; }
	if ($judgeSex != "") { $addCaseSQL .= "judge_sex='".$judgeSex."', "; }
	if ($defenceName != "") { $addCaseSQL .= "defence_lawyer_name='".$defenceName."', "; }
	if ($defenceNumber != "") { $addCaseSQL .= "defence_lawyer_number='".$defenceNumber."', "; }
	if ($defenceName2 != "") { $addCaseSQL .= "defence_lawyer_name_2='".$defenceName2."', "; }
	if ($defenceNumber2 != "") { $addCaseSQL .= "defence_lawyer_2_number='".$defenceNumber2."', "; }
	if ($prosecutorName != "") { $addCaseSQL .= "prosecutor_name='".$prosecutorName."', "; }
	if ($prosecutorNumber != "") { $addCaseSQL .= "prosecutor_number='".$prosecutorNumber."', "; }
	if ($payment != "") { $addCaseSQL .= "payment_amount=".$payment.", "; }
	if ($tax != "") { $addCaseSQL .= "with_tax=".$tax.",  "; }
	if ($prosecutorPayment != "") { $addCaseSQL .= "prosecutor_payment=".$prosecutorPayment.", "; } 
	if ($defencePayment != "") { $addCaseSQL .= "defence_payment=".$defencePayment.",  "; }
	if ($defence2Payment != "") { $addCaseSQL .= "defence_2_payment=".$defence2Payment.",  "; }
	if ($extraDemands != "") { $addCaseSQL .= "extra_demands='".$extraDemands."',  "; }
	

	if (sanitizeMySQL($_POST['prosecutorFirmName'])=="") {	$addCaseSQL .= "prosecutor_firm_id=0, "; }
	else { if ($prosecutorFirmId != "") { $addCaseSQL .= "prosecutor_firm_id=".$prosecutorFirmId.", "; }}
	
	if (sanitizeMySQL($_POST['defenceFirmName'])=="") {	$addCaseSQL .= "defence_lawyer_firm_id=0, "; }
	else {	if ($defenceFirmId != "") { $addCaseSQL .= "defence_lawyer_firm_id=".$defenceFirmId.", "; }}
	if (sanitizeMySQL($_POST['defenceFirmName2'])=="") { $addCaseSQL .= "defence_lawyer_firm_id_2=0, "; }
	else {	if ($defenceFirmId2 != "") { $addCaseSQL .= "defence_lawyer_firm_id_2=".$defenceFirmId2.", "; }}
	
	if (sanitizeMySQL($_POST['companyName'])=="") {	$addCaseSQL .= "defence_company_id=0, "; }
	else {	if ($companyId != "") { $addCaseSQL .= "defence_company_id=".$companyId.", "; }}
	if (sanitizeMySQL($_POST['company2Name'])=="") { $addCaseSQL .= "defence_company_2_id=0, "; }
	else {	if ($company2Id != "") { $addCaseSQL .= "defence_company_2_id=".$company2Id.", "; }}
	
	$addCaseSQL .= "remarks='".$remarks."' ";
	
	if ($deadline != "")
	{
		$addCaseSQL .= ",case_deadline='".$deadline."' ";
	}
	else
	{
		$addCaseSQL .= ",case_deadline=NULL";
	}
	if ($courtDate != "")
	{
		$addCaseSQL .= ",court_date='".$courtDate."'";
	}
	else
	{
		$addCaseSQL .= ",court_date=NULL";
	}
	$addCaseSQL .= " WHERE id=".$caseId;
	$addCaseResult = mysqli_query($db_server,$addCaseSQL);
	if (!$addCaseResult) die("Database access failed: " . mysqli_error()." SQL: ".$addCaseSQL);
	
	
}
?>