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
$lokasi = "";
$jumlah_lap = "";
$harga_sewa = "";
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
    $sql1 = "DELETE FROM referensi WHERE id_referensi = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Data Berhasil Dihapus";
    } else {
        $error = "Data Gagal Terhapus";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM referensi WHERE id_referensi = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nama = $r1['nama_tempat'];
    $lokasi = $r1['lokasi'];
    $jumlah_lap = $r1['jumlah_lap'];
    $harga_sewa = $r1['harga_sewa'];
    $tipe_lap = $r1['tipe_lap'];

    if ($anggota == '') {
        $error = "Data tidak ditemukan";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") { //untuk create data
    $nama = $_POST['nama_tempat'];
    $lokasi = $_POST['lokasi'];
    $jumlah_lap = $_POST['jumlah_lap'];
    $harga_sewa = $_POST['harga_sewa'];
    $tipe_lap = $_POST['tipe_lap'];

    if ($op == 'edit') {
        // Perbarui data jika ini adalah operasi edit
        $sql1 = "UPDATE referensi SET nama_tempat = '$nama', lokasi = '$lokasi', jumlah_lap = '$jumlah_lap', harga_sewa = '$harga_sewa', tipe_lap = '$tipe_lap' WHERE id_referensi = '$id'";
    } else {
        // Tambahkan data jika ini adalah operasi insert
        $sql1 = "INSERT INTO referensi (nama_tempat, lokasi, jumlah_lap, harga_sewa, tipe_lap) VALUES ('$nama', '$lokasi', '$jumlah_lap', '$harga_sewa', '$tipe_lap')";
    }

    $q1 = mysqli_query($koneksi, $sql1);

    if ($q1) {
        $sukses = "Data referensi berhasil diupdate/ditambahkan";
    } else {
        $error = "Data referensi gagal diupdate/ditambahkan";
    }
}

if ($error) {
    // Set header sebelum mencetak pesan kesalahan
    header("refresh:2;url=add_referensi.php"); // 2 = detik
?>
<?php
}

if ($sukses) {
    // Set header sebelum mencetak pesan sukses
    header("refresh:2;url=add_referensi.php"); // 2 = detik
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

        .breadcrumb-item a {
            text-decoration: none;
            color: #ccc;
        }

        .breadcrumb-item a:hover{
            color: #02406D;
        }

        #ref-nav{
            color: #02406D;
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
                        <a class="nav-link" href="/ArenaFinder/php/beranda.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ArenaFinder/php/aktivitas.php">Aktivitas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/ArenaFinder/php/referensi.php">Referensi</a>
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
                            Panel Pengelola
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/ArenaFinder/php/referensi.php">Referensi</a></li>
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
                        Tambah/Edit Data Referensi
                    </div>
                    <div class="card-body">
                        <?php if ($error || $sukses): ?>
                            <div class="alert <?php echo $error ? 'alert-danger' : 'alert-success'; ?>" role="alert">
                                <?php echo $error ? $error : $sukses; ?>
                            </div>
                        <?php endif; ?>
                        <!-- Form -->
                        <form action="" method="POST" autocomplete="off" onsubmit="return validasiForm()">
                            <div class="mb-3 row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama Tempat</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama_tempat" name="nama_tempat"
                                        value="<?php echo $nama ?>" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control" id="staticEmail" name="lokasi"
                                        value="<?php echo $lokasi ?>" required></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="jumlah_lap" class="col-sm-2 col-form-label">Jumlah Lapangan</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="jumlah_lap" name="jumlah_lap"
                                        value="<?php echo $jumlah_lap ?>" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="harga_sewa" class="col-sm-2 col-form-label">Harga Sewa</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="harga_sewa" name="harga_sewa"
                                        value="<?php echo $harga_sewa ?>" required>
                                </div>
                            </div>

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

                            <input type="submit" name="simpan" value="Simpan Data" class="btn w-100" id="save-btn">
                        </form>

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
                                            <input type="text" name="search" id="searchInput" style="width: 30%;"
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
                                                    <th scope="col">Nama Tempat</th>
                                                    <th scope="col">Lokasi</th>
                                                    <th scope="col">Jumlah Lapangan</th>
                                                    <th scope="col">Harga Sewa</th>
                                                    <th scope="col">Tipe Lapangan</th>
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
                                                    $sql = "SELECT * FROM referensi WHERE nama_tempat LIKE '%$searchTerm%'";
                                                } else {
                                                    $sql = "SELECT * FROM referensi ORDER BY id_referensi DESC";
                                                }

                                                $q2 = mysqli_query($koneksi, $sql);
                                                $urut = 1;
                                                while ($r2 = mysqli_fetch_array($q2)) {
                                                    $id = $r2['id_referensi'];
                                                    $nama = $r2['nama_tempat'];
                                                    $lokasi = $r2['lokasi'];
                                                    $jumlah_lap = $r2['jumlah_lap'];
                                                    $harga_sewa = $r2['harga_sewa'];
                                                    $tipe_lap = $r2['tipe_lap'];
                                                    ?>
                                                    <tr>
                                                        <th scope="row">
                                                            <?php echo $urut++ ?>
                                                        </th>
                                                        <td scope="row">
                                                            <?php echo $nama ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $lokasi ?>
                                                        </td>
                                                        <td scope="row">
                                                            <?php echo $jumlah_lap ?>
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