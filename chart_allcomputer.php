<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>All computer charts</title>

	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.js"></script> 
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>
	<script type="text/javascript" src="js/Chart.js"></script>
	<script>

	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	function printChart(id, arrayCom, arrayMax){
		//Get the context of the canvas element we want to select
		var ctx1 = document.getElementById(id).getContext("2d");

		for (i=0; i<5; i++){
			arrayCom[i] = arrayCom[i] / arrayMax[i] * 100;
		}

		var data = {
			labels : ["CPU","2D","3D","Memory","Disk"],
			datasets : [
				{
					fillColor : "rgba(220,220,220,0.5)",
					strokeColor : "rgba(220,220,220,1)",
					pointColor : "rgba(220,220,220,1)",
					pointStrokeColor : "#fff",
					data : arrayCom
				}
			]
		}

		var myChart1 = new Chart(ctx1).Radar(data, {scaleOverlay:true, scaleOverride:true, scaleSteps:5, scaleStepWidth:20, scaleStartValue:0, scaleLineColor:"rgba(255, 255, 255, 0.498039)"});			
	}
	</script>
	
</head>
<body style="padding-top: 50px;background-color:#162726;">
	<?php include 'topbar.php'; ?>

	<div style="height:auto;background-color:#162726; color:rgba(255,255,255,0.5);">

		<?php
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
		$query = "SELECT MAX(passmarkscore) from comdb.cpu;";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$line = pg_fetch_array($result);
		$maxCPU = $line[0];

		$query = "SELECT MAX(passmarkdiskscore) from comdb.computer;";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$line = pg_fetch_array($result);
		$maxDisk = $line[0];

		$query = "SELECT MAX(passmarkramscore) from comdb.computer;";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$line = pg_fetch_array($result);
		$maxRAM = $line[0];

		$query = "SELECT MAX(passmarkscore2D) from comdb.gpu;";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$line = pg_fetch_array($result);
		$max2D = $line[0];

		$query = "SELECT MAX(passmarkscore3D) from comdb.gpu;";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$line = pg_fetch_array($result);
		$max3D = $line[0];

		////////////////////////////////////////
		// Print out the charts
		////////////////////////////////////////

		$counter = 1;

		echo "<script> var arrayMax = [{$maxCPU},{$max2D},{$max3D},{$maxRAM},{$maxDisk}];</script>";

		foreach ($computer_array as $temp){
			echo "<div style='float:left; margin-left:50px;'>";
			echo "<canvas id='myChart{$counter}' width='400' height='400' ></canvas>";
			echo "<p style='text-align:center;'> {$temp->name} </p>";
			echo "</div>";

			echo "<script>";
			echo "var arrayCom = [{$cpu_array[$temp->cpuid]->passmarkscore},{$gpu_array[$temp->gpuid]->passmarkscore2D},{$gpu_array[$temp->gpuid]->passmarkscore3D},{$temp->passmarkramscore},{$temp->passmarkdiskscore}];";
			echo "printChart('myChart{$counter}', arrayCom, arrayMax);";
			echo "</script>";
			$counter++;
		}

	?>

	</div>
</body>
</html>