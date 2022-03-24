<?php
require_once 'generalPHP.php';
require_once 'db.php';

$db_server = mysqli_connect($db_hostname, $db_username, $db_password,$db_database);

if (isset($_GET['from']))
{
	$from = "'".sanitizeMySQL($_GET['from'])."'";
}
else
{
	$from = "(DATE(NOW()) - INTERVAL 1 YEAR)";
}
if (isset($_GET['to']))
{
	$to = "'".sanitizeMySQL($_GET['to'])."'";
}
else
{
	$to = "DATE(NOW())";
}

?>

        <script type="text/javascript" src="/js/raphael/raphael-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.raphael-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.bar-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.dot-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.line-min.js"></script>
        <script type="text/javascript" src="/js/raphael/g.pie-min.js"></script>
		<title>דו"ח 1 - תיקים</title>
		<style>
			#graph1-1 { width:450px; display: inline-block; }
			#graph1-2 { width:450px; display: inline-block; }
		</style>
		<script type="text/javascript" charset="utf-8">
			$(document).ready(function() { 

				// *** Graph 1 *** 
				var graph1Values = [];
				var graph1Labels = [];
				<?php 
					$query = "select count(*),round(datediff(date(t2.timestamp),t1.appointment_date)/30) as monthDiff
								from tbcases as t1, tbevents as t2
								where (t1.id = t2.case_id) and
								      (t2.type = 12) and
								      (t2.parm1 = 8) and
								      (t1.client_id = ".$clientId.") 
								group by monthDiff";
					$result = mysqli_query($db_server,$query);
					if (!$result) die("Database access failed: " . mysqli_error());
					elseif (mysqli_num_rows($result))
					{
						for ($i=0;$i<mysqli_num_rows($result);$i++)
						{
							$row = mysqli_fetch_row($result);
							echo "graph1Values[".$i."] = ".$row[0].";";
							echo "graph1Labels[".$i."] = '".$row[1]." חודשים';";
						}
						echo "var numOfValues=".mysqli_num_rows($result).";";
					}
					else
					{
						echo "$('#graph1-1').hide();";
					}
					
				?>
                var r = Raphael("graph1-1"),
                fin = function () {
                    this.flag = r.g.popup(this.bar.x, this.bar.y, this.bar.value || "0").insertBefore(this);
                },
                fout = function () {
                    this.flag.animate({opacity: 0}, 300, function () {this.remove();});
                };
                // r.g.txtattr.font = "12px 'Fontin Sans', Fontin-Sans, sans-serif";
                r.g.text(280, 100, "זמן טיפול כולל בתיק - בחודשים").attr({"font-size": 20});
                //Paper.barchart(x, y, width, height, values, opts)
				r.g.barchart(120, 120, 300, 220, graph1Values).hover(fin, fout);
                axis = r.g.axis(160,340,180,null,null,(numOfValues-1),2,graph1Labels, "|", 0);
                // var pie = r.g.piechart(280, 240, 100, [55, 20, 13, 32, 5, 1, 2, 10], {legend: ["%%.%% – Enterprise Users", "IE Users"], legendpos: "west", href: ["http://raphaeljs.com", "http://g.raphaeljs.com"]});
                

                var r = Raphael("graph1-2");
                // r.g.txtattr.font = "12px 'Fontin Sans', Fontin-Sans, sans-serif";
                r.g.text(320, 100, "גרף אינטרקטיבי").attr({"font-size": 20});
				
				
				//Paper.piechart(cx, cy, r, values, opts)
				//looks like the graph gets hard coded parameters
				var pie = r.g.piechart(120, 230, 100,
									  [55, 20, 13, 32, 5, 1, 2, 10],
									  {legend: ["%%.%% – Enterprise Users", "IE Users"],
									  legendpos: "east",
									  href: ["http://raphaeljs.com", "http://g.raphaeljs.com"]})
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
<nobr>
<span id="graph1-1"></span>
<span id="graph1-2"></span>
</nobr>

</body>
