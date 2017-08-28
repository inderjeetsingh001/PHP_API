<?php

//********** Database Connections **************//
//MySqli Driver used

$mysql_host = "localhost";
$username = "root";
$password = "";
$mysql_database = "php_api";

$con = mysqli_connect($mysql_host, $username, $password, $mysql_database);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

