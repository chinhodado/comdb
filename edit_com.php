<?php
if (array_key_exists('submit', $_POST))
{	
	// Establish the connection
	include 'dbConnection.php';

	// Performing SQL query
	$stmt = $dbconn->prepare("UPDATE computer SET name=:1, model=:2, ram=:3, passmark_disk_score=:4, passmark_ram_score=:5, passmark_total_score=:6, cpuid=:7, gpuid=:8
			WHERE computerid=:9");

	$stmt->bindValue(':1', $_POST['name']);
	$stmt->bindValue(':2', $_POST['model']);
	$stmt->bindValue(':3', $_POST['ram']);
	$stmt->bindValue(':4', $_POST['passmark_disk_score']);
	$stmt->bindValue(':5', $_POST['passmark_ram_score']);
	$stmt->bindValue(':6', $_POST['passmark_total_score']);
	$stmt->bindValue(':7', $_POST['cpuid']);
	$stmt->bindValue(':8', $_POST['gpuid']);
	$stmt->bindValue(':9', $_POST['computerid']);

	$result = $stmt->execute();

	echo "<p>Updated ".$_POST['name']."'s info</p>";

	//return to allcom page
	header( 'Location: all_computer.php' ) ;
}
?>