<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Add new gpu</title>

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
			<h1 style="font-size:38px;">Add new gpu</h1>
			<h5>Enter the gpu's information below</h5>
		</div>	

		<!-- MAIN CONTENT -->
		<form action="" method="POST" style="font-size:14px;line-height:20px;" class="form-horizontal">		
				<div class="row">

					<div class="col-lg-4">
						<div class="form-group">
							<label for="gpuname" class="col-lg-4 control-label">GPU name</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="gpuname" placeholder="" required>
							</div>
						</div>


						<div class="form-group">
							<label for="bandwidth" class="col-lg-4 control-label">Bandwidth</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="bandwidth" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="passmarkscore2D" class="col-lg-4 control-label">Passmark score 2D</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="passmarkscore2D" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-4"></div>
							<div class="col-lg-8">
								
							</div>
						</div>
						
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label for="gpuclock" class="col-lg-4 control-label">GPU clock</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="gpuclock" placeholder="">
							</div>
						</div>						
						<div class="form-group">
							<label for="memclock" class="col-lg-4 control-label">Memory clock</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="memclock" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="passmarkscore3D" class="col-lg-4 control-label">Passmark score 3D</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" id="passmarkscore3D" placeholder="" required>
							</div>
						</div>
					</div>
				</div>
				<input type="submit" name='submit' value='Add' class="btn btn-default">
				
		</form>
	</div>

			<?php
			if (array_key_exists('gpuname', $_POST) && array_key_exists('passmarkscore2D', $_POST) && array_key_exists('passmarkscore3D', $_POST))
			{
				include 'dbConnection.php';

				// Establish the connection
				$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());

				// Performing SQL query
				$query = "INSERT INTO comdb.gpu(name, passmarkscore2D, passmarkscore3D, gpuclock, bandwidth, memclock) VALUES('";
					$query .= $_POST['name'];
					$query .= "', ";
					$query .= $_POST['passmarkscore2D'];
					$query .= ", ";
					$query .= $_POST['passmarkscore3D'];
					$query .= ", '";
					$query .= $_POST['gpuclock'];
					$query .= "', '";
					$query .= $_POST['bandwidth'];
					$query .= "', '";
					$query .= $_POST['memclock'];
					$query .= "');";

					$result = pg_query($query) or die('Query failed: ' . pg_last_error());

					echo "<p>Inserted ".$_POST['gpuname']." into the database</p>";

					// Free resultset
					pg_free_result($result);

					// Closing connection
					pg_close($dbconn);
					}
			?>

</body>
</html>