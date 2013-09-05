<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>All computer charts - Spider</title>

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

		//initialize ignore list
		$arrayIgnore = array();
		//array_push($arrayIgnore,"IMG Beta", "IMG Alpha", "Primrose", "Asgard"); //let's try removing Beta and Alpha, by name


		/////////////////////////////////////
		// Get the max scores
		/////////////////////////////////////
		$arrayScoreCPU = array();
		$arrayScore2D = array();
		$arrayScore3D = array();
		$arrayScoreRAM = array();
		$arrayScoreDisk = array();

		foreach ($computer_array as $temp) {
			if (in_array($temp->name, $arrayIgnore)) continue;//if the name is in the ban list, skip it
			else {//populate the score arrays
				array_push($arrayScoreCPU, $cpu_array[$temp->cpuid]->passmarkscore);
				array_push($arrayScore2D,$gpu_array[$temp->gpuid]->passmarkscore2D);
				array_push($arrayScore3D,$gpu_array[$temp->gpuid]->passmarkscore3D);
				array_push($arrayScoreRAM,$temp->passmark_ram_score);
				array_push($arrayScoreDisk,$temp->passmark_disk_score);
			}
		}

		//now the actual max scores
		$maxCPU = max($arrayScoreCPU);
		$max2D = max($arrayScore2D);
		$max3D = max($arrayScore3D);
		$maxRAM = max($arrayScoreRAM);
		$maxDisk = max($arrayScoreDisk);

		////////////////////////////////////////
		// Print out the charts
		////////////////////////////////////////

		$counter = 1;

		echo "<script> var arrayMax = [{$maxCPU},{$max2D},{$max3D},{$maxRAM},{$maxDisk}];</script>";

		foreach ($computer_array as $temp){
			if (in_array($temp->name, $arrayIgnore)) continue;
			else {
			echo "<div style='float:left; margin-left:50px;height:600px;'>";
			echo "<canvas id='myChart{$counter}' width='400' height='400' ></canvas>";
			echo "<p style='text-align:center;'> {$temp->name} </p>";
			echo "</div>";

			echo "<script>";
			echo "var arrayCom = [{$cpu_array[$temp->cpuid]->passmarkscore},{$gpu_array[$temp->gpuid]->passmarkscore2D},{$gpu_array[$temp->gpuid]->passmarkscore3D},{$temp->passmark_ram_score},{$temp->passmark_disk_score}];";
			echo "printChart('myChart{$counter}', arrayCom, arrayMax);";
			echo "</script>";
			$counter++;}
		}

	?>

	</div>
</body>
</html>