<?php
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "arenafinder";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Ambil data yang dikirimkan dari formulir
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password']; // Anda harus melakukan enkripsi kata sandi sebelum menyimpannya ke database.
$level = $_POST['level'];

// Pastikan nilai ENUM yang valid sebelum menyimpannya
if (in_array($level, array('SUPER ADMIN', 'ADMIN', 'END USER'))) {
    // Lakukan pengiriman data ke database (Anda harus melakukan pengamanan dan enkripsi kata sandi)
    $sql = "INSERT INTO users (username, email, password, level) VALUES ('$username', '$email', '$password', '$level')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Nilai 'level' tidak valid.";
}

$conn->close(); // Tutup koneksi database
?>