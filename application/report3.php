<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_GET['from']))
{
	$from = "'".sanitizeMySQL($_GET['from'])."'";
	$from = "STR_TO_DATE(".$from.",'%d-%m-%Y')";
}
else
{
	$from = "(DATE(NOW()) - INTERVAL 1 YEAR)";
}
if (isset($_GET['to']))
{
	$to = "'".sanitizeMySQL($_GET['to'])."'";
	$to = "STR_TO_DATE(".$to.",'%d-%m-%Y')";
}
else
{
	$to = "DATE(NOW())";
}

?>


    <head>
        <script type="text/javascript" src="/js/raphael/raphael-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.raphael-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.bar-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.dot-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.line-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.pie-min.js"></script>
		<title>דו"ח 1 - תיקים</title>
		<style>
			#graph3-1 { width:450px; display: inline-block; }
			#graph3-2 { width:450px; display: inline-block; }
			#graph3-3 { width:450px; display: inline-block; }
			#graph3-4 { width:450px; display: inline-block; }
			#graph_container {width: 900px; margin: 0 auto; }
		</style>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() { 

				// *** Graph 1 *** 
				var graph1Values = [];
				var graph1Labels = [];
				<?php 
					$query = "select count(*),t1.court_id,t2.type,t2.location
								from tbcases as t1, tbcourts as t2
								where (court_id is not NULL) and
								      (t1.court_id = t2.id) and
								      (t1.appointment_type = 1) and
								      (t1.appointment_date >= ".$from.") and 
								      (t1.appointment_date <= ".$to.") and
								      (t1.client_id = ".$clientId.") 
								GROUP BY t1.court_id";
					$result = mysqli_query($db_server,$query);
					if (!$result) die("Database access failed: " . mysqli_error());
					elseif (mysqli_num_rows($result))
					{
						for ($i=0;$i<mysqli_num_rows($result);$i++)
						{
							$row = mysqli_fetch_row($result);
							echo "graph1Values[".$i."] = ".$row[0].";";
							echo "graph1Labels[".$i."] = '%% - ה".$courtType[$row[2]]." ".$row[3]." (".$row[0].")';";
						}
					}
				?>
                var r = Raphael("graph3-1");
                r.g.txtattr.font = "12px 'Fontin Sans', Fontin-Sans, sans-serif";
                r.g.text(320, 100, "פילוח תיקים לפי בתי משפט").attr({"font-size": 20});
                var pie = r.g.piechart(120, 230, 100, graph1Values,
                    {legend: graph1Labels,
                    legendpos: "east", href: []});
                pie.hover(function () {
                    this.sector.stop();
                    this.sector.scale(1.1, 1.1, this.cx, this.cy);
                    if (this.label) {
                        this.label[0].stop();
                        this.label[0].scale(1.5);
                        this.label[1].attr({"font-weight": 800});
                    }
                }, function () {
                    this.sector.animate({scale: [1, 1, this.cx, this.cy]}, 500, "bounce");
                    if (this.label) {
                        this.label[0].animate({scale: 1}, 500, "bounce");
                        this.label[1].attr({"font-weight": 400});
                    }
                });

             	// *** Graph 2 ***
                var graph2Values = [];
				var graph2Labels = [];
				<?php 
					$query = "select count(*),t2.type
								from tbcases as t1, tbcourts as t2
								where (court_id is not NULL) and
								      (t1.court_id = t2.id) and
								      (t1.appointment_type = 1) and
								      (t1.appointment_date >= ".$from.") and 
								      (t1.appointment_date <= ".$to.") and
								      (t1.client_id = ".$clientId.") 
								GROUP BY t2.type";
					$result = mysqli_query($db_server,$query);
					if (!$result) die("Database access failed: " . mysqli_error());
					elseif (mysqli_num_rows($result))
					{
						for ($i=0;$i<mysqli_num_rows($result);$i++)
						{
							$row = mysqli_fetch_row($result);
							echo "graph2Values[".$i."] = ".$row[0].";";
							echo "graph2Labels[".$i."] = '%% - ".$courtType[$row[1]]."';";
						}
					}
				?>
                var r = Raphael("graph3-2");
                // r.g.txtattr.font = "12px 'Fontin Sans', Fontin-Sans, sans-serif";
                r.g.text(320, 100, "פילוח תיקים לפי סוגי בתי משפט").attr({"font-size": 20});
                var pie = r.g.piechart(120, 230, 100, graph2Values, 
				{legend: graph2Labels, 
				legendpos: "east", href: []});
                pie.hover(function () {
                    this.sector.stop();
                    this.sector.scale(1.1, 1.1, this.cx, this.cy);
                    if (this.label) {
                        this.label[0].stop();
                        this.label[0].scale(1.5);
                        this.label[1].attr({"font-weight": 800});
                    }
                }, function () {
                    this.sector.animate({scale: [1, 1, this.cx, this.cy]}, 500, "bounce");
                    if (this.label) {
                        this.label[0].animate({scale: 1}, 500, "bounce");
                        this.label[1].attr({"font-weight": 400});
                    }
                });

             	// *** Graph 3 ***
                var graph3Values = [];
				var graph3Labels = [];
				<?php 
					$query = "select count(*),t1.judge_name
								from tbcases as t1
								where (t1.appointment_type = 1) and
								      (t1.appointment_date >= ".$from.") and 
								      (t1.appointment_date <= ".$to.") and
								      (t1.client_id = ".$clientId.") and
								      (t1.judge_name is not null)
								GROUP BY t1.judge_name";
					$result = mysqli_query($db_server,$query);
					if (!$result) die("Database access failed: " . mysqli_error());
					elseif (mysqli_num_rows($result))
					{
						for ($i=0;$i<mysqli_num_rows($result);$i++)
						{
							$row = mysqli_fetch_row($result);
							echo "graph3Values[".$i."] = ".$row[0]."; ";
							echo "graph3Labels[".$i."] = '%% - ".addslashes($row[1])."'; ";
						}
					}
				?>
				
                var r = Raphael("graph3-3");
                // r.g.txtattr.font = "12px 'Fontin Sans', Fontin-Sans, sans-serif";
                r.g.text(320, 100, "פילוח תיקים לפי שופטים").attr({"font-size": 20});
                var pie = r.g.piechart(120, 230, 100, graph3Values, 
				{legend: graph3Labels, 
				legendpos: "east", href: []});
                pie.hover(function () {
                    this.sector.stop();
                    this.sector.scale(1.1, 1.1, this.cx, this.cy);
                    if (this.label) {
                        this.label[0].stop();
                        this.label[0].scale(1.5);
                        this.label[1].attr({"font-weight": 800});
                    }
                }, function () {
                    this.sector.animate({scale: [1, 1, this.cx, this.cy]}, 500, "bounce");
                    if (this.label) {
                        this.label[0].animate({scale: 1}, 500, "bounce");
                        this.label[1].attr({"font-weight": 400});
                    }
                });

             // *** Graph 4 ***
                var graph4Values = [];
				var graph4Labels = [];
				<?php 
					$query = "select count(*),t2.name
								from tbcases as t1, tbcompanies as t2
								where (t1.defence_company_id = t2.id) and
								      (t1.appointment_date >= ".$from.") and 
								      (t1.appointment_date <= ".$to.") and
								      (t1.client_id = ".$clientId.") and
                      				  (t1.defence_company_id is not null) and
                      				  (t1.defence_company_id <> 0)
							group by t1.defence_company_id";
					$result = mysqli_query($db_server,$query);
					if (!$result) die("Database access failed: " . mysqli_error());
					elseif (mysqli_num_rows($result))
					{
						for ($i=0;$i<mysqli_num_rows($result);$i++)
						{
							$row = mysqli_fetch_row($result);
							echo "graph4Values[".$i."] = ".$row[0].";";
							echo "graph4Labels[".$i."] = '%% - ".addslashes($row[1])."';";
						}
					}
				?>
                var r = Raphael("graph3-4");
                // r.g.txtattr.font = "12px 'Fontin Sans', Fontin-Sans, sans-serif";
                r.g.text(320, 100, "פילוח תיקים לפי חברות ביטוח").attr({"font-size": 20});
                var pie = r.g.piechart(120, 230, 100, graph4Values, 
				{legend: graph4Labels, 
				legendpos: "east", href: []});
                pie.hover(function () {
                    this.sector.stop();
                    this.sector.scale(1.1, 1.1, this.cx, this.cy);
                    if (this.label) {
                        this.label[0].stop();
                        this.label[0].scale(1.5);
                        this.label[1].attr({"font-weight": 800});
                    }
                }, function () {
                    this.sector.animate({scale: [1, 1, this.cx, this.cy]}, 500, "bounce");
                    if (this.label) {
                        this.label[0].animate({scale: 1}, 500, "bounce");
                        this.label[1].attr({"font-weight": 400});
                    }
                });
            });
        </script>
	</head>
	<body class="raphael">
		<div id="graph_container">
			<nobr>
				<span id="graph3-1"></span>
				<span id="graph3-2"></span>
			</nobr>
			<br />
			<nobr>
				<span id="graph3-3"></span>
				<span id="graph3-4"></span>
			</nobr>
		</div>
	</body>
</html>
