<?php
// Sambungkan ke database
$host = "localhost";
$user = "tifz1761_root";
$pass = "tifnganjuk321";
$db= "tifz1761_arenafinder";

$koneksi = mysqli_connect("$host", "$user", "$pass", "$db");

// Periksa koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil kategori dari permintaan POST
$category = $_POST['category'];

// Query untuk mengambil data venues berdasarkan kategori
$query = "SELECT * FROM venues WHERE sport = '$category'";
$result = mysqli_query($koneksi, $query);

// Persiapkan respons HTML
$response = '';

// Periksa apakah ada data yang ditemukan
if (mysqli_num_rows($result) > 0) {
    // Loop melalui setiap baris hasil query
    while ($row = mysqli_fetch_assoc($result)) {
        // Sesuaikan dengan struktur data dan HTML yang Anda inginkan
        $response .= '<div class="venue-card">';
        $response .= '<h3>' . $row['venue_name'] . '</h3>';
        $response .= '<p>Lokasi: ' . $row['location'] . '</p>';
        // Tambahkan elemen HTML lainnya sesuai kebutuhan
        $response .= '</div>';
    }
} else {
    // Jika tidak ada data yang ditemukan
    $response = '<p>Tidak ada data yang ditemukan untuk kategori ' . $category . '</p>';
}

// Kembalikan respons HTML
echo $response;

// Tutup koneksi database
mysqli_close($koneksi);
?>
