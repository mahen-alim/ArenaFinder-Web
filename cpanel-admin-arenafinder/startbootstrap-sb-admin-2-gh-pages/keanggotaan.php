<?php
session_start();
include('database.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

$userName = $_SESSION['username'];

$id = $nama = $alamat = $no_telp = $hari = $waktu = $durasi = $harga = $status = $sukses = $error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sqlDelete = "DELETE FROM venue_membership WHERE id_membership = '$id'";
    $resultDelete = mysqli_query($conn, $sqlDelete);

    if ($resultDelete) {
        $sukses = "Data Berhasil Dihapus";
    } else {
        $error = "Data Gagal Terhapus";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sqlFetch = "SELECT * FROM venue_membership WHERE id_membership = '$id'";
    $resultFetch = mysqli_query($conn, $sqlFetch);
    $row = mysqli_fetch_array($resultFetch);

    $nama = $row['nama'];
    $alamat = $row['alamat'];
    $no_telp = $row['no_telp'];
    $hari = explode(",", $row['hari_main']);
    $waktu = $row['waktu_main'];
    $durasi = $row['durasi_main'];
    $harga = $row['harga'];
    $status = $row['status'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}

function generateAutoId($conn)
{
    $getLastIdQuery = "SELECT MAX(id_membership) AS max_id FROM venue_membership";
    $result = mysqli_query($conn, $getLastIdQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        $lastIdRow = mysqli_fetch_assoc($result);
        $lastId = $lastIdRow['max_id'];
        $newId = $lastId + 1;
    } else {
        $newId = 1;
    }

    return $newId;
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

    $email = $_SESSION['email'];
    $fetchVenueIdQuery = "SELECT id_venue, email FROM venues WHERE email = '$email'";
    $fetchVenueIdResult = mysqli_query($conn, $fetchVenueIdQuery);

    if ($fetchVenueIdResult && mysqli_num_rows($fetchVenueIdResult) > 0) {
        $venueRow = mysqli_fetch_assoc($fetchVenueIdResult);
        $id_venue = $venueRow['id_venue'];
        $email = $venueRow['email'];

        if (ctype_digit($nama) || strlen($nama) < 5 || strlen($nama) > 30 || ctype_punct($nama)) {
            $error = "Terdapat kesalahan pada kolom nama.";
        }

        if (ctype_digit($alamat) || strlen($alamat) < 10 || strlen($alamat) > 100 || ctype_punct($alamat)) {
            $error = "Terdapat kesalahan pada kolom alamat.";
        }

        if (empty($error)) {
            if ($op == 'edit') {
                $sqlUpdate = "UPDATE venue_membership SET nama = '$nama', alamat = '$alamat', no_telp = '$no_telp', hari_main = '$hari', waktu_main = '$waktu', durasi_main = '$durasi', harga = '$harga', status = '$status' WHERE id_membership = '$id'";
                $resultUpdate = mysqli_query($conn, $sqlUpdate);

                if ($resultUpdate) {
                    $sukses = "Data member berhasil diupdate";
                } else {
                    $error = "Data member gagal diupdate: " . mysqli_error($conn);
                }
            } else {
                $id_membership = generateAutoId($conn);

                $sqlInsert = "INSERT INTO venue_membership (id_membership, nama, alamat, no_telp, hari_main, waktu_main, durasi_main, harga, status, id_venue, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sqlInsert);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sssssssssss", $id_membership, $nama, $alamat, $no_telp, $hari, $waktu, $durasi, $harga, $status, $id_venue, $email);
                    $resultInsert = mysqli_stmt_execute($stmt);

                    if ($resultInsert) {
                        $sukses = "Data member berhasil ditambahkan";
                    } else {
                        $error = "Data member gagal ditambahkan: " . mysqli_error($conn);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    $error = "Prepared statement failed";
                }
            }
        } else {
            $error = "Terdapat kesalahan validasi pada kolom nama atau alamat.";
        }
    } else {
        $error = "Venue tidak ditemukan untuk email ini";
    }
}

if ($error || $sukses || $error2 || $sukses2) {
    // Set header sebelum mencetak pesan
    $refreshUrl = "keanggotaan.php";
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

    <title>ArenaFinder - Keanggotaan</title>

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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="keanggotaan.php">
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
                <a class="nav-link" href="" id="anggota-link">
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
                    <i class="fa-solid fa-cart-shopping" aria-hidden="true">
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
                            <a class="nav-link dropdown-toggle" href="" id="userDropdown" role="button"
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
                                <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal">
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
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                        style="background-color: #02406d; color: white">
                                        <h6 class="m-0 font-weight-bold">Tambah/Edit <span
                                                style="color: #a1ff9f;">Keanggotaan</span></h6>
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
                                                        <input type="text" class="form-control" id="id_membership"
                                                            name="id_membership"
                                                            value="<?php echo generateAutoId($conn); ?>" required hidden>
                                                        <input type="text" class="form-control" id="nama" name="nama"
                                                            value="<?php echo $nama ?>" required autofocus>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" id="alamat" name="alamat"
                                                            required><?php echo $alamat ?></textarea>
                                                    </div>
                                                </div>


                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function () {
                                                        // Function to create and display error messages
                                                        function showError(element, message) {
                                                            // Check if an error message element already exists
                                                            var errorElement = element.nextElementSibling;
                                                            if (!errorElement || !errorElement.classList.contains('error-message')) {
                                                                // If not, create a new error message element
                                                                errorElement = document.createElement('div');
                                                                errorElement.className = 'error-message';
                                                                // Set style for the error message
                                                                errorElement.style.color = 'red';
                                                                errorElement.style.fontSize = '0.8em'; // You can adjust the font-size as needed
                                                                // Insert the error message below the input field
                                                                element.parentNode.insertBefore(errorElement, element.nextSibling);
                                                            }

                                                            // Set the error message
                                                            errorElement.textContent = message;
                                                        }

                                                        // Function to remove error messages
                                                        function clearError(element) {
                                                            var errorElement = element.nextElementSibling;
                                                            if (errorElement && errorElement.classList.contains('error-message')) {
                                                                // If an error message element exists, remove it
                                                                errorElement.parentNode.removeChild(errorElement);
                                                            }
                                                        }

                                                        // Find the input fields
                                                        var namaTempatInput = document.getElementById('nama');
                                                        var lokasiInput = document.getElementById('alamat');

                                                        // Add input event listeners to trigger validation
                                                        namaTempatInput.addEventListener('input', function () {
                                                            var namaTempatValue = this.value;

                                                            if (/^\d+$/.test(namaTempatValue)) {
                                                                showError(this, "Nama tidak dapat hanya berisi angka.");
                                                            } else if (/^[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]+$/.test(namaTempatValue)) {
                                                                showError(this, "Nama tidak dapat hanya berisi simbol.");
                                                            } else if (namaTempatValue.length < 5 || namaTempatValue.length > 30) {
                                                                showError(this, "Nama harus memiliki panjang antara 5 sampai 30 karakter.");
                                                            } else {
                                                                clearError(this);
                                                            }
                                                        });

                                                        lokasiInput.addEventListener('input', function () {
                                                            var lokasiValue = this.value;

                                                            // Memeriksa apakah input hanya terdiri dari angka
                                                            if (/^\d+$/.test(lokasiValue)) {
                                                                showError(this, "Alamat tidak dapat hanya berisi angka.");
                                                            } else if (/^[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]+$/.test(lokasiValue)) {
                                                                showError(this, "Alamat tidak dapat hanya berisi simbol.");
                                                            } else if (lokasiValue.length < 10 || lokasiValue.length > 100) {
                                                                showError(this, "Alamat harus memiliki panjang antara 10 sampai 100 karakter.");
                                                            } else {
                                                                clearError(this);
                                                            }
                                                        });

                                                    });
                                                </script>

                                                <div class="mb-3 row">
                                                    <label for="no_telp" class="col-sm-2 col-form-label">Nomor
                                                        Telepon</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="phoneNumber"
                                                            name="no_telp" value="<?php echo $no_telp ?>" required
                                                            oninput="validatePhoneNumber()">
                                                    </div>
                                                </div>

                                                <script>
                                                    function validatePhoneNumber() {
                                                        var phoneNumberInput = document.getElementById('phoneNumber');
                                                        var phoneNumberValue = phoneNumberInput.value;

                                                        // Remove non-numeric characters
                                                        var numericValue = phoneNumberValue.replace(/\D/g, '');

                                                        // Check if the entered value is a valid phone number
                                                        if (numericValue.length <= 13) {
                                                            phoneNumberInput.value = numericValue;
                                                        } else {
                                                            alert("Nomor telepon harus berupa angka dengan panjang antara 10 sampai 13 karakter.");
                                                            phoneNumberInput.value = phoneNumberValue.substring(0, 13); // Trim to 13 characters
                                                        }
                                                    }
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
                                                    <div class="col-sm-10 d-flex flex-wrap" style="margin-left: -10px;">
                                                        <?php
                                                        $selectedDays = is_array($hari) ? $hari : array();

                                                        $daysOfWeek = array("Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu");

                                                        foreach ($daysOfWeek as $day) {
                                                            $isChecked = in_array($day, $selectedDays) ? "checked" : "";
                                                            ?>
                                                            <div class="form-check mx-3">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="hari_main[]" id="<?= strtolower($day) ?>"
                                                                    value="<?= $day ?>" <?= $isChecked ?>>
                                                                <label class="form-check-label" for="<?= strtolower($day) ?>">
                                                                    <?= $day ?>
                                                                </label>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="waktu-main" class="col-sm-2 col-form-label">Waktu
                                                        Main</label>
                                                    <div class="col-sm-10">
                                                        <input type="time" placeholder="-Pilih Waktu Main-"
                                                            class="form-control" id="waktu_main" name="waktu_main"
                                                            value="<?php echo $waktu ?>" required>
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
                                                                echo "selected" ?>>1
                                                                    jam
                                                                </option>
                                                                <option value="2" <?php if ($durasi == "2")
                                                                echo "selected" ?>>2
                                                                    jam
                                                                </option>
                                                                <option value="3" <?php if ($durasi == "3")
                                                                echo "selected" ?>>3
                                                                    jam
                                                                </option>
                                                                <option value="4" <?php if ($durasi == "4")
                                                                echo "selected" ?>>4
                                                                    jam
                                                                </option>
                                                                <option value="5" <?php if ($durasi == "5")
                                                                echo "selected" ?>>5
                                                                    jam
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
                            <?php } ?>


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
                            <div class="card shadow mb-4" id="tabel-card">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                    style="color: white; background-color: #02406d;">
                                    <h6 class="m-0 font-weight-bold">Tabel <span
                                            style="color: #a1ff9f">Keanggotaan</span></h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php if ($error2 || $sukses2): ?>
                                            <div class="alert <?php echo $error2 ? 'alert-danger' : 'alert-success'; ?>"
                                                role="alert">
                                                <?php echo $error2 ? $error2 : $sukses2; ?>
                                            </div>
                                        <?php endif; ?>
                                        <form action="keanggotaan.php#tabel-card" method="GET">
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
                                                    <th scope="col">Nama Member</th>
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

                                                $jumlahDataPerHalaman = 3;

                                                // Query untuk menghitung total member dengan email = arenafinder.app@gmail.com atau sesuai dengan session email
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

                                                    if ($_SESSION['email'] === 'arenafinder.app@gmail.com') {
                                                        // Jika pengguna adalah SUPER ADMIN, ambil semua data
                                                        $sql = "SELECT vm.*, v.location
                                                                FROM venue_membership vm
                                                                JOIN venues v ON vm.id_venue = v.id_venue
                                                                WHERE vm.nama LIKE '%$searchTerm%'
                                                                ORDER BY vm.id_membership DESC
                                                                LIMIT $awalData, $jumlahDataPerHalaman";
                                                    } else {
                                                        // Jika bukan SUPER ADMIN, ambil data berdasarkan email pengguna yang login
                                                        $email = $_SESSION['email'];
                                                        $sql = "SELECT vm.*, v.location
                                                                FROM venue_membership vm
                                                                JOIN venues v ON vm.id_venue = v.id_venue
                                                                WHERE vm.nama LIKE '%$searchTerm%' AND v.email = '$email'
                                                                ORDER BY vm.id_membership DESC
                                                                LIMIT $awalData, $jumlahDataPerHalaman";
                                                    }
                                                } else {
                                                    // Jika tidak ada pencarian, gunakan logika yang sama
                                                    if ($_SESSION['email'] === 'arenafinder.app@gmail.com') {
                                                        // Jika pengguna adalah SUPER ADMIN, ambil semua data
                                                        $sql = "SELECT vm.*, v.location, v.venue_name
                                                                FROM venue_membership vm
                                                                JOIN venues v ON vm.id_venue = v.id_venue
                                                                ORDER BY vm.id_membership DESC
                                                                LIMIT $awalData, $jumlahDataPerHalaman";
                                                    } else {
                                                        // Jika bukan SUPER ADMIN, ambil data berdasarkan email pengguna yang login
                                                        $email = $_SESSION['email'];
                                                        $sql = "SELECT vm.*, v.location, v.venue_name
                                                                FROM venue_membership vm
                                                                JOIN venues v ON vm.id_venue = v.id_venue
                                                                WHERE v.email = '$email'
                                                                ORDER BY vm.id_membership DESC
                                                                LIMIT $awalData, $jumlahDataPerHalaman";
                                                    }
                                                }

                                                $member = mysqli_query($conn, $sql);
                                                $urut = 1 + $awalData;
                                                while ($r2 = mysqli_fetch_array($member)) {
                                                    $id = $r2['id_membership'];
                                                    $nama = $r2['nama'];
                                                    $venueName = $r2['venue_name'];
                                                    $alamat = $r2['alamat'];
                                                    $no_telp = $r2['no_telp'];
                                                    $hari = $r2['hari_main'];
                                                    $waktu = $r2['waktu_main'];
                                                    $durasi = $r2['durasi_main'];
                                                    $harga = $r2['harga'];
                                                    $status = $r2['status'];
                                                    $email = $r2['email']; // Tambahkan baris ini untuk mendapatkan data email
                                                
                                                    ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <?php echo $urut++ ?>
                                                        </th>
                                                        <?php if ($_SESSION['email'] === 'arenafinder.app@gmail.com'): ?>
                                                            <td scope="row"
                                                                style="overflow: hidden; word-wrap: break-word; white-space: normal;">
                                                                <?php echo $email ?>
                                                            </td>
                                                        <?php endif; ?>
                                                        <?php if ($_SESSION['email'] === 'arenafinder.app@gmail.com'): ?>
                                                            <td scope="row"
                                                                style="overflow: hidden; word-wrap: break-word; white-space: normal;">
                                                                <?php echo $venueName ?>
                                                            </td>
                                                        <?php endif; ?>
                                                        <td scope="row">
                                                            <?php echo $nama ?>
                                                        </td>
                                                        <td scope="row"
                                                            style="overflow: hidden; word-wrap: break-word; white-space: normal;">
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
                                                            <label class="btn"
                                                                style="cursor: default; opacity: 0.9; transition: opacity 0.2s; background-color: #02406d; color: white; position: relative;">
                                                                <?php
                                                                $words = explode(' ', $status);
                                                                foreach ($words as $index => $word) {
                                                                    $color = ($word == 'Member') ? 'white' : (($word == 'Aktif') ? '#A1FF9F' : 'white');
                                                                    echo '<span style="color: ' . $color . ';">' . $word . '</span>';
                                                                    if ($index < count($words) - 1) {
                                                                        echo ' ';
                                                                    }
                                                                }
                                                                ?>
                                                            </label>

                                                        </td>
                                                        <td scope="row">
                                                            <?php
                                                            if (
                                                                isset($_SESSION['email']) && $_SESSION['email'] ===
                                                                'arenafinder.app@gmail.com'
                                                            ) {

                                                            } else {
                                                                // User is not logged in or has a different email, show the Edit button
                                                                echo '<a href="keanggotaan.php?op=edit&id=' . $id . '"><button type="button"
                                                            class="btn btn-warning">Edit</button></a>';
                                                            }
                                                            ?>
                                                            <a href="keanggotaan.php?op=delete&id=<?php echo $id ?>"
                                                                onclick="return confirm('Yakin mau menghapus data ini?')"><button
                                                                    type="button" class="btn btn-danger">Delete</button></a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                } ?>
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