<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>All computer charts - Bar - Group by components</title>

	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.js"></script> 
	<script src="http://code.highcharts.com/highcharts.js"></script>
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>
	
</head>
<body style="padding-top: 50px;background-color:#162726;">

	<?php
	include 'topbar.php';
	include 'dbConnection.php';
	include 'class_def.php';

	// Establish the connection
	$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());

	//////////////////////////////////////
	// Fetch CPU list
	//////////////////////////////////////

	$query = "select * from comdb.cpu;";
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());

	$cpu_array = array();

	while ($line = pg_fetch_array($result)) {
		$temp = new CPU($line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6], $line[7], $line[8], $line[9], $line[10], $line[11], $line[12], $line[13], $line[14]);
		$cpu_array[$line[0]] = $temp; 
	}

	//////////////////////////////////////
	// Fetch GPU list
	//////////////////////////////////////

	$query = "select * from comdb.gpu;";
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());

	$gpu_array = array();

	while ($line = pg_fetch_array($result)) {
		$temp = new GPU($line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6]);
		$gpu_array[$line[0]] = $temp; 
	}

	//////////////////////////////////////
	// Fetch computer list
	//////////////////////////////////////

	$query = "select * from comdb.computer;";
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());

	$computer_array = array();

	while ($line = pg_fetch_array($result)) {
		$temp = new Computer($line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6], $line[7], $line[8], $line[9]);
		array_push($computer_array, $temp);
	}

	/////////////////////////////////////
	// Get the max scores
	/////////////////////////////////////
	$arrayTotal = array();

	foreach ($computer_array as $temp) {
		array_push($arrayTotal, new NameAndData($temp->name, array(intval($cpu_array[$temp->cpuid]->passmarkscore), 
																	intval($gpu_array[$temp->gpuid]->passmarkscore2D), 
																	intval($gpu_array[$temp->gpuid]->passmarkscore3D), 
																	intval($temp->passmarkramscore), 
																	intval($temp->passmarkdiskscore))));
	}

	////////////////////////////////////////
	// Print out the charts
	////////////////////////////////////////

	$json_data = json_encode($arrayTotal);

	?>

	<div id="chart_container" style="width:100%; height:1500px;"></div>

	<script>
		$(function () {
			$('#chart_container').highcharts({
				chart: {type: 'bar'},
				title: {text: 'Passmark score chart <br> All computers - Group by components'},
				xAxis: {categories: ['CPU', '2D', '3D', 'RAM', 'Disk']},
				yAxis: {title: {text: 'Passmark score'}},
				series: <?php echo $json_data; ?>,
				credits: {enabled: false},
				plotOptions: {bar: {dataLabels: {enabled: true}}}
			});
		});
	</script>

</body>
</html>