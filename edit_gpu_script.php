<?php
if (array_key_exists('submit', $_POST))
{
	include 'dbConnection.php';
	// Establish the connection
	$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());

	// Performing SQL query
	$query = "UPDATE comdb.gpu SET name='".$_POST['name']."', 
										gpuclock='".$_POST['gpuclock']."', 
										bandwidth='".$_POST['bandwidth']."', 
										memclock='".$_POST['memclock']."', 
										passmarkscore2D=".$_POST['passmarkscore2D'].", 
										passmarkscore3D=".$_POST['passmarkscore3D']." 
			WHERE gpuid={$_POST['gpuid']}";

	$result = pg_query($query) or die('Query failed: ' . pg_last_error());

	echo "<p>Updated ".$_POST['name']."'s info</p>";

	// Free resultset
	pg_free_result($result);

	// Closing connection
	pg_close($dbconn);

	//return to allcom page
	header( 'Location: all_gpu.php' ) ;
}
?>