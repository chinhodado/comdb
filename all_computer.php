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
	<script>
		function send(comid){
			$.ajax({
				type: 'POST',
				dataType: 'html',
				url: 'edit_computer.php',
				data: {comid: comid},
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
	// Fetch computer list
	//////////////////////////////////////

	$query = "select * from comdb.computer;";
	$result = pg_query($query) or die('Query failed: ' . pg_last_error());

	$computer_array = array();

	while ($line = pg_fetch_array($result)) {
		$temp = new Computer($line[0], $line[1], $line[2], $line[3], $line[4], $line[5], $line[6], $line[7], $line[8], $line[9]);
		array_push($computer_array, $temp);
	}

	echo "<table id='hor-minimalist-b'>";
	echo "<tr>
			<td></td>
			<td>Model</td>
			<td>RAM</td>

			<td style='background:#f0b746;'>CPU</td>
			<td>CPU name</td>
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
		</tr>";

	foreach ($computer_array as $temp){	//number of computer
		echo "<tr>";
		//echo "<td>".$temp->computerid."</td>";
		echo "<td onclick='send(".$temp->computerid.")'>".$temp->name."</td>";
		echo "<td>".$temp->model."</td>";
		echo "<td>".$temp->ram."</td>";

		echo "<td style='background:#f0b746;'></td>";
		echo "<td>".$cpu_array[$temp->cpuid]->name."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->codename."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->technology."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->package."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->clock."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->clockturbo."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->l1cache."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->l2cache."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->l3cache."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->numcore."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->numthread."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->multiplier."</td>";
		echo "<td>".$cpu_array[$temp->cpuid]->instructions."</td>";

		//echo "<td>".$temp->gpuid."</td>";
		
		echo "<td>".$temp->psu."</td>";
		//echo "<td>".$temp->passmarkdiskscore."</td>";		
		//echo "<td>".$temp->passmarkramscore."</td>";		
		//echo "<td>".$temp->passmarktotalscore."</td>";
		echo "</tr>";
	}

	echo "</table>\n";

	// Free resultset
	pg_free_result($result);

	// Closing connection
	pg_close($dbconn);
	?>

	<script>//reverse the table
		$(document).ready(function(){
			$("table").each(function() {
				var $this = $(this);
				var newrows = [];
				$this.find("tr").each(function(){
					var i = 0;
					$(this).find("td").each(function(){
						i++;
						if(newrows[i] === undefined) { newrows[i] = $("<tr></tr>"); }
						newrows[i].append($(this));
					});
				});
				$this.find("tr").remove();
				$.each(newrows, function(){
					$this.append(this);
				});
			});
			return false;
		});
	</script>

</body>
</html>
