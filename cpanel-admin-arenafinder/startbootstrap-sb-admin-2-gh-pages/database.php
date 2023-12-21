<?php

$servername = "localhost";
$username_db = "tifz1761_root";
$password_db = "tifnganjuk321";
$dbname = "tifz1761_arenafinder";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_errno) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

return $conn;
?>