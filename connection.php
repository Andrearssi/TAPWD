<?php
$host = 'localhost';
$username = "root";
$password = "";
$databasename = "webprofile";
$conn = @mysqli_connect($host, $username, $password, $databasename);

if (!$conn) {
    echo "Error : " . mysqli_connect_error();
    exit();
}
