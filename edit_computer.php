<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Edit computer info</title>
	
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
	<!-- <link rel="stylesheet" href="css/form.css"> -->
</head>
<body>

	<!-- HEADER -->
	<div id="header">		
		<div class="page-full-width cf">	
			<div id="login-intro" class="fl">			
				<h1>Edit computer info</h1>
				<h5>Enter the computer's information below</h5>			
			</div>
		</div>
	</div>	
	
	<!-- MAIN CONTENT -->

	<?php
		include 'dbConnection.php';
		$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());
		$query = "SELECT * FROM comdb.computer WHERE computerid = ".$_POST['comid'].";";
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		$line = pg_fetch_array($result);
	?>

	<div id="content">	
		<form action="edit_com.php" method="POST" id="login-form">
			<fieldset>

				<input hidden type="text" id="computerid" name="computerid" value="<?php echo $line[0];?>"/>
				<p>
					<label for="name">Computer name:</label>
					<input type="text" id="name" name="name" value="<?php echo $line[6];?>" autofocus required/>
				</p>

				<p>
					<label for="model">Model:</label>
					<input type="text" id="model" name="model" value="<?php echo $line[8];?>"/>
				</p>

				<p>
					<label for="ram">RAM:</label>
					<input type="text" id="ram" name="ram" value="<?php echo $line[3];?>" required/>
				</p>

				<p>
					<label for="psu">PSU:</label>
					<input type="text" id="psu" name="psu" value="<?php echo $line[4];?>"/>
				</p>

				<p>
					<label for="passmarkdiskscore">Passmark disk score:</label>
					<input type="text" id="passmarkdiskscore" name="passmarkdiskscore" value="<?php echo $line[5];?>"/>
				</p>

				<p>
					<label for="passmarkramscore">Passmark RAM score:</label>
					<input type="text" id="passmarkramscore" name="passmarkramscore" value="<?php echo $line[7];?>"/>
				</p>

				<p>
					<label for="passmarktotalscore">Passmark total score:</label>
					<input type="text" id="passmarktotalscore" name="passmarktotalscore" value="<?php echo $line[9];?>" required/>
				</p>

				<?php
				//$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());
				$query = "SELECT * FROM comdb.cpu";
				$result = pg_query($query) or die('Query failed: ' . pg_last_error());

				echo "CPU: <select name='cpuid'>";
				while ($line2 = pg_fetch_array($result)) {
					if ($line2[0]==$line[1]) echo "<option selected value=".$line2[0].">".$line2[1]."</option>";
					else echo "<option value=".$line2[0].">".$line2[1]."</option>";
				}
				echo "</select><br/>";
				?>

				<input class="button round blue image-right ic-right-arrow" type="submit" name="bAdd" value="Change" />
			</fieldset>

		</form>


		
	</div> <!-- end content -->
</body>
</html>