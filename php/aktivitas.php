<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "arenafinderweb";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
  die("Tidak bisa terkoneksi");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aktivitas</title>
  <link rel="stylesheet" href="/ArenaFinder/css/aktivitas.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>

  <style>
    body {
      margin-top: 130px;
    }
  </style>
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
            <a class="nav-link active" aria-current="page">Aktivitas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/ArenaFinder/html/referensi.html">Referensi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="info_mitra.php">Info Mitra</a>
          </li>
        </ul>
        <li class="nav-item dropdown" style="margin-right: 20px; color: white;">
          <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i
              class="fa-solid fa-id-card fa-flip" style="margin-right: 5px;"></i>
            Daftar
          </a>
          <ul class="dropdown-menu" style="background-color: white; border: 1px solid #02406D;">
            <li><a class="dropdown-item"
                href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/register.php">Daftar
                sebagai Admin</a></li>
            <li><a class="dropdown-item" href="/ArenaFinder/php/daftar.php">Daftar sebagai User</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown" style="color: white; margin-right: 40px;">
          <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i
              class="fa-solid fa-right-to-bracket" style="margin-right: 5px;"></i>
            Masuk
          </a>
          <ul class="dropdown-menu" style="background-color: white; border: 1px solid #02406D;">
            <li><a class="dropdown-item"
                href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/login.html">Masuk sebagai
                Admin</a></li>
            <li><a class="dropdown-item" href="/ArenaFinder/php/masuk.php">Masuk sebagai User</a></li>
          </ul>
        </li>
        </form>
      </div>
    </div>
  </nav>

  <div class="box">
    <div class="group">
      <div class="rectangle"></div>
      <div class="div"></div>
    </div>
  </div>

  </div>
  <div class="title_activity"> Aktivitas Komunitas
  </div>
  <div class="sub_title_activity"> Berbagai macam akitivitas olahraga yang sedang berlangsung dan
    yang telah usai dilaksanakan, disajikan sesuai dengan
    kategori olahraga yang anda minati
  </div>
  <div class="third-sep"></div>
  <button class="semua">All</button>
  <button class="all" type="submit">
    <img src="/ArenaFinder/img_asset/alex-_AOL4_fDQ3M-unsplash.jpg" alt="">
    Futsal
  </button>
  <button class="all" type="submit">
    <img src="/ArenaFinder/img_asset/badmin.jpg" alt="">
    Bulutangkis
  </button>
  <button class="all" type="submit">
    <img src="/ArenaFinder/img_asset/voli.jpg" alt="">
    Bola Voli
  </button>
  <button class="all" type="submit">
    <img src="/ArenaFinder/img_asset/basket.jpg" alt="">
    Bola Basket
  </button>
  <button class="all" type="submit">
    <img src="/ArenaFinder/img_asset/pexels-ivan-siarbolin-3787832.jpg" alt="">
    Sepak Bola
  </button>

  <div class="semua-act">
    <div class="all-activity">Semua</div>
    <div class="all-activity1">Aktivitas</div>
  </div>

  <div class="fourth-sep"></div>

  <div class="cards-container">
    <?php
    $sql3 = "SELECT * FROM aktivitas ORDER BY id DESC";
    $q3 = mysqli_query($koneksi, $sql3);
    $count = 0; // Untuk menghitung jumlah kartu pada setiap baris
    
    while ($row = mysqli_fetch_array($q3)) {
      // Membuka baris baru setiap kali 4 kartu telah ditampilkan
      if ($count % 3 == 0) {
        echo '</div><div class="cards-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">';
      }

      // Card untuk data
      echo '<div class="card" style="width: 350px; margin-top: 50px; display: flex;">';
      echo '<div class="card-body">';

      $namaGambar = $row['gambar'];
      $gambarURL = "http://localhost/ArenaFinder/public/img/venue/" . $namaGambar;

      echo '<img src="' . $gambarURL . '" alt="Gambar" style="width: 100%; height: 250px">';
      echo '<h5 class="card-title">' . $row['nama_aktivitas'] . '</h5>';
      echo '<p class="card-text">' . $row['lokasi'] . '</p>';
      echo '<p class="card-text">' . $row['tanggal'] . '</p>';
      echo '<p class="card-text">' . $row['jam'] . '</p>';
      echo '<p class="card-text">Harga : Rp ' . $row['harga'] . '</p>';

      echo '</div></div>';

      $count++;
    }
    ?>
  </div>


  <div class="container">
    <div class="footer">
      <h1 style="font-size: 20px; color: white;">Arena</h1>
      <h1 style="font-size: 20px; color: #A1FF9F;">Finder</h1>
      <div class="hierarki">
        <p style="font-size: 20px; color: white; margin-left: 250px;">Hierarki
          <a href="" style="margin-top: 10px;">Beranda</a>
          <a href="">Aktivitas</a>
          <a href="">Referensi</a>
          <a href="">Info Mitra</a>
        </p>
        <p style="font-size: 20px; color: white; margin-left: 120px;">Bantuan
          <a href="" style="margin-top: 10px;">Apa saja layanan yang disediakan?</a>
          <a href="">Siapa target penggunanya?</a>
          <a href="">Bagaimana sistem ini bekerja?</a>
          <a href="">Saat kapan pengguna dapat mengetahui pesanan?</a>
          <a href="">Masuk aplikasi??</a>
          <a href="">Daftar aplikasi??</a>
        </p>
        <p style="font-size: 20px; color: white; margin-left: 120px;">Narahubung
          <a href="">https://chat.whatsapp.com/DycWLfU9nt40BIjERofIrq</a>
        </p>
      </div>
</body>

</html>