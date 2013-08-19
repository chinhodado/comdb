<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Computer detail</title>

	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.js"></script> 
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>
	<script>
	function change(event, name){
		var image = document.getElementById('mainimage');
		pos_x = event.offsetX?(event.offsetX):event.pageX-document.getElementById("pointer_div").offsetLeft;
		pos_y = event.offsetY?(event.offsetY):event.pageY-document.getElementById("pointer_div").offsetTop;
		if (pos_y>=32&&pos_y<=48) {
			if (pos_x>=10 && pos_x<48) image.setAttribute('src', 'images/'+name+'/cpuz_1_cpu.jpg');
			else if (pos_x>=48 && pos_x<96) image.setAttribute('src', 'images/'+name+'/cpuz_2_caches.jpg');
			else if (pos_x>=96 && pos_x<156) image.setAttribute('src', 'images/'+name+'/cpuz_3_mainboard.jpg');
			else if (pos_x>=156 && pos_x<208) image.setAttribute('src', 'images/'+name+'/cpuz_4_memory.jpg');
			else if (pos_x>=208 && pos_x<250) image.setAttribute('src', 'images/'+name+'/cpuz_5_spd.jpg');
			else if (pos_x>=250 && pos_x<302) image.setAttribute('src', 'images/'+name+'/cpuz_6_graphic.jpg');
		};
	}

	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
			results = regex.exec(location.search);
		return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	</script>
	
</head>
<body style="padding-top: 50px;background-color:#162726;">
	<?php include 'topbar.php'; ?>
	<div style="height:490px;background-color:#162d42;">
		<img style="float:right;" id="gpuimage">
		<img style="float:right;" onclick="change(event, getParameterByName('name'))" id="mainimage">


		<script>
			document.getElementById('mainimage').setAttribute('src', 'images/'+ getParameterByName('name') + '/cpuz_1_cpu.jpg');
		</script>

		<?php
			include 'dbConnection.php';
			$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());
			$query = "SELECT * FROM comdb.computer WHERE name = '".$_GET["name"]."';";
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
			$line = pg_fetch_array($result);

			$queryCPU = "SELECT * FROM comdb.cpu WHERE cpuid = '".$line[1]."';";
			$resultCPU = pg_query($queryCPU) or die('Query failed: ' . pg_last_error());
			$lineCPU = pg_fetch_array($resultCPU);

			$queryGPU = "SELECT * FROM comdb.gpu WHERE gpuid = '".$line[2]."';";
			$resultGPU = pg_query($queryGPU) or die('Query failed: ' . pg_last_error());
			$lineGPU = pg_fetch_array($resultGPU);
		?>
		<div style="color:#BBDAF9; padding-top: 50px; padding-left: 50px;">
			<p>Name: <?php echo $line[6];?></p>
			<p>Model: <?php echo $line[8];?></p>
			<p>CPU: <?php echo $lineCPU[1];?></p>
			<p>RAM: <?php echo $line[3];?></p>
			<p>GPU: <?php echo $lineGPU[1];?></p>
		</div>
		
	</div>


	<div style="height:auto;background-color:#162726;">

	</div>
	<script>
		document.getElementById('gpuimage').setAttribute('src', 'images/'+ getParameterByName('name') + '/gpuz.jpg');
	</script>

</body>
</html>