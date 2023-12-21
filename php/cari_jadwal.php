<?php
session_start();
$host = "localhost";
$user = "tifz1761_root";
$pass = "tifnganjuk321";
$db = "tifz1761_arenafinder";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Tidak bisa terkoneksi");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Aktivitas</title>
    <link rel="stylesheet" href="css/beranda.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
    <link rel="icon" href="img_asset/login.png">
    <style>
        body {
            margin-top: 150px;
            overflow-x: hidden;
        }

        .fourth-sep {
            margin-left: 175px;
        }

        .semua-act {
            margin-left: 200px;
        }

        #drop-menu {
            background-color: #e7f5ff;
            border: 1px solid white;
            color: #02406D;
        }

        .dropdown-divider {
            border: 1px solid white;
        }

        /* Saat dropdown-item di-hover */
        .dropdown-menu a.dropdown-item:hover {
            background-color: #02406D;
            color: white;
        }

        /* Mengatur warna teks dan latar belakang default */
        .dropdown-menu a.dropdown-item {
            color: initial;
            /* Atur warna teks kembali ke nilai default */
            background-color: initial;
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
            background-color: #a1ff9f;
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
            background-color: #a1ff9f;
            color: #02406D;
            transition: 0.5s;
            transform: scale(1.1);
        }

        #nav-down-item2:active {
            color: white;
        }

        .box {
            width: 100%;
            height: 77px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -115px;
        }

        .box .rectangle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 90%;
            height: 77px;
            top: 0;
            left: 0;
            background-color: #02406d;
            border-radius: 50px;
            margin-top: 100px;
            text-align: center;
            box-shadow: 0 2px 4px #A1FF9F;
        }

        .label {
            width: 588px;
            height: 58px;
            padding-top: 10px;
        }

        .label .jadwal-futsal-di {
            width: 588px;
            height: 58px;
            display: flex;
            text-align: center;
            justify-content: center;
            top: 0;
            left: 0;
            font-family: "Kanit-Medium", Helvetica;
            color: transparent;
            font-size: 30px;
            letter-spacing: -0.8px;
            line-height: 22px;
            gap: 5px;
        }

        .label .text-wrapper {
            color: #ffffff;
        }

        .label .span {
            color: #a1ff9f;
        }

        /* Style for the form container */
        .form-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 100px;
        }

        /* Style for the form group (containing select and date input) */
        .form-group {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        /* Style for the select input */
        .form-control {
            width: 300px;
            padding: 10px;
            border: 1px solid #02406D;
            border-radius: 5px;
            color: #02406D;
        }

        /* Style for the date input */
        .form-control[type="datetime-local"] {
            border: 1px solid #02406D;
            border-radius: 5px;
            width: 300px;
            padding: 10px;
            color: #02406D;
        }

        /* Style for the submit button */
        #btn-find {
            position: relative;
            padding: 10px;
            margin-top: 10px;
            margin-left: 30px;
            border-radius: 10px;
            text-align: center;
            width: 100px;
            height: 50px;
            background-color: #02406d;
            color: white;
        }

        /* Hover effect for the submit button */
        #btn-find:hover {
            background-color: #02406d;
            color: white;
            border: 1px solid #02406d;
            transition: 0.5s;
            transform: scale(1.1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
            /* Menambahkan bayangan */
        }

        #label2 {
            display: flex;
            background-color: #ffffff;
            padding: 10px;
            border-radius: 5px;
            margin-top: 50px;
            margin-bottom: 50px;
            margin-left: 50px;
            width: 100%;
            /* Adjust the width as needed */
        }

        #label2 .text {
            font-family: Arial, sans-serif;
        }

        #label2 .text-wrapper {
            font-weight: regular;
            color: #02406D;
        }

        #label2 .span {
            font-weight: bold;
            color: #02406D;
        }

        #label2 .text-wrapper-2 {
            font-weight: regular;
            color: #02406D;
        }

        #wrap-txt {
            margin-left: 100px;
        }

        #container-schedule {
            margin-top: 0px;
            margin-left: -500px;
        }

        .card-title {
            font-weight: bold;
            font-size: 25px;
            color: #02406D;
            width: 300px;
        }

        #date-card {
            margin-top: -30px;
            margin-bottom: -5px;
            color: #02406D;
        }

        #time-card {
            color: #02406D;
            font-weight: bold;
            font-size: 13px;
        }

        #price-card {
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
            color: #02406D;
        }

        #status-card {
            width: 50%;
            height: auto;
            background-color: #02406D;
            color: white;
            padding-top: 5px;
            padding-bottom: 15px;
            margin-bottom: -40px;
            margin-left: 75px;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;

        }

        #card-main {
            width: 220px;
            height: auto;
            margin-top: 20px;
            display: flex;
            transition: transform 0.2s;
            border: none;
            background-color: white;
            box-shadow: 0 2px 4px #02406D;
        }

        #card-main:hover {
            transform: translateY(-5px);
        }

        .card-container {
            display: flex;
            white-space: nowrap;
            padding: 10px;
            gap: 30px;
            box-sizing: border-box;
            cursor: grab;
            width: 95%;
            margin-left: 40px;
            /* Ensure the container takes the full width */
        }

        .card-container:active {
            cursor: grabbing;
        }

        .card {
            display: flex;
            flex-shrink: 0;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin: 10px;
            padding: 20px;
            font-size: 20px;
            font-weight: bold;
            min-width: 220px;
            background-color: #02406D;

        }

        .card:hover {
            cursor: pointer;
        }

        @media (max-width: 900px) {
            .form-container {
                display: flex;
                margin-left: 10px;
                margin-top: 100px;
            }

            /* Style for the select input */
            .form-control {
                width: 220px;
                padding: 10px;
                border: 1px solid #02406D;
                border-radius: 5px;
                color: #02406D;
            }

            #label2 {
                margin-left: 40px;
            }

            #wrap-txt {
                margin-left: 150px;
                padding-top: 5px;
            }

            .card-container {
                margin-left: 80px;
            }

            .footer {
                margin-left: -100px;
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
                    <?php
                    // Check if the user is logged in
                    if (isset($_SESSION['email'])) {
                        // User is logged in, show the "Panel Pengelola" button
                        echo '<li class="nav-item dropdown" id="nav-down1">
                            <a class="nav-link" id="nav-down-item1" href="/boots/index.php" style="width: 200px;">
                            <i class="fa-solid fa-id-card fa-flip" style="margin-right: 5px;"></i>
                            Panel Pengelola
                            </a>
                        </li>';
                    } else {
                        // User is not logged in, show the "Login" and "Register" buttons
                        echo '<li class="nav-item dropdown" id="nav-down1">
                            <a class="nav-link" id="nav-down-item1" href="/boots/login.php" style="width: 100px;">Masuk</a>
                        </li>
                        <li class="nav-item dropdown" id="nav-down1">
                            <a class="nav-link" id="nav-down-item2" href="/boots/register.php" style="width: 100px;">Daftar</a>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="box">
        <div class="rectangle">
            <div class="label">
                <p class="jadwal-futsal-di">
                    <?php
                    // Ambil data dari formulir pencarian
                    $jenis_lapangan = $_POST['jenis_lapangan'];
                    $tanggal = $_POST['tanggal'];

                    // Buat query untuk mencari jadwal sesuai dengan jenis lapangan dan tanggal
                    $query = "SELECT vp.*, v.sport, vb.payment_status
                            FROM venue_price vp
                            JOIN venues v ON vp.id_venue = v.id_venue
                            LEFT JOIN venue_booking vb ON vp.id_venue = vb.payment_status
                            WHERE v.sport='$jenis_lapangan' AND vp.date='$tanggal'";
                    $result = mysqli_query($koneksi, $query);

                    if ($row = mysqli_fetch_assoc($result)) {
                        // Mengambil data dari database
                        $futsalData = $row['sport']; // Mengambil data dari kolom 'sport' di tabel 'venues'
                        $tanggalData = $row['date']; // Mengambil data dari kolom 'date' di tabel 'venue_price'
                    
                        // Echo data ke dalam span
                        echo '<span class="text-wrapper">Jadwal</span>';
                        echo '<span class="span">' . $futsalData . ' </span>';
                        echo '<span class="text-wrapper">di </span>';
                        echo '<span class="span">Nganjuk </span>';
                        echo '<span class="text-wrapper">' . $tanggalData . '</span>';
                    } else {
                        echo '<span class="text-wrapper" id="wrap-txt">Jadwal Tidak Ditemukan</span>';
                    }
                    ?>

                </p>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form method="post" action="">
            <div class="form-group">
                <select id="inputOpsi" class="form-control" name="jenis_lapangan">
                    <option value="Futsal">Futsal</option>
                    <option value="Badminton">Badminton</option>
                    <option value="Voli">Voli</option>
                    <option value="Sepak Bola">Sepak Bola</option>
                    <option value="Tenis Lapangan">Tenis Lapangan</option>
                </select>
                <input type="datetime-local" placeholder="Pilih Tanggal" class="form-control" id="staticEmail"
                    name="tanggal">
                <button type="submit" id="btn-find">Temukan</button>
            </div>

        </form>
    </div>

    <div class="label" id="label2">
        <p class="text">
            <span class="text-wrapper">*Periode tanggal pemesanan:</span>
            <span class="span" id="span-con"></span>
            <script>
                // Mendapatkan tanggal sekarang
                const tglSekarang = new Date();

                // Mendapatkan bulan dan tahun sekarang
                const bulanSekarang = tglSekarang.getMonth();
                const tahunSekarang = tglSekarang.getFullYear();

                // Mendapatkan jumlah hari dalam bulan ini
                const akhirBulan = new Date(tahunSekarang, bulanSekarang + 1, 0).getDate();

                // Container untuk menampilkan card
                const cardCon = document.getElementById("span-con");

                const namaBulanArray = [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                    "Oktober",
                    "November",
                    "Desember",
                ];

                // Inisialisasi tanggal awal dan akhir
                let tanggalAwal = tglSekarang.getDate();
                let tanggalAkhir = akhirBulan;

                // Membuat string untuk menyimpan konten
                let kontenHTML = "";

                // Format bulan untuk penulisan satu kali saja
                const namaBulan = namaBulanArray[bulanSekarang];

                // Tambahkan elemen ke dalam string kontenHTML
                kontenHTML += `${tanggalAwal} ${namaBulan} - ${tanggalAkhir} ${namaBulan}`;

                // Setel innerHTML setelah perulangan selesai
                cardCon.innerHTML = kontenHTML;

            </script>

            <br>
            <span class="text-wrapper">*Status </span>
            <span class="span">Belum Dipesan</span>
            <span class="text-wrapper-2"> akan berubah menjadi </span>
            <span class="span">Sudah Dipesan</span>
            <span class="text-wrapper-2">jika admin telah mengkonfirmasi pesanan dari pelanggan.<br /></span>
            <span class="text-wrapper">*Durasi sewa lapangan </span>
            <span class="span">perjam</span>
            <span class="text-wrapper"> untuk setiap pemesanan.</span>
        </p>
    </div>

    <div class="card-container" id="cardContainer">
        <!-- Card akan ditambahkan melalui JavaScript -->
    </div>
    <div class="card-container" id="scheduleContainer">
        <!-- Card akan ditambahkan melalui JavaScript -->
    </div>

    <script>
        // Mendapatkan tanggal sekarang
        const currentDate = new Date();

        // Mendapatkan bulan dan tahun sekarang
        const currentMonth = currentDate.getMonth();
        const currentYear = currentDate.getFullYear();

        // Mendapatkan jumlah hari dalam bulan ini
        const lastDayOfMonth = new Date(
            currentYear,
            currentMonth + 1,
            0
        ).getDate();

        // Container untuk menampilkan card
        const cardContainer = document.getElementById("cardContainer");

        const monthNames = [
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember",
        ];

        const dayNames = [
            "Minggu",
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jum'at",
            "Sabtu",
        ];

        // Handle card click
        function handleCardClick(day) {
            // Clear the existing cards in the container
            cardContainer.innerHTML = '';

            // Set currentYear dan currentMonth
            const currentYear = new Date().getFullYear();
            const currentMonth = new Date().getMonth(); // Ingat, bulan dimulai dari 0 (Januari)

            // Get the full date
            const clickedDate = new Date(currentYear, currentMonth, day); // Sesuaikan day dengan tanggal yang diklik

            // Get the day and month names
            const dayName = dayNames[clickedDate.getDay()];
            const monthName = monthNames[clickedDate.getMonth()];

            // Create an element card
            const card = document.createElement("div");
            card.className = "card";

            card.style.color = "white";
            card.style.fontWeight = "800";
            card.style.fontSize = "40px";
            card.style.width = "220px";
            card.style.height = "120px";
            card.style.border = "none";
            card.style.boxShadow = "0 2px 4px rgba(0, 0, 0, 0.5)";

            // Set the value on the card
            card.textContent = `${day} ${monthName.substring(0, 3)}`;
            // Log the formatted date to the console
            console.log("Formatted Date:", clickedDate.toISOString().split('T')[0]);
            const dayOfWeek = document.createElement("div");
            dayOfWeek.textContent = `${dayName}`;
            dayOfWeek.style.color = "#a1ff9f";
            dayOfWeek.style.fontWeight = "200";
            dayOfWeek.style.fontSize = "30px";
            card.appendChild(dayOfWeek);

            // Perform an asynchronous request to get data from venue_price
            fetch('get_venue_price.php', {  // Update the path if needed
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'get_data',
                    date: clickedDate.toISOString().split('T')[0], // Format date as YYYY-MM-DD
                }),
            })
                .then(response => response.json())
                .then(data => {
                    // Assuming you have a container with id "scheduleContainer" in your HTML
                    const scheduleContainer = document.getElementById("scheduleContainer");

                    if (data.length > 0) {
                        data.forEach(schedule => {
                            const scheduleCard = document.createElement("div");
                            scheduleCard.className = "card";
                            scheduleCard.innerHTML = `
                                <div class="card-body">
                                    <h5 class="card-title">${schedule.membership === 0 ? 'Non Member' : 'Member'}</h5>
                                    <p class="card-text" id="date-card">${schedule.date}</p>
                                    <div class="waktu-container">
                                        <span class="card-text" id="time-card">${schedule.start_hour} - </span>
                                        <span class="card-text" id="time-card">${schedule.end_hour}</span>
                                    </div>
                                    <p class="card-text" id="price-card">Rp. ${schedule.price} /Jam</p>
                                    <p class="card-text" id="status-card" style="margin-top: auto;">${schedule.payment_status}</p>
                                </div>
                            `;
                            scheduleContainer.appendChild(scheduleCard);
                        });
                    } else {
                        // If no schedule data is retrieved, you can display a message or handle it accordingly
                        const noScheduleMessage = document.createElement("p");
                        noScheduleMessage.textContent = "No schedule available for this date.";
                        scheduleContainer.appendChild(noScheduleMessage);
                    }

                })
                .catch(error => {
                    console.error('Error:', error);
                });

            // Add the card to the container
            cardContainer.appendChild(card);
        }


        // Loop to create cards
        for (let day = currentDate.getDate(); day <= lastDayOfMonth; day++) {
            // Get the full date
            const currentDay = new Date(currentYear, currentMonth, day);
            const dayName = dayNames[currentDay.getDay()];
            const monthName = monthNames[currentDay.getMonth()];

            // Create an element card
            const card = document.createElement("div");
            card.className = "card";

            card.style.color = "white"; // Change the color for weekdays
            card.style.fontWeight = "800";
            card.style.fontSize = "40px";
            card.style.width = "220px";
            card.style.height = "120px";
            card.style.border = "none";
            card.style.boxShadow = "0 2px 4px rgba(0, 0, 0, 0.5)";
            card.style.cursor = "pointer"; // Add cursor style for indicating it's clickable

            // Set the value on the card
            card.textContent = `${day} ${monthName.substring(0, 3)}`;
            const dayOfWeek = document.createElement("div");
            dayOfWeek.textContent = `${dayName}`;
            dayOfWeek.style.color = "#a1ff9f";
            dayOfWeek.style.fontWeight = "200";
            dayOfWeek.style.fontSize = "30px";
            card.appendChild(dayOfWeek);

            // Handle card click
            card.addEventListener("click", function () {
                handleCardClick(day);
            });

            // Add the card to the container
            cardContainer.appendChild(card);
        }

        // Mendapatkan elemen container dan card
        const container = document.querySelector(".card-container");
        const cards = document.querySelectorAll(".card");

        let isDragging = false;
        let startPosition = 0;
        let currentTranslate = 0;
        let previousTranslate = 0;

        // Menyimpan posisi awal saat menyentuh layar atau klik mouse
        function onStart(event) {
            isDragging = true;
            startPosition = getEventPosition(event);
            container.style.transition = "none";
        }

        // Menggeser card saat menyentuh dan menggeser layar atau klik mouse
        function onMove(event) {
            if (isDragging) {
                const currentPosition = getEventPosition(event);
                currentTranslate = previousTranslate + currentPosition - startPosition;

                // Set a left margin (adjust the value as needed)
                const leftMargin = 50;

                // Limit the left boundary
                if (currentTranslate > leftMargin) {
                    currentTranslate = leftMargin;
                }

                // Limit the right boundary
                const maxTranslate = -(cards.length - 5) * (cards[0].offsetWidth + 20);
                if (currentTranslate < maxTranslate) {
                    currentTranslate = maxTranslate;
                }

                updateTransform();
            }
        }

        // Menghentikan animasi dan menyimpan posisi geser saat melepaskan layar atau klik mouse
        function onEnd() {
            isDragging = false;
            container.style.transition = "transform 0.2s ease";

            const threshold = container.offsetWidth / 5;

            // Menggeser ke kartu selanjutnya jika melebihi threshold, sebaliknya kembali ke posisi semula
            if (currentTranslate > 0) {
                container.style.transform = "translateX(0)";
                previousTranslate = currentTranslate = 0; z
            } else if (
                currentTranslate <
                -(cards.length - 5) * (cards[0].offsetWidth + 20)
            ) {
                container.style.transform = `translateX(${-(cards.length - 5) * (cards[0].offsetWidth + 20)
                    }px)`;
                previousTranslate = currentTranslate =
                    -(cards.length - 5) * (cards[0].offsetWidth + 20);
            } else if (currentTranslate < -50) { // Set the limit value (adjust as needed)
                container.style.transform = `translateX(${currentTranslate}px)`;
                previousTranslate = currentTranslate;
            } else {
                container.style.transform = "translateX(-50px)"; // Set the left limit value
                previousTranslate = currentTranslate = -50;
            }
        }


        // Menghitung posisi dari event (sentuhan atau klik mouse)
        function getEventPosition(event) {
            return event.type.includes("mouse")
                ? event.clientX
                : event.touches[0].clientX;
        }

        // Memperbarui transformasi pada container
        function updateTransform() {
            container.style.transform = `translateX(${currentTranslate}px)`;
        }

        // Event listener untuk menyentuh layar atau klik mouse
        container.addEventListener("mousedown", onStart);
        container.addEventListener("mousemove", onMove);
        container.addEventListener("mouseup", onEnd);

        // Event listener untuk sentuhan pada layar
        container.addEventListener("touchstart", onStart);
        container.addEventListener("touchmove", onMove);
        container.addEventListener("touchend", onEnd);
    </script>

    <div class="cards-container" id="container-schedule">
        <?php
        // Ambil data dari formulir pencarian
        $jenis_lapangan = $_POST['jenis_lapangan'];
        $tanggal = $_POST['tanggal'];

        $query = "SELECT vp.*, v.sport, 
        CASE 
            WHEN vb.date_confirmed IS NOT NULL AND vb.date_confirmed <> '$tanggal' THEN 'Sudah Dipesan'
            ELSE 'Belum Dipesan'
        END AS payment_status
        FROM venue_price vp
        JOIN venues v ON vp.id_venue = v.id_venue
        LEFT JOIN venue_booking vb ON vp.id_price = vb.payment_status
        WHERE v.sport='$jenis_lapangan' AND vp.date='$tanggal'";

        $result = mysqli_query($koneksi, $query);
        $count = 0;

        if (mysqli_num_rows($result) > 0) {
            // Tampilkan jadwal jika ditemukan
            while ($row = mysqli_fetch_assoc($result)) {
                // Membuka baris baru setiap kali 4 kartu telah ditampilkan
                if ($count % 5 == 0) {
                    echo '</div><div class="cards-container" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px;">';
                }
                // // Determine the card class based on the status
                // $cardClass = ($row['status_pemesanan'] == 'Sudah Dipesan') ? 'card shadow gray-card' : 'card shadow';
        
                // Card untuk data
                echo '<div class="card" id="card-main">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">' . ($row['membership'] == 0 ? 'Non Member' : 'Member') . '</h5>';
                echo '<p class="card-text" id="date-card">' . $row['date'] . '</p>';
                echo '<div class="waktu-container">';
                echo '<span class="card-text" id="time-card">' . $row['start_hour'] . ' - </span>';
                echo '<span class="card-text" id="time-card">' . $row['end_hour'] . '</span>';
                echo '</div>';
                echo '<p class="card-text" id="price-card">Rp. ' . $row['price'] . ' /Jam</p>';
                echo '<p class="card-text" id="status-card" style="margin-top: auto; font-weight: 100;">' . $row['payment_status'] . '</p>';

                echo '</div></div>';

                $count++;
            }
        }
        ?>
    </div>

    <div class="container">
        <div class="footer">
            <h1 style="font-size: 20px; color: white;">Arena</h1>
            <h1 style="font-size: 20px; color: #A1FF9F;">Finder</h1>
            <div class="hierarki">
                <p style="font-size: 20px; color: white; margin-left: 250px;">Hierarki
                    <a href="" style="margin-top: 10px;">Beranda</a>
                    <a href="">Aktivitas</a>
                    <a href="">Referensi</a>
                    <a href="">Info Mitra</a>
                </p>
                <p style="font-size: 20px; color: white; margin-left: 120px;">Bantuan
                    <a href="" style="margin-top: 10px;">Apa saja layanan yang disediakan?</a>
                    <a href="">Siapa target penggunanya?</a>
                    <a href="">Bagaimana sistem ini bekerja?</a>
                    <a href="">Saat kapan pengguna dapat mengetahui pesanan?</a>
                    <a href="">Masuk aplikasi??</a>
                    <a href="">Daftar aplikasi??</a>
                </p>
                <p style="font-size: 20px; color: white; margin-left: 120px;">Narahubung
                    <a href="">https://chat.whatsapp.com/DycWLfU9nt40BIjERofIrq</a>
                </p>
            </div>

            <!-- flatpickr -->
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script>
                flatpickr("input[type=datetime-local]", {});
            </script>
            <!-- Include Bootstrap JS and jQuery -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    flatpickr("#staticEmail", {
                        enableTime: false, // Enable time selection
                        minDate: "today", // Set the minimum date to today
                        dateFormat: "Y-m-d", // Specify the date format
                        defaultDate: "today"
                    });
                });
            </script>
</body>

</html>