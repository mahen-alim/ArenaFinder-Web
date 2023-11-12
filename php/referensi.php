<?php
session_start();
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
  <title>Referensi</title>
  <link rel="stylesheet" href="/ArenaFinder/css/referensi.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
  <style>
    .title_activity {
      margin-top: 0px;
      margin-left: 40px;
      font-size: 35px;
      font-weight: 500;
      color: #02406d;
    }

    #drop-menu {
      background-color: white;
      border: 1px solid #02406d;
    }

    .dropdown-divider {
      border: 1px solid #02406d;
    }

    /* Saat dropdown-item di-hover */
    .dropdown-menu a.dropdown-item:hover {
      background-color: #02406d;
      color: #a1ff9f;
    }

    /* Mengatur warna teks dan latar belakang default */
    .dropdown-menu a.dropdown-item {
      color: initial;
      /* Atur warna teks kembali ke nilai default */
      background-color: initial;
      /* Atur latar belakang kembali ke nilai default */
      color: #02406d;
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
      color: #02406d;
      background-color: #a1ff9f;
      width: 100px;
      height: 30px;
      text-align: center;
    }

    #nav-down-item1:hover {
      background-color: white;
      color: #02406d;
      transition: 0.5s;
      transform: scale(1.1);
    }

    #nav-down-item1:active {
      color: white;
    }

    #nav-down-item2:hover {
      background-color: #a1ff9f;
      color: #02406d;
      transition: 0.5s;
      transform: scale(1.1);
    }

    #nav-down-item2:active {
      color: white;
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

    .tipe-lap {
      display: flex;
      width: 500px;
      height: 100%;
      gap: 20px;
      margin-top: -48px;
      margin-left: 2rem;
    }

    .tipe-lap button {
      border: none;
      border-radius: 10px;
      width: 100px;
      position: relative;
      overflow: hidden;
      background-color: white;
      color: #02406d;
      box-shadow: 0 0 5px #02406d;
      transition: box-shadow 0.3s ease;
    }

    .fourth-sep {
      height: 50px;
      width: 5px;
      background-color: #02406d;
      margin-left: 13rem;
      margin-top: -3rem;
      border-radius: 10px;
    }

    #ref-btn {
      width: 200px;
      height: auto;
      background-color: white;
      display: flex;
      align-items: center;
      padding-left: 30px;
      border-radius: 10px;
      text-decoration: none;
      color: #02406d;
      box-shadow: 0 0 5px #02406d;
      transition: box-shadow 0.3s ease;
    }

    #ref-btn:hover {
      background-color: #02406d;
      color: white;
      transition: 1s;
      box-shadow: 0 0 10px #02406d;
    }

    .tipe-lap img {
      width: 100%;
      height: 100%;
      position: absolute;
      top: 100%;
      left: 0;
      opacity: 0;
      transition: top 0.3s ease, opacity 0.3s ease;
    }

    .tipe-lap button:hover img {
      top: 0;
      opacity: 1;
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

    section {
      display: none;
      /* Sembunyikan semua section secara default */
    }

    section.show {
      display: block;
      /* Tampilkan section yang memiliki kelas 'show' */
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
    }
  </style>
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg navbar-light" style="background-color: #02406d">
    <div class="container">
      <a class="navbar-brand" href="#">
        <span style="font-family: 'Kanit', sans-serif; color: white">Arena</span>
        <span style="font-family: 'Kanit', sans-serif; color: #a1ff9f">Finder</span>
        <span style="font-family: 'Kanit', sans-serif; color: white">|</span>
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
            <a class="nav-link" href="aktivitas.php">Aktivitas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="">Referensi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="info_mitra.php">Info Mitra</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <!-- Menggunakan 'ml-auto' untuk komponen di akhir navbar -->
          <li class="nav-item dropdown" id="nav-down1">
            <a class="nav-link" id="nav-down-item1"
              href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/" style="width: 200px;">
              <i class="fa-solid fa-id-card fa-flip" style="margin-right: 5px"></i>
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
    <div class="title_activity">Referensi Tempat Olahraga</div>
    <div class="sub_title_activity">
      Berbagai macam lapangan olahraga yang ada di Kabupaten Nganjuk baik
      indoor maupun outdoor
    </div>

    <p id="swipe-btn">Swipe >></p>

    <div class="con-type">
      <button class="semua" onclick="showCards('All')">All</button>
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
      const container = document.querySelector(".con-type");
      let isDragging = false;
      let startX, currentX, scrollLeft;

      container.addEventListener("mousedown", (e) => {
        isDragging = true;
        startX = e.pageX - container.offsetLeft;
        scrollLeft = container.scrollLeft;
        container.style.scrollBehavior = "auto";
      });

      container.addEventListener("mouseup", () => {
        isDragging = false;
        container.style.scrollBehavior = "smooth";
      });

      container.addEventListener("mouseleave", () => {
        isDragging = false;
        container.style.scrollBehavior = "smooth";
      });

      container.addEventListener("mousemove", (e) => {
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
        <div class="all-activity1">Lapangan</div>
      </div>

      <div class="fourth-sep">
        <div class="tipe-lap">
          <button id="indoorButton" onclick="showCards('Indoor')">Indoor<img src="/ArenaFinder/img_asset/badmin.jpg"
              alt="" /></button>
          <button id="outdoorButton" onclick="showCards('Outdoor')">Outdoor<img src="/ArenaFinder/img_asset/outdoor.jpg"
              alt="" /></button>

          <?php
          // Pastikan pengguna sudah login
          if (!isset($_SESSION['email'])) {
            // Redirect user to the login page if they are not logged in or level is not set
            header("Location: login.php");
            exit();
          }

          // Ambil level pengguna dari sesi
          $userEmail = $_SESSION['email'];

          // Tampilkan tombol "Tambah Referensi" hanya jika level pengguna adalah "superadmin"
          if ($userEmail == 'arenafinder.app@gmail.com') {
            echo '<a id="ref-btn" href="/ArenaFinder/php/add_referensi.php/">Tambah Referensi +</a>';
          } else {
            echo '<a id="ref-btn" href="/ArenaFinder/php/add_referensi.php/" style="display: none;">Tambah Referensi +</a>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <div class="cards-container">
    <div class="card-container"
      style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px; margin-top: 50px;">
      <?php
      $sql3 = "SELECT * FROM referensi ORDER BY id_referensi DESC";
      $q3 = mysqli_query($koneksi, $sql3);
      $count = 0; // Untuk menghitung jumlah kartu pada setiap baris
      
      while ($row = mysqli_fetch_array($q3)) {
        // Membuka baris baru setiap kali 4 kartu telah ditampilkan
        if ($count % 4 == 0) {
          echo '</div><div class="card-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">';
        }

        // Card untuk data
        echo '<div class="card" data-tipe-lap="' . $row['tipe_lap'] . '">';
        echo '<div class="card-body">';

        $namaGambar = $row['gambar'];
        $gambarURL = "http://localhost/ArenaFinder/public/img/venue/" . $namaGambar;

        echo '<img src="' . $gambarURL . '" alt="Gambar" >';
        echo '<h5 class="card-title mt-3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">' . $row['nama_tempat'] . '</h5>';
        echo '<p class="card-text"><i class="fa-solid fa-location-dot"></i><span style="word-wrap: break-word; max-width: 300px; display: block;">' . $row['lokasi'] . '</span></p>';
        echo '<p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">' . $row['jumlah_lap'] . ' Lapangan</p>';
        echo '<p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">Harga : Rp ' . $row['harga_sewa'] . '</p>';
        echo '<p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;" hidden>' . $row['tipe_lap'] . '</p>';

        echo '</div></div>';

        $count++;
      }
      ?>
    </div>
  </div>


  <section id="section1">
    <div class="cards-container">
      <div class="card-container"
        style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px; margin-top: 50px;">
        <?php
        $tipe_lapangan = 'Indoor';
        $tipe_olga = 'Badminton';
        $sql3 = "SELECT * FROM referensi WHERE tipe_lap = '$tipe_lapangan' AND tipe_olga = '$tipe_olga'";
        $q3 = mysqli_query($koneksi, $sql3);
        $count = 0; // Untuk menghitung jumlah kartu pada setiap baris
        
        while ($row = mysqli_fetch_array($q3)) {
          // Membuka baris baru setiap kali 4 kartu telah ditampilkan
          if ($count % 4 == 0) {
            echo '</div><div class="card-container" style="display: flex; justify-content: center; gap: 10px;">';
          }

          // Card untuk data
          echo '<div class="card" data-tipe-lap="' . $row['tipe_lap'] . '" data-tipe-olga="' . $row['tipe_olga'] . '">';
          echo '<div class="card-body">';

          $namaGambar = $row['gambar'];
          $gambarURL = "http://localhost/ArenaFinder/public/img/venue/" . $namaGambar;

          echo '<img src="' . $gambarURL . '" alt="Gambar" >';
          echo '<h5 class="card-title mt-3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">' . $row['nama_tempat'] . '</h5>';
          echo '<p class="card-text"><i class="fa-solid fa-location-dot"></i><span style="word-wrap: break-word; max-width: 300px; display: block;">' . $row['lokasi'] . '</span></p>';
          echo '<p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">' . $row['jumlah_lap'] . ' Lapangan</p>';
          echo '<p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">Harga : Rp ' . $row['harga_sewa'] . '</p>';
          echo '<p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;" hidden>' . $row['tipe_lap'] . '</p>';

          echo '</div></div>';

          $count++;
        }
        ?>
      </div>
    </div>
  </section>

  <section id="section2">
    <div class="cards-container">
      <div class="card-container"
        style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px; margin-top: 50px;">
        <?php
        $tipe_lapangan = 'Outdoor';
        $sql3 = "SELECT * FROM referensi WHERE tipe_lap = '$tipe_lapangan'";
        $q3 = mysqli_query($koneksi, $sql3);
        $count = 0; // Untuk menghitung jumlah kartu pada setiap baris
        
        while ($row = mysqli_fetch_array($q3)) {
          // Membuka baris baru setiap kali 4 kartu telah ditampilkan
          if ($count % 4 == 0) {
            echo '</div><div class="card-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px;">';
          }

          // Card untuk data
          echo '<div class="card" data-tipe-lap="' . $row['tipe_lap'] . '">';
          echo '<div class="card-body">';

          $namaGambar = $row['gambar'];
          $gambarURL = "http://localhost/ArenaFinder/public/img/venue/" . $namaGambar;

          echo '<img src="' . $gambarURL . '" alt="Gambar" >';
          echo '<h5 class="card-title mt-3" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">' . $row['nama_tempat'] . '</h5>';
          echo '<p class="card-text"><i class="fa-solid fa-location-dot"></i><span style="word-wrap: break-word; max-width: 300px; display: block;">' . $row['lokasi'] . '</span></p>';
          echo '<p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">' . $row['jumlah_lap'] . ' Lapangan</p>';
          echo '<p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">Harga : Rp ' . $row['harga_sewa'] . '</p>';
          echo '<p class="card-text" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;" hidden>' . $row['tipe_lap'] . '</p>';

          echo '</div></div>';

          $count++;
        }
        ?>
      </div>
    </div>
  </section>


  <script>
    function showCards(category) {
      var cards = document.querySelectorAll('.card');

      cards.forEach(function (card) {
        var tipeLap = card.getAttribute('data-tipe-lap');

        // Tampilkan hanya kartu dengan kategori yang sesuai
        if (tipeLap === category || category === 'All') {
          card.style.display = 'flex';
        } else {
          card.style.display = 'none';
        }
      });
    }
  </script>

  <div class="container">
    <div class="footer">
      <h1 style="font-size: 20px; color: white">Arena</h1>
      <h1 style="font-size: 20px; color: #a1ff9f">Finder</h1>
      <div class="hierarki">
        <p style="font-size: 20px; color: white; margin-left: 250px">
          Hierarki
          <a href="" style="margin-top: 10px">Beranda</a>
          <a href="">Aktivitas</a>
          <a href="">Referensi</a>
          <a href="">Info Mitra</a>
        </p>
        <p style="font-size: 20px; color: white; margin-left: 120px">
          Bantuan
          <a href="" style="margin-top: 10px">Apa saja layanan yang disediakan?</a>
          <a href="">Siapa target penggunanya?</a>
          <a href="">Bagaimana sistem ini bekerja?</a>
          <a href="">Saat kapan pengguna dapat mengetahui pesanan?</a>
          <a href="">Masuk aplikasi??</a>
          <a href="">Daftar aplikasi??</a>
        </p>
        <p style="font-size: 20px; color: white; margin-left: 120px">
          Narahubung
          <a href="">https://chat.whatsapp.com/DycWLfU9nt40BIjERofIrq</a>
        </p>
      </div>
    </div>
  </div>

  <!-- Include Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    $(document).ready(function () {
      $("#ref-btn").popover({
        content: "Menu ini hanya bisa diakses oleh super admin/developer",
        trigger: "hover",
        placement: "top",
      });
    });
  </script>
  <script>
    // Simulasikan status login admin (ganti dengan kode sesuai aplikasi Anda)
    const isAdmin = false; // Ganti menjadi true jika pengguna adalah admin

    document.addEventListener("DOMContentLoaded", function () {
      const refBtn = document.getElementById("ref-btn");

      refBtn.addEventListener("click", function (event) {
        if (isAdmin) {
          event.preventDefault(); // Mencegah tautan dari diikuti
          alert("Anda adalah admin. Anda tidak dapat mengakses tautan ini.");
        }
      });
    });
  </script>
</body>

</html>