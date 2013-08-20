<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>GPU list</title>
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
	// Fetch GPU list
	//////////////////////////////////////

	$query = "select * from comdb.gpu;";
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());

	$gpu_array = array();

	while ($line = pg_fetch_array($result)) {
		$temp = new GPU($line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6]);
		//array_push($cpu_array, $temp);
		$gpu_array[$line[0]] = $temp; 
	}

	echo "<table id='hor-minimalist-b'><thead>";
	echo "<tr>
		<th>Name</th>
		<th>GPU clock</th>
		<th>Bandwidth</th>
		<th>Memclock</th>
		<th>Passmark 2D score</th>
		<th>Passmark 3D score</th>
	</tr></thead><tbody>";

	foreach ($gpu_array as $temp){
		echo "<tr>";
		echo "<td> <a href='edit_gpu.php?gpuid=".$temp->gpuid."'>".$temp->name."</a></td>";
		echo "<td>".$temp->gpuclock."</td>";
		echo "<td>".$temp->bandwidth."</td>";
		echo "<td>".$temp->memclock."</td>";
		
		echo "<td>".$temp->passmarkscore2D."</td>";
		echo "<td>".$temp->passmarkscore3D."</td>";

		echo "</tr>";
	}


	echo "</tbody></table>\n";

	// Free resultset
	pg_free_result($result);

	// Closing connection
	pg_close($dbconn);
	?>

	<script>
		$(document).ready(function(){ 
			$("#hor-minimalist-b").tablesorter({sortList: [[0,0]]});
		});
	</script>

</body>
</html>
