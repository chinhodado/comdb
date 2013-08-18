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
		var image = document.getElementById('image');
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
<body style="padding-top: 50px;">
	<?php include 'topbar.php'; ?>
	<div style="height:410px;background-color:#162d42;">
		<img style="float:right;" onclick="change(event, getParameterByName('name'))" id="image">

		<script>
			document.getElementById('image').setAttribute('src', 'images/'+ getParameterByName('name') + '/cpuz_1_cpu.jpg');
		</script>

		<div style="color:#BBDAF9; padding-top: 50px; padding-left: 50px;">
			<p>Name: Tsubasa</p>
			<p>CPU: amd c60</p>
			<p>Ram: something</p>
			<p>gpu; something</p>
		</div>
		
	</div>


	<div style="height:auto;background-color:#162726;">
		<img src="images/Tsubasa/gpuz.jpg">
	</div>

</body>
</html>