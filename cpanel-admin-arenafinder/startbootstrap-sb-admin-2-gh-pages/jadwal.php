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
            $sukses = "Data jadwal berhasil diupdate/ditambahkan";
        } else {
            $error = "Data jadwal gagal diupdate/ditambahkan";
        }
    } else {
        $error = "Terdapat kesalahan input waktu";
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
    <style>
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
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #02406d;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-clipboard"></i>
                </div>
                <div class="sidebar-brand-text mx-3">ArenaFInder <sup>Admin</sup></div>
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
                <a class="nav-link" href="/ArenaFinder/html/beranda.html">
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
        <div id="content-wrapper" class="d-flex flex-column" style="background-color: #e7f5ff;">

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
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xxl-8 col-12">
                                <div class="card shadow mb-4 overflow-hidden" id="form-jadwal">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                        style="background-color: #02406d; color: white">
                                        <h6 class="m-0 font-weight-bold">Tambah/Edit Jadwal</h6>
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
                                                onsubmit="return validasiForm()">
                                                <div class="mb-3 row">
                                                    <label for="keanggotaan"
                                                        class="col-sm-2 col-form-label">Keanggotaan</label>
                                                    <div class="col-sm-10">
                                                        <input type="radio" id="member" name="keanggotaan"
                                                            value="Member" <?php if ($anggota == "Member")
                                                                echo "checked"; ?> required>
                                                        <label for="member">Member</label>

                                                        <input type="radio" id="nonmember" name="keanggotaan"
                                                            value="Non Member" style="margin-left: 20px;" <?php if ($anggota == "Non Member")
                                                                echo "checked"; ?> required>
                                                        <label for="nonmember">Non Member</label>
                                                    </div>
                                                </div>
                                                <div class="mb-3 row">
                                                    <label for="jenis_lap" class="col-sm-2 col-form-label">Jenis
                                                        Lapangan</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" name="jenis_lap" id="jenis_lap"
                                                            required>
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
                                                                class="form-control" id="tanggal" name="tanggal"
                                                                value="<?php echo $tanggal ?>" required>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="waktu-mulai" class="col-sm-2 col-form-label">Waktu
                                                        Mulai</label>
                                                    <div class="col-sm-10">
                                                        <input type="time" placeholder="-Pilih Waktu Mulai-"
                                                            class="form-control" id="waktu-mulai" name="waktu_mulai"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="waktu-selesai" class="col-sm-2 col-form-label">Waktu
                                                        Selesai</label>
                                                    <div class="col-sm-10">
                                                        <input type="time" placeholder="-Pilih Waktu Selesai-"
                                                            class="form-control" id="waktu-selesai" name="waktu_selesai"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="harga" name="harga"
                                                            readonly>
                                                        <input type="text" class="form-control" id="status"
                                                            name="status" readonly hidden value="Belum Dipesan">
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
                                    const waktuMulaiInput = document.getElementById("waktu-mulai");
                                    const waktuAkhirInput = document.getElementById("waktu-selesai");
                                    const hargaInput = document.getElementById("harga");
                                    const jenisLapanganSelect = document.getElementById("jenis_lap");

                                    waktuMulaiInput.addEventListener("input", calculatePrice);
                                    waktuAkhirInput.addEventListener("input", calculatePrice);
                                    jenisLapanganSelect.addEventListener("change", calculatePrice);

                                    function calculatePrice() {
                                        const waktuMulai = waktuMulaiInput.value;
                                        const waktuAkhir = waktuAkhirInput.value;
                                        const selectedLapangan = jenisLapanganSelect.value;

                                        if (waktuMulai && waktuAkhir) {
                                            const [startHour, startMinute] = waktuMulai.split(":").map(Number);
                                            const [endHour, endMinute] = waktuAkhir.split(":").map(Number);

                                            const startMinutes = startHour * 60 + startMinute;
                                            const endMinutes = endHour * 60 + endMinute;

                                            if (startMinutes < endMinutes) {
                                                const durationHours = (endMinutes - startMinutes) / 60;
                                                let pricePerHour = 90000;

                                                // Check if waktuMulai is between 16:00 and 17:00 (break time)
                                                if (startHour === 16 && startMinute >= 0 && startMinute <= 59) {
                                                    hargaInput.value = "Durasi waktu istirahat";
                                                    hargaInput.style.color = "red";
                                                    return; // Stop further processing
                                                }

                                                // Check if waktuMulai is between 17:00 and 24:00
                                                if (startHour >= 17 && startHour < 24) {
                                                    pricePerHour = 120000;
                                                }

                                                // Update pricePerHour based on selected jenis lapangan
                                                if (selectedLapangan === "Badminton") {
                                                    pricePerHour = 15000;
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
                                        <h6 class="m-0 font-weight-bold">Tabel Jadwal</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <form action="jadwal.php" method="GET">
                                                <div class="form-group" style="display: flex; gap: 10px;">
                                                    <input type="text" name="search" id="searchInput"
                                                        style="width: 30%;" class="form-control"
                                                        placeholder="Cari Jadwal"
                                                        value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

                                                    <button type="submit" class="btn btn-info"
                                                        id="searchButton">Cari</button>
                                                    <?php if (isset($_GET['search'])): ?>
                                                        <a href="jadwal.php" class="btn btn-secondary"
                                                            id="resetSearch">Hapus
                                                            Pencarian</a>
                                                    <?php endif; ?>
                                                </div>
                                            </form>

                                            <script>
                                                document.getElementById('searchButton').addEventListener('click', function (event) {
                                                    var searchInput = document.getElementById('searchInput');

                                                    if (searchInput.value === '') {
                                                        event.preventDefault(); // Mencegah pengiriman form jika field pencarian kosong
                                                        searchInput.placeholder = 'Kolom pencarian tidak boleh kosong!';
                                                        searchInput.style.borderColor = 'red'; // Mengubah warna border field

                                                    } else {
                                                        searchInput.style.borderColor = '';
                                                    }
                                                });

                                                document.getElementById('searchInput').addEventListener('click', function () {
                                                    var searchInput = document.getElementById('searchInput');
                                                    searchInput.placeholder = 'Cari Jadwal'; // Mengembalikan placeholder ke default saat input diklik
                                                    searchInput.style.borderColor = ''; // Mengembalikan warna border ke default saat input diklik
                                                });
                                            </script>

                                            <div class="container">
                                                <table class="table text-nowrap mb-0 table-centered table-hover"
                                                    cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">No.</th>
                                                            <th scope="col">Keanggotaan</th>
                                                            <th scope="col">Jenis Lapangan</th>
                                                            <th scope="col">Tanggal</th>
                                                            <th scope="col">Waktu Mulai</th>
                                                            <th scope="col">Waktu Selesai</th>
                                                            <th scope="col">Harga</th>
                                                            <th scope="col">Status</th>
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
                                                            $status = $r2['status_pemesanan'];
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
                                                                    <a href="jadwal.php?op=status&id="><button type="button"
                                                                            class="btn btn-info" id="editButton" disabled>
                                                                            <?php echo $status ?>
                                                                        </button></a>
                                                                </td>
                                                                <td scope="row">
                                                                    <a href="jadwal.php?op=edit&id=<?php echo $id ?>"><button
                                                                            type="button" class="btn btn-warning"
                                                                            id="editButton">Edit</button></a>
                                                                    <a href="jadwal.php?op=delete&id=<?php echo $id ?>"
                                                                        onclick="return confirm('Yakin mau menghapus data ini?')"><button
                                                                            type="button"
                                                                            class="btn btn-danger">Delete</button></a>
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
            <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.3"></script>
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