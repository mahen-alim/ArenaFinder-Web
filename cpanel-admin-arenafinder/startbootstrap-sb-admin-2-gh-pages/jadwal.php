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


    if ($op == 'edit') {
        // Perbarui data jika ini adalah operasi edit
        $sql1 = "UPDATE jadwal SET keanggotaan = '$anggota', jenis_lapangan = '$jenis_lap', tanggal = '$tanggal', waktu_mulai = '$waktu_mulai', waktu_selesai = '$waktu_selesai', harga = '$harga' WHERE id = '$id'";
    } else {
        // Tambahkan data jika ini adalah operasi insert
        $sql1 = "INSERT INTO jadwal (keanggotaan, jenis_lapangan, tanggal, waktu_mulai, waktu_selesai, harga) VALUES ('$anggota', '$jenis_lap', '$tanggal', '$waktu_mulai', '$waktu_selesai', '$harga')";
    }

    $q1 = mysqli_query($koneksi, $sql1);

    if ($q1) {
        $sukses = "Data berhasil diupdate/ditambahkan";
    } else {
        $error = "Data gagal diupdate/ditambahkan";
    }

}

if ($error) {
    // Set header sebelum mencetak pesan kesalahan
    header("refresh:2;url=jadwal.php"); // 2 = detik
    ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error ?>
    </div>
    <?php
}

if ($sukses) {
    // Set header sebelum mencetak pesan sukses
    header("refresh:2;url=jadwal.php"); // 2 = detik
    ?>
    <div class="alert alert-success" role="alert">
        <?php echo $sukses ?>
    </div>
    <?php
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ArenaFinder - Jadwal</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"
            style="background-color: #02406d;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">ArenaFInder <sup>Admin</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Pengelolaan Data
            </div>

            <!-- Nav Item - Jadwal Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Jadwal Lapangan</span></a>
            </li>

            <!-- Nav Item - Aktivitas Menu -->
            <li class="nav-item ">
                <a class="nav-link" href="aktivitas.php">
                    <i class="fa-solid fa-fire"></i>
                    <span>Aktivitas</span></a>
            </li>

            <!-- Nav Item - Referensi Menu -->
            <li class="nav-item ">
                <a class="nav-link" href="referensi.php">
                    <i class="fa-solid fa-asterisk"></i>
                    <span>Referensi</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Notifikasi
            </div>

            <!-- Nav Item - Pesanan -->
            <li class="nav-item">
                <a class="nav-link" href="pesanan.php">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>Pesanan</span></a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60"
                                            alt="...">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Douglas McGee</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Kelola Jadwal Pemesanan</h1>

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="card shadow mb-4" style="width: 71.5rem;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Tambah/Edit Jadwal</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <form action="" method="POST" enctype="multipart/form-data" autocomplete="off"
                                            onsubmit="return validasiForm()" required>
                                            <div class="mb-3 row">
                                                <label for="keanggotaan"
                                                    class="col-sm-2 col-form-label">Keanggotaan</label>
                                                <div class="col-sm-10">
                                                    <input type="radio" id="member" name="keanggotaan" value="Member"
                                                        <?php if ($anggota == "Member")
                                                            echo "checked"; ?>>
                                                    <label for="member">Member</label>

                                                    <input type="radio" id="nonmember" name="keanggotaan"
                                                        value="Non Member" style="margin-left: 20px;" <?php if ($anggota == "Non Member")
                                                            echo "checked"; ?>>
                                                    <label for="nonmember">Non Member</label>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="jenis_lap" class="col-sm-2 col-form-label">Jenis
                                                    Lapangan</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="jenis_lap" id="jenis_lap">
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
                                                        <input type="datetime-local" placeholder="-Pilih Tanggal-"
                                                            class="form-control" id="staticEmail" name="tanggal"
                                                            value="<?php echo $tanggal ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="waktu-mulai" class="col-sm-2 col-form-label">Waktu
                                                    Mulai</label>
                                                <div class="col-sm-10">
                                                    <input type="time" placeholder="-Pilih Waktu Mulai-"
                                                        class="form-control" id="waktu-mulai" name="waktu_mulai">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="waktu-selesai" class="col-sm-2 col-form-label">Waktu
                                                    Selesai</label>
                                                <div class="col-sm-10">
                                                    <input type="time" placeholder="-Pilih Waktu Selesai-"
                                                        class="form-control" id="waktu-selesai" name="waktu_selesai">
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="harga" name="harga"
                                                        readonly value="<?php echo $harga ?>">
                                                </div>

                                            </div>
                                            <div class="col-12">
                                                <input type="submit" name="simpan" value="Simpan Data"
                                                    class="btn btn-primary" style="margin-left: 60rem;">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    const waktuAwalInput = flatpickr("#waktu-mulai", {
                                        enableTime: true,
                                        noCalendar: true,
                                        dateFormat: "H:i",
                                    });
                                    const waktuAkhirInput = flatpickr("#waktu-selesai", {
                                        enableTime: true,
                                        noCalendar: true,
                                        dateFormat: "H:i",
                                    });
                                    const hargaInput = document.getElementById("harga");

                                    // Event listener untuk perubahan di input waktu-awal dan waktu-akhir
                                    waktuAwalInput.config.onChange.push(hitungHarga);
                                    waktuAkhirInput.config.onChange.push(hitungHarga);

                                    function hitungHarga() {
                                        const waktuAwal = waktuAwalInput.selectedDates[0];
                                        const waktuAkhir = waktuAkhirInput.selectedDates[0];

                                        // Pastikan kedua input sudah diisi dengan waktu yang valid
                                        if (waktuAwal && waktuAkhir) {
                                            // Periksa zona waktu untuk waktu awal dan waktu akhir
                                            const zonaWaktuAwal = waktuAwal.getTimezoneOffset();
                                            const zonaWaktuAkhir = waktuAkhir.getTimezoneOffset();

                                            if (zonaWaktuAwal === zonaWaktuAkhir) {
                                                const selisihWaktu = (waktuAkhir - waktuAwal) / (1000 * 60 * 60); // Selisih waktu dalam jam
                                                const hargaPerJam = 90000; // Ganti dengan harga per jam yang sesuai
                                                const totalHarga = selisihWaktu * hargaPerJam;
                                                hargaInput.value = totalHarga.toFixed(2); // Menampilkan harga dengan 2 desimal
                                            } else {
                                                hargaInput.value = "Zona waktu berbeda";
                                            }
                                        } else {
                                            hargaInput.value = ""; // Reset harga jika input tidak valid
                                        }
                                    }

                                });
                            </script>

                            <!-- DataTales Example -->
                            <div class="card shadow mb-4" style="width: 71.5rem;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Tabel Jadwal</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <form action="jadwal.php" method="GET">
                                            <div class="form-group">
                                                <input type="text" name="search" id="searchInput" class="form-control"
                                                    placeholder="Cari Jadwal"
                                                    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                            </div>
                                            <button type="submit" class="btn btn-info">Cari</button>
                                            <?php if (isset($_GET['search'])): ?>
                                                <a href="jadwal.php" class="btn btn-secondary" id="resetSearch">Hapus
                                                    Pencarian</a>
                                            <?php endif; ?>
                                        </form>
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Keanggotaan</th>
                                                    <th scope="col">Jenis Lapangan</th>
                                                    <th scope="col">Tanggal</th>
                                                    <th scope="col">Waktu Mulai</th>
                                                    <th scope="col">Waktu Selesai</th>
                                                    <th scope="col">Harga</th>
                                                    <th scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_GET['reset'])) {
                                                    // Pengguna menekan tombol "Hapus Pencarian"
                                                    header("Location: jadwal.php"); // Mengarahkan ke halaman tanpa parameter pencarian
                                                    exit();
                                                }

                                                if (isset($_GET['search'])) {
                                                    $searchTerm = $koneksi->real_escape_string($_GET['search']);
                                                    $sql = "SELECT * FROM jadwal WHERE jenis_lapangan LIKE '%$searchTerm%'";
                                                } else {
                                                    $sql = "SELECT * FROM jadwal ORDER BY id DESC";
                                                }

                                                $q2 = mysqli_query($koneksi, $sql);
                                                $urut = 1;
                                                while ($r2 = mysqli_fetch_array($q2)) {
                                                    $id = $r2['id'];
                                                    $anggota = $r2['keanggotaan'];
                                                    $jenis_lap = $r2['jenis_lapangan'];
                                                    $tanggal = $r2['tanggal'];
                                                    $w_mulai = $r2['waktu_mulai'];
                                                    $w_selesai = $r2['waktu_selesai'];
                                                    $harga = $r2['harga'];
                                                    ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <?php echo $urut++ ?>
                                                        </th>
                                                        <td scope="row">
                                                            <?php echo $anggota ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $jenis_lap ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $tanggal ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $w_mulai ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $w_selesai ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $harga ?>
                                                        </td>
                                                        <td scope="row">
                                                            <a href="jadwal.php?op=edit&id=<?php echo $id ?>"><button
                                                                    type="button" class="btn btn-warning">Edit</button></a>
                                                            <a href="jadwal.php?op=delete&id=<?php echo $id ?>"
                                                                onclick="return confirm('Yakin mau menghapus data ini?')"><button
                                                                    type="button" class="btn btn-danger">Delete</button></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>



                        </div>



                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("input[type=datetime-local]", {});
    </script>

    <script>
        config = {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",

        }
        flatpickr("input[type=time]", config);
    </script>

</body>

</html>