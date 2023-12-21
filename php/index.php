<?php
session_start();
$servername = "localhost";
$username_db = "tifz1761_root";
$password_db = "tifnganjuk321";
$dbname = "tifz1761_arenafinder";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Fungsi untuk memeriksa apakah pengguna sudah login
function checkUserLogin()
{
    if (isset($_SESSION['email'])) {
        return true; // Pengguna sudah login
    } else {
        return false; // Pengguna belum login
    }
}

// Jika pengguna belum login dan tombol "Status Lapangan" ditekan
if (!checkUserLogin() && isset($_POST["status_lap_button"])) {
    // Redirect ke halaman login.php
    header("Location: boots/login.php");
    exit();
}

// Jika pengguna sudah login dan tombol "Status Lapangan" ditekan
if (checkUserLogin() && isset($_POST["status_lap_button"])) {
    // Redirect ke halaman status-lap.php
    header("Location: status-lap.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="css/beranda.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <!-- <link rel="icon" href="img_asset/logo (1).png"> -->
    <link rel="icon" href="img_asset/login.png">
    <style>
        body {
            overflow-x: hidden;
        }

        .title-con {
            background-color: blue;
            color: white;
            display: flex;
            flex-direction: row;
            /* Atur flex-direction menjadi "row" */
            align-items: center;
        }

        .title {
            margin-left: 690px;
            position: relative;
            top: -270mm;
            color: #02406d;
            animation: slideUp 2s ease;
        }

        .title2 {
            margin-left: 690px;
            position: relative;
            top: -270mm;
            color: #02406d;
            font-size: 30px;
            animation: slideUp 3s ease;
            /* Nama animasi, durasi, dan jenis animasi */
        }

        .img1 {
            position: relative;
            margin-top: 55px;
            margin-bottom: 30px;
            margin-right: 15in;
            width: 700px;
            height: 700px;
            border: 1px solid white;
        }

        .img2 {
            margin-left: 710px;
            position: relative;
            top: -172mm;
            width: 600px;
            height: 500px;
        }

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
            color: #02406D;
            /* Atur latar belakang kembali ke nilai default */
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

        .btn-4,
        .btn-5,
        .btn-6,
        .btn-7,
        .btn-8 {
            cursor: pointer;
            transition: background-color 1s, box-shadow 1s;
        }

        .btn-4 img,
        .btn-5 img,
        .btn-6 img,
        .btn-7 img,
        .btn-8 img {
            transition: transform 2s;
            /* Animasi perubahan ukuran img */
        }

        .btn-4 span,
        .btn-5 span,
        .btn-6 span,
        .btn-7 span,
        .btn-8 span {
            transition: transform 1s;
            /* Animasi perubahan posisi teks */
            display: inline-block;
            /* Menggunakan display inline-block agar transform berlaku */
        }

        .btn-4:hover,
        .btn-5:hover,
        .btn-6:hover,
        .btn-7:hover,
        .btn-8:hover {
            background-color: #e7f5ff;
            cursor: default;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-4:hover img,
        .btn-5:hover img,
        .btn-6:hover img,
        .btn-7:hover img,
        .btn-8:hover img {
            transform: scale(0.8);
        }

        .btn-4:hover span,
        .btn-5:hover span,
        .btn-6:hover span,
        .btn-7:hover span,
        .btn-8:hover span {
            transform: translateY(-20px);
            /* Perubahan posisi teks ke atas saat dihover */
        }

        .input-jenis-lapangan {
            position: relative;
            top: -62.5rem;
            margin-left: 690px;
            border-radius: 10px;
            width: 250px;
            height: 50px;
            padding: 10px;
            color: #02406d;
            border: 1px solid #e7f5ff;
            /* Warna border */
            transition: border-color 0.3s;
            /* Efek hover */
        }

        .input-jenis-lapangan:hover {
            border-color: #02406d;
            cursor: pointer;
        }

        .button {
            position: relative;
            top: -68.8rem;
            margin-left: 1230px;
            border-radius: 10px;
            width: 100px;
            height: 50px;
            padding: 10px;
            border: 1px solid #e7f5ff;
            background-color: #02406d;
            color: white;
        }

        .button:hover {
            background-color: #02406d;
            color: white;
            border: 1px solid #02406d;
            transition: 0.5s;
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            /* Menambahkan bayangan */
        }

        #button-type {
            display: flex;
            margin-top: 20px;
            margin-left: 60px;

        }

        .btn-4 {
            border: #02406d;
            background-color: White;
            position: relative;
            margin-left: 30px;
            top: -117.5rem;
            font-weight: 600;
            color: #02406d;
        }

        .btn-4 img {
            width: 250px;
            /* Gambar akan mengisi seluruh lebar div */
            height: 250px;
            /* Tinggi gambar akan menyesuaikan agar tidak terdistorsi */
            display: block;
            justify-content: center;
            border-radius: 50%;
            padding: 20px;
            transition: scale 1s;
        }

        .btn-4 img:hover {
            scale: 105%;
        }

        .btn-5 {
            border: #02406d;
            background-color: white;
            position: relative;
            margin-left: 0px;
            top: -117.5rem;
            font-weight: 600;
            color: #02406d;
        }

        .btn-5 img {
            width: 250px;
            /* Gambar akan mengisi seluruh lebar div */
            height: 250px;
            /* Tinggi gambar akan menyesuaikan agar tidak terdistorsi */
            display: block;
            justify-content: center;
            border-radius: 50%;
            padding: 20px;
            transition: scale 1s;
        }

        .btn-5 img:hover {
            scale: 105%;
        }

        .btn-6 {
            border: #02406d;
            background-color: white;
            position: relative;
            margin-left: 0px;
            top: -117.5rem;
            font-weight: 600;
            color: #02406d;
        }

        .btn-6 img {
            width: 250px;
            /* Gambar akan mengisi seluruh lebar div */
            height: 250px;
            /* Tinggi gambar akan menyesuaikan agar tidak terdistorsi */
            display: block;
            justify-content: center;
            border-radius: 50%;
            padding: 20px;
            transition: scale 1s;
        }

        .btn-6 img:hover {
            scale: 105%;
        }

        .btn-7 {
            border: #02406d;
            background-color: white;
            position: relative;
            margin-left: 0px;
            top: -117.5rem;
            font-weight: 600;
            color: #02406d;
        }

        .btn-7 img {
            width: 250px;
            /* Gambar akan mengisi seluruh lebar div */
            height: 250px;
            /* Tinggi gambar akan menyesuaikan agar tidak terdistorsi */
            display: block;
            justify-content: center;
            border-radius: 50%;
            padding: 20px;
            transition: scale 1s;
        }

        .btn-7 img:hover {
            scale: 105%;
        }

        .btn-8 {
            border: #02406d;
            background-color: white;
            position: relative;
            margin-left: 0px;
            top: -117.5rem;
            font-weight: 600;
            color: #02406d;
        }

        .btn-8 img {
            width: 250px;
            /* Gambar akan mengisi seluruh lebar div */
            height: 250px;
            /* Tinggi gambar akan menyesuaikan agar tidak terdistorsi */
            display: block;
            justify-content: center;
            border-radius: 50%;
            padding: 20px;
            transition: scale 1s;
        }

        .btn-8 img:hover {
            scale: 105%;
        }

        .card-slider {
            position: relative;
            top: -200px;
        }

        #staticEmail {
            position: relative;
            top: -65.7rem;
            margin-left: 960px;
            border-radius: 10px;
            width: 250px;
            height: 50px;
            padding-left: 10px;
            padding-right: 10px;
            color: #02406d;
            border: 1px solid #e7f5ff;
            /* Warna border */
            transition: border-color 0.3s;
            /* Efek hover */
        }

        #staticEmail:hover {
            border-color: #02406d;
            /* Warna border saat hover */
            cursor: pointer;
        }

        #cardSlider {
            margin-left: 0px;
            display: flex;
            overflow-x: auto;
            /* Tambahkan overflow-x agar bisa di-scroll jika ada banyak card */
            gap: 10px;
            /* Tambahkan gap antara card */
            padding: 10px;
            /* Tambahkan padding agar card tidak menyentuh tepi */
        }

        /* Setiap card dalam card-slider */
        .card {
            width: 18rem;
            /* Sesuaikan lebar card sesuai kebutuhan responsif */
        }

        #sportModal {
            display: inline-block;
            background-color: #3498db;
            /* Warna latar belakang */
            color: #fff;
            /* Warna teks */
            padding: 5px 10px;
            /* Padding di dalam label */
            border-radius: 5px;
            /* Sudut melengkung pada label */
            margin-top: 10px;
            /* Jarak dari elemen sebelumnya */
        }

        .persegi2 {
            width: 88.5rem;
            /* Lebar persegi dalam piksel */
            height: 28rem;
            /* Tinggi persegi dalam piksel */
            background-color: white;
            /* Warna latar belakang persegi */
            position: relative;
            top: -95rem;
        }

        .persegi3 {
            width: 80rem;
            background-color: none;
            /* Warna latar belakang persegi */
            position: relative;
            top: -103rem;
            margin-left: 60px;
            margin-right: 0px;
        }

        .persegi2::before {
            content: "Jenis Olahraga";
            font-size: 20px;
            font-weight: regular;
            text-align: center;
            padding-top: 10px;
            position: absolute;
            color: white;
            top: 0;
            left: 8.7%;
            border: 1px solid #02406d;
            transform: translateX(-50%);
            border-bottom-right-radius: 150px;
            width: 250px;

            height: 60px;
            /* Tinggi bagian lengkungan di atas */
            background-color: #02406d;
            /* Warna latar belakang bagian lengkungan di atas */
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1), 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        .community {
            color: white;
            width: 350px;
            /* Lebar bagian lengkungan di atas */
            height: 60px;
            font-size: 20px;
            font-weight: regular;
            text-align: center;
            padding-top: 10px;
            background-color: #02406d;
            position: relative;
            top: -107rem;
            border-bottom-right-radius: 150px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1), 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        #con-awal {
            width: 88.5rem;

        }

        #con-img {
            width: 88.5rem;
        }

        /* ----------- SLIDER ------------ */
        .con-swiper {
            width: 88.5rem;
            margin-top: -130px;
        }

        #developer_group {
            color: white;
            width: 300px;
            /* Lebar bagian lengkungan di atas */
            height: 60px;
            font-size: 20px;
            font-weight: regular;
            text-align: center;
            padding-top: 10px;
            background-color: #02406d;
            position: relative;
            top: -55rem;
            border-bottom-right-radius: 150px;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1), 0px 0px 20px rgba(0, 0, 0, 0.1);
        }

        .swiper {
            width: 90%;
            margin-top: -900px;
        }

        .swiper-wrapper {
            width: 100%;
            height: 35em;
            display: flex;
            align-items: center;
            margin-left: 20px;
        }

        .card {
            width: 20em;
            height: 70%;
            background-color: #fff;
            border-radius: 2em;
            box-shadow: 0 0 2em rgba(0, 0, 0, 0.2);
            padding: 2em 1em;
            border: none;
            display: flex;
            align-items: center;
            flex-direction: column;
            margin: 0 2em;
        }

        .swiper-slide:not(.swiper-slide-active) {
            filter: blur(1px);
        }

        .card__image {
            width: 10em;
            height: 10em;
            border-radius: 50%;
            border: 5px solid #02406D;
            padding: 3px;
            margin-bottom: 2em;
        }

        .card__image img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .card__content {
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .social-buttons {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .social-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 1px solid #02406D;
            border-radius: 50%;
            color: #02406D;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .social-button:hover {
            background-color: #02406D;
            color: white;
        }

        /* Icon styles */
        .social-button i {
            font-size: 20px;
        }

        .card__title {
            font-size: 1.5rem;
            font-weight: 500;
            position: relative;
            top: 0.2em;
        }

        .card__name {
            color: #02406D;
        }

        .card__text {
            text-align: center;
            font-size: 1.1rem;
            margin: 1em 0;
        }

        .card__btn {
            background-color: #02406D;
            color: #fff;
            font-size: 1rem;
            text-transform: uppercase;
            font-weight: 600;
            border: none;
            padding: 0.5em;
            border-radius: 0.5em;
            margin-top: 0.5em;
            cursor: pointer;
        }

        #swiper-activity {
            width: 100%;
            margin-top: -1650px;
        }

        .tombol-aktivitas {
            margin-top: 20px;
            height: 30px;
            width: 150px;
            background-color: white;
            color: #02406d;
            border: 1px solid #02406d;
            border-radius: 20px;
        }

        .tombol-aktivitas:hover {
            background-color: #02406d;
            color: white;
        }

        .main-container-body {
            margin-top: 20px;
        }

        .container-type-sport {
            width: 100%;
            margin-top: 100px;
            margin-bottom: 0px;
        }

        #container-swiper-activity {
            width: 88.5rem;
            margin-top: 20px;
        }

        /* sub menu */
        .con-href {
            margin-top: -100px;
        }

        .btn-sub-menu {
            width: 80rem;
        }

        .persegi {
            width: 88.5rem;
            /* Lebar persegi dalam piksel */
            height: 20rem;
            /* Tinggi persegi dalam piksel */
            background-color: #e7f5ff;
            /* Warna latar belakang persegi */
            position: relative;
            top: -40rem;
            border-top-right-radius: 10rem;
            border-top-left-radius: 10rem;
            margin-left: 0px;
            cursor: grab;
        }

        .dragging {
            user-select: none;
        }

        .persegi::before {
            content: "";
            width: 70%;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            /* Lebar bagian lengkungan di atas */
            height: 320px;
            /* Tinggi bagian lengkungan di atas */
            background-color: white;
            /* Warna latar belakang bagian lengkungan di atas */
            border-bottom-right-radius: 10rem;
            border-bottom-left-radius: 10rem;
        }

        /* footer */
        .footer {
            height: 300px;
            width: 88.5rem;
            margin-left: 0px;
            margin-top: -150px;
            background-color: #02406d;
            font-family: "Kanit", sans-serif;
            color: white;
            padding: 20px;
            display: flex;
        }

        #button-type {
            gap: 20px;
            margin-left: 10px;
        }

        #backToTopBtn {
            width: 50px;
            height: 50px;
            display: flex;
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: white;
            color: #02406d;
            font-size: 25px;
            border: none;
            padding: 0px;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 2px 4px #02406d;
            transition: opacity 0.3s ease-in-out;
        }

        #backToTopBtn:hover {
            background-color: #02406d;
            color: white;
            transform: scale(1.1);
        }

        #backToTopBtn:active {
            transform: scale(0.9);
        }

        .container-rekomendasi {
            margin-top: 50px;
        }


        @media (max-width: 900px) {
            .persegi3 {
                width: 88%;
            }

            .constructor {
                margin-top: 150px;
                margin-left: -180px;
            }

            .img1 {
                margin-top: 10px;
                margin-left: 230px;
                width: 20%;
                height: auto;
            }

            .img2 {
                width: 70%;
                margin-top: -120px;
                margin-left: 70px;
                z-index: -1;
            }

            .navbar-brand {
                margin: 0;
            }

            .title {
                width: 30%;
                font-size: 25px;
                margin-left: 180px;
                margin-top: 600px;
                text-align: center;
            }

            .title2 {
                font-size: 20px;
                margin-left: -650px;
                text-align: center;

            }

            .main-form {
                margin-top: 30px;
            }

            /* Tambahkan aturan CSS lain sesuai kebutuhan Anda */
            .input-jenis-lapangan {
                position: relative;
                top: -62.5rem;
                margin-left: 215px;
                border-radius: 10px;
                width: 25%;
                height: 45px;
                color: #02406d;
                font-size: 20px;
                border: 1px solid #02406D;
                /* Warna border */
                transition: border-color 0.3s;
                /* Efek hover */
            }

            #staticEmail {
                position: relative;
                top: -62rem;
                margin-left: 215px;
                border-radius: 10px;
                width: 25%;
                height: auto;
                padding-left: 10px;
                padding-right: 10px;
                color: #02406d;
                font-size: 20px;
                border: 1px solid #02406D;
                /* Warna border */
                transition: border-color 0.3s;
                /* Efek hover */
            }

            .button {
                position: relative;
                top: -61rem;
                margin-left: 215px;
                border-radius: 10px;
                text-align: center;
                width: 25%;
                height: auto;
                padding-left: 10px;
                padding-right: 10px;
                border: none;
                background-color: #02406d;
                color: white;
                font-size: 20px;
            }

            .persegi {
                width: 20rem;
                /* Lebar persegi dalam piksel */
                height: 20rem;
                /* Tinggi persegi dalam piksel */
                background-color: #e7f5ff;
                /* Warna latar belakang persegi */
                position: relative;
                top: -40rem;
                border-top-right-radius: 10rem;
                border-top-left-radius: 10rem;
                margin-left: -200px;
            }

            .persegi::before {
                content: "";
                position: absolute;
                top: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 1000px;
                /* Lebar bagian lengkungan di atas */
                height: 320px;
                /* Tinggi bagian lengkungan di atas */
                background-color: white;
                /* Warna latar belakang bagian lengkungan di atas */
                border-bottom-right-radius: 10rem;
                border-bottom-left-radius: 10rem;
            }

            .btn-sub-menu {
                width: 50rem;
            }

            .btn[type="button"] {
                border-color: #02406d;
                width: 180px;
                /* Lebar bagian lengkungan di atas */
                height: auto;
                margin-left: 20px;
                font-weight: 600;
                position: relative;
                top: -60rem;
                border-bottom-left-radius: 5px;
                box-shadow: 2px 2px 5px rgba(0, 2, 4, 0, 6, D);
                padding-bottom: 0px;
            }

            .btn img {
                vertical-align: 30px;
                margin-top: 20px;
                width: 100%;
                height: auto;
                text-align: center;
            }

            .btn-1 {
                border: 1px solid #02406d;
                background-color: white;
                width: 180px;
                /* Lebar bagian lengkungan di atas */
                height: 243px;
                margin-left: 20px;
                font-weight: 600;
                position: relative;
                top: -66.3rem;
                border-radius: 5.5px;
                box-shadow: 2px 2px 5px rgba(0, 2, 4, 0, 6, D);
            }

            .btn-1 img {
                vertical-align: 0px;
                margin-top: 20px;
                width: 100%;
                height: auto;
                text-align: center;
            }

            .btn-2 {
                border: 1px solid #02406d;
                background-color: white;
                width: 180px;
                /* Lebar bagian lengkungan di atas */
                height: 243px;
                margin-top: 20px;
                margin-left: 20px;
                font-weight: 600;
                position: relative;
                top: -66.3rem;
                border-radius: 5.5px;
                box-shadow: 2px 2px 5px rgba(0, 2, 4, 0, 6, D);
            }

            .btn-2 img {
                vertical-align: 0px;
                margin-top: 20px;
                width: 90%;
                height: auto;
                text-align: center;
            }

            .btn-3 {
                border: 1px solid #02406d;
                background-color: white;
                width: 180px;
                /* Lebar bagian lengkungan di atas */
                height: 243px;
                margin-left: 223px;
                font-weight: 600;
                position: relative;
                top: -81.5rem;
                border-radius: 5.5px;
                box-shadow: 2px 2px 5px rgba(0, 2, 4, 0, 6, D);
            }

            .btn-3 img {
                vertical-align: 0px;
                margin-top: 20px;
                width: 90%;
                height: auto;
                text-align: center;
            }

            .main-container-body {
                margin-top: 350px;
            }

            .btn-4 {
                border: #02406d;
                height: 250px;
                background-color: White;
                position: relative;
                margin-left: 10px;
                top: -117.5rem;
                font-weight: 600;
                color: #02406d;
            }

            .btn-4 img {
                width: 175px;
                /* Gambar akan mengisi seluruh lebar div */
                height: 175px;
                /* Tinggi gambar akan menyesuaikan agar tidak terdistorsi */
                display: block;
                justify-content: center;
                border-radius: 50%;
                padding: 20px;
                transition: scale 1s;
            }

            .btn-5 {
                border: #02406d;
                height: 250px;
                background-color: White;
                position: relative;
                margin-left: 10px;
                top: -117.5rem;
                font-weight: 600;
                color: #02406d;
            }

            .btn-5 img {
                width: 175px;
                /* Gambar akan mengisi seluruh lebar div */
                height: 175px;
                /* Tinggi gambar akan menyesuaikan agar tidak terdistorsi */
                display: block;
                justify-content: center;
                border-radius: 50%;
                padding: 20px;
                transition: scale 1s;
            }

            .btn-6 {
                border: #02406d;
                height: 250px;
                background-color: White;
                position: relative;
                margin-left: -400px;
                top: -100rem;
                font-weight: 600;
                color: #02406d;
            }

            .btn-6 img {
                width: 175px;
                /* Gambar akan mengisi seluruh lebar div */
                height: 175px;
                /* Tinggi gambar akan menyesuaikan agar tidak terdistorsi */
                display: block;
                justify-content: center;
                border-radius: 50%;
                padding: 20px;
                transition: scale 1s;
            }

            .btn-7 {
                border: #02406d;
                height: 250px;
                background-color: White;
                position: relative;
                margin-left: 10px;
                top: -100rem;
                font-weight: 600;
                color: #02406d;
            }

            .btn-7 img {
                width: 175px;
                /* Gambar akan mengisi seluruh lebar div */
                height: 175px;
                /* Tinggi gambar akan menyesuaikan agar tidak terdistorsi */
                display: block;
                justify-content: center;
                border-radius: 50%;
                padding: 20px;
                transition: scale 1s;
            }

            .btn-8 {
                border: #02406d;
                height: 250px;
                background-color: White;
                position: relative;
                margin-left: -400px;
                top: -82.5rem;
                font-weight: 600;
                color: #02406d;
            }

            .btn-8 img {
                width: 175px;
                /* Gambar akan mengisi seluruh lebar div */
                height: 175px;
                /* Tinggi gambar akan menyesuaikan agar tidak terdistorsi */
                display: block;
                justify-content: center;
                border-radius: 50%;
                padding: 20px;
                transition: scale 1s;
            }

            .container-rekomendasi {
                margin-top: 450px;
            }

            .persegi3 {
                width: 90%;
                background-color: none;
                /* Warna latar belakang persegi */
                position: relative;
                top: -103rem;
                margin-left: 0px;
                margin-right: 0px;
            }
            
            .swiper {
                width: 80%;
                margin-top: -900px;
                margin-left: 0px;
            }

            .swiper-wrapper {
                width: 100%;
                height: 35em;
                display: flex;
                align-items: center;
                margin-left: -100px;
            }

            #button-type {
                display: flex;
                width: 50%;
            }

            #card-slider .card {
                width: 100%;
            }
        }
    </style>
</head>

<body style="overflow-x: hidden;">
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
                        <a class="nav-link active" href="">Beranda</a>
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
                    <?php
                    // Check if the user is logged in
                    if (isset($_SESSION['email'])) {
                        // User is logged in, show the "Panel Pengelola" button
                        echo '<li class="nav-item dropdown" id="nav-down1">
                    <a class="nav-link" id="nav-down-item1" href="boots/" style="width: 200px;">
                      <i class="fa-solid fa-id-card fa-flip" style="margin-right: 5px;"></i>
                      Panel Pengelola
                    </a>
                  </li>';
                    } else {
                        // User is not logged in, show the "Login" and "Register" buttons
                        echo '<li class="nav-item dropdown" id="nav-down1">
                    <a class="nav-link" id="nav-down-item1" href="boots/login.php" style="width: 100px;">Masuk</a>
                  </li>
                  <li class="nav-item dropdown" id="nav-down1">
                    <a class="nav-link" id="nav-down-item2" href="boots/register.php" style="width: 100px;">Daftar</a>
                  </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="constructor" id="con-awal">
        <div id="con-img">
            <img src="img_asset/logo (1).png" class="img1 img-fluid" alt="..." />
            <img src="img_asset/logo2.png" class="img2 img-fluid" alt="..." />
        </div>

        <h1 id="judul" class="title">Aktivitas penunjang kehidupan yang lebih sehat dan menyenangkan</h1>
        <h1 id="judul" class="title2">Temukan Sekarang !!!</h1>
        <div class="main-form">
            <form method="post" action="cari_jadwal.php">
                <select id="inputOpsi" class="input-jenis-lapangan" name="jenis_lapangan" required>
                    <option value="Futsal">Futsal</option>
                    <option value="Badminton">Badminton</option>
                    <option value="Voli">Voli</option>
                    <option value="Sepak Bola">Sepak Bola</option>
                    <option value="Tenis Lapangan">Tenis Lapangan</option>
                </select>
                <input type="datetime-local" placeholder="Pilih Tanggal" class="form-control" id="staticEmail"
                    name="tanggal" required>
                <button class="button" type="submit">Temukan</button>
            </form>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                flatpickr("#staticEmail", {
                    enableTime: false, // Enable time selection
                    minDate: "today", // Set the minimum date to today
                    dateFormat: "Y-m-d", // Specify the date format
                    defaultDate: "today",
                });
            });
        </script>
    </div>

    <div class="con-href">
        <div class="persegi"></div>
        <div class="btn-sub-menu">
            <a href="alur-pesan.php">
                <button class="btn" type="button" style="font-weight: 100;" id="alur-btn">Alur Pemesanan
                    <img src="img_asset/geocaching_40px (1).png" alt="">
                </button>
            </a>
            <a href="aktivitas.php">
                <button class="btn-1" type="button" style="font-weight: 100;">Aktivitas Komunitas
                    <img src="img_asset/people_48px (1).png" alt="" id="aktiv-btn">
                </button>
            </a>
            <form method="post">
                <button class="btn-2" type="submit" name="status_lap_button" style="font-weight: 100;">
                    Status Lapangan
                    <img src="img_asset/info_64px (1).png" alt="" id="status-btn">
                </button>
            </form>
            <a href="boots/pesanan.php">
                <button class="btn-3" type="button" style="font-weight: 100;">Daftar Pesanan
                    <img src="   https://cdn-icons-png.flaticon.com/512/1187/1187525.png " width="100" height="150"
                        alt="" title="" class="img-small">
                </button>
            </a>
        </div>
    </div>

    <div class="main-container-body">
        <div class="container-type-sport">
            <div class="persegi2"></div>
            <div id="button-type">
                <button class="btn-4" type="button">
                    <img src="img_asset/alex-_AOL4_fDQ3M-unsplash.jpg" alt=""><span>Futsal</span></button>
                <button class="btn-5" type="button">
                    <img src="img_asset/bulu tangkis.jpg" alt=""><span>Bulu Tangkis</span></button>
                <button class="btn-6" type="button">
                    <img src="img_asset/voli.jpg" alt=""><span>Bola Voli </span></button>
                <button class="btn-7" type="button">
                    <img src="img_asset/basket.jpg" alt=""><span>Bola Basket</span></button>
                <button class="btn-8" type="button">
                    <img src="img_asset/sepak bola.jpg" alt=""><span>Sepak Bola</span></button>
            </div>
        </div>

        <div class="container-rekomendasi">
            <div class="community"> Rekomendasi Komunitas </div>
            <div class="persegi3">
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner mx-3 my-1">
                        <div class="carousel-item active">
                            <img src="img_asset/connor-coyne-OgqWLzWRSaI-unsplash.jpg" class="d-block w-100" alt="..."
                                style="height: 500px;">
                        </div>
                        <div class="carousel-item">
                            <img src="img_asset/badmin_community.jpg" class="d-block w-100" alt="..."
                                style="height: 500px;">
                        </div>
                        <div class="carousel-item">
                            <img src="img_asset/bg-member.png" class="d-block w-100" alt="..." style="height: 500px;">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="container" id="container-swiper-activity">
            <div class="community" id="r-a" style="margin-top: 150px; margin-left: -100px;">Rekomendasi Aktivitas</div>
            <section class="swiper mySwiper" id="swiper-activity">
                <div class="swiper-wrapper" id="swiper-activity-wrapper">
                    <?php
                    // Pengambilan data dari tabel venue_aktivitas 
                    $sql = "SELECT va.*, v.location, v.sport
                            FROM venue_aktivitas va
                            JOIN venues v ON va.id_venue = v.id_venue";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $namaGambar = $row['photo']; // Assuming the 'photo' column contains the image filename
                            $gambarURL = "public/img/venue/" . $namaGambar;
                            ?>

                            <div class="swiper-slide" style="width: 400px;"> <!-- Sesuaikan lebar card -->
                                <div class="card" style="height: 450px; padding: 0px;">
                                    <!-- Use the data from the database to populate the card -->
                                    <img src="<?php echo $gambarURL; ?>" class="card-img-top" alt="..."
                                        style="height: 200px; object-fit: cover; border-bottom-left-radius: 40px; border-bottom-right-radius: 40px;">
                                    <div class="card__content">
                                        <span class="card__title" style="margin-top: 10px;">
                                            <?php echo $row['nama_aktivitas']; ?>
                                        </span>
                                        <span class="card__text">Lokasi :
                                            <?php echo $row['location']; ?>
                                        </span>
                                        <button class="tombol-aktivitas" data-nama="<?php echo $row['nama_aktivitas']; ?>"
                                            data-lokasi="<?php echo $row['location']; ?>"
                                            data-tanggal="<?php echo $row['date']; ?>"
                                            data-jam="<?php echo $row['jam_main']; ?>" data-harga="<?php echo $row['price']; ?>"
                                            data-foto="<?php echo $row['photo']; ?>"
                                            data-sport="<?php echo $row['sport']; ?>">Lihat
                                            Aktivitas</button>

                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    } else {
                        echo "0 results";
                    }

                    // Close the database connection
                    $conn->close();
                    ?>
                </div>
            </section>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalAktivitas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="judulModal">Judul Aktivitas</h4>
                    </div>
                    <div class="modal-body">
                        <img id="fotoModal" class="img-fluid mx-auto" alt="Foto Aktivitas"
                            style="width: 100%; height: auto;">
                        <p id="lokasiModal" style="margin-top: 10px;"></p>
                        <p id="tanggalModal"></p>
                        <p id="jamModal"></p>
                        <p id="hargaModal"></p>
                        <p id="sportModal"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="tombol-aktivitas mx-auto" id="tutupModal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Script JavaScript untuk menutup modal -->
        <script>
            document.getElementById('tutupModal').addEventListener('click', function () {
                $('#modalAktivitas').modal('hide'); // Sesuaikan dengan ID modal Anda
            });
        </script>

        <!-- Include jQuery library (you can download and host it locally if needed) -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <!-- Script untuk menangani pembukaan modal -->
        <script>
            $(document).ready(function () {
                // Menangani klik pada tombol dengan kelas "tombol-aktivitas"
                $('.tombol-aktivitas').click(function () {
                    // Mendapatkan data dari atribut data pada tombol
                    var namaAktivitas = $(this).data('nama');
                    var lokasi = $(this).data('lokasi');
                    var tanggal = $(this).data('tanggal');
                    var jam = $(this).data('jam');
                    var harga = $(this).data('harga');
                    var sport = $(this).data('sport');
                    var foto = 'public/img/venue/' + $(this).data('foto'); // Ganti dengan path sesuai struktur folder Anda

                    // Memasukkan data ke dalam modal
                    $('#judulModal').text(namaAktivitas);
                    $('#fotoModal').attr('src', foto);
                    $('#lokasiModal').text('Lokasi: ' + lokasi);
                    $('#tanggalModal').text('Hari/Tanggal: ' + tanggal);
                    $('#jamModal').text('Jam: ' + jam);
                    $('#hargaModal').text('Harga: ' + harga);
                    $('#sportModal').text(sport);

                    // Membuka modal
                    $('#modalAktivitas').modal('show');
                });
            });
        </script>

        <div class="con-swiper">
            <div class="community" id="developer_group">Tim Pengembang</div>
            <section class="swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="card swiper-slide">
                        <div class="card__image">
                            <img src="public/img_asset/1. Ahmad Baihaqi (1).JPG" alt="card image" />
                        </div>

                        <div class="card__content">
                            <span class="card__title">Achmad Baihaqi</span>
                            <span class="card__name">Mobile Developer</span>
                            <div class="social-buttons">
                                <a href="https://web.facebook.com/pages/Blessing-Futsal-Nganjuk/1438586789529016"
                                    class="social-button facebook"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="social-button twitter"><i class="fab fa-twitter"></i></a>
                                <a href="https://instagram.com/blessing.futsal?igshid=NGVhN2U2NjQOYg=="
                                    class="social-button instagram"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card swiper-slide">
                        <div class="card__image">
                            <img src="public/img_asset/ninik.jpg" alt="card image" />
                        </div>

                        <div class="card__content">
                            <span class="card__title">Ninik Yuniarsih</span>
                            <span class="card__name">Tester</span>
                            <div class="social-buttons">
                                <a href="https://web.facebook.com/pages/Blessing-Futsal-Nganjuk/1438586789529016"
                                    class="social-button facebook"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="social-button twitter"><i class="fab fa-twitter"></i></a>
                                <a href="https://instagram.com/blessing.futsal?igshid=NGVhN2U2NjQOYg=="
                                    class="social-button instagram"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card swiper-slide">
                        <div class="card__image">
                            <img src="public/img_asset/E41222030_Afrizal Wahyu Alkautsar_Teknik Informatika.jpeg.jpg"
                                alt="card image" />
                        </div>

                        <div class="card__content">
                            <span class="card__title">Afrizal Wahyu A.</span>
                            <span class="card__name">Project Manager</span>
                            <div class="social-buttons">
                                <a href="https://web.facebook.com/pages/Blessing-Futsal-Nganjuk/1438586789529016"
                                    class="social-button facebook"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="social-button twitter"><i class="fab fa-twitter"></i></a>
                                <a href="https://instagram.com/blessing.futsal?igshid=NGVhN2U2NjQOYg=="
                                    class="social-button instagram"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card swiper-slide">
                        <div class="card__image">
                            <img src="public/img_asset/DSC_7443 e.jpg" alt="card image" />
                        </div>

                        <div class="card__content">
                            <span class="card__title">Syafrizal Wd M.</span>
                            <span class="card__name">Web Developer</span>
                            <div class="social-buttons">
                                <a href="https://web.facebook.com/pages/Blessing-Futsal-Nganjuk/1438586789529016"
                                    class="social-button facebook"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="social-button twitter"><i class="fab fa-twitter"></i></a>
                                <a href="https://instagram.com/blessing.futsal?igshid=NGVhN2U2NjQOYg=="
                                    class="social-button instagram"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card swiper-slide">
                        <div class="card__image">
                            <img src="public/img_asset/E41222892_Widyasari Raisya _Teknik Informatika.JPG"
                                alt="card image" />
                        </div>

                        <div class="card__content">
                            <span class="card__title">Widyasari Raisya S.</span>
                            <span class="card__name">SQA</span>
                            <div class="social-buttons">
                                <a href="https://web.facebook.com/pages/Blessing-Futsal-Nganjuk/1438586789529016"
                                    class="social-button facebook"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="social-button twitter"><i class="fab fa-twitter"></i></a>
                                <a href="https://instagram.com/blessing.futsal?igshid=NGVhN2U2NjQOYg=="
                                    class="social-button instagram"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="backToTopBtn"><i class="fa-solid fa-chevron-up"></i></button>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var backToTopBtn = document.getElementById("backToTopBtn");

            // Function to update button visibility
            function updateButtonVisibility() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    backToTopBtn.style.display = "block";
                } else {
                    backToTopBtn.style.display = "none";
                }
            }

            // Initial check on page load
            updateButtonVisibility();

            // Show or hide the button based on scroll position
            window.onscroll = function () {
                updateButtonVisibility();
            };

            // Scroll to the top when the button is clicked
            backToTopBtn.onclick = function () {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            };
        });
    </script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 300,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
            },
        });
    </script>



    <div class="footer">
        <h1 style="font-size: 20px; color: white;">Arena</h1>
        <h1 style="font-size: 20px; color: #A1FF9F;">Finder</h1>
        <div class="hierarki">
            <p style="font-size: 20px; color: white; margin-left: 250px;">Hierarki
                <a href="index.php" style="margin-top: 10px;">Beranda</a>
                <a href="aktivitas.php">Aktivitas</a>
                <a href="referensi.php">Referensi</a>
                <a href="info_mitra.php">Info Mitra</a>
            </p>
            <p style="font-size: 20px; color: white; margin-left: 120px;">Bantuan
                <a href="" style="margin-top: 10px;">Apa saja layanan yang disediakan?</a>
                <a href="">Siapa target penggunanya?</a>
                <a href="">Bagaimana sistem ini bekerja?</a>
                <a href="">Saat kapan pengguna dapat mengetahui pesanan?</a>
                <a href="/boots/login.php">Masuk aplikasi??</a>
                <a href="/boots/register.php">Daftar aplikasi??</a>
            </p>
            <p style="font-size: 20px; color: white; margin-left: 120px;">Narahubung
                <a href="https://wa.me/62895807400305">https://wa.me/62895807400305
                </a>
            </p>
        </div>

    </div>



    <!-- flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("input[type=datetime-local]", {});
    </script>
    <!-- Include Bootstrap JS (jQuery and Popper.js are required) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>