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
	<script type="text/javascript" src="js/Chart.js"></script>
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
	<div style="height:525px;background-color:#162d42;">
		<img style="float:right; margin-top:20px; margin-right:20px;" id="gpuimage">
		<img style="float:right; margin-top:20px; margin-right:20px;" onclick="change(event, getParameterByName('name'))" id="mainimage">


		<script>
			//make the tabs viewable onclick
			document.getElementById('mainimage').setAttribute('src', 'images/'+ getParameterByName('name') + '/cpuz_1_cpu.jpg');

			//set the gpu image
			document.getElementById('gpuimage').setAttribute('src', 'images/'+ getParameterByName('name') + '/gpuz.jpg');
		</script>

		<?php
			//get the info for this computer
			include 'dbConnection.php';
			$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());
			$query = "SELECT * FROM comdb.computer WHERE name = '".$_GET["name"]."';";
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
			$lineCom = pg_fetch_array($result);

			$queryCPU = "SELECT * FROM comdb.cpu WHERE cpuid = '".$lineCom[1]."';";
			$resultCPU = pg_query($queryCPU) or die('Query failed: ' . pg_last_error());
			$lineCPU = pg_fetch_array($resultCPU);

			$queryGPU = "SELECT * FROM comdb.gpu WHERE gpuid = '".$lineCom[2]."';";
			$resultGPU = pg_query($queryGPU) or die('Query failed: ' . pg_last_error());
			$lineGPU = pg_fetch_array($resultGPU);
		?>
		<div style="color:#BBDAF9; padding-top: 50px; padding-left: 80px;">
			<h1>Name: <?php echo $lineCom[6];?></h1>
			<p>Model: <?php echo $lineCom[8];?></p>
			<p>CPU: <?php echo $lineCPU[1];?></p>
			<p>RAM: <?php echo $lineCom[3];?></p>
			<p>GPU: <?php echo $lineGPU[1];?></p>
			<button type="button" class="btn btn-default" name='submit' onclick="location.href='edit_computer.php?computerid=<?php echo $lineCom[0];?>';">Edit</button>
		</div>
		
	</div>

	<div style="height:auto;background-color:#162726; color:rgba(255,255,255,0.5);">

		<?php
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

		?>

		<canvas id="myChart1" width="400" height="400" style="float:left; margin-left:50px;"></canvas>

		<div style="float:left; padding-top: 80px; padding-left: 350px;padding-right: 50px;">
			<h1>Passmark total score: <?php echo $lineCom[9];?></h1>
			<p>Passmark CPU score: <?php echo $lineCPU[9];?></p>
			<p>Passmark disk score: <?php echo $lineCom[5];?></p>
			<p>Passmark RAM score: <?php echo $lineCom[7];?></p>
			<p>Passmark 2D score: <?php echo $lineGPU[2];?></p>
			<p>Passmark 3D score: <?php echo $lineGPU[3];?></p>
		</div>

		<script>
			//Get the context of the canvas element we want to select
			var ctx1 = document.getElementById("myChart1").getContext("2d");

			var arrayMax = [<?php echo $maxCPU;?>, <?php echo $max2D;?>, <?php echo $max3D;?>, <?php echo $maxRAM;?>, <?php echo $maxDisk;?>];
			var array2 = [<?php echo $lineCPU[9];?>, <?php echo $lineGPU[2];?>, <?php echo $lineGPU[3];?>, <?php echo $lineCom[7];?>, <?php echo $lineCom[5];?>];

			for (i=0; i<5; i++){
				array2[i] = array2[i] / arrayMax[i] * 100;
			}

			var data = {
				labels : ["CPU","2D","3D","Memory","Disk"],
				datasets : [
					{
						fillColor : "rgba(220,220,220,0.5)",
						strokeColor : "rgba(220,220,220,1)",
						pointColor : "rgba(220,220,220,1)",
						pointStrokeColor : "#fff",
						data : array2
					}
				]
			}

			var myChart1 = new Chart(ctx1).Radar(data, {scaleOverlay:true, scaleOverride:true, scaleSteps:5, scaleStepWidth:20, scaleStartValue:0, scaleLineColor:"rgba(255, 255, 255, 0.498039)"});			
		</script>

	</div>
</body>
</html>