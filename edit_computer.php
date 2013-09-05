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
			$stmt = $dbconn->prepare("SELECT * FROM computer WHERE computerid = :1");
			$stmt->bindValue(':1', $_GET['computerid']);

			$result = $stmt->execute();
			$line = $result->fetchArray();
		?>

		<form action="edit_com.php" method="POST" style="font-size:14px;line-height:20px;" class="form-horizontal">
			<fieldset>

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="name" class="col-lg-3 control-label">Computer name</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="name" value="<?php echo $line[8];?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="ram" class="col-lg-3 control-label">RAM</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="ram" value="<?php echo $line[6];?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="passmark_disk_score" class="col-lg-3 control-label">Passmark disk score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmark_disk_score" value="<?php echo $line[2];?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="passmark_ram_score" class="col-lg-3 control-label">Passmark RAM score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmark_ram_score" value="<?php echo $line[1];?>" required>
							</div>
						</div>		
						<div class="form-group">
							<label for="passmark_total_score" class="col-lg-3 control-label">Passmark total score</label>
							<div class="col-lg-5">
								<input type="text" class="form-control" name="passmark_total_score" value="<?php echo $line[0];?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="cpuid" class="col-lg-3 control-label">CPU</label>
							<div class="col-lg-5">
								<?php
								$query = "SELECT * FROM cpu";
								$result = $dbconn->query($query);

								echo "<select name='cpuid' id='cpuid' class='form-control'>";
								while ($line2 = $result->fetchArray()) {
									if ($line2[0]==$line[5]) echo "<option selected value=".$line2[0].">".$line2[1]."</option>";
									else echo "<option value=".$line2[0].">".$line2[1]."</option>";
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
								while ($line2 = $result->fetchArray()) {
									if ($line2[0]==$line[4]) echo "<option selected value=".$line2[0].">".$line2[1]."</option>";
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
								<input type="text" class="form-control" name="model" value="<?php echo $line[3];?>">
							</div>
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-lg-offset-5 col-lg-7">
					  <button type="submit" class="btn btn-default" name='submit'>Save</button>
					</div>
				</div>

				<input hidden type="text" id="computerid" name="computerid" value="<?php echo $line[7];?>"/>

			</fieldset>
		</form>		
	</div>

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
</body>
</html>
