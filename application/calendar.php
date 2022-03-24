<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';

pageStart("מערכת קליניקה - לו\"ז מרפאה ".$row[0],"<link rel='stylesheet' type='text/css' href='/css/fullcalendar.css' />
												  <script type='text/javascript' src='/js/moment.min.js'></script> 
												  <script type='text/javascript' src='/js/fullcalendar.min.js'></script> 
												  ");

?>
<br><br>
<h1><center>לו"ז מרפאה</center></h1>
<br>
<a id="addBtn" onClick="TINY.box.show({url:'addClinicDate.php',width:300,height:150,openjs:function(){generateDynamicForm();},closejs:function(){ $('#calendar').fullCalendar('refetchEvents');}})">הוסף תאריך מרפאה</a>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
<a id="printBtn" onClick='printAgenda()'>הדפסה</a>
<script>
$("#addBtn").button({ icons: { secondary: "ui-icon-plus" }});
$("#printBtn").button({ icons: { secondary: "ui-icon-print" }});
</script>
<br><br>
<br>
<div id='calendar'></div>

<script>
$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendar').fullCalendar({
    	theme:true,
    	isRTL:true,
    	header: {
		    	right:  'month,agendaDay',
		        center: 'title',
		        left:   'today prev,next'
    		},
    	buttonText: {
    	    	month: 'חודש',
    	    	day: 'יום',
    	    	today: 'היום'
    		}, 
    	dayNames : ['ראשון', 'שני', 'שלישי', 'רביעי', 'חמישי', 'שישי', 'שבת'],
    	dayNamesShort : ['ראשון', 'שני', 'שלישי', 'רביעי', 'חמישי', 'שישי', 'שבת'],
    	monthNames : ['ינואר', 'פברואר', 'מרץ', 'אפריל', 'מאי', 'יוני', 'יולי', 'אוגוסט', 'ספטמבר', 'אוקטובר', 'נובמבר', 'דצמבר'],
    	monthNamesShort: ['ינואר', 'פברואר', 'מרץ', 'אפריל', 'מאי', 'יוני', 'יולי', 'אוגוסט', 'ספטמבר', 'אוקטובר', 'נובמבר', 'דצמבר'],
    	eventSources: [
    	   {
	            url: '/appointments_feed.php',
	            contentType: "application/json; charset=utf-8",
	            data: {
	                id: '1'
	            },
	            error: function() {
	                alert('there was an error while fetching events (id-1) !');
	            },
	            allDayDefault: false,
	            color: '#7dbeff',   // a non-ajax option
	            textColor: 'black' // a non-ajax option
           },
           {
	            url: '/appointments_feed.php',
	            contentType: "application/json; charset=utf-8",
	            data: {
	                id: '2'
	            },
	            error: function() {
	                alert('there was an error while fetching events (id-2) !');
	            },
	            allDayDefault: false,
	            color: '#a4e79c',   // a non-ajax option
	            textColor: 'black' // a non-ajax option
           },
    	   {
	            url: '/appointments_feed.php',
	            contentType: "application/json; charset=utf-8",
	            data: {
	                id: '3'
	            },
	            error: function() {
	                alert('there was an error while fetching events (id-3) !');
	            },
	            allDayDefault: false,
	            color: '#ff7777',   // a non-ajax option
	            textColor: 'black' // a non-ajax option
          }
           ],
        slotMinutes: {
           agendaDay: <?php echo getSetting("appointment_time"); ?>
           },
        defaultEventMinutes: {
           agendaDay: <?php echo getSetting("appointment_time"); ?>
           },
        minTime: {
        	agendaDay: <?php echo "\"".getSetting("clinic_start_time")."\""; ?>
           },
        maxTime: {
        	agendaDay: <?php echo "\"".getSetting("clinic_end_time")."\""; ?>
           },
        allDaySlot: {
           	agendaDay: false
              },
        dayClick: function(date, allDay, jsEvent, view) {
        	   $('#calendar').fullCalendar( 'changeView', 'agendaDay' );
        	   $('#calendar').fullCalendar( 'gotoDate', date );
           },
        eventClick: function(calEvent, jsEvent, view) {
               if (calEvent.id == 0)
               {
            	   $('#calendar').fullCalendar( 'changeView', 'agendaDay' );
            	   $('#calendar').fullCalendar( 'gotoDate', calEvent.start );
               }
               else
               {
	        	   window.open('/showCase.php?id='+calEvent.id);
	               return false;
               }
           } 	
    });
    
});

function printAgenda()
{
	if ($("#calendar").fullCalendar("getView").name == "agendaDay") 
	{
		openNewWindow("calendarPrint.php?date="+$.fullCalendar.formatDate($("#calendar").fullCalendar("getDate"),"yyyy-MM-dd"));
	}
	else
	{
		alert('אנא בחר תאריך');
	}
}

function openNewWindow(url)
{
	popupWin = window.open(url,
	'open_window',
	' directories, status, scrollbars, resizable, dependent, width=640, height=480, left=0, top=0');
}


</script>

<?php pageEnd(); ?>