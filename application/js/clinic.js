

function testIsValidObject(objToTest)
{
	if (objToTest == null || objToTest == undefined)
	{
		return false;
	}
	return true;
}

function IsNumeric(input)
{
   return (input - 0) == input && input.length > 0;
}

function ajaxRequest()
{
	try // Non IE Browser?
	{
		var request = new XMLHttpRequest()
	}
	catch(e1)
	{
		try // IE 6+?
		{
			request = new ActiveXObject("Msxml2.XMLHTTP")
		}
		catch(e2)
		{
			try // IE 5?
			{
				request = new ActiveXObject("Microsoft.XMLHTTP")
			}
			catch(e3) // There is no Ajax Support
			{
				request = false
			}
		}
	}
	return request
}

function addLawyerFirmSend()
{
	params = "action=addLawyerFirm"+
			"&name="+document.AddLawyerForm.name.value+
			"&address="+document.AddLawyerForm.address.value+
			"&email="+document.AddLawyerForm.email.value+
			"&phone="+document.AddLawyerForm.phone.value+
			"&fax="+document.AddLawyerForm.fax.value
			
	
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	//dudy request.setRequestHeader("Content-length", params.length)
	//dudy request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				document.AddLawyerForm.id.value=this.responseText;
				TINY.box.hide();
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	request.send(params)  
}

function editLawyerFirmSend()
{
	params = "action=editLawyerFirm"+
			"&id="+document.AddLawyerForm.id.value+
			"&name="+document.AddLawyerForm.name.value+
			"&address="+document.AddLawyerForm.address.value+
			"&email="+document.AddLawyerForm.email.value+
			"&phone="+document.AddLawyerForm.phone.value+
			"&fax="+document.AddLawyerForm.fax.value
			
	
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	//dudy request.setRequestHeader("Content-length", params.length)
	//dudy request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				if (this.responseText != "")
				{
					alert(this.responseText);
				}
				TINY.box.hide();
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	request.send(params)  
}

function addCompanySend()
{
	params = "action=addCompany"+
			"&name="+document.AddCompanyForm.name.value+
			"&address="+document.AddCompanyForm.address.value+
			"&email="+document.AddCompanyForm.email.value+
			"&phone="+document.AddCompanyForm.phone.value+
			"&fax="+document.AddCompanyForm.fax.value
		
	
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	//dudy request.setRequestHeader("Content-length", params.length)
	//dudy request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				document.AddCompanyForm.id.value=this.responseText;
				TINY.box.hide();
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	
	request.send(params)  
}

function editCompanySend()
{
	params = "action=editCompany"+
			"&id="+document.editCompanyForm.id.value+
			"&name="+document.editCompanyForm.name.value+
			"&address="+document.editCompanyForm.address.value+
			"&email="+document.editCompanyForm.email.value+
			"&phone="+document.editCompanyForm.phone.value+
			"&fax="+document.editCompanyForm.fax.value
			
	
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	//dudy request.setRequestHeader("Content-length", params.length)
	//dudy request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				if (this.responseText != "")
				{
					alert(this.responseText);
				}
				TINY.box.hide();
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	request.send(params)  
}

function addCourtSend()
{
	params = "action=addCourt"+
			"&type="+document.AddCourtForm.courtTypeSelect.value+
			"&location="+document.AddCourtForm.location.value+
			"&address="+document.AddCourtForm.address.value+
			"&phone="+document.AddCourtForm.phone.value+
			"&fax="+document.AddCourtForm.fax.value
		
	
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	//dudy request.setRequestHeader("Content-length", params.length)
	//dudy request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				refreshCourtLocations();
				$("#courtLocationSelect").val(this.responseText);
				TINY.box.hide();
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	
	request.send(params)  
}

function editCourtSend()
{
	params = "action=editCourt"+
			"&id="+document.editCourtForm.id.value+
			"&type="+document.editCourtForm.courtTypeSelect.value+
			"&location="+document.editCourtForm.location.value+
			"&address="+document.editCourtForm.address.value+
			"&phone="+document.editCourtForm.phone.value+
			"&fax="+document.editCourtForm.fax.value
			
	
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	//dudy request.setRequestHeader("Content-length", params.length)
	//dudy request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				if (this.responseText != "")
				{
					alert(this.responseText);
				}
				TINY.box.hide();
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	request.send(params)  
}

function addSignatureSend()
{
	params = "action=addSignature"+
			"&desc="+document.AddSignatureForm.description.value+
			"&fileName="+document.AddSignatureForm.fileName.value
	
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	//dudy request.setRequestHeader("Content-length", params.length)
	//dudy request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				if (this.responseText != "")
				{
					alert(this.responseText);
				}
				TINY.box.hide();
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	
	request.send(params)  
}

function checkboxValues(name){
    var nodes = document.getElementsByName(name);
    var n;
    var values = new Array();
    for (var i = 0; n = nodes[i]; i++) {
        if (n.checked == true) {
            values[i]=n.value;
        }
    }
    return values;
}

function addEventSend($tiny)
{
	$('#savingImg').show();
	params = "action=addEvent"+
			"&id="+document.AddEventForm.id.value+
			"&actionType="+document.AddEventForm.actionType.value+
			"&type="+document.AddEventForm.eventTypeSelect.value+
			"&method="+document.AddEventForm.eventMethodSelect.value+
			"&fileName="+document.AddEventForm.fileName.value+
			"&fileDesc="+document.AddEventForm.fileDesc.value+
			"&remarks="+document.AddEventForm.remarks.value+
			"&letterMethod="+document.AddEventForm.letterMethodSelect.value+
			"&letterTemplate="+document.AddEventForm.letterTemplateSelect.value+
			"&addAlert="+checkboxValues("addAlert")+
			"&userAlertSelect="+document.AddEventForm.userAlertSelect.value+
			"&alertMethod="+checkboxValues("alertMethod")+
			"&toWho="+checkboxValues("toWho")+
			"&cc="+checkboxValues("cc")+
			"&toOther="+document.AddEventForm.toOther.value
	if (testIsValidObject(document.AddEventForm.parm1))
	{ params += "&parm1="+document.AddEventForm.parm1.value }
	if (testIsValidObject(document.AddEventForm.parm2))
	{ params += "&parm2="+document.AddEventForm.parm2.value }
	if (testIsValidObject(document.AddEventForm.parm3))
	{ params += "&parm3="+document.AddEventForm.parm3.value }
	if (testIsValidObject(document.AddEventForm.parm4))
	{ params += "&parm4="+document.AddEventForm.parm4.value }
	if (testIsValidObject(document.AddEventForm.parm5))
	{ params += "&parm5="+document.AddEventForm.parm5.value }
	if (testIsValidObject(document.AddEventForm.parm6))
	{ params += "&parm6="+document.AddEventForm.parm6.value }
	if (testIsValidObject(document.AddEventForm.parm7))
	{ params += "&parm7="+document.AddEventForm.parm7.value }
	if (testIsValidObject(document.AddEventForm.parm8))
	{ params += "&parm8="+document.AddEventForm.parm8.value }

	
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	//dudy request.setRequestHeader("Content-length", params.length)
	//dudy request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				var resp =  new Array();
				if (this.responseText != "")
				{
					resp = this.responseText.split(',');
					if (resp[1] != "")
					{
						alert(this.responseText);
					}
				}
				
				// check if opened in tinybox or dialog
				if ($tiny)
				{
					TINY.box.hide();
				}
				else
				{
					if (document.AddEventForm.actionType.value == "add")
					{
						document.AddEventForm.actionType.value = "edit";
						document.AddEventForm.id.value = this.responseText.substring(this.responseText.indexOf('eventId:')+8,this.responseText.indexOf(',',8));
						$("#submitBtn").val('שמור');
					}
					$('#savingImg').hide();
					$("#checkImg").show();
					unsavedFile = false;
					setTimeout("$('#checkImg').fadeOut();",1500);
				}
			}
			else
			{
				alert("שגיאה. האירוע לא נשמר.");
				alert( "Ajax error: " + this.statusText);
			}
		}
	}
	
	request.send(params)  
}

function refreshCourtLocations()
{	
	params = "action=refreshCourtLocations"+"&courtType="+document.addCaseFrm.courtTypeSelect.value
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	// dudy request.setRequestHeader("Content-length", params.length)
	// dudy request.setRequestHeader("Connection", "close")
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
					//alert (this.responseText);
					var xmlDocument = this.responseXML;
					courts = xmlDocument.getElementsByTagName("court");
					
					//empty companies select
					document.addCaseFrm.courtLocationSelect.options.length=0
					
					//repopulate the select
					var courtSelect=document.addCaseFrm.courtLocationSelect
					for (i=0; i<courts.length; i++){
						courtSelect.options[courtSelect.options.length]=new Option(courts[i].getElementsByTagName("name")[0].childNodes[0].nodeValue, courts[i].getElementsByTagName("ID")[0].childNodes[0].nodeValue,false, false)
					}
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	
	request.send(params)  
}

function lawyerFormValidator()
{
	var valid;
	valid = true;
	
	return valid;
}
function companyFormValidator()
{
	var valid;
	valid = true;
	
	return valid;
}
function courtFormValidator()
{
	var valid;
	valid = true;
	
	return valid;
}



function changeAppointmentType()
{
	
	// judge appointment
	if ($("#appointmentTypeSelect").val() == 1)
	{
		$("#judgeTR").fadeIn();
		$("#courtTR").fadeIn();
	}
	
	// agreed appointment
	if ($("#appointmentTypeSelect").val() == 2)
	{
		$("#judgeTR").fadeOut();
		$("#courtTR").fadeOut();
	}
	
	//private appointment
	if ($("#appointmentTypeSelect").val() == 3)
	{
		$("#judgeTR").fadeOut();
		$("#courtTR").fadeOut();
	}
}

function generateDynamicForm()
{
	params = "action=addEventForm"+
			"&eventType="+document.AddEventForm.eventTypeSelect.value
	if (testIsValidObject(document.AddEventForm.parm1Temp))
	{
		params += "&editEvent=true&parm1="+document.AddEventForm.parm1Temp.value+
				"&parm2="+document.AddEventForm.parm2Temp.value+
				"&parm3="+document.AddEventForm.parm3Temp.value+
				"&parm4="+document.AddEventForm.parm4Temp.value+
				"&parm5="+document.AddEventForm.parm5Temp.value+
				"&parm6="+document.AddEventForm.parm6Temp.value+
				"&parm7="+document.AddEventForm.parm7Temp.value+
				"&parm8="+document.AddEventForm.parm8Temp.value;
		
	}
				
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	//dudy request.setRequestHeader("Content-length", params.length)
	//dudy request.setRequestHeader("Connection", "close")
	
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
				$("#dynamicForm").hide();
				$("#dynamicForm").html(this.responseText);
				$("#dynamicForm").fadeIn("slow");
				
				// make parm4 a datepicker
				 var dates = $( "#parm4" ).datepicker({
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
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	
	request.send(params)  
}

function addEventScript()
{
	generateDynamicForm();
	populateTemplateList();
	$("#addBtn").button({ icons: { secondary: "ui-icon-plus" }});
}

function populateTemplateList()
{
	params = "action=populateTemplateList"+
			"&eventType="+document.AddEventForm.eventTypeSelect.value
	request = new ajaxRequest()  
	request.open("POST", "ajaxEngine.php", true)
	request.setRequestHeader("Content-type","application/x-www-form-urlencoded")
	//dudy request.setRequestHeader("Content-length", params.length)
	//dudy request.setRequestHeader("Connection", "close")
	request.onreadystatechange = function()
	{
		if (this.readyState == 4)
		{
			if (this.status == 200)
			{
					//alert (this.responseText);
					var xmlDocument = this.responseXML;
					templates = xmlDocument.getElementsByTagName("template");
					
					//empty templates select
					document.AddEventForm.letterTemplateSelect.options.length=0
					
					//repopulate the select
					var templateSelect=document.AddEventForm.letterTemplateSelect
					for (i=0; i<templates.length; i++){
						templateSelect.options[templateSelect.options.length]=new Option(templates[i].getElementsByTagName("description")[0].childNodes[0].nodeValue, templates[i].getElementsByTagName("ID")[0].childNodes[0].nodeValue,false, false)
					}
			}
			else alert( "Ajax error: " + this.statusText)
		}
	}
	
	request.send(params)
}

function deleteAlert(alertId)
{
	$.ajax({
		  type: 'POST',
		  url: 'ajaxEngine.php',
		  data: 'action=deleteAlert&alertId='+alertId,
		  success:  function(data) {
			     $('#alert'+alertId).fadeOut();
		   },
		  dataType: 'text'
		});
}

function hideAlert(alertId,daysToHide)
{
	$.ajax({
		  type: 'POST',
		  url: 'ajaxEngine.php',
		  data: 'action=hideAlert&alertId='+alertId+'&daysToHide='+daysToHide,
		  success:  function(data) {
			     $('#alert'+alertId).fadeOut();
		   },
		  dataType: 'text'
		});
}
function deleteSignature(id)
{
	$.ajax({
		  type: 'POST',
		  url: 'ajaxEngine.php',
		  data: 'action=deleteSignature&id='+id,
		  success:  function(data) {
		 		window.location.reload( true );
		   },
		  dataType: 'text'
		});
}
function sendDocumentByMail(docId,email)
{
	$("#mailDocSpinner"+docId).append('&nbsp;<img id="savingImg" src="images/loading-small-orange.gif" width="20px" />');
	$.ajax({
		  type: 'POST',
		  url: 'ajaxEngine.php',
		  data: 'action=mailDocument&docId='+docId+'&email='+email,
		  success:  function(data) {
			     $("#mailDocSpinner"+docId).children("img").remove();
		   },
		  dataType: 'text'
	});
}
function initUploader()
{
var uploader = new qq.FileUploader({
    // pass the dom node (ex. $(selector)[0] for jQuery users)
    element: document.getElementById('file-uploader'),
    // path to server-side upload script
    action: 'upload-server/php.php',
    sizeLimit: 0,
    debug: false,
    onComplete: function(id, fileName, responseJSON)
    {
      if (!responseJSON.success)
      {
        alert('תקלה בהעלאת הקובץ לשרת');
      }
      $('#fileName').val(responseJSON.fileName);
      $('#file-uploader').hide();
    },
    onSubmit: function(id, fileName){
			$('.qq-upload-button').hide();
        },
    onCancel: function(id, fileName){
        	$('.qq-upload-button').show();
            }
	}); 
}