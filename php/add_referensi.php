<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "arenafinderweb";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi");
}

$id = "";
$anggota = "";
$jenis_lap = "";
$tanggal = "";
$waktu_mulai = "";
$waktu_selesai = "";
$harga = "";
$status = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM jadwal WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Data Berhasil Dihapus";
    } else {
        $error = "Data Gagal Terhapus";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM jadwal WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $anggota = $r1['keanggotaan'];
    $jenis_lap = $r1['jenis_lapangan'];
    $tanggal = $r1['tanggal'];
    $waktu_mulai = $r1['waktu_mulai'];
    $waktu_selesai = $r1['waktu_selesai'];
    $harga = $r1['harga'];
    $status = $r1['status_pemesanan'];


    if ($anggota == '') {
        $error = "Data tidak ditemukan";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { //untuk create data
    $anggota = $_POST['keanggotaan'];
    $jenis_lap = $_POST['jenis_lap'];
    $tanggal = $_POST['tanggal'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];


    if ($tanggal == "-Pilih Tanggal-") {
        if ($harga !== "Input selisih waktu salah" && $harga !== "Durasi waktu istirahat") {
            if ($op == 'edit') {
                // Perbarui data jika ini adalah operasi edit
                $sql1 = "UPDATE jadwal SET keanggotaan = '$anggota', jenis_lapangan = '$jenis_lap', tanggal = '$tanggal', waktu_mulai = '$waktu_mulai', waktu_selesai = '$waktu_selesai', harga = '$harga', status_pemesanan = '$status' WHERE id = '$id'";
            } else {
                // Tambahkan data jika ini adalah operasi insert
                $sql1 = "INSERT INTO jadwal (keanggotaan, jenis_lapangan, tanggal, waktu_mulai, waktu_selesai, harga, status_pemesanan) VALUES ('$anggota', '$jenis_lap', '$tanggal', '$waktu_mulai', '$waktu_selesai', '$harga', '$status')";
            }

            $q1 = mysqli_query($koneksi, $sql1);

            if ($q1) {
                $sukses = "Data berhasil diupdate/ditambahkan";
            } else {
                $error = "Data gagal diupdate/ditambahkan";
            }
        } else {
            $error = "Terdapat kesalahan input waktu";
        }
    } else {
        $error = "Harap pilih tanggal sebelum menyimpan";
    }
}

if ($error) {
    // Set header sebelum mencetak pesan kesalahan
    header("refresh:2;url=jadwal.php"); // 2 = detik
?>
<?php
}

if ($sukses) {
    // Set header sebelum mencetak pesan sukses
    header("refresh:2;url=jadwal.php"); // 2 = detik
?>
<?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Referensi</title>
    <link rel="stylesheet" href="/ArenaFinder/css/referensi.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
    <style>
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

        #save-btn {
            background-color: #e7f5ff;
            color: #02406d;
            font-weight: bold;
        }

        #save-btn:hover {
            background-color: #02406d;
            color: white;
        }

        .mx-auto {
            margin-top: 100px;
            width: 800px;
        }

        .card {
            margin-top: 10px;
        }

        .card-header {
            background-color: #02406D;
            color: white;
        }

        /* Untuk tampilan seluler */
        @media (max-width: 768px) {
            .navbar-collapse.collapse.show {
                display: flex;
                flex-direction: column;
            }

            .navbar-nav {
                margin-top: 10px;
                text-align: left;
            }

            .navbar-nav #nav-down1 {
                margin-top: 10px;
                margin-right: 620px;
            }

        }

        /* Untuk tampilan penuh */
        @media (min-width: 769px) {
            .navbar-nav {
                flex-direction: row;
                justify-content: center;
                align-items: center;
                height: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #02406D;">
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
                        <a class="nav-link" href="/ArenaFinder/html/beranda.html">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ArenaFinder/php/aktivitas.php">Aktivitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ArenaFinder/html/referensi.html">Referensi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ArenaFinder/php/info_mitra.php">Info Mitra</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto"> <!-- Menggunakan 'ml-auto' untuk komponen di akhir navbar -->
                    <li class="nav-item dropdown" id="nav-down1">
                        <a class="nav-link" id="nav-down-item1"
                            href="/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/"
                            style="width: 150px;">
                            <i class="fa-solid fa-id-card fa-flip" style="margin-right: 5px;"></i>
                            Panel Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        Tambah/Edit Data Referensi
                    </div>
                    <div class="card-body">
                        <!-- Form -->
                        <form action="" method="POST" autocomplete="off" onsubmit="return validasiForm()">
                            <div class="mb-3 row">
                                <label for="keanggotaan" class="col-sm-2 col-form-label">Keanggotaan</label>
                                <div class="col-sm-10">
                                    <input type="radio" id="member" name="keanggotaan" value="Member" <?php if ($anggota == "Member")
                                        echo "checked"; ?> required>
                                    <label for="member">Member</label>

                                    <input type="radio" id="nonmember" name="keanggotaan" value="Non Member"
                                        style="margin-left: 20px;" <?php if ($anggota == "Non Member")
                                            echo "checked"; ?> required>
                                    <label for="nonmember">Non Member</label>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="jenis_lap" class="col-sm-2 col-form-label">Jenis
                                    Lapangan</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="jenis_lap" id="jenis_lap" required>
                                        <option value="">-Jenis Lapangan-</option>
                                        <option value="Badminton" <?php if ($jenis_lap == "Badminton")
                                            echo "selected" ?>>Badminton
                                            </option>
                                            <option value="Futsal" <?php if ($jenis_lap == "Futsal")
                                            echo "selected" ?>>Futsal
                                            </option>
                                            <option value="Sepak Bola" <?php if ($jenis_lap == "Sepak Bola")
                                            echo "selected" ?>>Sepak Bola
                                            </option>
                                            <option value="Bola Voli" <?php if ($jenis_lap == "Bola Voli")
                                            echo "selected" ?>>Bola Voli
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                                    <div class="col-sm-10">
                                        <input type="datetime-local" placeholder="-Pilih Tanggal-" class="form-control"
                                            id="tanggal" name="tanggal" value="<?php echo $tanggal ?>" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="waktu-mulai" class="col-sm-2 col-form-label">Waktu
                                    Mulai</label>
                                <div class="col-sm-10">
                                    <input type="time" placeholder="-Pilih Waktu Mulai-" class="form-control"
                                        id="waktu-mulai" name="waktu_mulai" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="waktu-selesai" class="col-sm-2 col-form-label">Waktu
                                    Selesai</label>
                                <div class="col-sm-10">
                                    <input type="time" placeholder="-Pilih Waktu Selesai-" class="form-control"
                                        id="waktu-selesai" name="waktu_selesai" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="harga" name="harga" readonly>
                                    <input type="text" class="form-control" id="status" name="status" readonly hidden
                                        value="Belum Dipesan">
                                </div>
                            </div>



                            <input type="submit" name="simpan" value="Simpan Data" class="btn w-100" id="save-btn">


                        </form>

                        <!-- Tabel -->
                        <table class="table mt-4">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>johndoe@example.com</td>
                                </tr>
                                <!-- Tambahkan baris tabel sesuai kebutuhan -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>