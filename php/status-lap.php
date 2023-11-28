<?php
session_start();
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
    <link rel="stylesheet" href="/ArenaFinder/css/beranda.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>

    <style>
        body {
            margin-top: 150px;
            overflow-x: hidden;
        }

        .fourth-sep {
            margin-left: 175px;
        }

        .semua-act {
            margin-left: 200px;
        }

        #drop-menu {
            background-color: #e7f5ff;
            border: 1px solid white;
            color: #02406D;
        }

        .dropdown-divider {
            border: 1px solid white;
        }

        /* Saat dropdown-item di-hover */
        .dropdown-menu a.dropdown-item:hover {
            background-color: #02406D;
            color: white;
        }

        /* Mengatur warna teks dan latar belakang default */
        .dropdown-menu a.dropdown-item {
            color: initial;
            /* Atur warna teks kembali ke nilai default */
            background-color: initial;
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
            background-color: #a1ff9f;
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
            background-color: #a1ff9f;
            color: #02406D;
            transition: 0.5s;
            transform: scale(1.1);
        }

        #nav-down-item2:active {
            color: white;
        }

        .box {
            width: 100%;
            height: 77px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -80px;
        }

        .box .rectangle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 90%;
            height: 77px;
            top: 0;
            left: 0;
            background-color: #02406d;
            border-radius: 50px;
            margin-top: 100px;
            text-align: center;
        }

        .label {
            width: 588px;
            height: 58px;
            padding-top: 10px;
        }

        .label .jadwal-futsal-di {
            width: 588px;
            height: 58px;
            display: flex;
            top: 0;
            left: 0;
            font-family: "Kanit-Medium", Helvetica;
            color: transparent;
            font-size: 30px;
            text-align: center;
            letter-spacing: -0.8px;
            line-height: 22px;
            gap: 5px;
        }

        .label .text-wrapper {
            color: #ffffff;
        }

        .label .span {
            color: #a1ff9f;
        }

        /* Style for the form container */
        .form-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 100px;
        }

        /* Style for the form group (containing select and date input) */
        .form-group {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        /* Style for the select input */
        .form-control {
            width: 300px;
            padding: 10px;
            border: 1px solid #02406D;
            border-radius: 5px;
            color: #02406D;
        }

        /* Style for the date input */
        .form-control[type="datetime-local"] {
            border: 1px solid #02406D;
            border-radius: 5px;
            width: 300px;
            padding: 10px;
            color: #02406D;
        }

        /* Style for the submit button */
        #btn-find {
            position: relative;
            padding: 10px;
            margin-top: 10px;
            margin-left: 30px;
            border-radius: 10px;
            text-align: center;
            width: 100px;
            height: 50px;
            background-color: #02406d;
            color: white;
        }

        /* Hover effect for the submit button */
        #btn-find:hover {
            background-color: #02406d;
            color: white;
            border: 1px solid #02406d;
            transition: 0.5s;
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            /* Menambahkan bayangan */
        }

        #label2 {
            display: flex;
            background-color: #ffffff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 50px;
            margin-left: 50px;
            width: 100%;
            /* Adjust the width as needed */
        }

        #label2 .text {
            font-family: Arial, sans-serif;
        }

        #label2 .text-wrapper {
            font-weight: regular;
            color: #02406D;
        }

        #label2 .span {
            font-weight: bold;
            color: #02406D;
        }

        #label2 .text-wrapper-2 {
            font-weight: regular;
            color: #02406D;
        }

        #wrap-txt {
            margin-left: 200px;
            margin-top: 5px;
        }

        .cards-container {
            margin-top: 100px;
        }

        .card-title {
            font-weight: bold;
            padding: 10px;
            font-size: 25px;
            color: #02406D;
        }

        #date-card {
            margin-top: -30px;
            margin-bottom: -5px;
            color: #02406D;
        }

        #time-card {
            color: #02406D;
            font-weight: bold;
            font-size: 13px;
        }

        #price-card {
            margin-top: 30px;
            font-size: 20px;
            font-weight: bold;
            color: #02406D;
        }

        #status-card {
            background-color: #02406D;
            color: white;
            padding: 10px;
            margin-top: auto;
            margin-bottom: -15.5px;
            border-top-right-radius: 20px;
            border-top-left-radius: 20px;
        }

        .card {
            width: 220px;
            margin-top: 50px;
            display: flex;
            transition: transform 0.2s;
            border: 1px solid #02406D;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .gray-card {
            background-color: darkgray;
            border: none;
            /* Gray background color */
            color: #ccc;
            /* Dark gray text color */
            /* Add any other styles you want for gray cards */
        }

        @media (max-width: 900px) {
            .form-container {
                display: flex;
                margin-left: 10px;
                margin-top: 100px;
            }

            /* Style for the select input */
            .form-control {
                width: 220px;
                padding: 10px;
                border: 1px solid #02406D;
                border-radius: 5px;
                color: #02406D;
            }

            #label2 {
                margin-left: 10px;
            }

            #wrap-txt {
                margin-left: 180px;
                padding-top: 5px;
            }

            .footer {
                margin-left: -100px;
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

    <div class="box">
        <div class="rectangle">
            <div class="label">
                <p class="jadwal-futsal-di">
                    <span class="text-wrapper" id="wrap-txt">Status <span class="span">Lapangan</span>
                    </span>
                </p>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form method="post" action="#">
            <div class="form-group">
                <select id="inputOpsi" class="form-control" name="jenis_lapangan">
                    <option value="">Jenis Lapangan</option>
                    <option value="Futsal">Futsal</option>
                    <option value="Badminton">Badminton</option>
                    <option value="Voli">Voli</option>
                    <option value="Sepak Bola">Sepak Bola</option>
                    <option value="Tenis Lapangan">Tenis Lapangan</option>
                </select>
                <input type="datetime-local" placeholder="Pilih Tanggal" class="form-control" id="staticEmail"
                    name="tanggal">
                <button type="submit" id="btn-find">Temukan</button>
            </div>

        </form>
    </div>

    <div class="label" id="label2">
        <p class="text">
            <span class="text-wrapper">*Status </span>
            <span class="span">Belum Dipesan</span>
            <span class="text-wrapper-2"> akan berubah menjadi </span>
            <span class="span">Sudah Dipesan</span>
            <span class="text-wrapper-2">jika admin telah mengkonfirmasi pesanan dari pelanggan.<br /></span>
            <span class="text-wrapper">*Durasi sewa lapangan </span>
            <span class="span">perjam</span>
            <span class="text-wrapper"> untuk setiap pemesanan.</span>
        </p>
    </div>

    <div class="cards-container">
        <?php
        if (isset($_POST['jenis_lapangan']) && isset($_POST['tanggal'])) {
            // Ambil data dari formulir pencarian
            $jenis_lapangan = $_POST['jenis_lapangan'];
            $tanggal = $_POST['tanggal'];

            // Buat query untuk mencari jadwal sesuai dengan jenis lapangan dan tanggal
            $query = "SELECT vp.*, v.sport, vb.payment_status
            FROM venue_price vp
            JOIN venues v ON vp.id_venue = v.id_venue
            LEFT JOIN venue_booking vb ON vp.id_venue = vb.payment_status
            WHERE v.sport='$jenis_lapangan' AND vp.date='$tanggal'";
            $result = mysqli_query($koneksi, $query);
            $count = 0;

            if (mysqli_num_rows($result) > 0) {
                // Tampilkan jadwal jika ditemukan
                while ($row = mysqli_fetch_assoc($result)) {
                    // Membuka baris baru setiap kali 4 kartu telah ditampilkan
                    if ($count % 4 == 0) {
                        echo '</div><div class="cards-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">';
                    }
                    // // Determine the card class based on the status
                    // $cardClass = ($row['status_pemesanan'] == 'Sudah Dipesan') ? 'card shadow gray-card' : 'card shadow';
        
                    // Card untuk data
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . ($row['membership'] == 0 ? 'Non Member' : 'Member') . '</h5>';
                    echo '<p class="card-text" id="date-card">' . $row['date'] . '</p>';
                    echo '<div class="waktu-container">';
                    echo '<span class="card-text" id="time-card">' . $row['start_hour'] . ' - </span>';
                    echo '<span class="card-text" id="time-card">' . $row['end_hour'] . '</span>';
                    echo '</div>';
                    echo '<p class="card-text" id="price-card">Rp. ' . $row['price'] . ' /Jam</p>';
                    echo '<p class="card-text" id="status-card" style="margin-top: auto;">' . $row['payment_status'] . '</p>';

                    echo '</div></div>';

                    $count++;
                }
            } else {
                echo '<span class="text-wrapper" style="margin-left: 60px;">Jadwal Tidak Ditemukan</span>';
            }
        } else {
            // If the form is not filled, fetch and display all records
            $queryAll = "SELECT * FROM venue_price";
            $resultAll = mysqli_query($koneksi, $queryAll);
            $count = 0;

            if (mysqli_num_rows($resultAll) > 0) {
                while ($row = mysqli_fetch_assoc($resultAll)) {
                    // Membuka baris baru setiap kali 4 kartu telah ditampilkan
                    if ($count % 4 == 0) {
                        echo '</div><div class="cards-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">';
                    }

                    // Display all records
                    echo '<div class="card">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . ($row['membership'] == 0 ? 'Non Member' : 'Member') . '</h5>';
                    echo '<p class="card-text" id="date-card">' . $row['date'] . '</p>';
                    echo '<div class="waktu-container">';
                    echo '<span class="card-text" id="time-card">' . $row['start_hour'] . ' - </span>';
                    echo '<span class="card-text" id="time-card">' . $row['end_hour'] . '</span>';
                    echo '</div>';
                    echo '<p class="card-text" id="price-card">Rp. ' . $row['price'] . ' /Jam</p>';
                    echo '<p class="card-text" id="status-card" style="margin-top: auto;">Sudah Dipesan</p>';

                    echo '</div></div>';

                    $count++;
                }
            } else {
                echo '<span class="text-wrapper" style="margin-left: 60px;">Tidak Ada Data di Database</span>';
            }
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

            <!-- flatpickr -->
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script>
                flatpickr("input[type=datetime-local]", {});
            </script>
            <!-- Include Bootstrap JS and jQuery -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    flatpickr("#staticEmail", {
                        enableTime: false, // Enable time selection
                        dateFormat: "Y-m-d", // Specify the date format
                    });
                });
            </script>
</body>

</html>