<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>All computer charts - bar</title>

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
	include 'class_def.php';

	// Establish the connection
	include 'dbConnection.php';

	//////////////////////////////////////
	// Fetch CPU list
	//////////////////////////////////////

	$query = "select * from cpu;";
	$result = $dbconn->query($query);

	$cpu_array = array();

	while ($line = $result->fetchArray()) {
		$temp = new CPU($line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6], $line[7], $line[8], $line[9], $line[10], $line[11], $line[12], $line[13], $line[14]);
		$cpu_array[$line[0]] = $temp; 
	}

	//////////////////////////////////////
	// Fetch GPU list
	//////////////////////////////////////

	$query = "select * from gpu;";
	$result = $dbconn->query($query);

	$gpu_array = array();

	while ($line = $result->fetchArray()) {
		$temp = new GPU($line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6]);
		$gpu_array[$line[0]] = $temp; 
	}

	//////////////////////////////////////
	// Fetch computer list
	//////////////////////////////////////

	$query = "select * from computer;";
	$result = $dbconn->query($query);

	$computer_array = array();

	while ($line = $result->fetchArray()) {
		$temp = new Computer($line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6], $line[7], $line[8]);
		array_push($computer_array, $temp);
	}

	/////////////////////////////////////
	// Get the max scores
	/////////////////////////////////////
	$arrayScoreCPU = array();
	$arrayScore2D = array();
	$arrayScore3D = array();
	$arrayScoreRAM = array();
	$arrayScoreDisk = array();

	$arrayComputerName = array();

	foreach ($computer_array as $temp) {
			array_push($arrayComputerName, $temp->name);

			array_push($arrayScoreCPU, intval($cpu_array[$temp->cpuid]->passmarkscore));
			array_push($arrayScore2D, intval($gpu_array[$temp->gpuid]->passmarkscore2D));
			array_push($arrayScore3D, intval($gpu_array[$temp->gpuid]->passmarkscore3D));
			array_push($arrayScoreRAM, intval($temp->passmark_ram_score));
			array_push($arrayScoreDisk, intval($temp->passmark_disk_score));
	}

	////////////////////////////////////////
	// Print out the charts
	////////////////////////////////////////
	$arrayFinal = array();
	array_push($arrayFinal, new NameAndData('CPU', $arrayScoreCPU));
	array_push($arrayFinal, new NameAndData('2D', $arrayScore2D));
	array_push($arrayFinal, new NameAndData('3D', $arrayScore3D));
	array_push($arrayFinal, new NameAndData('RAM', $arrayScoreRAM));
	array_push($arrayFinal, new NameAndData('Disk', $arrayScoreDisk));

	$json_computerName = json_encode($arrayComputerName);
	$json_data = json_encode($arrayFinal);

	?>

	<div id="chart_container" style="width:100%; height:1500px;"></div>

	<script>
		$(function () {
			$('#chart_container').highcharts({
				chart: {type: 'bar'},
				title: {text: 'Passmark score chart <br> All computers - Group by computer'},
				xAxis: {categories: <?php echo $json_computerName; ?>},
				yAxis: {title: {text: 'Passmark score'}},
				series: <?php echo $json_data; ?>,
				credits: {enabled: false},
				plotOptions: {bar: {dataLabels: {enabled: true}}}
			});
		});
	</script>

</body>
</html>