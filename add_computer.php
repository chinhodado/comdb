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
							<label for="passmark_disk_score" class="col-lg-3 control-label">Passmark disk score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmark_disk_score" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="passmark_ram_score" class="col-lg-3 control-label">Passmark RAM score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmark_ram_score" placeholder="" required>
							</div>
						</div>		
						<div class="form-group">
							<label for="passmark_total_score" class="col-lg-3 control-label">Passmark total score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmark_total_score" placeholder="" required>
							</div>
						</div>
						<div class="form-group">
							<label for="cpuid" class="col-lg-3 control-label">CPU</label>
							<div class="col-lg-5">
								<?php
								include 'dbConnection.php';
								$query = "SELECT * FROM cpu";
								$result = $dbconn->query($query);

								echo "<select name='cpuid' id='cpuid' class='form-control'>";
								while ($line = $result->fetchArray()) {
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
								$query = "SELECT * FROM gpu";
								$result = $dbconn->query($query);

								echo "<select name='gpuid' id='gpuid' class='form-control'>";
								// echo "<option value='0'></option>";
								while ($line2 = $result->fetchArray()) {
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
			// Prepare a query for execution
			$stmt = $dbconn->prepare('INSERT INTO computer(name, model, ram, passmark_disk_score, passmark_ram_score, passmark_total_score, cpuid, gpuid) VALUES (:1, :2, :3, :4, :5, :6, :7, :8)');
			$stmt->bindValue(':1', $_POST['name'], SQLITE3_TEXT);
			$stmt->bindValue(':2', $_POST['model'], SQLITE3_TEXT);
			$stmt->bindValue(':3', $_POST['ram'], SQLITE3_TEXT);
			$stmt->bindValue(':4', $_POST['passmark_disk_score'], SQLITE3_TEXT);
			$stmt->bindValue(':5', $_POST['passmark_ram_score'], SQLITE3_TEXT);
			$stmt->bindValue(':6', $_POST['passmark_total_score'], SQLITE3_TEXT);
			$stmt->bindValue(':7', $_POST['cpuid'], SQLITE3_TEXT);
			$stmt->bindValue(':8', $_POST['gpuid'], SQLITE3_TEXT);

			// Execute the prepared query.
			$result = $stmt->execute();

			echo "<p>Inserted ".$_POST['name']." into the database</p>";
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