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


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .mx-auto {
            width: 800px;
        }

        .card {
            margin-top: 20px;
            width: 150%;
            margin-left: -200px;
        }

        #tabel {
            width: 150%;
            margin-left: -200px;
        }

        .breadcrumb {
            margin-left: 130px;
            margin-top: 20px;
            padding-bottom: -20px;
        }
    </style>
</head>

<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/ArenaFinder/html/beranda.html">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kelola Jadwal</li>
        </ol>
    </nav>
    <div class="mx-auto">
        <!--untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Tambah / Edit Aktivitas
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                    header("refresh:2;url=kelola_jadwal.php"); // 2 = detik
                
                }
                ?>
                <?php
                if ($sukses) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                    header("refresh:2;url=kelola_jadwal.php"); // 2 = detik
                
                }
                ?>

                <form action="" method="POST" enctype="multipart/form-data" autocomplete="off" 
                    onsubmit="return validasiForm()" required>
                    <div class="mb-3 row">
                        <label for="keanggotaan" class="col-sm-2 col-form-label">Keanggotaan</label>
                        <div class="col-sm-10">
                            <input type="radio" id="member" name="keanggotaan" value="Member" <?php if ($anggota == "Member")
                                echo "checked"; ?>>
                            <label for="member">Member</label>

                            <input type="radio" id="nonmember" name="keanggotaan" value="Non Member"
                                style="margin-left: 20px;" <?php if ($anggota == "Non Member")
                                    echo "checked"; ?>>
                            <label for="nonmember">Non Member</label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jenis_lap" class="col-sm-2 col-form-label">Jenis Lapangan</label>
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
                                <input type="datetime-local" placeholder="-Pilih Tanggal-" class="form-control"
                                    id="staticEmail" name="tanggal" value="<?php echo $tanggal ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="waktu-mulai" class="col-sm-2 col-form-label">Waktu Mulai</label>
                        <div class="col-sm-10">
                            <input type="time" placeholder="-Pilih Waktu Mulai-" class="form-control" id="waktu-mulai"
                                name="waktu_mulai">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="waktu-selesai" class="col-sm-2 col-form-label">Waktu Selesai</label>
                        <div class="col-sm-10">
                            <input type="time" placeholder="-Pilih Waktu Selesai-" class="form-control"
                                id="waktu-selesai" name="waktu_selesai">
                        </div>
                    </div>

                    <div class=" mb-3 row">
                        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="harga" name="harga" readonly
                                value="<?php echo $harga ?>">
                        </div>

                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary"
                            style="margin-left: 65.5rem;">
                    </div>
                </form>
            </div>
        </div>

        <script>
            const waktuAwalInput = document.getElementById("waktu-mulai");
            const waktuAkhirInput = document.getElementById("waktu-selesai");
            const hargaInput = document.getElementById("harga");

            // Event listener untuk perubahan di input waktu-awal dan waktu-akhir
            waktuAwalInput.addEventListener("change", hitungHarga);
            waktuAkhirInput.addEventListener("change", hitungHarga);

            function hitungHarga() {
                const waktuAwal = waktuAwalInput.valueAsDate;
                const waktuAkhir = waktuAkhirInput.valueAsDate;

                // Pastikan kedua input sudah diisi dengan waktu yang valid
                if (waktuAwal && waktuAkhir) {
                    const selisihWaktu = (waktuAkhir - waktuAwal) / (1000 * 60 * 60); // Selisih waktu dalam jam
                    const hargaPerJam = 90000; // Ganti dengan harga per jam yang sesuai
                    const totalHarga = selisihWaktu * hargaPerJam;
                    hargaInput.value = totalHarga.toFixed(2); // Menampilkan harga dengan 2 desimal
                } else {
                    hargaInput.value = ""; // Reset harga jika input tidak valid
                }
            }
        </script>

        <!--untuk mengeluarkan data -->
        <div class="card" id="tabel">
            <div class="card-header text-white bg-secondary">
                Tabel Jadwal Pemesanan Lapangan
            </div>
            <div class="card-body">
                <table class="table">
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
                    <tbody>
                        <?php
                        $sql2 = "SELECT * FROM jadwal ORDER BY id DESC";
                        $q2 = mysqli_query($koneksi, $sql2);
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
                                    <a href="kelola_jadwal.php?op=edit&id=<?php echo $id ?>"><button type="button"
                                            class="btn btn-warning">Edit</button></a>
                                    <a href="kelola_jadwal.php?op=delete&id=<?php echo $id ?>"
                                        onclick="return confirm('Yakin mau menghapus data ini?')"><button type="button"
                                            class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>

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