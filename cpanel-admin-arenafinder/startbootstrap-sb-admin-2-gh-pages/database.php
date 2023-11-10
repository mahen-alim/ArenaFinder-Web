<?php

$servername = "localhost"; 
$username_db = "root"; 
$password_db = ""; 
$dbname = "arenafinderweb";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_errno) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

return $conn;
?>