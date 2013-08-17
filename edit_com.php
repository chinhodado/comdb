<?php
if (array_key_exists('submit', $_POST))
{
	include 'dbConnection.php';
	// Establish the connection
	$dbconn = pg_connect(pg_connection_string_from_database_url()) or die('Could not connect: ' . pg_last_error());

	// Performing SQL query
	$query = "UPDATE comdb.computer SET name='".$_POST['name']."', 
										model='".$_POST['model']."', 
										ram='".$_POST['ram']."', 
										psu='".$_POST['psu']."', 
										passmarkdiskscore='".$_POST['passmarkdiskscore']."', 
										passmarkramscore='".$_POST['passmarkramscore']."', 
										passmarktotalscore='".$_POST['passmarktotalscore']."', 
										cpuid='".$_POST['cpuid']."' 
			WHERE computerid={$_POST['computerid']}";

	$result = pg_query($query) or die('Query failed: ' . pg_last_error());

	echo "<p>Updated ".$_POST['name']."'s info</p>";

	// Free resultset
	pg_free_result($result);

	// Closing connection
	pg_close($dbconn);

	//return to allcom page
	header( 'Location: all_computer.php' ) ;
}
?>