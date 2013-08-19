<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Chart</title>
	<script type="text/javascript" src="js/Chart.js"></script>

	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.js"></script> 
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>	

</head>
<body>

	<?php include 'topbar.php';?>

	<div class="jumbotron">
      
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
		$computer_array[$line[0]] = $temp; 
		//array_push($computer_array, $temp);
	}

	//////////////////////////////////////
	// Process form submisssion
	//////////////////////////////////////	
	if (array_key_exists('submit', $_POST))
	{
		$computer1 = $computer_array[$_POST['computerid1']];
		$computer2 = $computer_array[$_POST['computerid2']];
		$cpu1 = $cpu_array[$computer1->cpuid];
		$cpu2 = $cpu_array[$computer2->cpuid];
		$gpu1 = $gpu_array[$computer1->gpuid];
		$gpu2 = $gpu_array[$computer2->gpuid];
		echo "<script>";
		echo "var array1=[".$cpu1->passmarkscore.",".$gpu1->passmarkscore2D.",".$gpu1->passmarkscore3D.",".$computer1->passmarkramscore.",".$computer1->passmarkdiskscore."];";
		echo "var array2=[".$cpu2->passmarkscore.",".$gpu2->passmarkscore2D.",".$gpu2->passmarkscore3D.",".$computer2->passmarkramscore.",".$computer2->passmarkdiskscore."];";
		echo "</script>";
	}?>

	<br>

	<form id='computerform1' method='POST' style='font-size:14px;line-height:20px;' class='form-horizontal'>
		<div class='row'>
			<label for='computerid1' class='col-lg-2 control-label'>Computer 1</label>
			<div class='col-lg-2'>
				<select name='computerid1' id='computerid1' class='form-control col-lg-3'>
				<?php
				//////////////////////////////////////
				// Populate select boxes 
				// (have to put this after the form submission processing code in order to set the default selected option in the select boxes)
				// remove einherjar (id=5) from the list
				//////////////////////////////////////					

				//firat select box				
				foreach ($computer_array as $temp){
					if(isset($computer1)&&$computer1->computerid==$temp->computerid) echo "<option value=".$temp->computerid." selected='selected'>".$temp->name."</option>\n";
					else echo "<option value=".$temp->computerid.">".$temp->name."</option>\n";
				}
				?>
				</select>
			</div>

			<div class="col-lg-1"></div>

			<label for='computerid2' class='col-lg-2 control-label'>Computer 2</label>
			<div class='col-lg-2'>
				<select name='computerid2' id='computerid2' class='form-control col-lg-3'>
				<?php
				//second select box
				foreach ($computer_array as $temp){
					if(isset($computer2)&&$computer2->computerid==$temp->computerid) echo "<option value=".$temp->computerid." selected='selected'>".$temp->name."</option>\n";
					else echo "<option value=".$temp->computerid.">".$temp->name."</option>\n";
				}?>
				</select>
			</div>

			<button type='submit' name='submit' class='btn btn-default'>Go</button>
		</div>
	</form>

	<?php
	// Free resultset
	pg_free_result($result);

	// Closing connection
	pg_close($dbconn);
	?>

		<div class="row">
			<div class='col-lg-4'>				
				<canvas style="float:right;" id="myChart1" width="400" height="400"></canvas>
			</div>

			<div class='col-lg-1'></div>

			<div class='col-lg-4'>				
				<canvas style="float:right;" id="myChart2" width="400" height="400"></canvas>
			</div>
		</div>


		<script>
			//Get the context of the canvas element we want to select
			var ctx1 = document.getElementById("myChart1").getContext("2d");
			var ctx2 = document.getElementById("myChart2").getContext("2d");

			var arrayMax = new Array();

			for (i=0; i<5; i++){
				arrayMax[i] = Math.max(array1[i], array2[i]);
				array1[i] = array1[i] / arrayMax[i] * 100;
				array2[i] = array2[i] / arrayMax[i] * 100;
			}

			var data1 = {
				labels : ["CPU","2D","3D","Memory","Disk"],
				datasets : [
					{
						fillColor : "rgba(220,220,220,0.5)",
						strokeColor : "rgba(220,220,220,1)",
						pointColor : "rgba(220,220,220,1)",
						pointStrokeColor : "#fff",
						data : array1
					}
				]
			}

			var data2 = {
				labels : ["CPU","2D","3D","Memory","Disk"],
				datasets : [
					{
						fillColor : "rgba(151,187,205,0.5)",
						strokeColor : "rgba(151,187,205,1)",
						pointColor : "rgba(151,187,205,1)",
						pointStrokeColor : "#fff",
						data : array2
					}
				]
			}

			var myChart1 = new Chart(ctx1).Radar(data1, {scaleOverlay:true, scaleOverride:true, scaleSteps:10, scaleStepWidth:10, scaleStartValue:0});
			var myChart2 = new Chart(ctx2).Radar(data2, {scaleOverlay:true, scaleOverride:true, scaleSteps:10, scaleStepWidth:10, scaleStartValue:0});
		</script>
	
	</div>
</body>
</html>
