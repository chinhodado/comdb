<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>CPU list chart</title>
	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">


	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"</script>
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>

	
</head>
<body style="padding-top: 50px;">
	<?php include 'topbar.php'; ?>

	
	<div id="chart_container" style="width:100%; height:400px;"></div>

	<script>
		$(function () {
			$('#chart_container').highcharts({
				chart: {type: 'bar'},
				title: {text: 'Passmark CPU'},
				xAxis: {categories: ['CPU']},
				yAxis: {title: {text: 'Passmark score'}},
				series: [{
					name: 'AMD Athlon 64 X2 4200+',
					data: [1022]
				}, {
					name: 'AMD Athlon 64 X2 7750 Black Edition',
					data: [1517]
				}, {
					name: 'AMD C-60',
					data: [678]
				}, {
					name: 'AMD Sempron 3000+',
					data: [413]
				}, {
					name: 'Intel Core i5 3470T',
					data: [4767]
				}, {
					name: 'Intel Core i5 480M',
					data: [2658]
				}, {
					name: 'Intel Core i7 3820',
					data: [9315]
				}, {
					name: 'Intel Pentium 4 3.00 GHz',
					data: [360]
				}, {
					name: 'Intel Pentium III E 850 MHz',
					data: [167]
				}, {
					name: 'Mobile Intel Pentium 4 M 2.00Ghz',
					data: [91]
				}
				],
			});
		});
	</script>
</body>
</html>
