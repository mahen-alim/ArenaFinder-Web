<?php

$servername = "localhost"; 
$username_db = "root"; 
$password_db = ""; 
$dbname = "arenafinder";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>