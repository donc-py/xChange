<?php
	//check if the database file exists and create a new if not
	//if(!is_file('db/db_xchange.sqlite3')){
	//	file_put_contents('db/db_xchange.sqlite3', null);
	//}
	// connecting the database
	$conn = new PDO('sqlite:/opt/bitnami/apache/htdocs/xchange/xChange/db/db_xchange.sqlite3');
	//Setting connection attributes
	//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//Query for creating reating the member table in the database if not exist yet.
	$query = "CREATE TABLE IF NOT EXISTS member(mem_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username TEXT, password TEXT, firstname TEXT, lastname TEXT)";
	//Executing the query
	$conn->exec($query);

	//Query for creating reating the member table in the database if not exist yet.
	$query = "CREATE TABLE IF NOT EXISTS wallet(wal_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mem_id INTEGER FOREIGN_KEY NOT NULL, address NVARCHAR(160)  NOT NULL, private_key NVARCHAR(160)  NOT NULL)";
	//Executing the query
	$conn->exec($query);

	//Query for creating reating the member table in the database if not exist yet.
	$query = "CREATE TABLE IF NOT EXISTS transactions(trans_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mem_id INTEGER FOREIGN_KEY NOT NULL, trans_type NVARCHAR(10), coin NVARCHAR(20), transaction_hash NVARCHAR(100), amount INTEGER, isPending INTEGER)";
	//Executing the query
	$conn->exec($query);

?>

