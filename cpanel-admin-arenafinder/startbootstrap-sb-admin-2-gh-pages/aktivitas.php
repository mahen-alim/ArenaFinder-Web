<?php
session_start();
include('database.php');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

if (isset($_SESSION['sport'])) {
    // Assign the value to $sportFromDB
    $sportFromVenues = $_SESSION['sport'];
}

$email = $_SESSION['email'];

$userName = $_SESSION['username'];

$id = "";
$nama = "";
$desc = "";
$jenis = "";
$lokasi = "";
$tanggal = "";
$anggota = "";
$jam = "";
$harga = "";
$sukses = "";
$error = "";
$sukses2 = "";
$error2 = "";
$limit = 10 * 1024 * 1024; // Batasan ukuran file (10MB)

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];

    // Hapus data dari tabel terkait terlebih dahulu
    $sqlDeleteMember = "DELETE FROM venue_aktivitas_member WHERE id_aktivitas = '$id'";
    $qDeleteMember = mysqli_query($conn, $sqlDeleteMember);

    if ($qDeleteMember) {
        // Hapus data dari tabel utama setelah menghapus data dari tabel terkait
        $sqlDeleteAktivitas = "DELETE FROM venue_aktivitas WHERE id_aktivitas = '$id'";
        $qDeleteAktivitas = mysqli_query($conn, $sqlDeleteAktivitas);

        if ($qDeleteAktivitas) {
            $sukses2 = "Data Berhasil Dihapus";
        } else {
            $error2 = "Gagal menghapus data aktivitas: " . mysqli_error($conn);
        }
    } else {
        $error2 = "Gagal menghapus data member: " . mysqli_error($conn);
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT va.*, v.location AS venue_lokasi
             FROM venue_aktivitas va
             JOIN venues v ON va.id_venue = v.id_venue
             WHERE va.id_aktivitas = '$id'";
    $q1 = mysqli_query($conn, $sql1);
    $r1 = mysqli_fetch_array($q1);

    $nama = $r1['nama_aktivitas'];
    $desc = $r1['desc_aktivitas'];
    $jenis = $r1['sport'];
    $tanggal = $r1['date'];
    $anggota = $r1['membership'];
    $jam = $r1['jam_main'];
    $harga = $r1['price'];
    $nama_file = $r1['photo'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $desc = $_POST['desc_aktivitas'];
    $jenis = $_POST['jenis_olga'];
    $tanggal = $_POST['tanggal'];
    $anggota = $_POST['keanggotaan'];
    $jam = $_POST['jam_main'];
    $harga = $_POST['harga'];
    $email = $_SESSION['email'];

    if (empty($tanggal)) {
        $error = "Tanggal main harus diisi";
    } else {
        $fetchVenueIdQuery = "SELECT id_venue, sport FROM venues WHERE email = '$email'";
        $fetchVenueIdResult = mysqli_query($conn, $fetchVenueIdQuery);


        if ($fetchVenueIdResult && mysqli_num_rows($fetchVenueIdResult) > 0) {
            $venueRow = mysqli_fetch_assoc($fetchVenueIdResult);
            $id_venue = $venueRow['id_venue'];
            $sportFromDB = $venueRow['sport'];

            if ($jenis == $sportFromDB) {

                if (ctype_digit($nama)) {
                    $error .= "Nama aktivitas tidak dapat hanya berisi angka. ";
                } elseif (strlen($nama) < 5 || strlen($nama) > 30) {
                    $error .= "Nama aktivitas harus memiliki panjang antara 5 sampai 30 karakter. ";
                } elseif (ctype_punct($nama)) {
                    $error .= "Nama aktivitas tidak dapat hanya berisi simbol. ";
                }

                if (empty($error)) {
                    if (!empty($_FILES['foto']['name'])) {
                        $nama_file = $_FILES['foto']['name'];
                        $tmp = $_FILES['foto']['tmp_name'];

                        // Tentukan folder tempat menyimpan gambar (ganti dengan folder Anda)
                        $upload_folder = '../public/img/venue/';

                        // Pindahkan file gambar ke folder tujuan
                        if (move_uploaded_file($tmp, $upload_folder . $nama_file)) {
                            // Jika pengunggahan berhasil, lanjutkan dengan query SQL
                            // Periksa apakah file gambar diunggah
                            if ($op == 'edit') {
                                // Perbarui data jika ini adalah operasi edit
                                $sql1 = "UPDATE venue_aktivitas SET 
                                 nama_aktivitas = '$nama',
                                 desc_aktivitas = '$desc',
                                 sport = '$jenis',
                                 date = '$tanggal',
                                 membership = '$anggota',
                                 jam_main = '$jam',
                                 price = '$harga',
                                 photo = '$nama_file',
                                 id_venue = '$id_venue'
                              WHERE id_aktivitas = '$id'";
                                $q1 = mysqli_query($conn, $sql1);

                                if ($q1) {
                                    $sukses = "Data aktivitas berhasil diupdate";
                                } else {
                                    $error = "Data aktivitas gagal diupdate";
                                }
                            } else {
                                // Tambahkan data jika ini adalah operasi insert
                                $sql1 = "INSERT INTO venue_aktivitas (nama_aktivitas, desc_aktivitas, sport, date, membership, jam_main, price, photo, id_venue, max_member) 
                              VALUES ('$nama', '$desc', '$jenis', '$tanggal', '$anggota', '$jam', '$harga', '$nama_file', '$id_venue', 999)";
                                $q1 = mysqli_query($conn, $sql1);

                                if ($q1) {
                                    $sukses = "Data aktivitas berhasil ditambahkan";
                                } else {
                                    $error = "Data aktivitas gagal ditambahkan";
                                }
                            }
                        } else {
                            $error = "Harap pilih gambar yang akan diunggah";
                        }
                    } else {
                        $error = "Harap pilih gambar yang akan diunggah";
                    }
                } else {
                    $error = "Terdapat kesalahan validasi pada kolom nama aktivitas.";
                }
            } else {
                $error .= "Jenis olahraga tidak sesuai dengan email. ";
            }
        } else {
            $error = "Venue tidak ditemukan untuk email ini";
        }
    }
}

if ($error || $sukses || $error2 || $sukses2) {
    // Set header sebelum mencetak pesan
    $refreshUrl = "aktivitas.php";
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

    <title>ArenaFinder - Aktivitas</title>

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
                searchInput.placeholder = 'Cari Aktivitas';
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="aktivitas.php">
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
            <li class="nav-item active">
                <a class="nav-link" href="">
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
                        style="color: #02406d;">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <i class="fa-solid fa-fire mt-3 mr-3" style="color: #02406d;"></i>
                        <h1 class="h3 mr-2 mt-4" style="color: #02406d; font-size: 20px; font-weight: bold;">Aktivitas
                        </h1>
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
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                        style="background-color: #02406d; color: white">
                                        <h6 class="m-0 font-weight-bold">Tambah/Edit <span
                                                style="color: #a1ff9f;">Aktivitas</span></h6>
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
                                                    <label for="nama" class="col-sm-2 col-form-label">Nama Aktivitas</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="nama" name="nama"
                                                            value="<?php echo $nama ?>" required autofocus>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="desc_aktivitas" class="col-sm-2 col-form-label">Deskripsi
                                                        Aktivitas</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" id="desc_aktivitas"
                                                            name="desc_aktivitas" required><?php echo $desc ?></textarea>
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
                                                        var namaInput = document.getElementById('nama');

                                                        // Add input event listeners to trigger validation
                                                        namaInput.addEventListener('input', function () {
                                                            var namaTempatValue = this.value;

                                                            if (/^\d+$/.test(namaTempatValue)) {
                                                                showError(this, "Nama aktivitas tidak dapat hanya berisi angka.");
                                                            } else if (/^[!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]+$/.test(namaTempatValue)) {
                                                                showError(this, "Nama aktivitas tidak dapat hanya berisi simbol.");
                                                            } else if (namaTempatValue.length < 5 || namaTempatValue.length > 30) {
                                                                showError(this, "Nama aktivitas harus memiliki panjang antara 5 sampai 30 karakter.");
                                                            } else {
                                                                clearError(this);
                                                            }
                                                        });

                                                    });
                                                </script>
                                                <div class="mb-3 row">
                                                    <label for="jenis_lap" class="col-sm-2 col-form-label">Jenis
                                                        Olahraga</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="jenis_olga"
                                                            name="jenis_olga" value="<?php echo $sportFromVenues; ?>"
                                                            readonly>
                                                    </div>
                                                </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="alamat" class="col-sm-2 col-form-label">Tanggal Main</label>
                                            <div class="col-sm-10" onclick="">
                                                <input type="text" placeholder="-Pilih Tanggal-" class="form-control"
                                                    id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>" required>
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
                                            <label for="keanggotaan" class="col-sm-2 col-form-label">Keanggotaan</label>
                                            <div class="col-sm-10">
                                                <input type="radio" id="member" name="keanggotaan" value="Member" <?php echo ($anggota == "Member") ? 'checked' : ''; ?>     <?php echo ($sportFromVenues == "Renang") ? 'disabled' : ''; ?> required>
                                                <label for="member">Member</label>

                                                <input type="radio" id="nonmember" name="keanggotaan" value="Non Member"
                                                    style="margin-left: 20px;" <?php echo ($anggota == "Non Member") ? 'checked' : ''; ?>     <?php echo ($sportFromVenues == "Renang") ? 'disabled' : ''; ?> required>
                                                <label for="nonmember">Non Member</label>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="jam main" class="col-sm-2 col-form-label"
                                                style="cursor: pointer">Jam Main</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="jam_main" id="jam_main" required>
                                                    <option value="">-Jam Main-</option>
                                                    <option value="1" <?php if ($jam == "1")
                                                        echo "selected" ?>>1 jam
                                                        </option>
                                                        <option value="2" <?php if ($jam == "2")
                                                        echo "selected" ?>>2 jam
                                                        </option>
                                                        <option value="3" <?php if ($jam == "3")
                                                        echo "selected" ?>>3 jam
                                                        </option>
                                                        <option value="4" <?php if ($jam == "4")
                                                        echo "selected" ?>>4 jam
                                                        </option>
                                                        <option value="5" <?php if ($jam == "5")
                                                        echo "selected" ?>>5 jam
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="mb-3 row">
                                                <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="harga" name="harga" readonly
                                                        value="<?php echo $harga ?>">
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                                            <div class="col-sm-10">
                                                <input class="col-xxl-8 col-12" type="file" id="foto" name="foto"
                                                    required="required" style="margin-left: -10px;"/>
                                            </div>
                                        </div>

                                        <div class="mb-3 row">
                                            <label class="col-sm-2 col-form-label">Tampilan</label>
                                            <div class="col-sm-10">
                                                <?php
                                                // Tampilkan gambar jika ada
                                                if (!empty($nama_file)) {
                                                    echo "<img src='../public/img/venue/$nama_file' alt='Gambar' style='width: 100px; height: auto;'>";
                                                }
                                                ?>
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
                        const jamMainSelect = document.getElementById("jam_main");
                        const hargaInput = document.getElementById("harga");
                        const jenisLapanganSelect = document.getElementById("jenis_olga");
                        const keanggotaanMember = document.getElementById("member");
                        const keanggotaanNonMember = document.getElementById("nonmember");

                        jamMainSelect.addEventListener("input", calculatePrice);
                        jenisLapanganSelect.addEventListener("change", calculatePrice);
                        keanggotaanMember.addEventListener("change", calculatePrice);
                        keanggotaanNonMember.addEventListener("change", calculatePrice);

                        function calculatePrice() {
                            const selectedJamMain = jamMainSelect.value;
                            const selectedLapangan = jenisLapanganSelect.value;
                            const isMember = keanggotaanMember.checked;
                            const isNonMember = keanggotaanNonMember.checked;

                            // Assuming the duration is 1 hour for simplicity, you can modify this based on your actual input
                            const durationHours = 1;
                            let basePricePerHour = 0;

                            switch (selectedLapangan) {
                                case "Sepak bola":
                                    basePricePerHour = 50000;
                                    break;
                                case "Bola Voli":
                                    basePricePerHour = 50000;
                                    break;
                                case "Bola Basket":
                                    basePricePerHour = 50000;
                                    break;
                                case "Tenis Lapangan":
                                    basePricePerHour = 18000;
                                    break;
                                case "Bulu tangkis":
                                    basePricePerHour = 18000;
                                    break;
                                case "Renang":
                                    basePricePerHour = 10000;
                                    break;
                                case "Futsal":
                                    if (isMember) {
                                        // Member pricing
                                        basePricePerHour = 90000;
                                    } else if (isNonMember) {
                                        // Non-Member pricing
                                        basePricePerHour = 105000;
                                    } else {
                                        // Neither is selected, set a default value or handle accordingly
                                        hargaInput.value = "Pilih keanggotaan terlebih dahulu";
                                        hargaInput.style.color = "red";
                                        return;
                                    }
                                    break;
                                default:
                                    // Default case, cabor not recognized
                                    hargaInput.value = "Harga tidak diketahui";
                                    hargaInput.style.color = "black";
                                    return;
                            }

                            // Calculate total price
                            const totalPrice = durationHours * basePricePerHour * selectedJamMain;

                            hargaInput.value = totalPrice;

                            // Remove any previous warning
                            hargaInput.style.color = "black";
                        }
                    </script>


                    <!-- DataTales Example -->
                    <div class="card shadow mb-4" id="tabel-card">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                            style="color: white; background-color: #02406d;">
                            <h6 class="m-0 font-weight-bold">Tabel <span style="color: #a1ff9f">Aktivitas</span></h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php if ($error2 || $sukses2): ?>
                                    <div class="alert <?php echo $error2 ? 'alert-danger' : 'alert-success'; ?>"
                                        role="alert">
                                        <?php echo $error2 ? $error2 : $sukses2; ?>
                                    </div>
                                <?php endif; ?>
                                <form action="aktivitas.php" method="GET">
                                    <div class="form-group" style="display: flex; gap: 10px;">
                                        <input type="text" name="search" class="form-control" id="searchInput"
                                            style="width: 30%;" placeholder="Tekan / untuk Mencari Aktivitas"
                                            value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                        <button type="submit" class="btn btn-info" id="searchButton">Cari</button>
                                        <?php if (isset($_GET['search'])): ?>
                                            <a href="aktivitas.php" class="btn btn-secondary">Hapus Pencarian</a>
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
                                            searchInput.placeholder = 'Cari Aktivitas';
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
                                            <th scope="col">Nama Aktivitas</th>
                                            <th scope="col">Deskripsi Aktivitas</th>
                                            <th scope="col">Jenis Olahraga</th>
                                            <th scope="col">Lokasi</th>
                                            <th scope="col">Tanggal Main</th>
                                            <th scope="col">Keanggotaan</th>
                                            <th scope="col">Jam Main</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Foto</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (isset($_GET['reset'])) {
                                            // Pengguna menekan tombol "Hapus Pencarian"
                                            header("Location: aktivitas.php"); // Mengarahkan ke halaman tanpa parameter pencarian
                                            exit();
                                        }

                                        $jumlahDataPerHalaman = 3;

                                        // Perform the query to get the total number of rows
                                        $queryCount = mysqli_query($conn, "SELECT COUNT(*) as total FROM venue_aktivitas");
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
                                                $sql = "SELECT va.*, v.location, v.email, v.venue_name
                                                        FROM venue_aktivitas va
                                                        JOIN venues v ON va.id_venue = v.id_venue
                                                        WHERE va.nama_aktivitas LIKE '%$searchTerm%'
                                                        ORDER BY va.id_aktivitas DESC
                                                        LIMIT $awalData, $jumlahDataPerHalaman";
                                            } else {
                                                $sql = "SELECT va.*, v.location, v.email, v.venue_name
                                                        FROM venue_aktivitas va
                                                        JOIN venues v ON va.id_venue = v.id_venue
                                                        ORDER BY va.id_aktivitas DESC
                                                        LIMIT $awalData, $jumlahDataPerHalaman";
                                            }
                                        } else {
                                            // Jika email bukan arenafinder.app@gmail.com, tampilkan data sesuai dengan session email
                                            if (isset($_GET['search'])) {
                                                $searchTerm = $conn->real_escape_string($_GET['search']);
                                                $sql = "SELECT va.*, v.location, v.email, v.venue_name
                                                        FROM venue_aktivitas va
                                                        JOIN venues v ON va.id_venue = v.id_venue
                                                        WHERE va.nama_aktivitas LIKE '%$searchTerm%' AND v.email = '$email'
                                                        ORDER BY va.id_aktivitas DESC
                                                        LIMIT $awalData, $jumlahDataPerHalaman";
                                            } else {
                                                $sql = "SELECT va.*, v.location, v.email, v.venue_name
                                                        FROM venue_aktivitas va
                                                        JOIN venues v ON va.id_venue = v.id_venue
                                                        WHERE v.email = '$email'
                                                        ORDER BY va.id_aktivitas DESC
                                                        LIMIT $awalData, $jumlahDataPerHalaman";
                                            }
                                        }

                                        $aktivitas = mysqli_query($conn, $sql);
                                        $urut = 1 + $awalData;

                                        while ($r2 = mysqli_fetch_array($aktivitas)) {
                                            $id = $r2['id_aktivitas'];
                                            $email = $r2['email'];
                                            $venueName = $r2['venue_name'];
                                            $desc = $r2['desc_aktivitas'];
                                            $nama = $r2['nama_aktivitas'];
                                            $jenis = $r2['sport'];
                                            $lokasi = $r2['location']; // Ambil data dari kolom location di tabel venues
                                            $tanggal = $r2['date'];
                                            $anggota = $r2['membership'];
                                            $jam = $r2['jam_main'];
                                            $harga = $r2['price'];
                                            $foto = $r2['photo'];
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
                                                <td scope="row"
                                                    style="overflow: hidden; word-wrap: break-word; white-space: normal;">
                                                    <?php echo $nama ?>
                                                </td>
                                                <td scope="row"
                                                    style="overflow: hidden; word-wrap: break-word; white-space: normal;">
                                                    <?php echo $desc ?>
                                                </td>
                                                <td scope="row">
                                                    <?php echo $jenis ?>
                                                </td>
                                                <td scope="row"
                                                    style="overflow: hidden; word-wrap: break-word; white-space: normal;">
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
                                                    Jam
                                                </td>
                                                <td scope="row">
                                                    <?php echo $harga ?>
                                                </td>
                                                <td scope="row">
                                                    <img src="../public/img/venue/<?php echo $foto; ?>" alt="Image"
                                                        style="width: 100px; height: 100px;">
                                                </td>

                                                <td scope="row">
                                                    <?php
                                                    if (
                                                        isset($_SESSION['email']) && $_SESSION['email'] ===
                                                        'arenafinder.app@gmail.com'
                                                    ) {
                                                    } else {
                                                        // User is not logged in or has a different email, show the Edit button
                                                        echo '<a href="aktivitas.php?op=edit&id=' . $id . '"><button type="button"
                                                            class="btn btn-warning">Edit</button></a>';
                                                    }
                                                    ?>
                                                    <a href="aktivitas.php?op=delete&id=<?php echo $id ?>"
                                                        onclick="return confirm('Yakin mau menghapus data ini?')">
                                                        <button type="button" class="btn btn-danger">Delete</button>
                                                    </a>
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
                                        echo "<li class='page-item'><a class='page-link' href='aktivitas.php?page=" . ($page - 1) . "'>&laquo; Previous</a></li>";
                                    }

                                    // Numbered pagination links
                                    for ($i = 1; $i <= $jumlahHalaman; $i++) {
                                        echo "<li class='page-item " . (($page == $i) ? 'active' : '') . "'><a class='page-link' href='aktivitas.php?page=$i'>$i</a></li>";
                                    }

                                    // Next page link
                                    if ($page < $jumlahHalaman) {
                                        echo "<li class='page-item'><a class='page-link' href='aktivitas.php?page=" . ($page + 1) . "'>Next &raquo;</a></li>";
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
        config = {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",

        }
        flatpickr("input[type=time]", config);
    </script>

</body>

</html>