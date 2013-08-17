<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Edit computer info</title>
	
	<link href="css/table_style.css" rel="stylesheet" />
	<link href="css/bootstrap.css" rel="stylesheet">

	<script src="js/jquery-1.9.1.js"></script> 
	<script src="js/jquery.tablesorter.js"></script>
	<script src="js/bootstrap.js"></script>
</head>
<body>
	<?php include 'topbar.php'; ?>
	<div class="jumbotron">

		<div>		
			<h1 style="font-size:38px;">Edit computer info</h1>
			<h5>Enter the computer's information below</h5>			
		</div>	
	
		<?php
			include 'dbConnection.php';
			$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());
			$query = "SELECT * FROM comdb.computer WHERE computerid = ".$_POST['comid'].";";
			$result = pg_query($query) or die('Query failed: ' . pg_last_error());
			$line = pg_fetch_array($result);
		?>

		<form action="edit_com.php" method="POST" style="font-size:14px;line-height:20px;" class="form-horizontal">
			<fieldset>

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="name" class="col-lg-3 control-label">Computer name</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="name" value="<?php echo $line[6];?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="ram" class="col-lg-3 control-label">RAM</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="ram" value="<?php echo $line[3];?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="passmarkdiskscore" class="col-lg-3 control-label">Passmark disk score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmarkdiskscore" value="<?php echo $line[5];?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="passmarkramscore" class="col-lg-3 control-label">Passmark RAM score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmarkramscore" value="<?php echo $line[7];?>" required>
							</div>
						</div>		
						<div class="form-group">
							<label for="passmarktotalscore" class="col-lg-3 control-label">Passmark total score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmarktotalscore" value="<?php echo $line[9];?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="cpuid" class="col-lg-3 control-label">CPU</label>
							<div class="col-lg-5">
								<?php
								$query = "SELECT * FROM comdb.cpu";
								$result = pg_query($query) or die('Query failed: ' . pg_last_error());

								echo "<select name='cpuid' class='form-control'>";
								while ($line2 = pg_fetch_array($result)) {
									if ($line2[0]==$line[1]) echo "<option selected value=".$line2[0].">".$line2[1]."</option>";
									else echo "<option value=".$line2[0].">".$line2[1]."</option>";
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
								<input type="text" class="form-control" name="model" value="<?php echo $line[8];?>">
							</div>
						</div>
						<div class="form-group">
							<label for="psu" class="col-lg-1 control-label">PSU</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="psu" value="<?php echo $line[4];?>">
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-lg-offset-5 col-lg-7">
					  <button type="submit" class="btn btn-default" name='submit'>Save</button>
					</div>
				</div>

				<input hidden type="text" id="computerid" name="computerid" value="<?php echo $line[0];?>"/>

			</fieldset>
		</form>		
	</div>
</body>
</html>
