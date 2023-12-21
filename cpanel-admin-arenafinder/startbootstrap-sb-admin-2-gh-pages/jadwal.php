<?php
session_start();
include('database.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['sport'])) {
    // Assign the value to $sportFromDB
    $sportFromDB = $_SESSION['sport'];
}

$email = $_SESSION['email'];

$userName = $_SESSION['username'];


$id = "";
$anggota = "";
$jenis_lap = "";
$tgl = "";
$waktu_mulai = "";
$waktu_selesai = "";
$harga = "";
$status = "";
$sukses = "";
$error = "";
$sukses2 = "";
$error2 = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "DELETE FROM venue_price WHERE id_price = '$id'";
    $q1 = mysqli_query($conn, $sql1);
    if ($q1) {
        $sukses2 = "Data Berhasil Dihapus";
    } else {
        $error2 = "Data Gagal Terhapus";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];

    // Ubah query untuk mendapatkan data yang sesuai dengan ID
    $sql1 = "SELECT vp.*, v.sport
            FROM venue_price vp
            JOIN venues v ON vp.id_venue = v.id_venue
            WHERE vp.id_price = '$id'"; // Sesuaikan dengan nama kolom yang sesuai

    $q1 = mysqli_query($conn, $sql1);

    if ($q1) {
        $r1 = mysqli_fetch_array($q1);

        $anggota = $r1['membership'];
        $jenis_lap = $r1['sport'];
        $tgl = $r1['date'];
        $waktu_mulai = $r1['start_hour'];
        $waktu_selesai = $r1['end_hour'];
        $harga = $r1['price'];
        $status = $r1['status_pemesanan'];

        if ($jenis_lap == '') {
            $error = "Data tidak ditemukan";
        }
    } else {
        $error = "Error querying database: " . mysqli_error($conn);
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") { //untuk create data
    // Get the user's email from the session
    $email = $_SESSION['email'];
    $anggota = $_POST['keanggotaan'];
    $jenis_lap = $_POST['jenis_lap'];
    $tgl = $_POST['tanggal'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];
    $harga = $_POST['harga'];


    if (empty($tgl)) {
        $error = "Tanggal main harus diisi";
    } else {
        $fetchVenueIdQuery = "SELECT v.id_venue, vl.id_lapangan, v.sport
                          FROM venues v 
                          JOIN venue_lapangan vl ON v.id_venue = vl.id_venue
                          WHERE v.email = '$email' AND v.sport = '$jenis_lap'";
        $fetchVenueIdResult = mysqli_query($conn, $fetchVenueIdQuery);

        if ($fetchVenueIdResult && mysqli_num_rows($fetchVenueIdResult) > 0) {
            $venueRow = mysqli_fetch_assoc($fetchVenueIdResult);
            $id_venue = $venueRow['id_venue'];
            $id_lapangan = $venueRow['id_lapangan'];

            // Additional validation checks
            if ($harga !== "Input selisih waktu salah" && $harga !== "Durasi waktu istirahat" && $harga !== "Harga tidak diketahui") {
                if ($waktu_mulai && $waktu_selesai) {
                    $startHour = (int) explode(":", $waktu_mulai)[0];
                    $endHour = (int) explode(":", $waktu_selesai)[0];

                    // Check if the start time is during the break (16:00 - 17:00)
                    if ($startHour >= 16 && $startHour < 17) {
                        $error = "Durasi waktu istirahat";
                    } else {
                        // Check for an existing schedule with the same date and overlapping time
                        $checkScheduleQuery = "SELECT COUNT(*) AS count_schedule
                                          FROM venue_price
                                          WHERE id_venue = '$id_venue'
                                          AND date = '$tgl'
                                          AND ((start_hour <= '$waktu_mulai' AND end_hour >= '$waktu_mulai')
                                               OR (start_hour <= '$waktu_selesai' AND end_hour >= '$waktu_selesai')
                                               OR (start_hour >= '$waktu_mulai' AND end_hour <= '$waktu_selesai'))
                                          AND membership = '$anggota'";

                        $checkScheduleResult = $conn->query($checkScheduleQuery);

                        if ($checkScheduleResult) {
                            $row = $checkScheduleResult->fetch_assoc();
                            $countSchedule = $row['count_schedule'];

                            if ($countSchedule > 0) {
                                // There is an existing schedule with the same date, overlapping time, and membership
                                $error = "Jadwal dengan tanggal, waktu, dan keanggotaan yang sama sudah ada.";
                            } else {
                                // Proceed with updating or inserting the schedule
                                if ($op == 'edit') {
                                    // Perbarui data jika ini adalah operasi edit
                                    $sql1 = "UPDATE venue_price SET 
                                                id_venue = '$id_venue',
                                                id_lapangan = '$id_lapangan',
                                                membership = '$anggota',
                                                date = '$tgl',
                                                start_hour = '$waktu_mulai',
                                                end_hour = '$waktu_selesai',
                                                price = '$harga'
                                            WHERE id_price = '$id'";
                                    $q1 = mysqli_query($conn, $sql1);

                                    if ($q1) {
                                        $sukses = "Data jadwal berhasil diupdate";
                                    } else {
                                        $error = "Data jadwal gagal diupdate";
                                    }
                                } else {
                                    // Tambahkan data jika ini adalah operasi insert
                                    $sql1 = "INSERT INTO venue_price (id_venue, id_lapangan, membership, date, start_hour, end_hour, price) 
                                        VALUES ('$id_venue', '$id_lapangan', '$anggota', '$tgl', '$waktu_mulai', '$waktu_selesai', '$harga')";
                                    $q1 = mysqli_query($conn, $sql1);

                                    if ($q1) {
                                        $sukses = "Data jadwal berhasil ditambahkan";
                                    } else {
                                        $error = "Data jadwal gagal ditambahkan";
                                    }
                                }
                            }
                        } else {
                            // Error executing query
                            $error = "Gagal melakukan pengecekan jadwal.";
                        }
                    }
                } else {
                    $error = "Input waktu mulai dan waktu selesai harus diisi";
                }
            } else {
                $error = "Terdapat kesalahan input harga";
            }
        } else {
            $error = "Tempat atau jenis olahraga tidak sesuai untuk email ini";
        }
    }
}


if ($error || $sukses || $error2 || $sukses2) {
    // Set header sebelum mencetak pesan
    $refreshUrl = "jadwal.php";
    if ($error2 || $sukses2) {
        $refreshUrl .= "#tabel-card";
    }
    header("refresh:2;url=$refreshUrl"); // 2 = detik
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
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="icon" href="../img_asset/login.png">
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
                searchInput.placeholder = 'Cari Jadwal';
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="jadwal.php">
                <div class="sidebar-brand-icon">
                    <i class="fa-solid fa-circle-user mx-3 ml-auto"></i>
                </div>
                <div class="sidebar-brand-text" style="text-transform: none; font-weight: 500; font-size: 20px">Arena
                </div>
                <div class="sidebar-brand-text"
                    style="color: #a1ff9f; text-transform: none; font-weight: 500; font-size: 20px">Finder <span
                        style="color: white;">|</span></div>
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
                <a class="nav-link" href="../index.php">
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

            <!-- Nav Item - Keanggotaan -->
            <li class="nav-item ">
                <a class="nav-link" href="keanggotaan.php">
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
                        <span class="badge badge-danger badge-counter"
                            style="background-color: #a1ff9f; color: #02406d; font-size: 15px;"
                            id="pesanan-link"></span>
                    </i>
                    <span>Pesanan</span></a>
            </li>

            <!-- Include jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

            <!-- Your Badge Script with AJAX -->
            <script>
                setInterval(function () {
                    function loadDoc() {
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("pesanan-link").innerHTML = this.responseText;
                            }
                        };
                        xhttp.open("GET", "check_badge.php", true);
                        xhttp.send();
                    }
                    loadDoc();
                }, 1000);
            </script>

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
                        style="color: #02406d">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <i class="fa-solid fa-calendar-days mt-3 mr-3" style="color: #02406d;"></i>
                        <h1 class="h3 mr-2 mt-4" style="color: #02406d; font-size: 20px; font-weight: bold;">Jadwal
                            Lapangan</h1>
                    </div>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Halo,
                                    <?php echo $userName; ?>
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
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <?php
                // Ambil level pengguna berdasarkan email yang terkait dengan sesi
                $email = $_SESSION['email']; // Pastikan sesi telah dimulai
                $sqlGetLevel = "SELECT level FROM users WHERE email = ?";
                $stmtGetLevel = $conn->prepare($sqlGetLevel);
                $stmtGetLevel->bind_param("s", $email);
                $stmtGetLevel->execute();
                $resultLevel = $stmtGetLevel->get_result();
                $rowLevel = $resultLevel->fetch_assoc();
                $level = $rowLevel['level'];
                $stmtGetLevel->close();
                ?>

                <!-- Begin Page Content -->

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xxl-8 col-12">
                            <?php
                            // Periksa level pengguna
                            if ($level != 'SUPER ADMIN') {
                                // Tampilkan form hanya jika level bukan 'SUPER ADMIN'
                                ?>
                                <div class="card shadow mb-4 overflow-hidden" id="form-jadwal">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                        style="background-color: #02406d; color: white">
                                        <h6 class="m-0 font-weight-bold">Tambah/Edit <span
                                                style="color: #a1ff9f;">Jadwal</span></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive overflow-hidden">
                                            <?php if ($error || $sukses): ?>
                                                <div class="alert <?php echo $error ? 'alert-danger' : 'alert-success'; ?>"
                                                    role="alert">
                                                    <?php echo $error ? $error : $sukses; ?>
                                                </div>
                                            <?php endif; ?>
                                            <form action="" method="POST" autocomplete="off"
                                                onsubmit="return validasiForm()" name="jadwal-form">

                                                <div class="mb-3 row">
                                                    <label for="jenis_lap" class="col-sm-2 col-form-label">
                                                        Keanggotaan</label>
                                                    <div class="col-sm-10">
                                                        <input type="radio" id="member" name="keanggotaan" value="1" <?php echo ($anggota == "1") ? "checked" : ""; ?> required>
                                                        <label for="member">Member</label>

                                                        <input type="radio" id="nonmember" name="keanggotaan" value="0"
                                                            style="margin-left: 20px;" <?php echo ($anggota == "0") ? "checked" : ""; ?> required>
                                                        <label for="nonmember">Non Member</label>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="jenis_lap" class="col-sm-2 col-form-label">Jenis
                                                        Olahraga</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="jenis_lap"
                                                            name="jenis_lap" value="<?php echo $sportFromDB; ?>" readonly>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="alamat" class="col-sm-2 col-form-label">Tanggal Main</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" placeholder="-Pilih Tanggal-"
                                                            class="form-control" id="tanggal" name="tanggal"
                                                            value="<?php echo $tgl; ?>" required>
                                                    </div>
                                                </div>

                                        </div>

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                flatpickr("#tanggal", {
                                                    enableTime: false, // Enable time selection
                                                    minDate: "today", // Set the minimum date to today
                                                    dateFormat: "Y-m-d", // Specify the date format
                                                });
                                            });

                                        </script>

                                        <div class="mb-3 row">
                                            <label for="waktu-mulai" class="col-sm-2 col-form-label">Waktu
                                                Mulai</label>
                                            <div class="col-sm-10">
                                                <input type="time" placeholder="-Pilih Waktu Mulai-" class="form-control"
                                                    id="waktu-mulai" name="waktu_mulai" value="<?php echo $waktu_mulai ?>"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="waktu-selesai" class="col-sm-2 col-form-label">Waktu
                                                Selesai</label>
                                            <div class="col-sm-10">
                                                <input type="time" placeholder="-Pilih Waktu Selesai-" class="form-control"
                                                    id="waktu-selesai" name="waktu_selesai"
                                                    value="<?php echo $waktu_selesai ?>" required>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="harga" name="harga"
                                                    value="<?php echo $harga ?>" readonly>
                                                <input type="text" class="form-control" id="status" name="status" readonly
                                                    hidden value="Belum Dipesan">
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
                        </div>
                    <?php } ?>


                    <script>
                        const waktuMulaiInput = document.getElementById("waktu-mulai");
                        const waktuAkhirInput = document.getElementById("waktu-selesai");
                        const hargaInput = document.getElementById("harga");
                        const jenisLapanganSelect = document.getElementById("jenis_lap");
                        const keanggotaanMember = document.getElementById("member");
                        const keanggotaanNonMember = document.getElementById("nonmember");

                        waktuMulaiInput.addEventListener("input", calculatePrice);
                        waktuAkhirInput.addEventListener("input", calculatePrice);
                        jenisLapanganSelect.addEventListener("change", calculatePrice);
                        keanggotaanMember.addEventListener("change", calculatePrice);
                        keanggotaanNonMember.addEventListener("change", calculatePrice);

                        function calculatePrice() {
                            const waktuMulai = waktuMulaiInput.value;
                            const waktuAkhir = waktuAkhirInput.value;
                            const selectedLapangan = jenisLapanganSelect.value;
                            const isMember = keanggotaanMember.checked;
                            const isNonMember = keanggotaanNonMember.checked;

                            if (waktuMulai && waktuAkhir) {
                                const [startHour, startMinute] = waktuMulai.split(":").map(Number);
                                const [endHour, endMinute] = waktuAkhir.split(":").map(Number);

                                const startMinutes = startHour * 60 + startMinute;
                                const endMinutes = endHour * 60 + endMinute;

                                if (startMinutes < endMinutes) {
                                    const durationHours = (endMinutes - startMinutes) / 60;
                                    let pricePerHour = 0;

                                    if (startHour === 16 && endHour === 17) {
                                        // Check if waktuMulai is between 16:00 and 17:00 (break time)
                                        hargaInput.value = "Durasi waktu istirahat";
                                        hargaInput.style.color = "red";
                                        return; // Stop further processing
                                    }

                                    switch (selectedLapangan) {
                                        case "Bulu tangkis":
                                            pricePerHour = 18000;
                                            break;
                                        case "Renang":
                                            pricePerHour = 8000;
                                            break;
                                        case "Futsal":
                                            if (isMember) {
                                                // Member pricing
                                                if (startHour >= 7 && endHour <= 16) {
                                                    // Session from 7 AM to 4 PM
                                                    pricePerHour = 90000;
                                                } else if (startHour >= 17 && endHour <= 24) {
                                                    // Session from 5 PM to 12 AM
                                                    pricePerHour = 120000;
                                                } else {
                                                    // Invalid time range
                                                    hargaInput.value = "Input selisih waktu salah";
                                                    hargaInput.style.color = "red";
                                                    return;
                                                }
                                            } else if (isNonMember) {
                                                // Non-Member pricing
                                                if (startHour >= 7 && endHour <= 16) {
                                                    // Session from 7 AM to 4 PM
                                                    pricePerHour = 105000;
                                                } else if (startHour >= 17 && endHour <= 24) {
                                                    // Session from 5 PM to 12 AM
                                                    pricePerHour = 135000;
                                                } else {
                                                    // Invalid time range
                                                    hargaInput.value = "Input selisih waktu salah";
                                                    hargaInput.style.color = "red";
                                                    return;
                                                }
                                            }
                                            break;
                                        default:
                                            // Default case, cabor not recognized
                                            hargaInput.value = "Harga tidak diketahui";
                                            hargaInput.style.color = "black";
                                            return;
                                    }

                                    const totalPrice = durationHours * pricePerHour;
                                    hargaInput.value = totalPrice;

                                    // Remove any previous warning
                                    hargaInput.style.color = "black";
                                } else {
                                    // Invalid time range, display a warning
                                    hargaInput.value = "Input selisih waktu salah";
                                    hargaInput.style.color = "red";
                                }
                            } else {
                                // One or both input fields are empty, clear the harga field
                                hargaInput.value = "";
                                hargaInput.style.color = "black";
                            }
                        }
                    </script>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                            style="color: white; background-color: #02406d;">
                            <h6 class="m-0 font-weight-bold">Tabel <span style="color: #a1ff9f">Jadwal</span></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if ($error2 || $sukses2): ?>
                                    <div class="alert <?php echo $error2 ? 'alert-danger' : 'alert-success'; ?>"
                                        role="alert">
                                        <?php echo $error2 ? $error2 : $sukses2; ?>
                                    </div>
                                <?php endif; ?>
                                <form action="jadwal.php" method="GET">
                                    <div class="form-group" style="display: flex; gap: 10px;">
                                        <input type="text" name="search" id="searchInput" style="width: 30%;"
                                            class="form-control" placeholder="Tekan / untuk Mencari Jadwal"
                                            value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

                                        <button type="submit" class="btn btn-info" id="searchButton">Cari</button>
                                        <?php if (isset($_GET['search'])): ?>
                                            <a href="jadwal.php" class="btn btn-secondary" id="resetSearch">Hapus
                                                Pencarian</a>
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
                                                        searchInput.placeholder = 'Cari Jadwal';
                                                        searchInput.style.borderColor = '';
                                                    }
                                                }
                                            };

                                            xhr.send();
                                        }
                                    });

                                    document.getElementById('searchInput').addEventListener('click', function () {
                                        var searchInput = document.getElementById('searchInput');
                                        searchInput.placeholder = 'Cari Jadwal';
                                        searchInput.style.borderColor = '';
                                    });

                                    document.addEventListener('keydown', function (event) {
                                        var searchInput = document.getElementById('searchInput');

                                        // Check if the 'F' key is pressed and the placeholder is 'Kolom pencarian tidak boleh kosong!'
                                        if (event.key.toLowerCase() === '/' && searchInput.placeholder === 'Kolom pencarian tidak boleh kosong!') {
                                            searchInput.placeholder = 'Cari Jadwal';
                                            searchInput.style.borderColor = '';
                                        }
                                    });
                                </script>

                                <table class="table text-nowrap table-centered table-hover" id="dataTable" width="100%"
                                    cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <?php if ($_SESSION['email'] === 'arenafinder.app@gmail.com'): ?>
                                                <th scope="col">
                                                    Email Pengelola
                                                </th>
                                            <?php endif; ?>
                                            <?php if ($_SESSION['email'] === 'arenafinder.app@gmail.com'): ?>
                                                <th scope="col">
                                                    Nama Tempat
                                                </th>
                                            <?php endif; ?>
                                            <th scope="col">Keanggotaan</th>
                                            <th scope="col">Jenis Olahraga</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Waktu Mulai</th>
                                            <th scope="col">Waktu Selesai</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="hoverable">
                                        <?php
                                        if (isset($_GET['reset'])) {
                                            // Pengguna menekan tombol "Hapus Pencarian"
                                            header("Location: jadwal.php"); // Mengarahkan ke halaman tanpa parameter pencarian
                                            exit();
                                        }

                                        $jumlahDataPerHalaman = 10;

                                        // Perform the query to get the total number of rows
                                        $queryCount = mysqli_query($conn, "SELECT COUNT(*) as total FROM venue_price");
                                        $countResult = mysqli_fetch_assoc($queryCount);
                                        $jumlahData = $countResult['total'];

                                        // Calculate the total number of pages
                                        $jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

                                        // Get the current page
                                        $page = (isset($_GET["page"])) ? $_GET["page"] : 1;

                                        // Calculate the starting data index for the current page
                                        $awalData = ($page - 1) * $jumlahDataPerHalaman;

                                        $email = $_SESSION['email'];

                                        if ($email === 'arenafinder.app@gmail.com') {
                                            // Jika email adalah arenafinder.app@gmail.com, tampilkan semua data
                                            if (isset($_GET['search'])) {
                                                $searchTerm = $conn->real_escape_string($_GET['search']);
                                                $sql = "SELECT vp.*, v.sport, v.email, v.venue_name
                                                        FROM venue_price vp
                                                        JOIN venues v ON vp.id_venue = v.id_venue
                                                        WHERE v.sport LIKE '%$searchTerm%'
                                                        ORDER BY vp.id_price DESC
                                                        LIMIT $awalData, $jumlahDataPerHalaman";
                                            } else {
                                                $sql = "SELECT vp.*, v.sport, v.email, v.venue_name
                                                        FROM venue_price vp
                                                        JOIN venues v ON vp.id_venue = v.id_venue
                                                        ORDER BY vp.id_price DESC
                                                        LIMIT $awalData, $jumlahDataPerHalaman";
                                            }
                                        } else {
                                            // Jika user tidak login dengan email arenafinder.app@gmail.com, tampilkan data sesuai dengan emailnya
                                            if (isset($_GET['search'])) {
                                                $searchTerm = $conn->real_escape_string($_GET['search']);
                                                $sql = "SELECT vp.*, v.sport, v.email, v.venue_name
                                                        FROM venue_price vp
                                                        JOIN venues v ON vp.id_venue = v.id_venue
                                                        WHERE v.email = '$email' AND v.sport LIKE '%$searchTerm%'
                                                        ORDER BY vp.id_price DESC
                                                        LIMIT $awalData, $jumlahDataPerHalaman";
                                            } else {
                                                $sql = "SELECT vp.*, v.sport, v.email, v.venue_name
                                                        FROM venue_price vp
                                                        JOIN venues v ON vp.id_venue = v.id_venue
                                                        WHERE v.email = '$email'
                                                        ORDER BY vp.id_price DESC
                                                        LIMIT $awalData, $jumlahDataPerHalaman";
                                            }
                                        }

                                        $jadwal = mysqli_query($conn, $sql);
                                        $urut = 1 + $awalData;

                                        while ($r2 = mysqli_fetch_array($jadwal)) {
                                            $id = $r2['id_price'];
                                            $email = $r2['email'];
                                            $venueName = $r2['venue_name'];
                                            $anggota = $r2['membership'];
                                            $sport = $r2['sport'];
                                            $tgl = $r2['date'];
                                            $w_mulai = $r2['start_hour'];
                                            $w_selesai = $r2['end_hour'];
                                            $harga = $r2['price'];
                                            // Konversi nilai $anggota ke teks
                                            $status_anggota = ($anggota == 0) ? "Non Member" : "Member";
                                            ?>
                                            <tr>
                                                <th scope="row">
                                                    <?php echo $urut++ ?>
                                                </th>
                                                <?php if ($_SESSION['email'] === 'arenafinder.app@gmail.com'): ?>
                                                    <td scope="row">
                                                        <?php echo $email ?>
                                                    </td>
                                                <?php endif; ?>
                                                <?php if ($_SESSION['email'] === 'arenafinder.app@gmail.com'): ?>
                                                    <td scope="row">
                                                        <?php echo $venueName ?>
                                                    </td>
                                                <?php endif; ?>
                                                <td scope="row">
                                                    <?php echo $status_anggota ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $sport ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $tgl ?>
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
                                                    <?php
                                                    if (
                                                        isset($_SESSION['email']) && $_SESSION['email'] ===
                                                        'arenafinder.app@gmail.com'
                                                    ) {

                                                    } else {
                                                        // User is not logged in or has a different email, show the Edit button
                                                        echo '<a href="jadwal.php?op=edit&id=' . $id . '"><button type="button"
                                                            class="btn btn-warning">Edit</button></a>';
                                                    }
                                                    ?>
                                                    <a href="jadwal.php?op=delete&id=<?php echo $id ?>"
                                                        onclick="return confirm('Yakin mau menghapus data ini?')"><button
                                                            type="button" class="btn btn-danger">Delete</button></a>
                                                </td>
                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function () {
                                                        <?php if ($isArenaFinderEmail): ?>
                                                            document.getElementById('editButton').addEventListener('click', function () {
                                                                // Manually trigger the modal
                                                                $('#editModal').modal('show');
                                                            });
                                                        <?php endif; ?>
                                                    });
                                                </script>

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
                                        echo "<li class='page-item'><a class='page-link' href='jadwal.php?page=" . ($page - 1) . "'>&laquo; Previous</a></li>";
                                    }

                                    // Numbered pagination links
                                    for ($i = 1; $i <= $jumlahHalaman; $i++) {
                                        echo "<li class='page-item " . (($page == $i) ? 'active' : '') . "'><a class='page-link' href='jadwal.php?page=$i'>$i</a></li>";
                                    }

                                    // Next page link
                                    if ($page < $jumlahHalaman) {
                                        echo "<li class='page-item'><a class='page-link' href='jadwal.php?page=" . ($page + 1) . "'>Next &raquo;</a></li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
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
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>



    <!-- Include Bootstrap CSS and JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <!-- flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3"></script>
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