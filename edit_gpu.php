<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Edit GPU info</title>
	
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
			<h1 style="font-size:38px;">Edit GPU info</h1>
			<h5>Enter the GPU's information below</h5>			
		</div>	
	
		<?php
			include 'dbConnection.php';			
			$stmt = $dbconn->prepare("SELECT * FROM gpu WHERE gpuid = :1");
			$stmt->bindValue(':1', $_GET['gpuid']);

			$result = $stmt->execute();
			$line = $result->fetchArray();
		?>

		<form action="edit_gpu_script.php" method="POST" style="font-size:14px;line-height:20px;" class="form-horizontal">
			<fieldset>

				<div class="row">
					<div class="col-lg-4">
						<div class="form-group">
							<label for="name" class="col-lg-4 control-label">GPU name</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="name" value="<?php echo $line[1];?>" required>
							</div>
						</div>
						<div class="form-group">
							<label for="bandwidth" class="col-lg-4 control-label">Bandwidth</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="bandwidth" value="<?php echo $line[5];?>">
							</div>
						</div>
						<div class="form-group">
							<label for="passmarkscore2D" class="col-lg-4 control-label">Passmark score 2D</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="passmarkscore2D" value="<?php echo $line[2];?>" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-lg-4"></div>
							<div class="col-lg-8">
								<input type="submit" name='submit' value='Save' class="btn btn-default">
							</div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="form-group">
							<label for="gpuclock" class="col-lg-4 control-label">GPU clock</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="gpuclock" value="<?php echo $line[4];?>">
							</div>
						</div>
						<div class="form-group">
							<label for="memclock" class="col-lg-4 control-label">Memory clock</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="memclock" value="<?php echo $line[6];?>">
							</div>
						</div>
						<div class="form-group">
							<label for="passmarkscore3D" class="col-lg-4 control-label">Passmark score 3D</label>
							<div class="col-lg-8">
								<input type="text" class="form-control" name="passmarkscore3D" value="<?php echo $line[3];?>" required>
							</div>
						</div>						
					</div>
				</div>

				<input hidden type="text" id="gpuid" name="gpuid" value="<?php echo $line[0];?>"/>

			</fieldset>
		</form>		
	</div>
</body>
</html>
