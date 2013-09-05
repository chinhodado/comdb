<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Passmark CPU score chart</title>
	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">

	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>	
</head>
<body style="padding-top: 50px;">

	<?php
		include 'topbar.php';
		include 'class_def.php';

		// Establish the connection
		include 'dbConnection.php';

		//query and result
		$query = "select * from cpu order by passmarkscore;";
		$result = $dbconn->query($query);

		$cpu_array = array();//prepare an array of CPUAndScore objects

		while ($line = $result->fetchArray()) {
			$temp = new CPUAndScore($line[1], $line[9]);//$line[1] is CPU name, $line[9] is the Passmark score
			array_push($cpu_array, $temp);
		}

		$json_cpu_data = json_encode($cpu_array);//turn this array into json, ready to use later
		?>
	
	<div id="chart_container" style="width:100%; height:400px;"></div>

	<script>
		$(function () {
			$('#chart_container').highcharts({
				chart: {type: 'bar'},
				title: {text: 'Passmark CPU score chart'},
				xAxis: {categories: ['CPU']},
				yAxis: {title: {text: 'Passmark score'}},
				series: <?php echo $json_cpu_data; ?>,
				credits: {enabled: false},
				plotOptions: {bar: {dataLabels: {enabled: true}}}
			});
		});
	</script>
</body>
</html>
