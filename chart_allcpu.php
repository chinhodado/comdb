<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>CPU list chart</title>
	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.js"></script> 
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"</script>
</head>
<body style="padding-top: 50px;">
	<?php include 'topbar.php'; ?>
	<div id="chart_container" style="width:100%; height:400px;"></div>
	<script>
		$(function () {
			$('#chart_container').highcharts({
				chart: {
					type: 'bar'
				},
				title: {
					text: 'Fruit Consumption'
				},
				xAxis: {
					categories: ['Apples', 'Bananas', 'Oranges']
				},
				yAxis: {
					title: {
						text: 'Fruit eaten'
					}
				},
				series: [{
					name: 'Jane',
					data: [1, 0, 4]
				}, {
					name: 'John',
					data: [5, 7, 3]
				}],
			});
		});
	</script>
</body>
</html>
