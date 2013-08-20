<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Add new computer</title>
	
	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.js"></script> 
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>
</head>
<body>
	<?php include 'topbar.php'; ?>
	<div class="jumbotron">

		<!-- HEADER -->
		<div>		
			<h1 style="font-size:38px;">Add new computer</h1>
			<h5>Enter the computer's information below</h5>			
		</div>	
	
		<!-- MAIN CONTENT -->
		<form action="" method="POST" style="font-size:14px;line-height:20px;" class="form-horizontal">		
			<fieldset>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="name" class="col-lg-3 control-label">Computer name</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="name" placeholder="" required>
							</div>
						</div>

						<div class="form-group">
							<label for="ram" class="col-lg-3 control-label">RAM</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="ram" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="passmarkdiskscore" class="col-lg-3 control-label">Passmark disk score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmarkdiskscore" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="passmarkramscore" class="col-lg-3 control-label">Passmark RAM score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmarkramscore" placeholder="" required>
							</div>
						</div>		
						<div class="form-group">
							<label for="passmarktotalscore" class="col-lg-3 control-label">Passmark total score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmarktotalscore" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="cpuid" class="col-lg-3 control-label">CPU</label>
							<div class="col-lg-5">
								<?php
								include 'dbConnection.php';
								$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());
								$query = "SELECT * FROM comdb.cpu";
								$result = pg_query($query) or die('Query failed: ' . pg_last_error());

								echo "<select name='cpuid' id='cpuid' class='form-control'>";
								while ($line = pg_fetch_array($result)) {
									echo "<option value=".$line[0].">".$line[1]."</option>";
								}
								echo "</select><br/>";
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="cpuid" class="col-lg-3 control-label">GPU</label>
							<div class="col-lg-5">
								<?php
								$query = "SELECT * FROM comdb.gpu";
								$result = pg_query($query) or die('Query failed: ' . pg_last_error());
								echo "<select name='gpuid' id='gpuid' class='form-control'>";
								// echo "<option value='0'></option>";
								while ($line2 = pg_fetch_array($result)) {
									echo "<option value=".$line2[0].">".$line2[1]."</option>";
								}
								echo "</select><br/>";
								?>
							</div>
						</div>							
					</div>

					<div class="col-lg-6">
						<div class="form-group">
							<label for="model" class="col-lg-1 control-label">Model</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="model" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="psu" class="col-lg-1 control-label">PSU</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="psu" placeholder="">
							</div>
						</div>						
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-lg-offset-5 col-lg-7">
					  <button type="submit" class="btn btn-default" name='submit'>Add</button>
					</div>
				</div>

			</fieldset>
		</form>
	
		<?php
		if (array_key_exists('submit', $_POST))
		{
			// Establish the connection
			$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());

			// Performing SQL query
			$query = "INSERT INTO comdb.computer(name, model, ram, psu, passmarkdiskscore, passmarkramscore, passmarktotalscore, cpuid, gpuid) VALUES('";
			$query .= $_POST['name'];
			$query .= "', '";
			$query .= $_POST['model'];
			$query .= "', '";
			$query .= $_POST['ram'];
			$query .= "', '";
			$query .= $_POST['psu'];
			$query .= "', '";
			$query .= $_POST['passmarkdiskscore'];
			$query .= "', '";
			$query .= $_POST['passmarkramscore'];
			$query .= "', '";
			$query .= $_POST['passmarktotalscore'];
			$query .= "', '";
			$query .= $_POST['cpuid'];
			$query .= "', '";
			$query .= $_POST['gpuid'];
			$query .= "');";

			$result = pg_query($query) or die('Query failed: ' . pg_last_error());

			echo "<p>Inserted ".$_POST['name']." into the database</p>";

			// Free resultset
			pg_free_result($result);

			// Closing connection
			pg_close($dbconn);
		}
		?>
	<script>
		// sort the CPU Select box
		$("#cpuid").html($("#cpuid option").sort(function (a, b) {
			return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
		}))
		// sort the GPU Select box
		$("#gpuid").html($("#gpuid option").sort(function (a, b) {
			return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
		}))
	</script>
		
	</div>
</body>
</html>