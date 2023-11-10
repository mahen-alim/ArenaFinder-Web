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
            background-color: #e7f5ff;
            width: 100px;
            height: 30px;
            text-align: center;
        }

        #nav-down-item1:hover {
            background-color: #e7f5ff;
            color: #02406D;
            transition: 0.5s;
            transform: scale(1.1);
        }

        #nav-down-item1:active {
            color: white;
        }

        #nav-down-item2:hover {
            background-color: #e7f5ff;
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
        }
    </style>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-lg" style="background-color: #02406D;">
        <div class="container-fluid">
            <a class="navbar-brand"
                style="font-family: 'Kanit', sans-serif; color: white; margin-right: -235px;">Arena</a>
            <a class="navbar-brand"
                style="font-family: 'Kanit', sans-serif; color: #A1FF9F; margin-left: 235px;">Finder</a>
            <a class="navbar-brand" style="font-family: 'Kanit', sans-serif; color: white; padding-right: 300px;">|</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation"
                style="margin-top: 0px; background-color: white; color-scheme: #02406D;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
                    <li class="nav-item dropdown" id="nav-down1">
                        <a class="nav-link" id="nav-down-item1"
                            href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/"
                            style="width: 200px;">
                            <i class="fa-solid fa-id-card fa-flip" style="margin-right: 5px;"></i>
                            Panel Pengelola
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="box">
        <div class="rectangle">
            <div class="label">
                <p class="jadwal-futsal-di">
                    <?php
                    // Ambil data dari formulir pencarian
                    $jenis_lapangan = $_POST['jenis_lapangan'];
                    $tanggal = $_POST['tanggal'];

                    // Buat query untuk mencari jadwal sesuai dengan jenis lapangan dan tanggal
                    $query = "SELECT * FROM jadwal WHERE jenis_lapangan='$jenis_lapangan' AND tanggal='$tanggal'";
                    $result = mysqli_query($koneksi, $query);

                    if ($row = mysqli_fetch_assoc($result)) {
                        // Mengambil data dari database
                        $futsalData = $row['jenis_lapangan']; // Ganti "nama_futsal" dengan nama kolom yang sesuai di database
                        $tanggalData = $row['tanggal']; // Ganti "tanggal" dengan nama kolom yang sesuai di database
                    
                        // Echo data ke dalam span
                        echo '<span class="text-wrapper">Jadwal</span>';
                        echo '<span class="span">' . $futsalData . ' </span>';
                        echo '<span class="text-wrapper">di </span>';
                        echo '<span class="span">Nganjuk </span>';
                        echo '<span class="text-wrapper">' . $tanggalData . '</span>';
                    } else {
                        echo 'Data tidak ditemukan'; // Handle when no data is found in the database
                    }
                    ?>
                </p>
            </div>
        </div>
    </div>


    <div class="form-container">
        <form method="post" action="/ArenaFinder/php/cari_jadwal.php">
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
            <span class="text-wrapper">*Periode tanggal pemesanan: </span>
            <span class="span">06 Sep - 30 Sep.<br /></span>
            <span class="text-wrapper">*Status </span>
            <span class="span">Belum Dipesan</span>
            <span class="text-wrapper-2"> akan berubah menjadi </span>
            <span class="span">Sudah Dipesan</span>
            <span class="text-wrapper-2">jika total waktu yang disediakan pada salah satu sesi hari sudah habis
                terjual.<br /></span>
            <span class="text-wrapper">*Durasi sewa lapangan </span>
            <span class="span">perjam</span>
            <span class="text-wrapper"> untuk setiap pemesanan.</span>
        </p>
    </div>

    <div class="cards-container">
        <?php
        // Ambil data dari formulir pencarian
        $jenis_lapangan = $_POST['jenis_lapangan'];
        $tanggal = $_POST['tanggal'];

        // Buat query untuk mencari jadwal sesuai dengan jenis lapangan dan tanggal
        $query = "SELECT * FROM jadwal WHERE jenis_lapangan='$jenis_lapangan' AND tanggal='$tanggal'";
        $result = mysqli_query($koneksi, $query);
        $count = 0;

        if (mysqli_num_rows($result) > 0) {
            // Tampilkan jadwal jika ditemukan
            while ($row = mysqli_fetch_assoc($result)) {
                // Membuka baris baru setiap kali 4 kartu telah ditampilkan
                if ($count % 8 == 0) {
                    echo '</div><div class="cards-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">';
                }
                // Card untuk data
                echo '<div class="card shadow">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . $row['keanggotaan'] . '</h5>';
                echo '<p class="card-text" id="date-card">' . $row['tanggal'] . '</p>';
                echo '<div class="waktu-container">';
                echo '<span class="card-text" id="time-card">' . $row['waktu_mulai'] . ' - </span>';
                echo '<span class="card-text" id="time-card">' . $row['waktu_selesai'] . '</span>';
                echo '</div>';
                echo '<p class="card-text" id="price-card">Rp. ' . $row['harga'] . ' /Jam</p>';
                echo '<p class="card-text" id="status-card" style="margin-top: auto;">' . $row['status_pemesanan'] . '</p>';

                echo '</div></div>';

                $count++;
            }
        } else {
            echo "Jadwal telah dipesan.";
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
</body>

</html>