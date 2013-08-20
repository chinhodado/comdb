<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Passmark GPU 3D score chart</title>
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
		include 'dbConnection.php';
		include 'class_def.php';

		// Establish the connection
		$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());

		//query and result
		$query = "select * from comdb.gpu order by passmarkscore3D;";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());

		$gpu_array = array();//prepare an array of CPUAndScore objects

		while ($line = pg_fetch_array($result)) {
			//reuse the CPUAndScore class definition, since it's the same for the job. Might need to change the class name later
			$temp = new CPUAndScore($line[1], $line[3]);//$line[1] is GPU name, $line[3] is the Passmark 3D score
			array_push($gpu_array, $temp);
		}

		$json_cpu_data = json_encode($gpu_array);//turn this array into json, ready to use later
		?>
	
	<div id="chart_container" style="width:100%; height:400px;"></div>

	<script>
		$(function () {
			$('#chart_container').highcharts({
				chart: {type: 'bar'},
				title: {text: 'Passmark GPU 3D score chart'},
				xAxis: {categories: ['GPU']},
				yAxis: {title: {text: 'Passmark 3D score'}},
				series: <?php echo $json_cpu_data; ?>
			});
		});
	</script>
</body>
</html>
