<?php
// Sambungkan ke database
$koneksi = mysqli_connect("localhost", "root", "", "arenafinderweb");

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Ambil data pengguna berdasarkan ID atau metode lain
$id_pengguna = 1; // Gantilah dengan ID pengguna yang sesuai
$query = "SELECT username, email FROM users WHERE id = $id_pengguna";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    $data_pengguna = mysqli_fetch_assoc($result);
} else {
    die("Pengguna tidak ditemukan.");
}

mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengisian Profil Akun</title>
</head>
<body>
    <h1>Pengisian Profil Akun</h1>
    <form method="post" action="simpan_profil.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" value="<?php echo $data_pengguna['username']; ?>" readonly>

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?php echo $data_pengguna['email']; ?>" readonly>

        <label for="profile_info">Profil Akun:</label>
        <textarea name="profile_info" id="profile_info"></textarea>

        <input type="submit" value="Simpan Profil">
    </form>
</body>
</html>
