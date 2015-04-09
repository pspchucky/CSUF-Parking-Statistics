<!DOCTYPE html>
<html lang="en">
	<head>
		<title>CSUF Parking Database | Graph Test</title>
		<meta charset="utf-8" />
		<script type="text/javascript" src="http://www.chartjs.org/assets/Chart.min.js"></script>
		<style>
		* { margin:0; padding:0; } /* to remove the top and left whitespace */

		html, body { width:100%; height:100%; } /* just to be sure these are full screen*/

		canvas { display:block; } /* To remove the scrollbars */
		</style>
	</head>
	<body>
		<canvas id="CSUF_Parking_Chart" width="600" height="400"</canvas>
		<script type="text/javascript">
			var canvas = document.getElementById('CSUF_Parking_Chart');
			// resize the canvas to fill browser window dynamically
			window.addEventListener('resize', resizeCanvas, false);

			function resizeCanvas() {
					canvas.width = window.innerWidth;
					canvas.height = window.innerHeight;
					drawStuff(); 
			}
			resizeCanvas();

			function drawStuff() {
				var ctx = document.getElementById("CSUF_Parking_Chart").getContext("2d");
				var data = {
					labels: [<?php date_default_timezone_set('America/Los_Angeles'); for($i = 0; $i <= 59; $i++){ if($i <= 9){echo "\"".date('g').":0". $i ."\",";}elseif($i == 59){echo "\"".date('g').":". $i ."\"";}else{echo "\"".date('g').":". $i ."\",";} } ?>],
					datasets: [
						{
							label: "Nutwood Structure",
							fillColor: "rgba(255,0,255,0.2)",
							strokeColor: "rgba(255,0,220,1)",
							pointColor: "rgba(255,0,0,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(220,220,220,1)",
							data: [<?php date_default_timezone_set('America/Los_Angeles');
										$result = file_get_contents('http://orange-missle-101-214152.usw1-2.nitrousbox.com/csuf_parking_dev/api/database.php?structure=nutwood&time='.time()."&h=".date('g'));
										echo $result; ?>]
						},
						{
							label: "State College Structure",
							fillColor: "rgba(151,187,205,0.2)",
							strokeColor: "rgba(151,187,205,1)",
							pointColor: "rgba(255,255,0,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(151,187,205,1)",
							data: [<?php date_default_timezone_set('America/Los_Angeles');
										$result = file_get_contents('http://orange-missle-101-214152.usw1-2.nitrousbox.com/csuf_parking_dev/api/database.php?structure=state_college&time='.time()."&h=".date('g'));
										echo $result; ?>]
						},
						{
							label: "Eastside Structure",
							fillColor: "rgba(255,12,255,0.2)",
							strokeColor: "rgba(151,187,205,1)",
							pointColor: "rgba(151,187,205,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(151,187,205,1)",
							data: [<?php date_default_timezone_set('America/Los_Angeles');
										$result = file_get_contents('http://orange-missle-101-214152.usw1-2.nitrousbox.com/csuf_parking_dev/api/database.php?structure=eastside&time='.time()."&h=".date('g'));
										echo $result; ?>]
						},
						{
							label: "Lot A & G",
							fillColor: "rgba(220,220,220,0.2)",
							strokeColor: "rgba(220,220,220,1)",
							pointColor: "rgba(220,220,220,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(220,220,220,1)",
							data: [<?php date_default_timezone_set('America/Los_Angeles');
										$result = file_get_contents('http://orange-missle-101-214152.usw1-2.nitrousbox.com/csuf_parking_dev/api/database.php?structure=lot_a_g&time='.time()."&h=".date('g'));
										echo $result; ?>]
						}
					]
				};
				new Chart(ctx).Line(data);
			}	
			
		
		
		
		
		</script>
	</body>
</html>