<?php
session_start();
$host = "localhost";
$user = "tifz1761_root";
$pass = "tifnganjuk321";
$db = "tifz1761_arenafinder";

// $host = "localhost";
// $user = "root";
// $pass = "";
// $db = "arenafinder";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi");
}

$id = "";
$nama = "";
$deskripsi = "";
$type_sport = "";
$status = "";
$lokasi = "";
$coordinate = "";
$jumlah_lap = "";
$harga_sewa = 0;
$tipe_lap = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];

    // Hapus data dari tabel yang memiliki foreign key ke `venues`
    $tablesToDelete = ['venue_membership', 'venue_galery', 'venue_aktivitas', 'venue_review', 'venue_booking'];

    foreach ($tablesToDelete as $table) {
        $sql_delete_related_data = "DELETE FROM $table WHERE id_venue = '$id'";
        $q_delete_related_data = mysqli_query($koneksi, $sql_delete_related_data);

        if (!$q_delete_related_data) {
            $error2 = "Data Gagal Terhapus pada tabel $table: " . mysqli_error($koneksi);
            echo $error2;
            exit; // Hentikan proses jika terjadi kesalahan
        }
    }

    // Hapus data dari tabel `venue_lapangan` yang memiliki foreign key ke `venues`
    $sql_delete_related_lapangan = "DELETE FROM venue_lapangan WHERE id_venue = '$id'";
    $q_delete_related_lapangan = mysqli_query($koneksi, $sql_delete_related_lapangan);

    // Hapus data dari tabel `venues`
    $sql_delete_venues = "DELETE FROM venues WHERE id_venue = '$id'";
    $q_delete_venues = mysqli_query($koneksi, $sql_delete_venues);

    // Periksa jika penghapusan berhasil atau tidak
    if ($q_delete_venues) {
        $sukses2 = "Data Berhasil Dihapus";
    } else {
        $error2 = "Data Gagal Terhapus (Terdapat Kesalahan pada Tabel `venues`): " . mysqli_error($koneksi);
        echo $error2;
    }
}


if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM venues WHERE id_venue = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $email = $r1['email'];
    $nama = $r1['venue_name'];
    $lokasi = $r1['location'];
    $status = $r1['status'];
    $type_sport = $r1['sport'];
    $jumlah_lap = $r1['total_lapangan'];
    $harga_sewa = $r1['price'];
    $tipe_lap = $r1['sport_status'];
    $deskripsi = $r1['desc_venue'];
    $coordinate = $r1['coordinate'];

    if ($nama == '') {
        $error = "Data tidak ditemukan";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_tempat'];
    $lokasi = $_POST['lokasi_tempat'];
    $type_sport = $_POST['jenis_olga'];
    $jumlah_lap = $_POST['jumlah_lap'];
    $status = $_POST['status'];
    $harga_sewa = $_POST['harga_sewa'];
    $tipe_lap = $_POST['tipe_lap'];
    $email = $_POST['email_admin'];
    $deskripsi = $_POST['deskripsi_tempat'];
    $coordinate = $_POST['coordinate_tempat'];

    if (empty($harga_sewa)) {
        $harga_sewa = 0;
    }

    // Check if the email already exists
    $checkEmailQuery = "SELECT COUNT(*) as count FROM venues WHERE email = '$email'";
    $checkEmailResult = mysqli_query($koneksi, $checkEmailQuery);
    $emailCount = mysqli_fetch_assoc($checkEmailResult)['count'];

    $pattern = '/^-?\d+(\.\d+)?,\s?-?\d+(\.\d+)?$/';

    // Validation
    if ($emailCount > 0) {
        $error = "Alamat email sudah digunakan untuk tempat lain.";
    } elseif (empty($nama) || !preg_match('/^[a-zA-Z\s]{5,30}$/', $nama)) {
        $error = "Nama tempat harus berupa huruf dan memiliki panjang antara 5 sampai 30 karakter.";
    } elseif (strlen($lokasi) < 10 || strlen($lokasi) > 100) {
        $error = "Lokasi harus berisi angka dan memiliki panjang antara 10 sampai 100 karakter.";
    } else if (!(bool) preg_match($pattern, $coordinate)) {
        $error = "Koordinat tidak valid";
    } elseif ($status !== "Gratis" && $harga_sewa == 0) {
        $error = "Harga sewa tidak boleh bernilai 0.";
    } else {
        // Image Upload
        if (!empty($_FILES['foto']['name'])) {
            $nama_file = $_FILES['foto']['name'];
            $tmp = $_FILES['foto']['tmp_name'];
            $upload_folder = 'public/img/venue/';

            if (move_uploaded_file($tmp, $upload_folder . $nama_file)) {
                // Database Operation
                if ($op == 'edit') {
                    $sql1 = "UPDATE venues SET email = '$email', venue_name = '$nama', location = '$lokasi', sport = '$type_sport', total_lapangan = '$jumlah_lap', status = '$status', price = '$harga_sewa', price_membership = '$harga_sewa', sport_status = '$tipe_lap', venue_photo = '$nama_file', desc_venue = '$deskripsi', coordinate = '$coordinate' WHERE id_venue = '$id'";
                } else {
                    $sql1 = "INSERT INTO venues (email, venue_name, location, sport, total_lapangan, status, price, price_membership, sport_status, venue_photo, coordinate, desc_venue) VALUES ('$email', '$nama', '$lokasi', '$type_sport', '$jumlah_lap', '$status', '$harga_sewa', '$harga_sewa', '$tipe_lap', '$nama_file', '$coordinate', '$deskripsi')";
                }


                if ($op == 'edit') {
                    $q1 = mysqli_query($koneksi, $sql1);
                } else {
                    if ($emailCount > 0) {
                        $error = "Email ini telah memiliki tempat olahraganya. Pilih email lainnya.";
                    } else {
                        $q1 = mysqli_query($koneksi, $sql1);
                    }
                }

                if ($op != 'edit') {
                    // Additional operations after insert
                    $idVenue = mysqli_insert_id($koneksi);

                    $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                    foreach ($days as $day) {
                        $sql = "INSERT INTO venue_operasional (`id_venue`, `day_name`, `opened`, `closed`) VALUES ($idVenue, '$day', '07:00:00', '23:00:00')";
                        mysqli_query($koneksi, $sql);
                    }

                    for ($i = 1; $i <= $jumlah_lap; $i++) {
                        $sql = "INSERT INTO `venue_lapangan` (`id_venue`, `nama_lapangan`, `photo`) VALUES ($idVenue, 'Lapangan $i', '$nama_file')";
                        mysqli_query($koneksi, $sql);
                    }
                }

                if ($q1) {
                    $sukses = "Data referensi berhasil diupdate/ditambahkan";
                } else {
                    $error = "Data referensi gagal diupdate/ditambahkan";
                }
            } else {
                $error = "Harap pilih gambar yang akan diunggah :)";
            }
        } else {
            $error = "Harap pilih gambar yang akan diunggah :|";
        }
    }
}


if ($error || $sukses || $error2 || $sukses2) {
    // Set header sebelum mencetak pesan
    $refreshUrl = "add_referensi.php";
    if ($error2 || $sukses2) {
        $refreshUrl .= "#tabel-card";
    }
    header("refresh:2;url=$refreshUrl"); // 2 = detik
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Referensi</title>
    <link rel="stylesheet" href="css/referensi.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
    <link rel="icon" href="img_asset/login.png">
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

        .breadcrumb-item a {
            text-decoration: none;
            color: #ccc;
        }

        .breadcrumb-item a:hover {
            color: #02406D;
        }

        #ref-nav {
            color: #02406D;
        }

        #con-link{
            margin-top: 100px;
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
                        <a class="nav-link" href="index.php">Beranda</a>
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
                        <a class="nav-link" id="nav-down-item1" href="boots/index.php" style="width: 200px;">
                            <i class="fa-solid fa-id-card fa-flip" style="margin-right: 5px;"></i>
                            Panel Pengelola
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" id="con-link">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="referensi.php">Referensi</a></li>
                        <li class="breadcrumb-item active" aria-current="page" id="ref-nav">Tambah Referensi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        Tambah/Edit <span style="color: #A1FF9F;">Referensi</span>
                    </div>
                    <div class="card-body">
                        <?php if ($error || $sukses): ?>
                            <div class="alert <?php echo $error ? 'alert-danger' : 'alert-success'; ?>" role="alert">
                                <?php echo $error ? $error : $sukses; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Form -->
                        <form action="" method="POST" autocomplete="off" onsubmit="return validasiForm()"
                            enctype="multipart/form-data">
                            <div class="mb-3 row">
                                <label for="nama" class="col-sm-2 col-form-label">Email Pengelola</label>
                                <div class="col-sm-10">
                                    <select class="form-select" id="email_admin" name="email_admin" required>
                                        <?php
                                        // Assuming you have a database connection established
                                        $emailQuery = "SELECT email FROM users WHERE level IN ('ADMIN', 'SUPER ADMIN')";
                                        $emailResult = mysqli_query($koneksi, $emailQuery);

                                        // Check if the query was successful
                                        if ($emailResult) {
                                            while ($row = mysqli_fetch_assoc($emailResult)) {
                                                $selected = ($row['email'] == $email) ? 'selected' : '';
                                                echo "<option value='{$row['email']}' $selected>{$row['email']}</option>";
                                            }
                                            mysqli_free_result($emailResult);
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama Tempat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama_tempat" name="nama_tempat"
                                        value="<?php echo $nama ?>" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi Tempat</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="deskripsi_tempat" name="deskripsi_tempat"
                                        required><?php echo $deskripsi; ?></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="lokasi_tempat" name="lokasi_tempat"
                                        required><?php echo $lokasi; ?></textarea>
                                </div>
                            </div>


                            <div class="mb-3 row">
                                <label for="coordinate" class="col-sm-2 col-form-label">Koordinat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="coordinate_tempat"
                                        name="coordinate_tempat" value="<?php echo $coordinate ?>" required>
                                </div>
                            </div>

                            <!-- Add this script inside the head or body of your HTML document -->
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
                                    var namaTempatInput = document.getElementById('nama_tempat');
                                    var lokasiInput = document.getElementById('lokasi');

                                    // Add input event listeners to trigger validation
                                    namaTempatInput.addEventListener('input', function () {
                                        var namaTempatValue = this.value;
                                        if (/\d/.test(namaTempatValue) || namaTempatValue.length < 5 || namaTempatValue.length > 30) {
                                            showError(this, "Nama tempat harus berupa huruf, bukan simbol dan memiliki panjang antara 5 sampai 30 karakter.");
                                        } else {
                                            clearError(this);
                                        }
                                    });

                                    lokasiInput.addEventListener('input', function () {
                                        var lokasiValue = this.value;

                                        // Memeriksa apakah input hanya terdiri dari angka
                                        if (/^\d+$/.test(lokasiValue)) {
                                            showError(this, "Lokasi tidak dapat hanya berisi angka.");
                                        } else if (!/^[\w\s\d!@#$%^&*()_+{}\[\]:;<>,.?~\\/-]{10,100}$/.test(lokasiValue)) {
                                            showError(this, "Lokasi harus memiliki panjang antara 10 sampai 100 karakter dan dapat berisi huruf, angka, dan simbol.");
                                        } else {
                                            clearError(this);
                                        }
                                    });

                                });
                            </script>

                            <div class="mb-3 row">
                                <label for="jenis_olga" class="col-sm-2 col-form-label">Jenis
                                    Olahraga</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="jenis_olga" id="jenis_olga" required>
                                        <option value="">-Pilih Jenis Olahraga-</option>
                                        <option value="Bulu tangkis" <?php if ($type_sport == "Bulu tangkis")
                                            echo "selected" ?>>Badminton
                                            </option>
                                            <option value="Futsal" <?php if ($type_sport == "Futsal")
                                            echo "selected" ?>>Futsal
                                            </option>
                                            <option value="Sepak bola" <?php if ($type_sport == "Sepak bola")
                                            echo "selected" ?>>Sepak Bola
                                            </option>
                                            <option value="Bola Voli" <?php if ($type_sport == "Bola Voli")
                                            echo "selected" ?>>Bola
                                                Voli
                                            </option>
                                            <option value="Bola Basket" <?php if ($type_sport == "Bola Basket")
                                            echo "selected" ?>>Bola Basket
                                            </option>
                                            <option value="Tenis Lapangan" <?php if ($type_sport == "Tenis Lapangan")
                                            echo "selected" ?>>Tenis Lapangan
                                            </option>
                                            <option value="Renang" <?php if ($type_sport == "Renang")
                                            echo "selected" ?>>Renang
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                <div class="mb-3 row">
                                    <label for="jumlah_lap" class="col-sm-2 col-form-label">Jumlah Lapangan</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="jumlah_lap" name="jumlah_lap"
                                            value="<?php echo $jumlah_lap ?>" required>
                                </div>
                            </div>
                            <!-- Add this script inside the head or body of your HTML document -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var jumlahLapanganInput = document.getElementById('jumlah_lap');

                                    jumlahLapanganInput.addEventListener('input', function () {
                                        var jumlahLapanganValue = this.value;

                                        // Check if the entered value is not a positive integer
                                        if (!/^\d+$/.test(jumlahLapanganValue) || jumlahLapanganValue < 0 || jumlahLapanganValue > 5) {
                                            alert("Jumlah lapangan harus berupa angka positif dan maksimal inputtan jumlah lapangan berjumlah 5.");
                                            this.value = ''; // Clear the input field
                                        }
                                    });
                                });
                            </script>

                            <div class="mb-3 row">
                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="">-Pilih Status-</option>
                                        <option value="Berbayar" <?php if ($status == "Berbayar")
                                            echo "selected" ?>>Berbayar
                                            </option>
                                            <option value="Disewakan" <?php if ($status == "Disewakan")
                                            echo "selected" ?>>Disewakan
                                            </option>
                                            <option value="Gratis" <?php if ($status == "Gratis")
                                            echo "selected" ?>>Gratis
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label for="harga_sewa" class="col-sm-2 col-form-label">Harga Sewa</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="harga_sewa" name="harga_sewa"
                                            value="<?php echo $harga_sewa ?>" required>
                                </div>
                            </div>

                            <!-- Add this script inside the head or body of your HTML document -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    var hargaSewaInput = document.getElementById('harga_sewa');

                                    hargaSewaInput.addEventListener('input', function () {
                                        var hargaSewaValue = this.value;

                                        // Check if the entered value is a positive integer with a length between 1 and 7 digits
                                        if (!/^\d{1,7}$/.test(hargaSewaValue)) {
                                            alert("Harga sewa harus berupa angka dengan panjang antara 1 dan 7 digit.");
                                            this.value = ''; // Clear the input field
                                        }
                                    });
                                });
                            </script>

                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    // Dapatkan elemen status dan input harga
                                    var statusElement = document.getElementById('status');
                                    var hargaSewaInput = document.getElementById('harga_sewa');

                                    // Atur status awal saat halaman dimuat
                                    toggleHargaInput(statusElement.value);

                                    // Tambahkan event listener untuk perubahan pada elemen status
                                    statusElement.addEventListener('change', function () {
                                        toggleHargaInput(statusElement.value);
                                    });

                                    // Fungsi untuk mengatur status input harga berdasarkan nilai status
                                    function toggleHargaInput(statusValue) {
                                        // Jika status adalah 'Gratis', nonaktifkan input harga
                                        if (statusValue === 'Gratis') {
                                            hargaSewaInput.disabled = true;
                                            hargaSewaInput.value = 0; // Atur nilai menjadi 0 atau sesuai kebutuhan
                                        } else {
                                            // Jika status adalah 'Berbayar' atau 'Disewakan', aktifkan input harga
                                            hargaSewaInput.disabled = false;
                                        }
                                    }
                                });
                            </script>

                            <div class="mb-3 row">
                                <label for="tipe_lap" class="col-sm-2 col-form-label">Tipe Lapangan</label>
                                <div class="col-sm-10">
                                    <input type="radio" id="indoor" name="tipe_lap" value="Indoor" <?php if ($tipe_lap == "Indoor")
                                        echo "checked"; ?> required>
                                    <label for="indoor">Indoor</label>

                                    <input type="radio" id="outdoor" name="tipe_lap" value="Outdoor"
                                        style="margin-left: 20px;" <?php if ($tipe_lap == "Outdoor")
                                            echo "checked"; ?> required>
                                    <label for="outdoor">Outdoor</label>

                                </div>
                            </div>


                            <div class="mb-3 row">
                                <label for="gambar" class="col-sm-2 col-form-label">Gambar</label>
                                <div class="col-sm-10">
                                    <input class="col-xxl-8 col-12" type="file" id="foto" name="foto" required />
                                </div>
                            </div>

                            <input type="submit" name="simpan" value="Simpan Data" class="btn w-100" id="save-btn">
                        </form>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4" id="tabel-card">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"
                                style="color: white; background-color: #02406d;">
                                <h6 class="m-0 font-weight-bold">Tabel <span style="color: #A1FF9F;">Referensi</span></h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <?php if ($error2 || $sukses2): ?>
                                        <div class="alert <?php echo $error2 ? 'alert-danger' : 'alert-success'; ?>"
                                            role="alert">
                                            <?php echo $error2 ? $error2 : $sukses2; ?>
                                        </div>
                                    <?php endif; ?>
                                    <form action="add_referensi.php#tabel-card" method="GET">
                                        <div class="form-group" style="display: flex; gap: 10px;">
                                            <input type="text" name="search" id="searchInput" style="width: 50%;"
                                                class="form-control" placeholder="Cari Tempat Olahraga"
                                                value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">

                                            <button type="submit" class="btn btn-info" id="searchButton">Cari</button>
                                            <?php if (isset($_GET['search'])): ?>
                                                <a href="add_referensi.php" class="btn btn-secondary" id="resetSearch">Hapus
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
                                            searchInput.placeholder = 'Cari Tempat Olahraga'; // Mengembalikan placeholder ke default saat input diklik
                                            searchInput.style.borderColor = ''; // Mengembalikan warna border ke default saat input diklik
                                        });
                                    </script>

                                    <div class="container">
                                        <table class="table text-nowrap mb-0 table-centered table-hover"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No.</th>
                                                    <th scope="col">Email Pengelola</th>
                                                    <th scope="col">Nama Tempat</th>
                                                    <th scope="col">Deskripsi Tempat</th>
                                                    <th scope="col">Lokasi</th>
                                                    <th scope="col">Koordinat Tempat</th>
                                                    <th scope="col">Jenis Olahraga</th>
                                                    <th scope="col">Jumlah Lapangan</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Harga Sewa</th>
                                                    <th scope="col">Tipe Lapangan</th>
                                                    <th scope="col">Foto</th>
                                                    <th scope="col">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="hoverable">
                                                <?php
                                                if (isset($_GET['reset'])) {
                                                    // Pengguna menekan tombol "Hapus Pencarian"
                                                    header("Location: add_referensi.php"); // Mengarahkan ke halaman tanpa parameter pencarian
                                                    exit();
                                                }

                                                if (isset($_GET['search'])) {
                                                    $searchTerm = $koneksi->real_escape_string($_GET['search']);
                                                    $sql = "SELECT * FROM venues WHERE venue_name LIKE '%$searchTerm%'";
                                                } else {
                                                    $sql = "SELECT * FROM venues ORDER BY id_venue DESC";
                                                }

                                                $q2 = mysqli_query($koneksi, $sql);
                                                $urut = 1;
                                                while ($r2 = mysqli_fetch_array($q2)) {
                                                    $id = $r2['id_venue'];
                                                    $email = $r2['email'];
                                                    $nama = $r2['venue_name'];
                                                    $lokasi = $r2['location'];
                                                    $type_sport = $r2['sport'];
                                                    $jumlah_lap = $r2['total_lapangan'];
                                                    $status = $r2['status'];
                                                    $harga_sewa = $r2['price'];
                                                    $tipe_lap = $r2['sport_status'];
                                                    $foto = $r2['venue_photo'];
                                                    $deskripsi = $r2['desc_venue'];
                                                    $coordinate = $r2['coordinate'];
                                                    ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <?php echo $urut++ ?>
                                                        </th>
                                                        <td scope="row"
                                                            style="overflow: hidden; word-wrap: break-word; white-space: normal;">
                                                            <?php echo $email ?>
                                                        </td>
                                                        <td scope="row"
                                                            style="overflow: hidden; word-wrap: break-word; white-space: normal;">
                                                            <?php echo $nama ?>
                                                        </td>
                                                        <td scope="row"
                                                            style="overflow: hidden; word-wrap: break-word; white-space: normal;">
                                                            <?php echo $deskripsi ?>
                                                        </td>
                                                        <td scope="row"
                                                            style="overflow: hidden; word-wrap: break-word; white-space: normal;">
                                                            <?php echo $lokasi ?>
                                                        </td>
                                                        <td scope="row"
                                                            style="overflow: hidden; word-wrap: break-word; white-space: normal;">
                                                            <?php echo $coordinate ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $type_sport ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $jumlah_lap ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $status ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $harga_sewa ?>
                                                        </td>
                                                        <td scope="row">
                                                            <a href="add_referensi.php?op=status&id="><button type="button"
                                                                    class="btn btn-info" id="editButton" disabled>
                                                                    <?php echo $tipe_lap ?>
                                                                </button></a>
                                                        </td>
                                                        <td scope="row">
                                                            <img src="/public/img/venue/<?php echo $foto; ?>" alt="Image"
                                                                style="width: 100px; height: 100px;">
                                                        </td>
                                                        <td scope="row">
                                                            <a href="add_referensi.php?op=edit&id=<?php echo $id ?>"><button
                                                                    type="button" class="btn btn-warning"
                                                                    id="editButton">Edit</button></a>
                                                            <a href="add_referensi.php?op=delete&id=<?php echo $id ?>"
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
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>