<?php

$servername = "localhost"; 
$username_db = "root"; 
$password_db = ""; 
$dbname = "arenafinder";

$mysqli = new mysqli($servername, $username_db, $password_db, $dbname);

if ($mysqli->connect_errno) {
    die("Koneksi ke database gagal: " . $mysqli->connect_error);
}

return $mysqli;
?>