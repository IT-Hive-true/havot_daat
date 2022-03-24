<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="/js/clinic.js" type="text/javascript"></script>
        <link rel='stylesheet' type='text/css' href='/css/main.css' />
        <link rel='stylesheet' type='text/css' href='/css/fullcalendar.css' />
		<script type='text/javascript' src='/js/moment.min.js'></script>
		<script type='text/javascript' src='/js/fullcalendar.min.js'></script>
        <title>הוספת אירוע</title>
        
</head>
<body>
<div id='calendarWidget'></div>

<script>
$(document).ready(function() {

    // page is now ready, initialize the calendar...

    $('#calendarWidget').fullCalendar({
    	theme:true,
    	isRTL:true,
    	defaultView: 'agendaDay',
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
	                alert('there was an error while fetching events!');
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
	                alert('there was an error while fetching events!');
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
	                alert('there was an error while fetching events!');
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
            	   $('#calendarWidget').fullCalendar( 'changeView', 'agendaDay' );
            	   $('#calendarWidget').fullCalendar( 'gotoDate', calEvent.start );
               }
               else
               {
	        	   window.open('/showCase.php?id='+calEvent.id);
	               return false;
               }
           } 	
    });
    
});
</script>
</body>
</html>
