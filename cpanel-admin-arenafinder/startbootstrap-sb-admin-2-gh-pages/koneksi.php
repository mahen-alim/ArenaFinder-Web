<?php
// konfigurasi database
$server = "103.247.11.134";
$username = "tifz1761_root";
$password = "tifnganjuk321";
$database = "tifz1761_arenafinder";

// membuat koneksi ke databae
$conn = new mysqli($server, $username, $password, $database);

// cek koneksi berhasil atau tidak
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

?>
