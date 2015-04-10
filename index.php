<!DOCTYPE html>
<html lang="en" class="wf-proximanova-n4-active wf-proximanova-n6-active wf-sourcecodepro-n4-active wf-sourcecodepro-n7-active wf-active">
	<head>
		<title>CSUF Parking Database | Graph Test</title>
		<meta charset="utf-8" />
		<script type="text/javascript" src="http://www.chartjs.org/assets/Chart.min.js"></script>
		<style>


		html, body { width:75%; height:75%; } /* just to be sure these are full screen*/
      
    canvas { padding-left: 0; padding-right: 0; margin-left: auto; margin-right: auto; display: block; width: 800px; }
      
    .line-legend {
      list-style: none;
      position: absolute;
      right: 8px;
      top: 0;
    }
    .line-legend li {
      display: block;
      padding-left: 30px;
      position: relative;
      margin-bottom: 4px;
      border-radius: 5px;
      padding: 2px 8px 2px 28px;
      font-size: 14px;
      cursor: default;
      -webkit-transition: background-color 200ms ease-in-out;
      -moz-transition: background-color 200ms ease-in-out;
      -o-transition: background-color 200ms ease-in-out;
      transition: background-color 200ms ease-in-out;
    }
    .line-legend li:hover {
      background-color: #e1e1e1;
    }
    .line-legend li span {
      display: block;
      position: absolute;
      left: 0;
      top: 0;
      width: 20px;
      height: 100%;
      border-radius: 5px;
    }
      
		</style>
	</head>
	<body>
		<canvas id="CSUF_Parking_Chart" width="600" height="400"></canvas>
    <div id="legendDiv"></div>
		<script type="text/javascript">
      var data = {
					labels: [<?php date_default_timezone_set('America/Los_Angeles'); for($i = 0; $i <= 59; $i++){ if($i <= 9){echo "\"".date('g').":0". $i ."\",";}elseif($i == 59){echo "\"".date('g').":". $i ."\"";}else{echo "\"".date('g').":". $i ."\",";} } ?>],
					datasets: [
						{
							label: "Nutwood Structure",
							fillColor: "rgba(0,12,255,0.2)",
							strokeColor: "rgba(255,0,205,1)",
							pointColor: "rgba(0,187,205,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(0,255,34,1)",
							data: [<?php date_default_timezone_set('America/Los_Angeles');
										$result = file_get_contents('http://orange-missle-101-214152.usw1-2.nitrousbox.com/csuf_parking_dev/api/database.php?structure=nutwood&time='.time()."&h=".date('g'));
										echo $result; ?>]
						},
						{
							label: "State College Structure",
							fillColor: "rgba(100,255,100,0.2)",
							strokeColor: "rgba(15,110,255,1)",
							pointColor: "rgba(255,255,0,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(0,255,34,1)",
							data: [<?php date_default_timezone_set('America/Los_Angeles');
										$result = file_get_contents('http://orange-missle-101-214152.usw1-2.nitrousbox.com/csuf_parking_dev/api/database.php?structure=state_college&time='.time()."&h=".date('g'));
										echo $result; ?>]
						},
						{
							label: "Eastside Structure",
							fillColor: "rgba(255,0,255,0.2)",
							strokeColor: "rgba(255,0,220,1)",
							pointColor: "rgba(255,0,0,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(0,255,34,1)",
							data: [<?php date_default_timezone_set('America/Los_Angeles');
										$result = file_get_contents('http://orange-missle-101-214152.usw1-2.nitrousbox.com/csuf_parking_dev/api/database.php?structure=eastside&time='.time()."&h=".date('g'));
										echo $result; ?>]
						},
						{
							label: "Lot A & G",
							fillColor: "rgba(220,220,220,0)",
							strokeColor: "rgba(220,220,220,0)",
							pointColor: "rgba(220,220,220,1)",
							pointStrokeColor: "#fff",
							pointHighlightFill: "#fff",
							pointHighlightStroke: "rgba(0,255,34,1)",
							data: [<?php date_default_timezone_set('America/Los_Angeles');
										$result = file_get_contents('http://orange-missle-101-214152.usw1-2.nitrousbox.com/csuf_parking_dev/api/database.php?structure=lot_a_g&time='.time()."&h=".date('g'));
										echo $result; ?>]
						}
					]
				};
			var canvas = document.getElementById('CSUF_Parking_Chart');
			// resize the canvas to fill browser window dynamically
			window.addEventListener('resize', resizeCanvas, false);

			function resizeCanvas() {
					canvas.width = window.innerWidth*0.75;
					canvas.height = window.innerHeight*0.75;
			}
			resizeCanvas();

			window.onload = function(){
          var ctx = document.getElementById("CSUF_Parking_Chart").getContext("2d");
          window.Line_Chart = new Chart(ctx).Line(data, {
            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
            responsive : true,
            animationEasing: "easeOutQuart",
            tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>%"
          });
         var helpers = Chart.helpers;
         var legendHolder = document.getElementById('legendDiv');
      legendHolder.innerHTML = Line_Chart.generateLegend();
      helpers.each(legendHolder.firstChild.childNodes, function(legendNode, index){
          helpers.addEvent(legendNode, 'mouseover', function(){
              var activeSegment = Line_Chart.datasets[index];
              var saveColor = activeSegment.fillColor;
              activeSegment.fillColor = activeSegment.pointColor;
              Line_Chart.showTooltip([activeSegment]);
              activeSegment.fillColor = saveColor;
          });
      });
        helpers.addEvent(legendHolder.firstChild, 'mouseout', function(){
          Line_Chart.draw();
      });
        canvas.parentNode.parentNode.appendChild(legendHolder.firstChild);
        document.getElementById("legendDiv").innerHTML = Line_Chart.generateLegend();
      }
		</script>
	</body>
</html>