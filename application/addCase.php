<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

pageStart("מערכת קליניקה - יצירת תיק");
?>
<script>
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
<center><h1>יצירת תיק חדש</h1></center>
<br />
<div id="CaseContent">
<form name="addCaseFrm" method="post" action="addCaseAction.php" onsubmit="return addCaseFormValidator()">
<table class="case-table">
	<tr><td>
		<table class="case-table">
			<tr>
				<td>שם פציינט: <input name="patientName" id="patientName" type="text" maxlength="35" />&nbsp&nbsp&nbsp<span id="patientNameError" class="errorMsg"></span></td>
				<td>ת"ז: <input name="patientId" id="patientId" type="text" maxlength="10" />&nbsp&nbsp&nbsp<span id="patientIdError" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td>תאריך לידה: <input name="patientBirthDate" id="patientBirthDate" type="text" maxlength="20" /> (YYYY-MM-DD)&nbsp&nbsp&nbsp<span id="patientBirthDateError" class="errorMsg"></span></td>
				<td>מין: זכר <input type="radio" name="patientSex" value="M" checked />
					נקבה <input type="radio" name="patientSex" value="F" /></td>
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
					if ($i==1) {echo "selected";}
					echo " value=\"".$i."\">".$caseTypeValue."</option>";
				}
				?>
				</select></td>
				<td>תאריך מינוי: <input name="appointmentDate" id="appointmentDate" type="text" />&nbsp&nbsp&nbsp<span id="appointmentDateError" class="errorMsg"></span></td>
			</tr>
			<tr id="judgeTR">
				<td>שם השופט: <input name="judgeName" type="text" maxlength="20" /></td>
				<td>מין: זכר <input type="radio" name="judgeSex" value="M" checked />
					נקבה <input type="radio" name="judgeSex" value="F" /></td>
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
							if ($i==0) {echo "selected";}
							echo " value=\"".$courtRow[0]."\">".$courtType[$courtRow[0]]."</option>";
						}
					}
				?>
				</select> ב <select name="courtLocationSelect" size="1"></select>
				&nbsp<a onClick="TINY.box.show({url:'addCourt.php',width:400,height:270})">הוסף בית משפט</a>
				</td>
				<script>refreshCourtLocations();</script>
				<td>ת.א: <input name="court_num" type="text" maxlength="20" /></td>
			</tr>
			<tr>
				<td>תשלום: <input name="payment" id="payment" type="text" maxlength="6" /> כולל מע"מ <input type="radio" name="tax" value="1"  />
					ללא מע"מ <input type="radio" name="tax" value="0" checked /><span id="paymentError" class="errorMsg"></span></td>
				<td>חלוקת תשלום:  תובע %<input name="prosecutorPayment" id="prosecutorPayment" type="text" size="3" maxlength="3" /> נתבע %<input name="defencePayment" id="defencePayment" type="text" size="3" maxlength="3" /> נתבע 2 %<input name="defence2Payment" id="defence2Payment" type="text" size="3" maxlength="3" />
				<span id="paymentDivisionError" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td>תאריך למסירת חוו"ד: <input name="deadline" id="deadline" type="text" />&nbsp&nbsp&nbsp<span id="deadlineError" class="errorMsg"></span></td>
				<td>תאריך למסירת החומר הרפואי: <input name="courtDate" id="courtDate" type="text" />&nbsp&nbsp&nbsp<span id="courtDateError" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td><u>עו"ד תובע:</u> שם:<input name="prosecutorName" type="text" maxlength="35" /><br />
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמשרד: <input name="prosecutorFirmName" id="prosecutorFirmName" type="text" maxlength="50" />
					<input type="hidden" id="prosecutorFirmId" name="prosecutorFirmId"/>
				<a onClick="TINY.box.show({url:'newLawyerFirm.php',width:400,height:270,closejs:function(){ $('#prosecutorFirmName').val(document.AddLawyerForm.name.value); $('#prosecutorFirmId').val(document.AddLawyerForm.id.value); }})">הוסף משרד</a>
				&nbsp&nbsp&nbsp<span id="prosecutorFirmError" class="errorMsg"></span>
				<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמספרם: <input name="prosecutorNumber" type="text" maxlength="12" />
				</td>
			</tr>
			<tr>
				<td><u>עו"ד נתבע:</u> שם:<input name="defenceName" type="text" maxlength="35" /><br />
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמשרד: <input name="defenceFirmName" id="defenceFirmName" type="text" maxlength="50" />
					<input type="hidden" id="defenceFirmId" name="defenceFirmId"/>
				<a onClick="TINY.box.show({url:'newLawyerFirm.php',width:400,height:270,closejs:function(){ $('#defenceFirmName').val(document.AddLawyerForm.name.value); $('#defenceFirmId').val(document.AddLawyerForm.id.value); }})">הוסף משרד</a>
				&nbsp&nbsp&nbsp<span id="defenceFirmError" class="errorMsg"></span>
				<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמספרם: <input name="defenceNumber" type="text" maxlength="12" />
				</td>
				<td><u>חברה נתבעת:</u> <input name="companyName" id="companyName" type="text" maxlength="50" /><input type="hidden" id="companyId" name="companyId"/>
					<a onClick="TINY.box.show({url:'newCompany.php',width:400,height:270,closejs:function(){ $('#companyName').val(document.AddCompanyForm.name.value); $('#companyId').val(document.AddCompanyForm.id.value); }})">הוסף חברה</a>
					&nbsp&nbsp&nbsp<span id="companyError" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td><u>עו"ד נתבע 2:</u> שם:<input name="defenceName2" type="text" maxlength="35" /><br />
					&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמשרד: <input name="defenceFirmName2" id="defenceFirmName2" type="text" maxlength="50" />
					<input type="hidden" id="defenceFirmId2" name="defenceFirmId2"/>
				<a onClick="TINY.box.show({url:'newLawyerFirm.php',width:400,height:270,closejs:function(){ $('#defenceFirmName2').val(document.AddLawyerForm.name.value); $('#defenceFirmId2').val(document.AddLawyerForm.id.value); }})">הוסף משרד</a>
				&nbsp&nbsp&nbsp<span id="defenceFirm2Error" class="errorMsg"></span>
				<br />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspמספרם: <input name="defenceNumber2" type="text" maxlength="12" />
				</td>
				<td><u>חברה נתבעת 2:</u> <input name="company2Name" id="company2Name" type="text" maxlength="50" /><input type="hidden" id="company2Id" name="company2Id"/>
					<a onClick="TINY.box.show({url:'newCompany.php',width:400,height:270,closejs:function(){ $('#company2Name').val(document.AddCompanyForm.name.value); $('#company2Id').val(document.AddCompanyForm.id.value); }})">הוסף חברה</a>
					&nbsp&nbsp&nbsp<span id="company2Error" class="errorMsg"></span></td>
			</tr>
			<tr>
				<td colspan="2">דרישות נוספות: <textarea name="extraDemands" cols="36" rows="1"></textarea></td>
			</tr>
		</table>
	</td></tr>
	<tr><td>
		<table class="case-table">
			<tr>
				<td>הערות: <textarea name="remarks" cols="40" rows="2"></textarea></td>
			</tr>
		</table>
	</td></tr>
	<tr>
		<td colspan="2" align="left"><input type="submit" value="צור" /></td>
	</tr>
</table>
</form>
</div>
<?php 
pageEnd();