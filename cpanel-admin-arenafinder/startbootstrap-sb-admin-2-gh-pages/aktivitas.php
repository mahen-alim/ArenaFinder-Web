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
$nama = "";
$jenis = "";
$lokasi = "";
$tanggal = "";
$anggota = "";
$jam = "";
$harga = "";
$sukses = "";
$error = "";
$limit = 10 * 1024 * 1024; // Batasan ukuran file (10MB)

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM aktivitas WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Data Berhasil Dihapus";
    } else {
        $error = "Data Gagal Terhapus";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM aktivitas WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nama = $r1['nama_aktivitas'];
    $jenis = $r1['jenis_olga'];
    $lokasi = $r1['lokasi'];
    $tanggal = $r1['tanggal'];
    $anggota = $r1['keanggotaan'];
    $jam = $r1['jam'];
    $harga = $r1['harga'];


    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { //untuk create data
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis_olga'];
    $lokasi = $_POST['lokasi'];
    $tanggal = $_POST['tanggal'];
    $anggota = $_POST['keanggotaan'];
    $jam = $_POST['jam_main'];
    $harga = $_POST['harga'];


    if (!empty($_FILES['foto']['name'])) {
        $nama_file = $_FILES['foto']['name'];
        $tmp = $_FILES['foto']['tmp_name'];

        // Tentukan folder tempat menyimpan gambar (ganti dengan folder Anda)
        $upload_folder = 'C:\\xampp\\htdocs\\ArenaFinder\\public\\img\\venue\\';

        // Pindahkan file gambar ke folder tujuan
        if (move_uploaded_file($tmp, $upload_folder . $nama_file)) {
            // Jika pengunggahan berhasil, lanjutkan dengan query SQL
            // Periksa apakah file gambar diunggah

            if ($op == 'edit') {
                // Perbarui data jika ini adalah operasi edit
                $sql1 = "UPDATE aktivitas SET nama_aktivitas = '$nama', jenis_olga = '$jenis', lokasi = '$lokasi', tanggal = '$tanggal', keanggotaan = '$anggota', jam = '$jam', harga = '$harga', gambar = '$nama_file' WHERE id = '$id'";
            } else {
                // Tambahkan data jika ini adalah operasi insert
                $sql1 = "INSERT INTO aktivitas (nama_aktivitas, jenis_olga, lokasi, tanggal, keanggotaan, jam, harga, gambar) VALUES ('$nama', '$lokasi', '$tanggal', '$anggota', '$jam', '$harga', '$nama_file')";
            }

            $q1 = mysqli_query($koneksi, $sql1);

            if ($q1) {
                $sukses = "Data berhasil diupdate/ditambahkan";
            } else {
                $error = "Data gagal diupdate/ditambahkan";
            }

        } else {
            $error = "Harap pilih gambar yang akan diunggah";
        }
    } else {
        $error = "Harap pilih gambar yang akan diunggah";
    }
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
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

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
            <li class="nav-item ">
                <a class="nav-link" href="jadwal.php">
                    <i class="fa-solid fa-calendar-days"></i>
                    <span>Jadwal Lapangan</span></a>
            </li>

            <!-- Nav Item - Aktivitas Menu -->
            <li class="nav-item active">
                <a class="nav-link" href="">
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
                    <h1 class="h3 mb-4 text-gray-800">Kelola Aktivitas Olahraga</h1>

                    <div class="row">

                        <div class="col-lg-6">
                            <div class="card shadow mb-4" style="width: 71.5rem;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Tambah/Edit Aktivitas</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php
                                        if ($error) {
                                            ?>
                                            <div class="alert alert-danger" role="alert">
                                                <?php echo $error ?>
                                            </div>
                                            <?php
                                            header("refresh:2;url=aktivitas.php"); // 2 = detik
                                        
                                        }
                                        ?>
                                        <?php
                                        if ($sukses) {
                                            ?>
                                            <div class="alert alert-success" role="alert">
                                                <?php echo $sukses ?>
                                            </div>
                                            <?php
                                            header("refresh:2;url=aktivitas.php"); // 2 = detik
                                        }
                                        ?>

                                        <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                                            <div class="mb-3 row">
                                                <label for="nama" class="col-sm-2 col-form-label">Nama Aktivitas</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="staticEmail" name="nama"
                                                        value="<?php echo $nama ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="jenis_olga" class="col-sm-2 col-form-label">Jenis Olahraga</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="jenis_olga" id="jenis_olga">
                                                        <option value="">-Pilih Jenis Olahraga-</option>
                                                        <option value="Badminton" <?php if ($jenis == "Badminton")
                                                            echo "selected" ?>>Badminton
                                                            </option>
                                                            <option value="Futsal" <?php if ($jenis == "Futsal")
                                                            echo "selected" ?>>Futsal
                                                            </option>
                                                            <option value="Sepak Bola" <?php if ($jenis == "Sepak Bola")
                                                            echo "selected" ?>>Sepak Bola
                                                            </option>
                                                            <option value="Bola Voli" <?php if ($jenis == "Bola Voli")
                                                            echo "selected" ?>>Bola Voli
                                                            </option>
                                                            <option value="Bola Basket" <?php if ($jenis == "Bola Basket")
                                                            echo "selected" ?>>Bola Basket
                                                            </option>
                                                            <option value="Tenis Lapangan" <?php if ($jenis == "Tenis Lapangan")
                                                            echo "selected" ?>>Tenis Lapangan
                                                            </option>
                                                        </select>
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="staticEmail"
                                                        name="lokasi" value="<?php echo $lokasi ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3 row">
                                                <label for="alamat" class="col-sm-2 col-form-label">Tanggal Main</label>
                                                <div class="col-sm-10" onclick="">
                                                    <input type="datetime-local" placeholder="-Pilih Tanggal-"
                                                        class="form-control" id="staticEmail" name="tanggal"
                                                        value="<?php echo $tanggal ?>">
                                                </div>
                                            </div>
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
                                                <label for="jam main" class="col-sm-2 col-form-label">Jam Main</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="jam_main" id="jam_main">
                                                        <option value="">-Jam Main-</option>
                                                        <option value="1 jam" <?php if ($jam == "1 jam")
                                                            echo "selected" ?>>1 jam
                                                            </option>
                                                            <option value="2 jam" <?php if ($jam == "2 jam")
                                                            echo "selected" ?>>2 jam
                                                            </option>
                                                            <option value="3 jam" <?php if ($jam == "3 jam")
                                                            echo "selected" ?>>3 jam
                                                            </option>
                                                            <option value="4 jam" <?php if ($jam == "4 jam")
                                                            echo "selected" ?>>4 jam
                                                            </option>
                                                            <option value="5 jam" <?php if ($jam == "5 jam")
                                                            echo "selected" ?>>5 jam
                                                            </option>
                                                        </select>
                                                </div>
                                            </div>


                                                <div class=" mb-3 row">
                                                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="harga" name="harga"
                                                            readonly value="<?php echo $harga ?>">
                                                </div>

                                                <div class=" mb-3 row">
                                                    <label for="foto" class="col-sm-2 col-form-label"
                                                        style="margin-top: 10px; margin-left: 12px;">Gambar</label>
                                                    <input type="file" name="foto" required="required" multiple
                                                        style="margin-left: 213px; margin-top: -30px;" />
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
                                // Mendapatkan elemen-elemen yang diperlukan
                                var jamMainSelect = document.getElementById("jam_main");
                                var hargaInput = document.getElementById("harga");

                                // Tambahkan event listener untuk memantau perubahan pada pilihan jam_main
                                jamMainSelect.addEventListener("change", function () {
                                    // Mendapatkan nilai yang dipilih oleh pengguna
                                    var selectedValue = jamMainSelect.value;

                                    // Tentukan harga berdasarkan nilai yang dipilih
                                    var harga = 0;
                                    if (selectedValue === "1 jam") {
                                        harga = 15000;
                                    } else if (selectedValue === "2 jam") {
                                        harga = 30000;
                                    } else if (selectedValue === "3 jam") {
                                        harga = 45000;
                                    } else if (selectedValue === "4 jam") {
                                        harga = 50000;
                                    } else if (selectedValue === "5 jam") {
                                        harga = 65000;
                                    } else {
                                        <?php echo $error ?>
                                    }

                                    // Masukkan harga ke dalam input harga
                                    hargaInput.value = harga;
                                });

                            </script>

                            <!-- DataTales Example -->
                            <div class="card shadow mb-4" style="width: 71.5rem;">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Tabel Jadwal</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Nama Aktivitas</th>
                                                    <th scope="col">Jenis Olahraga</th>
                                                    <th scope="col">Lokasi</th>
                                                    <th scope="col">Tanggal Main</th>
                                                    <th scope="col">Keanggotaan</th>
                                                    <th scope="col">Jam Main</th>
                                                    <th scope="col">Harga</th>
                                                    <th scope="col">Gambar</th>
                                                    <th scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql2 = "SELECT * FROM aktivitas ORDER BY id DESC";
                                                $q2 = mysqli_query($koneksi, $sql2);
                                                $urut = 1;
                                                while ($r2 = mysqli_fetch_array($q2)) {
                                                    $id = $r2['id'];
                                                    $nama = $r2['nama_aktivitas'];
                                                    $jenis = $r2['jenis_olga'];
                                                    $lokasi = $r2['lokasi'];
                                                    $tanggal = $r2['tanggal'];
                                                    $anggota = $r2['keanggotaan'];
                                                    $jam = $r2['jam'];
                                                    $harga = $r2['harga'];
                                                    $gambar = $r2['gambar'];
                                                    ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <?php echo $urut++ ?>
                                                        </th>
                                                        <td scope="row">
                                                            <?php echo $nama ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $jenis ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $lokasi ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $tanggal ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $anggota ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $jam ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $harga ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $gambar ?>
                                                        </td>
                                                        <td scope="row">
                                                            <a href="aktivitas.php?op=edit&id=<?php echo $id ?>"><button
                                                                    type="button" class="btn btn-warning">Edit</button></a>
                                                            <a href="aktivitas.php?op=delete&id=<?php echo $id ?>"
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