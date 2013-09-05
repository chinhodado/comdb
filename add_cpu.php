<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Add new cpu</title>

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
			<h1 style="font-size:38px;">Add new cpu</h1>
			<h5>Enter the cpu's information below</h5>
		</div>	

		<!-- MAIN CONTENT -->
		<form action="" method="POST" style="font-size:14px;line-height:20px;" class="form-horizontal">		
			<fieldset>
				<div class="row">

					<div class="col-lg-4">
						<div class="form-group">
							<label for="cpuname" class="col-lg-3 control-label">CPU name</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="cpuname" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="technology" class="col-lg-3 control-label">Technology</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="technology" placeholder="22nm? 32nm? ..." required>
							</div>
						</div>
						<div class="form-group">
							<label for="clock" class="col-lg-3 control-label">Clock</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="clock" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="l1cache" class="col-lg-3 control-label">L1 cache</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="l1cache" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="l3cache" class="col-lg-3 control-label">L3 cache</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="l3cache" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="numcore" class="col-lg-3 control-label">Core</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="numcore" placeholder="number of core" required>
							</div>
						</div>
						<div class="form-group">
							<label for="instructions" class="col-lg-3 control-label">Instructions</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="instructions" placeholder="" required>
							</div>
						</div>

						<div class="form-group">
							<div class="col-lg-3"></div>
							<div class="col-lg-8">
								<button type="submit" class="btn btn-default" name="submit">Add</button>
							</div>
						</div>
						
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label for="codename" class="col-lg-3 control-label">Codename</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="codename" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="package" class="col-lg-3 control-label">Package</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="package" placeholder="socket?" required>
							</div>
						</div>
						<div class="form-group">
							<label for="clockturbo" class="col-lg-3 control-label">Clock turbo</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="clockturbo" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="l2cache" class="col-lg-3 control-label">L2 cache</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="l2cache" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="multiplier" class="col-lg-3 control-label">Multiplier</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="multiplier" placeholder="">
							</div>
						</div>
						<div class="form-group">
							<label for="numthread" class="col-lg-3 control-label">Thread</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="numthread" placeholder="number of thread" required>
							</div>
						</div>
						<div class="form-group">
							<label for="passmarkscore" class="col-lg-3 control-label">Passmark score</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="passmarkscore" placeholder="" required>
							</div>
						</div>

					</div>

				</div>
				
			</fieldset>
		</form>
	</div>

	<?php
	if (array_key_exists('submit', $_POST))
	{
		// Establish the connection
		include 'dbConnection.php';

		// Prepare a query for execution
		$stmt = $dbconn->prepare('INSERT INTO cpu(technology, name, package, clock, clockturbo, l1cache, l2cache, l3cache, numcore, passmarkscore, codename, instructions, multiplier, numthread) 
													VALUES (:1, :2, :3, :4, :5, :6, :7, :8, :9, :10, :11, :12, :13, :14)');
		$stmt->bindValue(':1', $_POST['technology']);
		$stmt->bindValue(':2', $_POST['cpuname']);
		$stmt->bindValue(':3', $_POST['package']);
		$stmt->bindValue(':4', $_POST['clock']);
		$stmt->bindValue(':5', $_POST['clockturbo']);
		$stmt->bindValue(':6', $_POST['l1cache']);
		$stmt->bindValue(':7', $_POST['l2cache']);
		$stmt->bindValue(':8', $_POST['l3cache']);
		$stmt->bindValue(':9', $_POST['numcore']);
		$stmt->bindValue(':10', $_POST['passmarkscore']);
		$stmt->bindValue(':11', $_POST['codename']);
		$stmt->bindValue(':12', $_POST['instructions']);
		$stmt->bindValue(':13', $_POST['multiplier']);
		$stmt->bindValue(':14', $_POST['numthread']);

		// Execute the prepared query.
		$result = $stmt->execute();

		echo "<p>Inserted ".$_POST['cpuname']." into the database</p>";

	}
	?>

</body>
</html>