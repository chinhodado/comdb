<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>CPU list</title>
	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.js"></script> 
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>

</head>
<body>
	<?php include 'topbar.php'; ?>

	<br/><br/><br/><br/>

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
		//array_push($cpu_array, $temp);
		$cpu_array[$line[0]] = $temp; 
	}

	echo "<table id='hor-minimalist-b'>";
	echo "<tr>
		<td>Name</td>
		<td>Code name</td>
		<td>Technology</td>
		<td>Package</td>
		<td>Clock</td>
		<td>Clock turbo</td>
		<td>L1 Cache</td>
		<td>L2 Cache</td>
		<td>L3 Cache</td>
		
		<td>Core</td>
		<td>Thread</td>

		<td>Multiplier</td>
		<td>Instructions</td>

		<td>Passmark score</td>
	</tr>";

	foreach ($cpu_array as $temp){
		echo "<tr>";
		//echo "<td>".$temp->cpuid."</td>";
		echo "<td>".$temp->name."</td>";
		echo "<td>".$temp->codename."</td>";
		echo "<td>".$temp->technology."</td>";
		echo "<td>".$temp->package."</td>";
		echo "<td>".$temp->clock."</td>";
		echo "<td>".$temp->clockturbo."</td>";
		echo "<td>".$temp->l1cache."</td>";
		echo "<td>".$temp->l2cache."</td>";
		echo "<td>".$temp->l3cache."</td>";

		echo "<td>".$temp->numcore."</td>";
		echo "<td>".$temp->numthread."</td>";		
		
		echo "<td>".$temp->instructions."</td>";
		echo "<td>".$temp->multiplier."</td>";

		echo "<td>".$temp->passmarkscore."</td>";

		echo "</tr>";
	}


	echo "</table>\n";

	// Free resultset
	pg_free_result($result);

	// Closing connection
	pg_close($dbconn);
	?>

</body>
</html>
