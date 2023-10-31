<?php
// sisipkan class koneksi.php untuk menghubungkan ke database
include("koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Periksa apakah username dan password valid
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
  
    header("Location: /ArenaFinder/html/beranda.html");
    } else {
        echo "Email tidak ditemukan. <a href='login.php'>Coba lagi</a>";
    }

$conn->close();
?>