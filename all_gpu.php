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
	<script>
		function send(gpuid){
			$.ajax({
				type: 'POST',
				dataType: 'html',
				url: 'edit_gpu.php',
				data: {gpuid: gpuid},
				success: function(data){
					// Replace the whole body with the new HTML page
					var newDoc = document.open('text/html', 'replace');
					newDoc.write(data);
					newDoc.close();
				}

			});
		}
	</script>
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

	echo "<table id='hor-minimalist-b'>";
	echo "<tr>
		<td>Name</td>
		<td>GPU clock</td>
		<td>Bandwidth</td>
		<td>Memclock</td>
		<td>Passmark 2D score</td>
		<td>Passmark 3D score</td>
	</tr>";

	foreach ($gpu_array as $temp){
		echo "<tr>";
		//echo "<td>".$temp->gpuid."</td>";
		echo "<td onclick='send(".$temp->gpuid.")'>".$temp->name."</td>";
		echo "<td>".$temp->gpuclock."</td>";
		echo "<td>".$temp->bandwidth."</td>";
		echo "<td>".$temp->memclock."</td>";
		
		echo "<td>".$temp->passmarkscore2D."</td>";
		echo "<td>".$temp->passmarkscore3D."</td>";

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
