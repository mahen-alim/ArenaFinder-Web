<?php
session_start();
// Include your database connection code here
$db_host = "localhost";
$db_name = "arenafinderweb";
$db_user = "root";
$db_pass = "";

// Establish a connection to the database
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_FILES['fileUpload']['name'])) {
    $nama_file = $_FILES['fileUpload']['name'];
    $tmp = $_FILES['fileUpload']['tmp_name'];

    // Tentukan folder tempat menyimpan gambar (ganti dengan folder Anda)
    $upload_folder = 'C:\\xampp\\htdocs\\ArenaFinder\\public\\img\\venue\\';

    // Pindahkan file gambar ke folder tujuan
    if (move_uploaded_file($tmp, $upload_folder . $nama_file)) {
      // Insert image information into the database
      $sql = "INSERT INTO gambar (nama_gambar, data_gambar) VALUES (?, ?)";
      $stmt = $conn->prepare($sql);

      // Read the image content
      $image_data = file_get_contents($upload_folder . $nama_file);

      // Bind parameters
      $stmt->bind_param("ss", $nama_file, $image_data);

      // Execute the statement
      $stmt->execute();

      // Close the statement
      $stmt->close();

      // Redirect back to the original page
      header("Location: info_mitra.php");
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Info Mitra</title>
  <link rel="stylesheet" href="/ArenaFinder/css/info_mitra.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
  <style>
    body {
      overflow-x: scroll;
    }

    .img-container {
      display: flex;
      align-item: center;
      justify-content: center;
    }

    .img-container img {
      display: flex;
      align-item: center;
      justify-content: center;
      margin-top: 50px;
      max-width: 100%;
      height: 300px;
      border-bottom-right-radius: 50px;
      border-bottom-left-radius: 50px;
    }

    /* Gaya untuk menyembunyikan teks h3 secara default */
    #rincianHarga {
      display: none;
    }

    #rincianHarga2 {
      display: none;
    }

    /* Menampilkan section1 terlebih dahulu */
    #section1 {
      display: block;
    }

    .link.active {
      color: #02406d;
    }

    .title-con {
      margin-left: 400px;
    }

    /* Menyembunyikan semua bagian kecuali section1 */
    section:not(#section1) {
      display: none;
    }

    .title button:active {
      background-color: #02406D;
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

    .main-con {
      margin-left: 45px;
    }

    .social-buttons {
      text-align: end;
      margin-top: -75px;
      margin-right: 420px;
    }

    .social-button {
      display: inline-block;
      padding: 10px 20px;
      margin: 10px;
      text-align: end;
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 5px;
      font-size: 20px;
      transition: transform 0.2s;
      /* Sesuaikan ukuran ikon */
    }

    .facebook {
      background-color: #1877F2;
      /* Warna Facebook */
    }

    .twitter {
      background-color: #1DA1F2;
      /* Warna Twitter */
    }

    .instagram {
      background-color: #E4405F;
      /* Warna Instagram */
    }

    .social-button:hover {
      background-color: #333;
      transform: translateY(-5px);
      /* Warna latar belakang saat tombol dihover */
    }

    .pengelola {
      margin-top: -730px;
      margin-left: 720px;
    }

    .keanggotaan {
      margin-left: 720px;
      margin-top: 50px;
    }

    .lokasi {
      margin-left: 720px;
      margin-top: 50px;
    }

    .image-container {
      display: flex;
      flex-wrap: wrap;
      text-align: center;
    }

    .file-input-wrapper {
      position: relative;
      display: flex;
      overflow: hidden;
      margin-top: 50px;
      gap: 10px;
    }

    #card-body-4 {
      width: 100%;
      background-color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
    }

    #btn-s4 {
      position: relative;
      width: 200px;
      height: 50px;
      margin-top: 20px;
      border: 1px solid #02406D;
      border-radius: 10px;
      background-color: white;
      color: #02406D;
    }

    #btn-s4:hover {
      background-color: #02406D;
      color: white;
      transition: 0.5s;
    }

    .card-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
    }

    #card-act {
      width: 300px;
      margin-top: 50px;
      text-align: center;
      border: none;
    }

    .card-text {
      margin: 5px;
    }

    #card-act img {
      width: 100%;
      height: 300px;
      border-radius: 10px;
      transition: transform 1s;
    }

    #card-act img:hover {
      transform: scale(1.1);
    }

    @media (max-width: 900px) {
      .img-container img {
        margin-left: -20px;
        max-width: 100%;
        height: 300px;
        border-bottom-right-radius: 50px;
        border-bottom-left-radius: 50px;
      }

      .title-con {
        margin-left: 80px;
      }

      .social-buttons {
        text-align: end;
        margin-top: -65px;
        margin-right: 60px;
      }

      .pengelola {
        margin-top: 30px;
        margin-left: -118px;
      }

      #pengelolaTempat {
        display: flex;
        /* Menggunakan display: flex; untuk membuat tampilan horizontal */
        align-items: start;
        /* Untuk pusatkan elemen vertikal di dalam container */
        gap: 20px;
      }

      #pengelolaTempat img {
        margin: 0 20px;
        /* Spasi antara gambar */
        width: 100px;
        height: 100px;
        margin-top: 20px;
        margin-left: 10px;
        border-radius: 20px;
      }

      #pengelolaTempat h5 {
        margin: 0 10px;
        /* Spasi antara teks */
        padding-top: 20px;
      }

      .keanggotaan {
        margin-left: -118px;
        margin-top: 30px;
      }

      .lokasi {
        margin-left: -118px;
        margin-top: 30px;
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
            <a class="nav-link" href="aktivitas.php">Aktivitas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="referensi.php">Referensi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="">Info Mitra</a>
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
            echo '<li class="nav-item dropdown" id="nav-down1">
                <a class="nav-link" id="nav-down-item1" href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/login.php" style="width: 100px;">Masuk</a>
              </li>
              <li class="nav-item dropdown" id="nav-down1">
                <a class="nav-link" id="nav-down-item2" href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/register.php" style="width: 100px;">Daftar</a>
              </li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav>

  <div class="first-con">
    <div class="img-container">
      <div>
        <img src="/ArenaFinder/img_asset/blessing.png" alt="">
      </div>
    </div>

    <div class="title-con">
      <div class="box">
        <div class="group">
          <div class="rectangle"></div>
          <div class="div"></div>
        </div>
      </div>

      <div class="title">
        <h2>Blessing Futsal
        </h2>
        <h5>2 Lapangan</h5>
      </div>
    </div>

    <div class="social-buttons">
      <a href="https://web.facebook.com/pages/Blessing-Futsal-Nganjuk/1438586789529016"
        class="social-button facebook"><i class="fab fa-facebook"></i></a>
      <a href="#" class="social-button twitter"><i class="fab fa-twitter"></i></a>
      <a href="https://instagram.com/blessing.futsal?igshid=NGVhN2U2NjQOYg==" class="social-button instagram"><i
          class="fab fa-instagram"></i></a>
    </div>

  </div>

  <script>
    function simpanPerubahan() {
      // Ambil teks yang diedit dan simpan dalam variabel
      var editedText = document.getElementById('editableText').innerText;
      var harga1 = document.getElementById('harga1').innerText;
      var harga2 = document.getElementById('harga2').innerText;
      var harga3 = document.getElementById('harga3').innerText;
      var harga4 = document.getElementById('harga4').innerText;

      // Tampilkan notifikasi atau lakukan apa yang Anda inginkan dengan teks yang diedit
      alert('Perubahan Teks: ' + editedText + '\nHarga 1: ' + harga1 + '\nHarga 2: ' + harga2 + '\nHarga 3: ' + harga3 + '\nHarga 4: ' + harga4);
    }
  </script>

  <div class="main-con">
    <div class="nav-body">
      <div class="link-body">
        <nav>
          <ul>
            <li><a class="link" id="link1" href="#section1" data-target="section1">TENTANG</a></li>
            <li><a class="link" id="link2" href="#section2" data-target="section2">AKTIVITAS</a></li>
            <li><a class="link" id="link3" href="#section3" data-target="section3">MEMBER</a></li>
            <li><a class="link" id="link4" href="#section4" data-target="section4">GALERI</a></li>
            <li><a class="link" id="link5" href="#section5" data-target="section5">KONTAK</a></li>
          </ul>
        </nav>
      </div>
    </div>

    <section id="section1">
      <div class="tentang-con">
        <div class="deskripsi">
          <h3>Deskripsi</h3>
          <h6 id="editableText">Blessing Futsal merupakan tempat penyewaan lapangan futsal yang dimana didirikan
            oleh Mr... dan sekarang tetap menjadi bagian layanan olahraga terbaik untuk masyarakat di Kabupaten
            Nganjuk dan sekitarnya.
          </h6>

          <div class="harga">
            <h3>Rincian Harga
              <div id="rincianHarga">
                <h6>Member > <strong>07:00 - 16:00</strong> (Pagi - Sore)
                  <h6><strong>Rp. 90.000/Jam</strong></h6>
                </h6>
                <h6>Member > <strong>17:00 - 24:00</strong> (Sore - Malam)
                  <h6><strong>Rp. 120.000/Jam</strong></h6>
                </h6>
                <h6>Non Member > <strong>07:00 - 16:00</strong> (Pagi - Sore)
                  <h6><strong>Rp. 105.000/Jam</strong></h6>
                </h6>
                <h6>Non Member > <strong>17:00 - 24:00</strong> (Sore - Malam)
                  <h6><strong>Rp. 135.000/Jam</strong></h6>
                </h6>
              </div>
            </h3>
          </div>

          <div class="fasilitas">
            <h3>Fasilitas Tempat</h3>
            <div id="fasilitasTempat">
              <div style="margin-bottom: 20px;">
                <img src="/ArenaFinder/img_asset/toilet.jpg" alt="">
                <h5 style="text-align: center;">Toilet</h5>
              </div>

              <div style="margin-bottom: 20px;">
                <img src="/ArenaFinder/img_asset/kursi.jpg" alt="">
                <h5 style="text-align: center; width: 80px;">Kursi Penonton</h5>
              </div>
              <div style="margin-bottom: 20px;">
                <img src="/ArenaFinder/img_asset/parkiran.jpg" alt="">
                <h5 style="text-align: center;">Area Parkir</h5>
              </div>
              <div style="margin-bottom: 20px;">
                <img src="/ArenaFinder/img_asset/alex-_AOL4_fDQ3M-unsplash.jpg" alt="">
                <h5 style="text-align: center; width: 80px;">Lapangan Futsal</h5>
              </div>
            </div>
          </div>

          <div class="pengelola">
            <h3>Pengelola</h3>
            <div id="pengelolaTempat">
              <div class="pengelola-item">
                <img src="/ArenaFinder/img_asset/alex-_AOL4_fDQ3M-unsplash.jpg" alt="">
                <h5>Admin</h5>
              </div>
              <div class="pengelola-item">
                <img src="/ArenaFinder/img_asset/alex-_AOL4_fDQ3M-unsplash.jpg" alt="">
                <h5>Super Admin</h5>
              </div>
            </div>
          </div>

          <div class="keanggotaan">
            <h3>Sistem Keanggotaan</h3>
            <div id="pengelolaTempat">
              <div class="pengelola-item">
                <img src="/ArenaFinder/img_asset/alex-_AOL4_fDQ3M-unsplash.jpg" alt="">
                <h5>Member</h5>
              </div>
              <div class="pengelola-item">
                <img src="/ArenaFinder/img_asset/alex-_AOL4_fDQ3M-unsplash.jpg" alt="">
                <h5>Non Member</h5>
              </div>
            </div>
          </div>

          <div class="lokasi">
            <h3>Lokasi</h3>
            <div id="pengelolaTempat">
              <div class="pengelola-item">
                <iframe
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3954.772089912621!2d111.91565287506188!3d-7.599764592415119!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e784bb1bfb7007b%3A0xf4b4b72690bfdd4d!2sBLESSING%20FUTSAL!5e0!3m2!1sid!2sid!4v1699786792132!5m2!1sid!2sid"
                  width="450" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            </div>
          </div>

          <script src="script.js"></script>
        </div>
      </div>
    </section>

    <section id="section2">
      <div class="tentang-con">
        <div class="deskripsi" style="width: 100%; margin-left: -65px;">
          <div class="card"
            style="color: white; background: linear-gradient(to right, #02406D, 50%, white); border: 1px solid white;">
            <div class="card-body">
              <h3>Blessing Futsal Activity</h3>
              <h6 id="editableText" style="color: white;"><strong style="color: #A1FF9F;">Futsal</strong> oleh <strong
                  style="color: #A1FF9F;">Mr. Robert</strong>
              </h6>
            </div>
          </div>
          <h3 style="margin-top: 30px;">Semua Aktivitas</h3>
        </div>

        <div class="cards-container">
          <?php
          $sql3 = "SELECT * FROM aktivitas WHERE jenis_olga = 'Futsal' ORDER BY id DESC";
          $q3 = mysqli_query($conn, $sql3);
          $count = 0; // Untuk menghitung jumlah kartu pada setiap baris
          
          while ($row = mysqli_fetch_array($q3)) {
            // Membuka baris baru setiap kali 4 kartu telah ditampilkan
            if ($count % 6 == 0) {
              echo '</div><div class="card-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">';
            }

            // Card untuk data
            echo '<div class="card" id="card-act">';
            echo '<div class="card-body">';

            $namaGambar = $row['gambar'];
            $gambarURL = "http://localhost/ArenaFinder/public/img/venue/" . $namaGambar;

            echo '<img src="' . $gambarURL . '" alt="Gambar">';
            echo '<h5 class="card-title mt-3">' . $row['nama_aktivitas'] . '</h5>';
            echo '<p class="card-text"><i class="fa-solid fa-location-dot"></i>' . $row['lokasi'] . '</p>';
            echo '<p class="card-text">' . $row['tanggal'] . '</p>';
            echo '<p class="card-text">' . $row['jam'] . '</p>';
            echo '<p class="card-text">Harga : Rp ' . $row['harga'] . '</p>';

            echo '</div></div>';

            $count++;
          }
          ?>
        </div>

      </div>

    </section>

  </div>

  <section id="section3">
    <div class="tentang-con" style="margin-left: 250px;">
      <div class="deskripsi" style="width: 100%; display: flex; align-items: center; flex-wrap: wrap; gap: 10px;">

        <?php
        // Fetch and display data from keanggotaan table
        $sql = "SELECT * FROM keanggotaan";
        $result = mysqli_query($conn, $sql);
        $count = 0;

        while ($row = mysqli_fetch_assoc($result)) {
          if ($count % 4 == 0) {
            echo '</div><div class="deskripsi" style="width: 100%; display: flex; justify-content: space-around; gap: 10px;">';
          }
          echo '<div class="card" style="flex: 0 0 calc(25% - 20px); background-color: white; border: 1px solid #02406d;">'; // Adjust flex properties for the desired width
          echo '<div class="card-body" style="display: flex; flex-direction: column; align-items: center; color: #02406d;">';
          echo '<h3>' . $row['nama'] . '</h3>';
          echo '<p>' . $row['alamat'] . '</p>';
          echo '<p>' . $row['status'] . '</p>';
          echo '</div>';
          echo '</div>';

          $count++;
        }

        echo '</div>'; // Close the last deskripsi div
        
        ?>

      </div>
    </div>
  </section>



  <section id="section4">
    <div class="tentang-con">
      <div class="deskripsi">
        <div class="card">
          <div class="card-body" id="card-body-4">
            <?php
            // Fetch data gambar from the database
            $sql = "SELECT id, nama_gambar, data_gambar FROM gambar"; // Adjust table name and column names as needed
            $result = $conn->query($sql);

            // Fetch data as an associative array
            echo '<div class="image-container">';
            $count = 0; // Variable to count the images in a row
            while ($image = $result->fetch_assoc()) {
              ?>
              <div class="card">
                <img src="data:image/jpeg;base64,<?= base64_encode($image['data_gambar']); ?>" alt="Gambar">
              </div>
              <?php
              $count++;
              // If 4 images are displayed in a row, start a new row
              if ($count == 4) {
                echo '</div><div class="image-container">';
                $count = 0; // Reset the count for the new row
              }
            }
            echo '</div>'; // Close the last container
            ?>
            <form action="#" method="post" enctype="multipart/form-data">
              <div class="file-input-wrapper">
                <div class="file-input-button">Pilih Gambar</div>
                <input type="file" name="fileUpload" id="fileUpload" accept="image/*">

                <br>
              </div>
              <button type="submit" name="submit" id="btn-s4">Upload
                dan Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="section5">
    <div class="tentang-con">
      <div class="deskripsi" style="width: 10rem; margin-left: -85px;">
        <div class="card" style="color: black;  border: 1px solid white;">
          <div class="card-body" style="background-color: white;">
            <img src="/ArenaFinder/img_asset/bg-member.png" alt="" style="border-radius: 10px;">
            <div class="card" style="margin-top: -41rem; margin-left: 30px; width: 500px; border: 1px solid white;">
              <div class="card-body" style="display: flex; align-items: center;">
                <img src="/ArenaFinder/img_asset/telepon.png" alt="" style="width: 20%; border-radius: 5px;">
                <h3 style="margin-left: 20px;">08958074xxxxx</h3>
                <div class="card"
                  style="display: flex; width: 150px; text-align: center; height: 30px; background-color: #02406D; color: white; margin-left: 50px;">
                  Super Admin
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  </div>


  <script>
    // Ambil semua tautan di dalam navigasi
    const navLinks = document.querySelectorAll(".link");

    // Tambahkan event listener untuk setiap tautan navigasi
    navLinks.forEach((link) => {
      link.addEventListener("click", (event) => {
        event.preventDefault();

        // Ambil target dari atribut data-target
        const targetId = link.getAttribute("data-target");

        // Sembunyikan semua bagian
        const sections = document.querySelectorAll("section");
        sections.forEach((section) => {
          section.style.display = "none";
        });

        // Tampilkan bagian yang sesuai dengan tautan yang diklik
        const targetSection = document.getElementById(targetId);
        targetSection.style.display = "block";

        // Hapus kelas "active" dari semua tautan
        navLinks.forEach((navLink) => {
          navLink.classList.remove("active");
        });

        // Tambahkan kelas "active" ke tautan yang diklik
        link.classList.add("active");
      });
    });

  </script>

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

  <!-- Include Bootstrap JS and jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>