<?php
include('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Peroleh data dari formulir
    $newUsername = $_POST['username'];
    $newEmail = $_POST['email'];
    $newLevel = $_POST['level'];

    // Proses upload dan perbarui nama file jika ada file yang diunggah
    if ($_FILES['profil_image']['error'] == UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['profil_image']['tmp_name'];
        $fileExtension = pathinfo($_FILES['profil_image']['name'], PATHINFO_EXTENSION);
        $newProfileImage = $newUsername . '_profile.' . $fileExtension;

        move_uploaded_file($fileTmp, '..//public//img//venue/' . $newProfileImage);
    } else {
        // Jika tidak ada file yang diunggah, gunakan foto profil yang sudah ada
        $newProfileImage = $existingProfileImage; // Gantilah dengan variabel yang menyimpan nama file foto profil saat ini
    }

    // Update data pengguna di tabel users
    $updateQuery = "UPDATE users SET username = '$newUsername', email = '$newEmail', level = '$newLevel', user_photo = '$newProfileImage' WHERE id_users = '$userId'";

    // Jalankan query update
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        // Redirect ke halaman profil.php setelah berhasil memperbarui data
        header("Location: profil.php");
        exit(); // Pastikan untuk keluar setelah melakukan redirect
    } else {
        echo "Gagal memperbarui data pengguna: " . mysqli_error($conn);
    }
}

?>