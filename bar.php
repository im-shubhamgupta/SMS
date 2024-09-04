<?php 

// First array for purchased product 
$purchased= array(1, 2, 3, 4, 5, 6); 

// Second array for sold product 
$sold= array(6, 5, 4, 3, 2, 1); 

// Data to draw graph for purchased products 
$dataPoints = array( 
	array("label"=> "Jan", "y"=> $purchased[0]), 
	array("label"=> "Feb", "y"=> $purchased[1]), 
	array("label"=> "March", "y"=> $purchased[2]), 
	array("label"=> "April", "y"=> $purchased[3]), 
	array("label"=> "May", "y"=> $purchased[4]), 
	array("label"=> "Jun", "y"=> $purchased[5]) 
	 
); 

// Data to draw graph for sold products 
$dataPoints2 = array( 
	array("label"=> "Jan", "y"=> $sold[0]), 
	array("label"=> "Feb", "y"=> $sold[1]), 
	array("label"=> "March", "y"=> $sold[2]), 
	array("label"=> "April", "y"=> $sold[3]), 
	array("label"=> "May", "y"=> $sold[4]), 
	array("label"=> "Jun", "y"=> $sold[5]) 
); 
	
?> 

<!DOCTYPE HTML> 
<html> 
<head> 
	<script src="https://canvasjs.com/assets/script/canvasjs.min.js"> 
	</script> 
	<script> 
		window.onload = function () { 
		
			var chart = new CanvasJS.Chart("chartContainer", { 
				animationEnabled: true, 
				title:{ 
					text: "Monthly Purchased and Sold Product"
				},	 
				axisY: { 
					title: "Purchased", 
					titleFontColor: "#4F81BC", 
					lineColor: "#4F81BC", 
					labelFontColor: "#4F81BC", 
					tickColor: "#4F81BC"
				}, 
				axisY2: { 
					title: "Sold", 
					titleFontColor: "#C0504E", 
					lineColor: "#C0504E", 
					labelFontColor: "#C0504E", 
					tickColor: "#C0504E"
				},	 
				toolTip: { 
					shared: true 
				}, 
				legend: { 
					cursor:"pointer", 
					itemclick: toggleDataSeries 
				}, 
				data: [{ 
					type: "column", 
					name: "Purchased", 
					legendText: "Purchased", 
					showInLegend: true, 
					dataPoints:<?php echo json_encode($dataPoints, 
							JSON_NUMERIC_CHECK); ?> 
				}, 
				{ 
					type: "column",	 
					name: "Sold", 
					legendText: "Sold", 
					axisYType: "secondary", 
					showInLegend: true, 
					dataPoints:<?php echo json_encode($dataPoints2, 
							JSON_NUMERIC_CHECK); ?> 
				}] 
			}); 
			chart.render(); 
			
			function toggleDataSeries(e) { 
				if (typeof(e.dataSeries.visible) === "undefined"
							|| e.dataSeries.visible) { 
					e.dataSeries.visible = false; 
				} 
				else { 
					e.dataSeries.visible = true; 
				} 
				chart.render(); 
			} 
		
		} 
	</script> 
</head> 

<body> 
	<div id="chartContainer" style="height: 300px; width: 100%;"></div> 
</body> 
</html> 
