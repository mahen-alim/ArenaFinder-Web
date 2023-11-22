<?php
session_start();
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "arenafinder";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Beranda</title>
  <link rel="stylesheet" href="/ArenaFinder/css/beranda.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
  <style>
    .title-con {
      background-color: blue;
      color: white;
      display: flex;
      flex-direction: row;
      /* Atur flex-direction menjadi "row" */
      align-items: center;
    }

    .title {
      margin-left: 690px;
      position: relative;
      top: -270mm;
      color: #02406d;
      animation: slideUp 2s ease;
    }

    .title2 {
      margin-left: 690px;
      position: relative;
      top: -270mm;
      color: #02406d;
      font-size: 30px;
      animation: slideUp 3s ease;
      /* Nama animasi, durasi, dan jenis animasi */
    }

    .img1 {
      position: relative;
      margin-top: 55px;
      margin-bottom: 30px;
      margin-right: 15in;
      width: 700px;
      height: 700px;
      border: 1px solid white;
    }

    .img2 {
      margin-left: 690px;
      position: relative;
      top: -172mm;
      width: 600px;
      height: 500px;
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
      color: #02406D;
      /* Atur latar belakang kembali ke nilai default */
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

    .button {
      position: relative;
      top: -68.8rem;
      margin-left: 1230px;
      border-radius: 10px;
      width: 100px;
      height: 50px;
      padding: 10px;
      border: 1px solid #e7f5ff;
      background-color: #02406d;
      color: white;
    }

    .button:hover {
      background-color: #02406d;
      color: white;
      border: 1px solid #02406d;
      transition: 0.5s;
      transform: scale(1.1);
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      /* Menambahkan bayangan */
    }

    .card-slider {
      position: relative;
      top: -200px;
    }

    #staticEmail {
      position: relative;
      top: -65.7rem;
      margin-left: 960px;
      border-radius: 10px;
      width: 250px;
      height: 50px;
      padding-left: 10px;
      padding-right: 10px;
      color: #02406d;
      border: 1px solid #e7f5ff;
      /* Warna border */
      transition: border-color 0.3s;
      /* Efek hover */
    }

    #staticEmail:hover {
      border-color: #02406d;
      /* Warna border saat hover */
      cursor: pointer;
    }

    @media (max-width: 900px) {
      .persegi3 {
        width: 88%;
      }

      .constructor {
        margin-left: -150px;
      }

      .img1 {
        margin-top: 30px;
        margin-left: 220px;
        width: 60%;
        height: auto;
      }

      .img2 {
        width: 60%;
        margin-left: 250px;
        margin-top: 35rem;
        position: relative;
        height: auto;
      }

      .navbar-brand {
        margin: 0;
      }

      .title {
        font-size: 35px;
        margin-left: 180px;
        margin-top: 30px;
        text-align: center;
      }

      .title2 {
        font-size: 30px;
        margin-left: 200px;
        text-align: center;

      }

      /* Tambahkan aturan CSS lain sesuai kebutuhan Anda */
      .input-jenis-lapangan {
        position: relative;
        top: -62.5rem;
        margin-left: 190px;
        border-radius: 10px;
        width: 250px;
        height: 50px;
        padding: 10px;
        color: #02406d;
        border: 1px solid #e7f5ff;
        /* Warna border */
        transition: border-color 0.3s;
        /* Efek hover */
      }

      #staticEmail {
        position: relative;
        top: -65.7rem;
        margin-left: 450px;
        border-radius: 10px;
        width: 250px;
        height: 50px;
        padding-left: 10px;
        padding-right: 10px;
        color: #02406d;
        border: 1px solid #e7f5ff;
        /* Warna border */
        transition: border-color 0.3s;
        /* Efek hover */
      }

      .button {
        position: relative;
        top: -68.8rem;
        margin-left: 710px;
        border-radius: 10px;
        width: 100px;
        height: 50px;
        padding-left: 10px;
        padding-right: 10px;
        border: 1px solid #e7f5ff;
        background-color: #02406d;
        color: white;
      }

      #button-type {
        display: flex;
        width: 50%;
      }


      #card-slider .card {
        width: 100%;
      }

    }
  </style>
</head>

<body style="overflow-x: hidden;">
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
            <a class="nav-link active" href="">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="aktivitas.php">Aktivitas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="referensi.php">Referensi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="info_mitra.php">Info Mitra</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto"> <!-- Menggunakan 'ml-auto' untuk komponen di akhir navbar -->
          <?php
          // Check if the user is logged in
          if (isset($_SESSION['email'])) {
            // User is logged in, show the "Panel Pengelola" button
            echo '<li class="nav-item dropdown" id="nav-down1">
                <a class="nav-link" id="nav-down-item1" href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/" style="width: 200px;">
                  <i class="fa-solid fa-id-card fa-flip" style="margin-right: 5px;"></i>
                  Panel Pengelola
                </a>
              </li>';
          } else {
            // User is not logged in, show the "Login" and "Register" buttons
            echo '<li class="nav-item">
                <a class="nav-link" href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/login.php" style="width: 100px;">Login</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/register.php" style="width: 100px;">Register</a>
              </li>';
          }
          ?>
        </ul>

      </div>
    </div>
  </nav>

  <div class="constructor">
    <img src="/ArenaFinder/img_asset/logo (1).png" class="img1 img-fluid" alt="..." />
    <img src="/ArenaFinder/img_asset/logo2.png" class="img2 img-fluid" alt="..." />
    <h1 id="judul" class="title">Aktivitas penunjang kehidupan yang lebih sehat dan menyenangkan</h1>
    <h1 id="judul" class="title2">Temukan Sekarang !!!</h1>
    <form method="post" action="cari_jadwal.php">
      <select id="inputOpsi" class="input-jenis-lapangan" name="jenis_lapangan">
        <option value="">Jenis Lapangan</option>
        <option value="Futsal">Futsal</option>
        <option value="Badminton">Badminton</option>
        <option value="Voli">Voli</option>
        <option value="Sepak Bola">Sepak Bola</option>
        <option value="Tenis Lapangan">Tenis Lapangan</option>
      </select>
      <input type="datetime-local" placeholder="Pilih Tanggal" class="form-control" id="staticEmail" name="tanggal">
      <button class="button" type="submit">Temukan</button>
    </form>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#staticEmail", {
          enableTime: false, // Enable time selection
          minDate: "today", // Set the minimum date to today
          dateFormat: "Y-m-d", // Specify the date format
        });
      });
    </script>

  </div>

  <div class="persegi"></div>
  <a href="alur-pesan.php">
    <button class="btn" type="button" style="font-weight: 100;" id="alur-btn">Alur Pemesanan
      <img src="/ArenaFinder/img_asset/geocaching_40px (1).png" alt="">
    </button>
  </a>
  <a href="/ArenaFinder/php/aktivitas.php">
    <button class="btn-1" type="button" style="font-weight: 100;">Aktivitas Komunitas
      <img src="/ArenaFinder/img_asset/people_48px (1).png" alt="" id="aktiv-btn"></button>
  </a>
  <a href="status-lap.php">
    <button class="btn-2" type="button" style="font-weight: 100;">Status Lapangan
      <img src="/ArenaFinder/img_asset/info_64px (1).png" alt="" id="status-btn"></button>
  </a>
  <a href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/pesanan.php">
    <button class="btn-3" type="button" style="font-weight: 100;">Daftar Pesanan
      <img src="   https://cdn-icons-png.flaticon.com/512/1187/1187525.png " width="100" height="150" alt="" title=""
        class="img-small"></button>
  </a>







  <div class="persegi2"></div>
  <div id="button-type">
    <button class="btn-4" type="button">
      <img src="/ArenaFinder/img_asset/alex-_AOL4_fDQ3M-unsplash.jpg" alt="">Futsal</button>
    <button class="btn-5" type="button">
      <img src="/ArenaFinder/img_asset/badmin.jpg" alt="">Badminton</button>
    <button class="btn-6" type="button">
      <img src="/ArenaFinder/img_asset/voli.jpg" alt="">Bola Voli</button>
    <button class="btn-7" type="button">
      <img src="/ArenaFinder/img_asset/basket.jpg" alt="">Bola Basket</button>
    <button class="btn-8" type="button">
      <img src="/ArenaFinder/img_asset/pexels-ivan-siarbolin-3787832.jpg" alt="">Sepak Bola</button>
  </div>
  <a href="" class="no-underline">Lihat lebih banyak</a>

  <div class="community"> Rekomendasi Komunitas </div>
  <div class="persegi3">
    <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
          aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
          aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner mx-3 my-1">
        <div class="carousel-item active">
          <img src="/ArenaFinder/img_asset/connor-coyne-OgqWLzWRSaI-unsplash.jpg" class="d-block w-100" alt="..."
            style="height: 500px;">
        </div>
        <div class="carousel-item">
          <img src="/ArenaFinder/img_asset/pexels-ivan-siarbolin-3787832.jpg" class="d-block w-100" alt="..."
            style="height: 500px;">
        </div>
        <div class="carousel-item">
          <img src="/ArenaFinder/img_asset/pexels-laura-rincón-16477377.jpg" class="d-block w-100" alt="..."
            style="height: 500px;">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
        data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>

  <div class="container">
    <div class="community" style="margin-top: 200px; margin-left: -120px;"> Rekomendasi Aktivitas </div>
    <div class="card-slider w-60 h-60" id="cardSlider">
      <div class="card">
        <img src="/ArenaFinder/img_asset/pexels-laura-rincón-16477377.jpg" class="card-img-top" alt="..."
          style="height: 300px">
        <div class="small-box" style="margin-left: 380px; height: 50px;">2/2</div>
        <div class="card-body">
          <h5 class="card-title">Latihan Bersama Badminton TIF PSDKU Nganjuk</h5>
          <h6 class="card-text">Lokasi : GOR Badminton Bung Karno Nganjuk</h6>
          <h6 class="card-text">Hari/Tgl : Minggu, 17/09/2023</h6>
          <h6 class="card-text">Jam : 09:00 - 13:00</h6>
          <h6 class="card-text">Harga : 5000/orang</h6>
          <button href="#" class="tombol-aktivitas">Lihat Aktivitas</button>
        </div>
      </div>
      <div class="card">
        <img src="/ArenaFinder/img_asset/pexels-ivan-siarbolin-3787832.jpg" class="card-img-top" alt="..."
          style="height: 300px">
        <div class="small-box" style="margin-left: 380px; height: 50px;">2/2</div>
        <div class="card-body">
          <h5 class="card-title">Latihan Bersama Badminton TIF PSDKU Nganjuk</h5>
          <h6 class="card-text">Lokasi : GOR Badminton Bung Karno Nganjuk</h6>
          <h6 class="card-text">Hari/Tgl : Minggu, 17/09/2023</h6>
          <h6 class="card-text">Jam : 09:00 - 13:00</h6>
          <h6 class="card-text">Harga : 5000/orang</h6>
          <button href="#" class="tombol-aktivitas">Lihat Aktivitas</button>
        </div>
      </div>
      <div class="card">
        <img src="/ArenaFinder/img_asset/connor-coyne-OgqWLzWRSaI-unsplash.jpg" class="card-img-top" alt="..."
          style="height: 300px">
        <div class="small-box" style="margin-left: 380px; height: 50px;">2/2</div>
        <div class="card-body">
          <h5 class="card-title">Latihan Bersama Badminton TIF PSDKU Nganjuk</h5>
          <h6 class="card-text">Lokasi : GOR Badminton Bung Karno Nganjuk</h6>
          <h6 class="card-text">Hari/Tgl : Minggu, 17/09/2023</h6>
          <h6 class="card-text">Jam : 09:00 - 13:00</h6>
          <h6 class="card-text">Harga : 5000/orang</h6>
          <button href="#" class="tombol-aktivitas">Lihat Aktivitas</button>
        </div>
      </div>
      <div class="card">
        <img src="/ArenaFinder/img_asset/alex-_AOL4_fDQ3M-unsplash.jpg" class="card-img-top" alt="..."
          style="height: 300px">
        <div class="small-box" style="margin-left: 380px; height: 50px;">2/2</div>
        <div class="card-body">
          <h5 class="card-title">Latihan Bersama Badminton TIF PSDKU Nganjuk</h5>
          <h6 class="card-text">Lokasi : GOR Badminton Bung Karno Nganjuk</h6>
          <h6 class="card-text">Hari/Tgl : Minggu, 17/09/2023</h6>
          <h6 class="card-text">Jam : 09:00 - 13:00</h6>
          <h6 class="card-text">Harga : 5000/orang</h6>
          <button href="#" class="tombol-aktivitas">Lihat Aktivitas</button>
        </div>
      </div>
      <div class="card">
        <img src="/ArenaFinder/img_asset/pexels-laura-rincón-16477377.jpg" class="card-img-top" alt="..."
          style="height: 300px">
        <div class="small-box" style="margin-left: 380px; height: 50px;">2/2</div>
        <div class="card-body">
          <h5 class="card-title">Latihan Bersama Badminton TIF PSDKU Nganjuk</h5>
          <h6 class="card-text">Lokasi : GOR Badminton Bung Karno Nganjuk</h6>
          <h6 class="card-text">Hari/Tgl : Minggu, 17/09/2023</h6>
          <h6 class="card-text">Jam : 09:00 - 13:00</h6>
          <h6 class="card-text">Harga : 5000/orang</h6>
          <button href="#" class="tombol-aktivitas">Lihat Aktivitas</button>
        </div>
      </div>
    </div>
  </div>

  <script src="/ArenaFinder/js/script.js"></script>

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

    </div>
  </div>

  <!-- flatpickr -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
    flatpickr("input[type=datetime-local]", {});
  </script>
  <!-- Include Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>