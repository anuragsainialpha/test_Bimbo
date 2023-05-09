<?php

$servername = "localhost";
$username = "root";
$password = "S-BbU876#$9p";
$dbname = "bbuapps"; 


$MysqlConn = mysqli_connect($servername, $username, $password, $dbname);

//print_r( $MysqlConn);

$selectQuery = "SELECT* from user";
$result = mysqli_query($MysqlConn,$selectQuery);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);


print_r($row);
