<?php
session_start();
include('database.php');

$id = "";
$nama = "";
$alamt = "";
$no_telp = "";
$hari = "";
$waktu = "";
$durasi = "";
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
    $sql1 = "DELETE FROM venue_membership WHERE id_membership = '$id'";
    $q1 = mysqli_query($conn, $sql1);
    if ($q1) {
        $sukses = "Data Berhasil Dihapus";
    } else {
        $error = "Data Gagal Terhapus";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM venue_membership WHERE id_membership = '$id'";
    $q1 = mysqli_query($conn, $sql1);
    $r2 = mysqli_fetch_array($q1);
    $nama = $r2['nama'];
    $alamat = $r2['alamat'];
    $no_telp = $r2['no_telp'];
    $hari = $r2['hari_main'];
    $waktu = $r2['waktu_main'];
    $durasi = $r2['durasi_main'];
    $harga = $r2['harga'];
    $status = $r2['status'];


    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $hari = implode(",", $_POST['hari_main']);
    $waktu = $_POST['waktu_main'];
    $durasi = $_POST['durasi_main'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    // Fetch id_venue based on the user's email
    $email = $_SESSION['email'];
    $fetchVenueIdQuery = "SELECT id_venue, email FROM venues WHERE email = '$email'";
    $fetchVenueIdResult = mysqli_query($conn, $fetchVenueIdQuery);

    if ($fetchVenueIdResult && mysqli_num_rows($fetchVenueIdResult) > 0) {
        $venueRow = mysqli_fetch_assoc($fetchVenueIdResult);
        $id_venue = $venueRow['id_venue'];
        $email = $venueRow['email'];

        if ($op == 'edit') {
            // Perbarui data jika ini adalah operasi edit
            $sql1 = "UPDATE venue_membership SET nama = '$nama', alamat = '$alamat', no_telp = '$no_telp', hari_main = '$hari', waktu_main = '$waktu', durasi_main = '$durasi', harga = '$harga', status = '$status' WHERE id_membership = '$id'";
            $q1 = mysqli_query($conn, $sql1);

            if ($q1) {
                $sukses = "Data member berhasil diupdate";
            } else {
                $error = "Data member gagal diupdate";
            }
        } else {
            // Tambahkan data jika ini adalah operasi insert
            $sql1 = "INSERT INTO venue_membership (nama, alamat, no_telp, hari_main, waktu_main, durasi_main, harga, status, id_venue, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql1);

            // Check if the statement was prepared successfully
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssssssss", $nama, $alamat, $no_telp, $hari, $waktu, $durasi, $harga, $status, $id_venue, $email);
                $result = mysqli_stmt_execute($stmt);

                if ($result) {
                    $sukses = "Data member berhasil ditambahkan";
                } else {
                    $error = "Data member gagal ditambahkan";
                }

                // Close the statement
                mysqli_stmt_close($stmt);
            } else {
                // Handle the case where the statement preparation fails
                $error = "Prepared statement failed";
            }

        }
    } else {
        $error = "Venue tidak ditemukan untuk email ini";
    }
}


if ($error) {
    // Set header sebelum mencetak pesan kesalahan
    header("refresh:2;url=keanggotaan.php"); // 2 = detik
?>
<?php
}

if ($sukses) {
    // Set header sebelum mencetak pesan sukses
    header("refresh:2;url=keanggotaan.php"); // 2 = detik
?>
<?php
}


if (!isset($_SESSION['email'])) {
    // Jika pengguna belum masuk, arahkan mereka kembali ke halaman login
    header("Location: login.php");
    exit();
}

// Pengguna sudah masuk, Anda dapat mengakses data sesi
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ArenaFinder - Keanggotaan</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        body {
            font-family: "Kanit", sans-serif;
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
    </style>

    <script>
        // JavaScript code to focus on the search input when "F" key is pressed
        document.addEventListener('keydown', function (event) {
            // Check if the pressed key is 'F' (case-insensitive)
            if (event.key.toLowerCase() === '/') {
                // Focus on the search input
                document.getElementById('searchInput').focus();
                searchInput.placeholder = 'Cari Member';
                searchInput.style.borderColor = '';
                // Prevent the default behavior of the key press
                event.preventDefault();
            }
        });
    </script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #02406d;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-clipboard mx-3 ml-auto"></i>
                </div>
                <div class="sidebar-brand-text">Arena</div>
                <div class="sidebar-brand-text" style="color: #a1ff9f;">Finder</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fa-solid fa-house-user"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Nav Item - Web -->
            <li class="nav-item">
                <a class="nav-link" href="/ArenaFinder/php/beranda.php">
                    <i class="fa-brands fa-edge"></i>
                    <span>Lihat Website</span></a>
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
            <li class="nav-item">
                <a class="nav-link" href="aktivitas.php">
                    <i class="fa-solid fa-fire"></i>
                    <span>Aktivitas</span></a>
            </li>

            <!-- Nav Item - Keanggotaan -->
            <li class="nav-item active">
                <a class="nav-link" href="">
                    <i class="fa-solid fa-users"></i>
                    <span>Keanggotaan</span></a>
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
                    <i class="fa-solid fa-cart-shopping">
                        <span class="badge badge-danger badge-counter">New</span>
                    </i>
                    <span>Pesanan</span></a>
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
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: white;">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"
                        style="color: #02406d;">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <i class="fa-solid fa-users mt-3 mr-3" style="color: #02406d;"></i>
                        <h1 class="h3 mr-2 mt-4" style="color: #02406d; font-size: 20px; font-weight: bold;">Keanggotaan
                        </h1>
                    </div>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Halo,
                                    <?php echo $email; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>

                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profil.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
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

                    <div class="row">

                        <div class="col-xxl-8 col-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                    style="background-color: #02406d; color: white">
                                    <h6 class="m-0 font-weight-bold">Tambah/Edit Keanggotaan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive overflow-hidden">
                                        <?php if ($error || $sukses): ?>
                                            <div class="alert <?php echo $error ? 'alert-danger' : 'alert-success'; ?>"
                                                role="alert">
                                                <?php echo $error ? $error : $sukses; ?>
                                            </div>
                                        <?php endif; ?>
                                        <form action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                                            <div class="mb-3 row">
                                                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="staticEmail" name="nama"
                                                        value="<?php echo $nama ?>" required autofocus>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                                <div class="col-sm-10">
                                                    <textarea type="text" class="form-control" id="staticEmail"
                                                        name="alamat" value="<?php echo $alamat ?>" required></textarea>
                                                </div>
                                            </div>

                                            <div class="input-group mb-3 row">
                                                <label for="no_telp" class="col-sm-2 col-form-label">Nomor
                                                    Telepon</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group ml-1">
                                                        <div class="input-group-prepend">
                                                            <button type="button"
                                                                class="btn btn-outline-secondary dropdown-toggle"
                                                                data-toggle="dropdown">
                                                                <img src="https://cdn-icons-png.flaticon.com/512/323/323372.png"
                                                                    width="20" height="auto" alt="" title=""
                                                                    class="img-small">+62 (Indonesia)
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><a class="dropdown-item" href="#" data-code="+62">
                                                                        <img src="https://cdn-icons-png.flaticon.com/512/323/323372.png"
                                                                            width="20" height="auto" alt="" title=""
                                                                            class="img-small">+62 (Indonesia)</a></li>
                                                                <li><a class="dropdown-item" href="#" data-code="+970">
                                                                        <img src="https://cdn-icons-png.flaticon.com/512/6157/6157447.png "
                                                                            width="20" height="auto" alt="" title=""
                                                                            class="img-small">+970 (Palestina)</a></li>
                                                                <li><a class="dropdown-item" href="#"
                                                                        data-code="+65"><img
                                                                            src="   https://cdn-icons-png.flaticon.com/512/12339/12339650.png "
                                                                            width="20" height="auto" alt="" title=""
                                                                            class="img-small">+65 (Singapura)</a></li>
                                                                <li><a class="dropdown-item" href="#"
                                                                        data-code="+91"><img
                                                                            src="   https://cdn-icons-png.flaticon.com/512/10597/10597864.png "
                                                                            width="20" height="auto" alt="" title=""
                                                                            class="img-small">+91 (India)</a></li>
                                                                <li><a class="dropdown-item" href="#"
                                                                        data-code="+61"><img
                                                                            src="   https://cdn-icons-png.flaticon.com/512/3909/3909435.png "
                                                                            width="20" height="auto" alt="" title=""
                                                                            class="img-small">+61 (Australia)</a></li>
                                                                <li><a class="dropdown-item" href="#"
                                                                        data-code="+33"><img
                                                                            src="   https://cdn-icons-png.flaticon.com/512/5921/5921991.png "
                                                                            width="20" height="auto" alt="" title=""
                                                                            class="img-small">+33 (France)</a></li>
                                                                <li><a class="dropdown-item" href="#"
                                                                        data-code="+49"><img
                                                                            src="   https://cdn-icons-png.flaticon.com/512/323/323332.png "
                                                                            width="20" height="auto" alt="" title=""
                                                                            class="img-small">+49 (Germany)</a></li>
                                                                <li><a class="dropdown-item" href="#"
                                                                        data-code="+81"><img
                                                                            src="   https://cdn-icons-png.flaticon.com/512/197/197604.png "
                                                                            width="20" height="auto" alt="" title=""
                                                                            class="img-small">+81 (Japan)</a></li>
                                                            </ul>
                                                        </div>

                                                        <input type="text" class="form-control" id="selectedCountryCode"
                                                            aria-label="Text input with segmented dropdown button"
                                                            name="no_telp" value="+62" required>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Anda perlu menyertakan jQuery dan Bootstrap JS untuk mengaktifkan dropdown -->
                                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                            <script
                                                src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function () {
                                                    // Menambahkan event listener untuk mengganti teks tombol saat item dropdown dipilih
                                                    const dropdownItems = document.querySelectorAll('.dropdown-item');
                                                    const dropdownButton = document.querySelector('.btn.btn-outline-secondary');

                                                    dropdownItems.forEach(function (item) {
                                                        item.addEventListener('click', function (event) {
                                                            event.preventDefault(); // Menghentikan tautan standar
                                                            const selectedCode = this.getAttribute('data-code');
                                                            const selectedCountry = this.textContent;
                                                            const countryLogo = this.querySelector('img').getAttribute('src');

                                                            // Mengganti teks tombol dengan logo dan teks negara
                                                            dropdownButton.innerHTML = `<img src="${countryLogo}" width="20" height="auto" alt="" title="" class="img-small"> ${selectedCountry}`;
                                                            document.querySelector('#selectedCountryCode').value = selectedCode;
                                                        });
                                                    });
                                                });
                                            </script>
                                            <script>
                                                // Mendapatkan elemen-elemen yang diperlukan
                                                var jamMainSelect = document.getElementById("durasi_main");
                                                var hargaInput = document.getElementById("harga");

                                                // Tambahkan event listener untuk memantau perubahan pada pilihan jam_main
                                                jamMainSelect.addEventListener("change", function () {
                                                    // Mendapatkan nilai yang dipilih oleh pengguna
                                                    var selectedValue = jamMainSelect.value;

                                                    // Tentukan harga berdasarkan nilai yang dipilih
                                                    var harga = 0;
                                                    if (selectedValue === "1 jam") {
                                                        harga = 90000;
                                                    } else if (selectedValue === "2 jam") {
                                                        harga = 180000;
                                                    } else if (selectedValue === "3 jam") {
                                                        harga = 360000;
                                                    } else if (selectedValue === "4 jam") {
                                                        harga = 720000;
                                                    } else if (selectedValue === "5 jam") {
                                                        harga = 1440000;
                                                    } else {
                                                        <?php echo $error ?>
                                                    }

                                                    // Masukkan harga ke dalam input harga
                                                    hargaInput.value = harga;
                                                });

                                            </script>

                                            <div class="mb-3 row">
                                                <label for="hari_main" class="col-sm-2 col-form-label"
                                                    style="cursor: pointer">Hari Main</label>
                                                <div class="col-sm-10 d-flex flex-wrap">
                                                    <div class="form-check mx-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="hari_main[]" id="senin" value="Senin" <?php if ($hari == "Senin")
                                                                echo "checked"; ?>>
                                                        <label class="form-check-label" for="senin">Senin</label>
                                                    </div>
                                                    <div class="form-check mx-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="hari_main[]" id="selasa" value="Selasa" <?php if ($hari == "Selasa")
                                                                echo "checked"; ?>>
                                                        <label class="form-check-label" for="selasa">Selasa</label>
                                                    </div>
                                                    <div class="form-check mx-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="hari_main[]" id="rabu" value="Rabu" <?php if ($hari == "Rabu")
                                                                echo "checked"; ?>>
                                                        <label class="form-check-label" for="rabu">Rabu</label>
                                                    </div>
                                                    <div class="form-check mx-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="hari_main[]" id="kamis" value="Kamis" <?php if ($hari == "Kamis")
                                                                echo "checked"; ?>>
                                                        <label class="form-check-label" for="kamis">Kamis</label>
                                                    </div>
                                                    <div class="form-check mx-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="hari_main[]" id="jum'at" value="Jum'at" <?php if ($hari == "Jum'at")
                                                                echo "checked"; ?>>
                                                        <label class="form-check-label" for="jum'at">Jum'at</label>
                                                    </div>
                                                    <div class="form-check mx-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="hari_main[]" id="sabtu" value="Sabtu" <?php if ($hari == "Sabtu")
                                                                echo "checked"; ?>>
                                                        <label class="form-check-label" for="sabtu">Sabtu</label>
                                                    </div>
                                                    <div class="form-check mx-3">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="hari_main[]" id="minggu" value="Minggu" <?php if ($hari == "Minggu")
                                                                echo "checked"; ?>>
                                                        <label class="form-check-label" for="rabu">Minggu</label>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="mb-3 row">
                                                <label for="waktu-main" class="col-sm-2 col-form-label">Waktu
                                                    Main</label>
                                                <div class="col-sm-10">
                                                    <input type="time" placeholder="-Pilih Waktu Main-"
                                                        class="form-control" id="waktu_main" name="waktu_main" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="durasi_main" class="col-sm-2 col-form-label"
                                                    style="cursor: pointer">Jam Main</label>
                                                <div class="col-sm-10">
                                                    <select class="form-control" name="durasi_main" id="durasi_main"
                                                        required>
                                                        <option value="">-Durasi Main-</option>
                                                        <option value="1" <?php if ($durasi == "1")
                                                            echo "selected" ?>>1 jam
                                                            </option>
                                                            <option value="2" <?php if ($durasi == "2")
                                                            echo "selected" ?>>2 jam
                                                            </option>
                                                            <option value="3" <?php if ($durasi == "3")
                                                            echo "selected" ?>>3 jam
                                                            </option>
                                                            <option value="4" <?php if ($durasi == "4")
                                                            echo "selected" ?>>4 jam
                                                            </option>
                                                            <option value="5" <?php if ($durasi == "5")
                                                            echo "selected" ?>>5 jam
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="harga" name="harga"
                                                            readonly value="<?php echo $harga ?>">
                                                    <input type="text" class="form-control" id="status" name="status"
                                                        hidden value="Member Aktif">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xxl-8 col-12">
                                                    <input type="submit" name="simpan" value="Simpan Data"
                                                        class="btn w-100 mt-5" id="save-btn">
                                                </div>
                                            </div>


                                        </form>
                                    </div>
                                </div>
                            </div>


                            <script>
                                // Mendapatkan elemen-elemen yang diperlukan
                                var jamMainSelect = document.getElementById("durasi_main");
                                var hargaInput = document.getElementById("harga");

                                // Tambahkan event listener untuk memantau perubahan pada pilihan jam_main
                                jamMainSelect.addEventListener("change", function () {
                                    // Mendapatkan nilai yang dipilih oleh pengguna
                                    var selectedValue = jamMainSelect.value;

                                    // Tentukan harga berdasarkan nilai yang dipilih
                                    var harga = 0;
                                    if (selectedValue == "1") {
                                        harga = 90000;
                                    } else if (selectedValue == "2") {
                                        harga = 180000;
                                    } else if (selectedValue == "3") {
                                        harga = 360000;
                                    } else if (selectedValue == "4") {
                                        harga = 720000;
                                    } else if (selectedValue == "5") {
                                        harga = 1440000;
                                    } else {
                                        <?php echo $error ?>
                                    }

                                    // Masukkan harga ke dalam input harga
                                    hargaInput.value = harga;
                                });

                            </script>

                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                    style="color: white; background-color: #02406d;">
                                    <h6 class="m-0 font-weight-bold">Tabel Keanggotaan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <form action="keanggotaan.php" method="GET">
                                            <div class="form-group" style="display: flex; gap: 10px;">
                                                <input type="text" name="search" class="form-control" id="searchInput"
                                                    style="width: 30%;" placeholder="Tekan / untuk Mencari Member"
                                                    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                                <button type="submit" class="btn btn-info"
                                                    id="searchButton">Cari</button>
                                                <?php if (isset($_GET['search'])): ?>
                                                    <a href="keanggotaan.php" class="btn btn-secondary">Hapus Pencarian</a>
                                                <?php endif; ?>
                                            </div>
                                        </form>

                                        <script>
                                            document.getElementById('searchButton').addEventListener('click', function (event) {
                                                var searchInput = document.getElementById('searchInput');

                                                if (searchInput.value === '') {
                                                    event.preventDefault(); // Prevent form submission if the search field is empty
                                                    searchInput.placeholder = 'Kolom pencarian tidak boleh kosong!';
                                                    searchInput.style.borderColor = 'red'; // Change border color to red
                                                } else {
                                                    // Perform AJAX request to check if the value exists in the database
                                                    var xhr = new XMLHttpRequest();
                                                    xhr.open('GET', 'aktivitas.php?checkValue=' + encodeURIComponent(searchInput.value), true);

                                                    xhr.onload = function () {
                                                        if (xhr.status === 200) {
                                                            console.log(xhr.responseText);
                                                            var response = JSON.parse(xhr.responseText);
                                                            if (response.count === 0) {
                                                                // Value not found in the database
                                                                event.preventDefault();
                                                                searchInput.placeholder = 'Pencarian tidak ditemukan!';
                                                                searchInput.style.borderColor = 'red';
                                                            } else {
                                                                // Reset styles
                                                                searchInput.placeholder = 'Cari Aktivitas';
                                                                searchInput.style.borderColor = '';
                                                            }
                                                        }
                                                    };

                                                    xhr.send();
                                                }
                                            });

                                            document.getElementById('searchInput').addEventListener('click', function () {
                                                var searchInput = document.getElementById('searchInput');
                                                searchInput.placeholder = 'Cari Aktivitas';
                                                searchInput.style.borderColor = '';
                                            });

                                            document.addEventListener('keydown', function (event) {
                                                var searchInput = document.getElementById('searchInput');

                                                // Check if the 'F' key is pressed and the placeholder is 'Kolom pencarian tidak boleh kosong!'
                                                if (event.key.toLowerCase() === '/' && searchInput.placeholder === 'Kolom pencarian tidak boleh kosong!') {
                                                    searchInput.placeholder = 'Cari Member';
                                                    searchInput.style.borderColor = '';
                                                }
                                            });
                                        </script>

                                        <table class="table text-nowrap table-centered table-hover" id="dataTable"
                                            width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">Alamat</th>
                                                    <th scope="col">No. Telepon</th>
                                                    <th scope="col">Hari Main</th>
                                                    <th scope="col">Waktu Main</th>
                                                    <th scope="col">Durasi Main</th>
                                                    <th scope="col">Harga</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_GET['reset'])) {
                                                    // Pengguna menekan tombol "Hapus Pencarian"
                                                    header("Location: keanggotaan.php"); // Mengarahkan ke halaman tanpa parameter pencarian
                                                    exit();
                                                }

                                                $jumlahDataPerHalaman = 10;

                                                // Perform the query to get the total number of rows
                                                $queryCount = mysqli_query($conn, "SELECT COUNT(*) as total FROM venue_membership");
                                                $countResult = mysqli_fetch_assoc($queryCount);
                                                $jumlahData = $countResult['total'];

                                                // Calculate the total number of pages
                                                $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

                                                // Get the current page
                                                $page = (isset($_GET["page"])) ? $_GET["page"] : 1;

                                                // Calculate the starting data index for the current page
                                                $awalData = ($page - 1) * $jumlahDataPerHalaman;

                                                if (isset($_GET['search'])) {
                                                    $searchTerm = $conn->real_escape_string($_GET['search']);
                                                    $sql = "SELECT * FROM venue_membership WHERE nama LIKE '%$searchTerm%' LIMIT $awalData, $jumlahDataPerHalaman";
                                                } else {
                                                    $sql = "SELECT * FROM venue_membership ORDER BY id_membership DESC LIMIT $awalData, $jumlahDataPerHalaman";
                                                }
                                                $member = mysqli_query($conn, $sql);
                                                $urut = 1 + $awalData;
                                                while ($r2 = mysqli_fetch_array($member)) {
                                                    $id = $r2['id_membership'];
                                                    $nama = $r2['nama'];
                                                    $alamat = $r2['alamat'];
                                                    $no_telp = $r2['no_telp'];
                                                    $hari = $r2['hari_main'];
                                                    $waktu = $r2['waktu_main'];
                                                    $durasi = $r2['durasi_main'];
                                                    $harga = $r2['harga'];
                                                    $status = $r2['status'];
                                                    ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <?php echo $urut++ ?>
                                                        </th>
                                                        <td scope="row">
                                                            <?php echo $nama ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $alamat ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $no_telp ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $hari ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $waktu ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $durasi ?>
                                                            Jam
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $harga ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $status ?>
                                                        </td>
                                                        <td scope="row">
                                                            <a href="keanggotaan.php?op=edit&id=<?php echo $id ?>"><button
                                                                    type="button" class="btn btn-warning"
                                                                    id="editButton">Edit</button></a>
                                                            <a href="keanggotaan.php?op=delete&id=<?php echo $id ?>"
                                                                onclick="return confirm('Yakin mau menghapus data ini?')"><button
                                                                    type="button" class="btn btn-danger">Delete</button></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <!-- Pagination code -->
                                        <ul class='pagination'>
                                            <!-- Previous page link -->
                                            <?php
                                            if ($page > 1) {
                                                echo "<li class='page-item'><a class='page-link' href='keanggotaan.php?page=" . ($page - 1) . "'>&laquo; Previous</a></li>";
                                            }

                                            // Numbered pagination links
                                            for ($i = 1; $i <= $jumlahHalaman; $i++) {
                                                echo "<li class='page-item " . (($page == $i) ? 'active' : '') . "'><a class='page-link' href='keanggotaan.php?page=$i'>$i</a></li>";
                                            }

                                            // Next page link
                                            if ($page < $jumlahHalaman) {
                                                echo "<li class='page-item'><a class='page-link' href='keanggotaan.php?page=" . ($page + 1) . "'>Next &raquo;</a></li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>



                        </div>




                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

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
                    <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Akhiri aktivitas?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
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