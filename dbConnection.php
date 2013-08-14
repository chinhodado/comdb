<?php
	function pg_connection_string_from_database_url() {
		extract(parse_url($_ENV["HEROKU_POSTGRESQL_COBALT_URL"]));
		return "user=$user password=$pass host=$host dbname=" . substr($path, 1);
		//return "user='postgres' password='root' host='localhost' dbname='postgres'";
	}
?>
