<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Machines list</title>
	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.js"></script> 
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>

</head>
<body>

	<br/><br/><br/><br/>

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

	echo "<table id='hor-minimalist-b'><thead>";
	echo "<tr>
			<th></th>
			<th>Model</th>
			<th>RAM</th>
			<th>CPU</th>
			<th>GPU</th>
			<th>Passmark total score</th>
		</tr></thead><tbody>";

	foreach ($computer_array as $temp){
		echo "<tr>";

		echo "<td><a href='detail_computer.php?name=".$temp->name."'>".$temp->name."</a></td>";
		echo "<td>".$temp->model."</td>";
		echo "<td>".$temp->ram."</td>";

		echo "<td>".$cpu_array[$temp->cpuid]->name."</td>";
		echo "<td>".$gpu_array[$temp->gpuid]->name."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->codename."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->technology."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->package."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->clock."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->clockturbo."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->l1cache."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->l2cache."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->l3cache."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->numcore."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->numthread."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->multiplier."</td>";
		// echo "<td>".$cpu_array[$temp->cpuid]->instructions."</td>";

		// echo "<td>".$temp->gpuid."</td>";
		
		// echo "<td>".$temp->psu."</td>";
		// echo "<td>".$temp->passmarkdiskscore."</td>";		
		// echo "<td>".$temp->passmarkramscore."</td>";		
		echo "<td>".$temp->passmark_total_score."</td>";
		echo "</tr>";
	}

	echo "</tbody></table>\n";

	?>

	<script>
		$(document).ready(function(){ 
			$("#hor-minimalist-b").tablesorter({sortList: [[0,0]]});
		});
	</script>
</body>
</html>
