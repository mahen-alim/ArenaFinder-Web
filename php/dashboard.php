<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Kanit&display=swap"
      rel="stylesheet"
    />
    <style>
        body{
            width: 100%;
            border-collapse: collapse;
            font-family: kanit;
        }

        table{
            justify-content: center;
            align-items: center;
            display: flex;     
            
        }
        th, td{
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            
        }

        th{
            background-color: #f2f2f2;
            text-align: center;
            background-color: #02406d;
            color: white;
            font-weight: 400;
        }

        .judul{
            background: linear-gradient(to right, #3498db, #FF5733 50%, #e74c3c);
            display: flex;
            text-align: center;
            width: 188px;
            padding-left: 8px;
            padding-top: 0px;
            border-radius: 18px;
            margin-left: 43%;
            margin-top: 20px;
            margin-bottom: 25px;
            font-size: 15px;
            gap: 10px;
            transition: transform 0.2s;
        }

        .judul:hover{
            transform: scale(1.1);
        }

        .judul img{
            width: 100%;
            margin-left: -173.5px;
            transition: opacity 0.3s;
            border-radius: 18px;
            opacity: 0;
        }

        .judul:hover img{
            opacity: 1;
        }

        .head1{
            color: white;
        }

        .head2{
            color: #a1ff9f;
        }
    </style>

</head>
<body>
    <div class="judul">
    <div class="background"></div>
    <h1 class="head1">Tabel</h1>
    <h1 class="head2">Akun</h1>
    <img src="img_asset/voli.jpg" alt="">
    </div>
<?php

include("koneksi.php");

$sql = "SELECT * FROM users"; // Pengambilan data dari tabel users

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Data ditemukan, lakukan iterasi untuk menampilkannya dalam tabel HTML
    echo "<table>";
    echo "<tr><th>Id Akun</th><th>Username</th><th>Email</th><th>Password</th><th>Konfirmasi Password</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        echo "<td>" . $row["konfirmasi_password"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Tidak ada data yang ditemukan.";
}

// Tutup koneksi
$conn->close();
?>
</body>
</html>