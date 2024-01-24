<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "login_db";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
return $mysqli;
