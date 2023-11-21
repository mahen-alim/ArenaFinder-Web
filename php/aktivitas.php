<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "arenafinder";

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

    .semua-act {
      margin-left: 200px;
    }

    #drop-menu {
      background-color: white;
      border: 1px solid #02406D;
    }

    .dropdown-divider {
      border: 1px solid #02406D;
    }

    /* Saat dropdown-item di-hover */
    .dropdown-menu a.dropdown-item:hover {
      background-color: #02406D;
      color: #A1FF9F;
    }

    /* Mengatur warna teks dan latar belakang default */
    .dropdown-menu a.dropdown-item {
      color: initial;
      /* Atur warna teks kembali ke nilai default */
      background-color: initial;
      /* Atur latar belakang kembali ke nilai default */
      color: #02406D;
    }

    #auth-con {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-left: 75px;

    }

    #nav-down-item1 {
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 6px;
      color: white;
      border: 1px solid white;
      width: 100px;
      height: 30px;
      text-align: center;
    }

    #nav-down-item2 {
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 6px;
      color: #02406D;
      background-color: #A1FF9F;
      width: 100px;
      height: 30px;
      text-align: center;
    }

    #nav-down-item1:hover {
      background-color: white;
      color: #02406D;
      transition: 0.5s;
      transform: scale(1.1);
    }

    #nav-down-item1:active {
      color: white;
    }

    #nav-down-item2:hover {
      background-color: #A1FF9F;
      color: #02406D;
      transition: 0.5s;
      transform: scale(1.1);
    }

    #nav-down-item2:active {
      color: white;
    }

    .card-text {
      text-align: center;
      /* Menengahkan teks */
    }

    .fa-location-dot {
      margin-right: 10px;
      /* Memberikan jarak antara logo dan teks */
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
    }

    .card {
      width: 300px;
      margin-top: 50px;
      text-align: center;
      border: none;
    }

    .card-text {
      margin: 5px;
    }

    .card img {
      width: 100%;
      height: 300px;
      border-radius: 10px;
      transition: transform 1s;
    }

    .card img:hover {
      transform: scale(1.1);
    }

    .con-type {
      width: 90%;
      display: flex;
      overflow: hidden;
      white-space: nowrap;
      touch-action: cross-slide-x;
      user-select: none;
      margin-top: 50px;
      margin-right: 20px;
      margin-left: 50px;
      position: relative;
    }

    .con-type button {
      display: flex;
      flex-direction: column;
      align-items: center;
      border: none;
      background: none;
      cursor: pointer;
    }

    .con-type img {
      max-width: 100%;
      height: auto;
      /* Atur ukuran margin sesuai preferensi Anda */
    }

    button.semua {
      width: 60px;
      height: 60px;
      padding-top: 10px;
      margin-top: 20px;
      margin-left: 0px;
      margin-right: 15px;
      text-align: center;
      border: 1px solid #02406d;
      border-radius: 10px;
      background-color: white;
      color: #02406d;
      font-size: 25px;
      font-weight: regular;
      animation: slideRight 2s ease-in-out;
    }

    .semua {
      margin-top: 30px;
      margin-left: 0px;
      border: 1px solid #02406d;
      border-radius: 10px;
      background-color: white;
      color: #02406d;
      font-size: 25px;
      font-weight: regular;
      animation: slideRight 2s ease-in-out;
    }

    button.all {
      width: 100px;
      height: 100px;
      animation: slideRight 2s ease-in-out;
    }

    .all img {
      width: 60px;
      height: 60px;
      border: 1px solid white;
      border-radius: 10px;
      margin-bottom: 15px;
      transition: scale 1s;
    }

    .all img:hover {
      scale: 105%;
    }

    .semua-act {
      display: flex;
      text-align: justify;
      justify-content: flex-start;
      background-color: #02406d;
      color: white;
      margin-left: 50px;
      margin-top: 50px;
      height: 50px;
      width: fit-content;
      border-radius: 10px;
    }

    .con-main {
      margin-left: 30px;
    }

    #swipe-btn {
      position: absolute;
      right: 0;
      margin-right: 150px;
      margin-top: 30px;
      font-size: 12px;
      animation: slideRight 2s ease-in-out;
      font-weight: lighter;
      color: #02406d;
    }

    .semua-act .all-activity {
      padding: 10px;
    }

    .semua-act .all-activity1 {
      padding: 10px;
      margin-left: -10px;
      color: #A1FF9F;
    }

    @keyframes slideRight {
      0% {
        transform: translateX(100%);
        /* Elemen dimulai dari bawah */
        opacity: 0;
        /* Elemen transparan saat dimulai */
      }

      100% {
        transform: translateX(0%);
        /* Elemen dimulai dari bawah */
        opacity: 1;
        /* Elemen transparan saat dimulai */
      }
    }

    @media (max-width: 900px) {
      .con-type {
        width: 85%;
        display: flex;
        overflow: hidden;
        white-space: nowrap;
        touch-action: pan-y;
        user-select: none;
        margin-top: 50px;
        margin-right: 20px;
        margin-left: 50px;
        position: relative;
      }

      .con-type button {
        display: flex;
        flex-direction: column;
        align-items: center;
        border: none;
        background: none;
        cursor: pointer;
      }

      .con-type img {
        max-width: 100%;
        height: auto;
        /* Atur ukuran margin sesuai preferensi Anda */
      }

      button.semua {
        width: 60px;
        height: 60px;
        margin-top: 20px;
        margin-left: 0px;
        margin-right: 15px;
        border: 1px solid #02406d;
        border-radius: 10px;
        background-color: white;
        color: #02406d;
        font-size: 25px;
        font-weight: regular;
        animation: slideRight 2s ease-in-out;
      }

      .all img {
        width: 60px;
        height: 60px;
        border: 1px solid white;
        border-radius: 10px;
        margin-bottom: 15px;
        transition: scale 1s;
        animation: slideRight 2s ease-in-out;
      }

      .all img:hover {
        scale: 105%;
      }

      .semua-act {
        display: flex;
        text-align: justify;
        justify-content: flex-start;
        background-color: #02406d;
        color: white;
        margin-left: 50px;
        height: 50px;
        width: fit-content;
        border-radius: 10px;
      }

      .con-main {
        margin-left: 10px;
      }

      .semua-act {
        margin-left: 35px;
      }

      .footer {
        margin-left: -100px;
      }

      #swipe-btn {
        position: absolute;
        right: 0;
        margin-right: 20px;
        margin-top: 30px;
        font-size: 12px;
        animation: slideRight 2s ease-in-out;
        font-weight: lighter;
        color: #02406d;
      }

      .footer {
        margin-left: -100px;
      }

      .semua-act .all-activity {
        padding: 10px;
      }

      .semua-act .all-activity1 {
        padding: 10px;
        margin-left: -10px;
        color: #A1FF9F;
      }
    }
  </style>
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light" style="background-color: #02406D;">
    <div class="container">
      <a class="navbar-brand" href="#">
        <span style="font-family: 'Kanit', sans-serif; color: white;">Arena</span>
        <span style="font-family: 'Kanit', sans-serif; color: #A1FF9F;">Finder</span>
        <span style="font-family: 'Kanit', sans-serif; color: white;">|</span>
      </a>

      <button class="navbar-toggler bg-white" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto my-auto">
          <li class="nav-item">
            <a class="nav-link" href="beranda.php">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="">Aktivitas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="referensi.php">Referensi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="info_mitra.php">Info Mitra</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto"> <!-- Menggunakan 'ml-auto' untuk komponen di akhir navbar -->
          <li class="nav-item dropdown" id="nav-down1">
            <a class="nav-link" id="nav-down-item1"
              href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/" style="width: 200px;">
              <i class="fa-solid fa-id-card fa-flip" style="margin-right: 5px;"></i>
              Panel Pengelola
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="box">
    <div class="group">
      <div class="rectangle"></div>
      <div class="div"></div>
    </div>
  </div>

  <div class="con-main">
    <div class="title_activity">Aktivitas Komunitas
    </div>
    <div class="sub_title_activity">Berbagai macam akitivitas olahraga yang sedang berlangsung dan
      yang telah usai dilaksanakan, disajikan sesuai dengan
      kategori olahraga yang anda minati
    </div>

    <div class="con-type">
      <button class="semua">All</button>
      <button class="all" type="submit">
        <img src="/ArenaFinder/img_asset/futsal.jpg" alt="" />
        <span>Bola Futsal</span>
      </button>
      <button class="all" type="submit">
        <img src="/ArenaFinder/img_asset/badmin.jpg" alt="" />
        <span>Badminton</span>
      </button>
      <button class="all" type="submit">
        <img src="/ArenaFinder/img_asset/voli.jpg" alt="" />
        <span>Bola Voli</span>
      </button>
      <button class="all" type="submit">
        <img src="/ArenaFinder/img_asset/basket.jpg" alt="" />
        <span>Bola Basket</span>
      </button>
      <button class="all" type="submit">
        <img src="/ArenaFinder/img_asset/pexels-ivan-siarbolin-3787832.jpg" alt="" />
        <span>Sepak Bola</span>
      </button>
    </div>

    <script>
      const container = document.querySelector('.con-type');
      let isDragging = false;
      let startX, currentX, scrollLeft;

      container.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.pageX - container.offsetLeft;
        scrollLeft = container.scrollLeft;
        container.style.scrollBehavior = 'auto';
      });

      container.addEventListener('mouseup', () => {
        isDragging = false;
        container.style.scrollBehavior = 'smooth';
      });

      container.addEventListener('mouseleave', () => {
        isDragging = false;
        container.style.scrollBehavior = 'smooth';
      });

      container.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
        currentX = e.pageX - container.offsetLeft;
        const scrollX = currentX - startX;
        container.scrollLeft = scrollLeft - scrollX;
      });

    </script>

    <div id="con-3">
      <div class="semua-act">
        <div class="all-activity">Semua</div>
        <div class="all-activity1">Aktivitas</div>
      </div>
    </div>

  </div>

  <div class="cards-container">
    <?php
    $sql3 = "SELECT va.*, v.location
    FROM venue_aktivitas va
    JOIN venues v ON va.id_venue = v.id_venue
    ORDER BY va.id_aktivitas DESC";
    $q3 = mysqli_query($koneksi, $sql3);
    $count = 0; // Untuk menghitung jumlah kartu pada setiap baris
    
    while ($row = mysqli_fetch_array($q3)) {
      // Membuka baris baru setiap kali 4 kartu telah ditampilkan
      if ($count % 4 == 0) {
        echo '</div><div class="card-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">';
      }

      // Card untuk data
      echo '<div class="card">';
      echo '<div class="card-body">';

      $namaGambar = $row['photo'];
      $gambarURL = "http://localhost/ArenaFinder/public/img/venue/" . $namaGambar;

      echo '<img src="' . $gambarURL . '" alt="Gambar">';
      echo '<h5 class="card-title mt-3">' . $row['nama_aktivitas'] . '</h5>';
      echo '<p class="card-text"><i class="fa-solid fa-location-dot"></i>' . $row['location'] . '</p>';
      echo '<p class="card-text">' . $row['date'] . '</p>';
      echo '<p class="card-text">' . $row['jam_main'] . ' Jam</p>';
      echo '<p class="card-text">Harga : Rp ' . $row['price'] . '</p>';

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
      <!-- Include Bootstrap JS and jQuery -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>