<?php
if (array_key_exists('submit', $_POST))
{
	// Establish the connection
	include 'dbConnection.php';	

	// Performing SQL query
	$stmt = $dbconn->prepare("UPDATE gpu SET name=:1, gpuclock=:2, bandwidth=:3, memclock=:4, passmarkscore2D=:5, passmarkscore3D=:6 
			WHERE gpuid=:7");

	$stmt->bindValue(':1', $_POST['name']);
	$stmt->bindValue(':2', $_POST['gpuclock']);
	$stmt->bindValue(':3', $_POST['bandwidth']);
	$stmt->bindValue(':4', $_POST['memclock']);
	$stmt->bindValue(':5', $_POST['passmarkscore2D']);
	$stmt->bindValue(':6', $_POST['passmarkscore3D']);
	$stmt->bindValue(':7', $_POST['gpuid']);

	$result = $stmt->execute();

	echo "<p>Updated ".$_POST['name']."'s info</p>";

	//return to allcom page
	header( 'Location: all_gpu.php' ) ;
}
?>