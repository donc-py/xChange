<?php

//check if the database file exists and create a new if not
//if(!is_file('http://3.139.87.137/xchange/xChange/db/db_xchange.sqlite3')){
 //   file_put_contents('http://3.139.87.137/xchange/xChange/db/db_xchange.sqlite3', null);
//}
// connecting the database
$conn = new PDO('sqlite:/opt/bitnami/apache/htdocs/xchange/xChange/db/db_xchange.sqlite3');
//Setting connection attributes
//$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//Query for creating reating the member table in the database if not exist yet.
//$query = "CREATE TABLE IF NOT EXISTS member(mem_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username TEXT, password TEXT, firstname TEXT, lastname TEXT)";
//Executing the query
//$conn->exec($query);

//Query for creating reating the member table in the database if not exist yet.
//$query = "CREATE TABLE IF NOT EXISTS wallet(wal_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mem_id INTEGER FOREIGN_KEY NOT NULL, address NVARCHAR(160)  NOT NULL, private_key NVARCHAR(160)  NOT NULL)";
//Executing the query
//$conn->exec($query);

//Query for creating reating the member table in the database if not exist yet.
//$query = "CREATE TABLE IF NOT EXISTS transactions(trans_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, mem_id INTEGER FOREIGN_KEY NOT NULL, trans_type NVARCHAR(10), coin NVARCHAR(20), transaction_hash NVARCHAR(100), amount INTEGER, isPending INTEGER)";
//Executing the query
//$conn->exec($query);
$reqAddress = 'aedc29f6294dc5f43f02b56b5aba7ec2a20d0797';
//$reqAddress = strtolower('0x6028cF17865Da40FBD1a65924D9A3a8EFc0aD2EE');
$query = "SELECT mem_id FROM wallet WHERE address = :reqAddress";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':reqAddress', $reqAddress);
    $stmt->execute();
    $row = $stmt->fetchAll();
    var_dump($row[0]['mem_id']);
var_dump(count($row));
    //$data = [
    //    'username' => 'arnold',
    //    'password' => '123456',
    //    'firstname' => 'derf',
    //    'lastname' => 'fred',
    //    'walletid' => 'as'
    //];
    //$sqlq = "INSERT INTO member (username, password, firstname, lastname,walletid) VALUES(:username, :password, :firstname, :lastname, :walletid)";
    //$stmt2= $conn->prepare($sqlq);
    //$stmt2->execute($data);
    try{
        //$qry = $conn->prepare(
        //    'INSERT INTO member (username, password, firstname, lastname,walletid) VALUES (?, ?, ?, ?, ?)');
        //$qry->execute(array('arnold', '123456', 'derf','fred','as'));

        $query2 = "SELECT mem_id, username, firstname FROM member";
        $stmt2 = $conn->prepare($query2);
        $stmt2->execute();
        $row2 = $stmt2->fetchAll();
    var_dump($row2);
       }
       catch(PDOException $e) {echo $e->getMessage();}
    


echo "as";

?>