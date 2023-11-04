<?php
// Koneksi ke database
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "arenafinder";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
  die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Menggunakan Google API Client Library
require_once __DIR__ . '/vendor/autoload.php';

// Inisialisasi client OAuth 2.0
$client = new Google_Client();
$client->setAuthConfig('config_client.json'); // Gantilah dengan file konfigurasi OAuth Google Anda
$client->setRedirectUri('http://localhost/ArenaFinder/php/masuk.php');
$client->addScope('email');
$client->addScope('profile');

// Inisialisasi session
session_start();

if (isset($_GET['code'])) {
  // Mendapatkan akses token setelah otorisasi Google
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: http://localhost/ArenaFinder/php/masuk.php'); // Redirect ke halaman callback
}

if (isset($_SESSION['access_token'])) {
  // Akses token masih berlaku, gunakan untuk mengambil data pengguna
  $client->setAccessToken($_SESSION['access_token']);
  $plus = new Google_Service_Plus($client);
  $userProfile = $plus->people->get('me');

  // Ambil data pengguna
  $googleUserId = $userProfile->getId();
  $googleEmail = $userProfile->getEmails()[0]->getValue();
  $googleDisplayName = $userProfile->getDisplayName();

  // Simpan data pengguna ke dalam database
  $sql = "INSERT INTO users (id_users, email, full_name) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sss", $googleUserId, $googleEmail, $googleDisplayName);

  if ($stmt->execute()) {
    echo "Registrasi berhasil (dengan Google).";
  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
}

// Regis Google
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Registrasi manual
  $manualUsername = $_POST['username'];
  $manualEmail = $_POST['email'];
  $manualPassword = $_POST['password'];

  // Simpan data manual ke dalam database
  $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $hashedPassword = password_hash($manualPassword, PASSWORD_BCRYPT);
  $stmt->bind_param("sss", $manualUsername, $manualEmail, $hashedPassword);

  if ($stmt->execute()) {
    echo "Registrasi manual berhasil.";
    header('Location: http://localhost/ArenaFinder/php/masuk.php'); // Redirect ke halaman callback

  } else {
    echo "Error: " . $stmt->error;
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar</title>
  <link rel="stylesheet" type="text/css" href="/ArenaFinder/css/daftar.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>

  <style>
    body {
      display: flex;
      justify-content: center;
      /* Tengah-tengahkan secara horizontal */
      align-items: center;
    }
  </style>
  <script>
    function registerWithGoogle() {
      // Redirect ke halaman Google Login
      window.location.href = '<?php echo $authUrl; ?>';
    }
  </script>

</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg" style="background-color: #02406D;">
    <div class="container-fluid">
      <a class="navbar-brand" style="font-family: 'Kanit', sans-serif; color: white; margin-right: -235px;">Arena</a>
      <a class="navbar-brand" style="font-family: 'Kanit', sans-serif; color: #A1FF9F; margin-left: 235px;">Finder</a>
      <a class="navbar-brand" style="font-family: 'Kanit', sans-serif; color: white; padding-right: 300px;">|</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation"
        style="margin-top: 0px; background-color: white; color-scheme: #02406D;">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/ArenaFinder/html/beranda.html">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="aktivitas.php">Aktivitas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/ArenaFinder/html/referensi.html">Referensi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="info_mitra.php">Info Mitra</a>
          </li>
        </ul>
        <a class="daftar-btn" type="button"><i class="fa-solid fa-id-card"></i>
          Daftar
        </a>
        <a class="masuk-btn" type="button" href="masuk.php"><i class="fa-solid fa-right-to-bracket fa-flip"
            style="margin-right: 5px;"></i>
          Masuk
        </a>
        </form>
      </div>
    </div>
  </nav>
  <form method="POST" action="" onsubmit="return validasiForm()">
    <div class="container">
      <div class="judul">
        <h1 class="daftar">Daftar</h1>
        <h1 class="akun">Akun</h1>
      </div>
      <div class="separator"></div>
      <div class="username">Nama Pengguna
        <input type="text" name="username" autofocus required autocomplete="off">
      </div>
      <div class="username">Email
        <input type="email" name="email" required
          style="width: 300px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;flex-direction: column; height: 40px;">
      </div>
      <div class="username">Sandi
        <input type="password" name="password" required>
      </div>
      <div class="username">Konfirmasi Sandi
        <input type="password" name="confirm_password" required>
      </div>
      <div class="separator2">
        <div class="line-1"></div>
        <div class="line-2"></div>
      </div>
      <div class="google-area">
        <button class="google-button" onclick="registerWithGoogle()">
          <img src="/ArenaFinder/img_asset/google.png" alt="">
          Daftar dengan Google
        </button>
      </div>
      <div class="username">
        <button class="tombol-daftar-body">Daftar</button>
      </div>
    </div>
    <input type="hidden" name="level" value="END USER" id="level" />
  </form>
  <p id="pesan-error" style="color: red;"></p>

  <script>
    function validasiForm() {
      var password = document.getElementById("password").value;
      var konfirmasiPassword = document.getElementById("konfirmasi_password").value;
      var pesanError = document.getElementById("pesan-error");

      if (password !== konfirmasiPassword) {
        pesanError.innerHTML = "Konfirmasi Kata Sandi harus sama dengan Kata Sandi!";
        return false; // Mencegah pengiriman formulir jika ada kesalahan
      }
      return true; // Kirim formulir jika konfirmasi kata sandi sama dengan kata sandi
    }
  </script>

</body>

</html>