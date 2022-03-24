function addEventScript()
{
	/*$(document).ready(function() {
	    $('#file_upload').uploadify({
	      'uploader'  : 'uploadify/uploadify.swf',
	      'script'    : 'uploadify/uploadify.php',
	      'cancelImg' : 'images/cancel.png',
	      'folder'    : 'files',
	      'auto'      : true,
	      'buttonText': 'Select File',
	        'onComplete'  : function(event, ID, fileObj, response, data) {
	            $("#fileName").val(fileObj.name);
	            $("#fileNameLabel").html("<img src=\"/images/check.jpg\" width=\"15\" /> "+fileObj.name);
	            
	          }
	        
	    });
	  });
*/
	generateDynamicForm();
	$("#addBtn").button({ icons: { secondary: "ui-icon-plus" }});
}

function generateDynamicForm()
{
	params = "action=addEventForm"+
			"&eventType="+document.AddEventForm.eventTypeSelect.value
	if (testIsValidObject(document.AddEventForm.parm1Temp))
	{
		params += "&parm1="+document.AddEventForm.parm1Temp.value+
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
	request.setRequestHeader("Content-length", params.length)
	request.setRequestHeader("Connection", "close")
	
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