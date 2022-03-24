<?php
require_once 'generalPHP.php';
require_once 'pageBuilder.php';

if (isset($_GET['filterText']))
{
	$filterText = sanitizeMySQL($_GET['filterText']);
}

pageStart("מערכת קליניקה - משרדי עורכי-דין");
?>
<script>
	/*
	$(function() {
		var dates = $( "#fromDate, #toDate" ).datepicker({
			defaultDate: "+1w",
			dateFormat:"yy-mm-dd",
			changeMonth: true,
			numberOfMonths: 3,
			onSelect: function( selectedDate ) {
				var option = this.id == "fromDate" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
				$( "#tabs" ).tabs( "option", "ajaxOptions", { data: "from="+$("#fromDate").val() + "&to="+$("#toDate").val() } );
				$( "#tabs" ).tabs("load" , $( "#tabs" ).tabs('option', 'selected') )
			}
		});
	});
	*/

	
	$(function() {
		$( "#toDate" ).datepicker({dateFormat: 'dd-mm-yy' });
		$( "#fromDate" ).datepicker({ dateFormat: 'dd-mm-yy' });
	});
  
	$(document).ready(function() { 
		$("#toDate").datepicker('setDate','c');
		$('#fromDate').datepicker('setDate','c-1y');
		
		$("#toDate").bind('change', function() {
			updateTabData()
		});
		$('#fromDate').bind('change', function() {
			updateTabData()
		});
	});
	
		
	
</script>
<br /><br />
<div>
טווח תאריכים
<label for="fromDate">מ-</label>
<input type="text" id="fromDate" name="fromDate"/>
<label for="toDate">עד-</label>
<input type="text" id="toDate" name="toDate"/>
</div>
<br /><br />
<script>
	$(function() {
		$( "#tabs" ).tabs({
			spinner: 'Retrieving data...',
			ajaxOptions: {
				type:'GET',
			 	data: "from="+$("#fromDate").val() + "&to="+$("#toDate").val() ,
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"תקלה בהעלאת הדוח המבוקש" );
				}
			}
		});
		
	});
	
	function updateTabData() {
		//console.log('was in updateTabData()');
		//console.log('active='+$("#tabs").tabs('option', 'active'));
		//console.log('active_json' + (($("#tabs").tabs('option', 'active')).tabs('option', 'active')).tabs('option', 'active'));
		//console.log($("#tabs").tabs('option', 'active').index());
		
		$('#tabs-1-a').attr('href' , '/report5.php?' + "from="+$("#fromDate").val() + "&to="+$("#toDate").val() );
		$('#tabs-2-a').attr('href' , '/report1.php?' + "from="+$("#fromDate").val() + "&to="+$("#toDate").val() );
		$('#tabs-3-a').attr('href' , '/report2.php?' + "from="+$("#fromDate").val() + "&to="+$("#toDate").val() );
		$('#tabs-4-a').attr('href' , '/report3.php?' + "from="+$("#fromDate").val() + "&to="+$("#toDate").val() );
		$('#tabs-5-a').attr('href' , '/report4.php?' + "from="+$("#fromDate").val() + "&to="+$("#toDate").val() );
		
		// reload page
		var tabIndex = $('#tabs').data('active_tab');
		//if ( isNaN(tabIndex) ) {
		//	tabIndex = 0;
		//}
		//console.log("tabIndex = " + tabIndex );
		$( "#tabs" ).tabs("load" , tabIndex );
	}
	
	function setTabIndex(i) {
		$('#tabs').data('active_tab',i);
	}

	
</script>



<div id="tabs" data-active_tab="0" >
	<ul>
		<li id="tabs-1" onclick="setTabIndex(0)" ><a id="tabs-1-a" href="/report5.php">דו"חות אקסל</a></li>
		<li id="tabs-2" onclick="setTabIndex(1)" ><a id="tabs-2-a" href="/report1.php">תיקים</a></li>
		<li id="tabs-3" onclick="setTabIndex(2)" ><a id="tabs-3-a" href="/report2.php">מינויים</a></li>
		<li id="tabs-4" onclick="setTabIndex(3)" ><a id="tabs-4-a" href="/report3.php">בתי משפט</a></li>
		<li id="tabs-5" onclick="setTabIndex(4)" ><a id="tabs-5-a" href="/report4.php">תשלומים</a></li>
	</ul>
</div>

<br /><br /><br />

<?php pageEnd(); ?>