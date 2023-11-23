<?php
session_start();

if (!isset($_SESSION['email'])) {
    // Jika pengguna belum masuk, arahkan mereka kembali ke halaman login
    header("Location: login.php");
    exit();
}

// Pengguna sudah masuk, Anda dapat mengakses data sesi
$email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ArenaFinder - Pesanan</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }
    </style>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #02406d;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fa-solid fa-clipboard mx-3 ml-auto"></i>
                </div>
                <div class="sidebar-brand-text">Arena</div>
                <div class="sidebar-brand-text" style="color: #a1ff9f;">Finder</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

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
                <a class="nav-link" href="/ArenaFinder/php/beranda.php">
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
            <li class="nav-item">
                <a class="nav-link" href="jadwal.php">
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
                <a class="nav-link" href="keanggotaan.php" id="anggota-link">
                    <i class="fa-solid fa-users"></i>
                    <span>Keanggotaan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Notifikasi
            </div>

            <!-- Assuming this is your navigation link HTML -->
            <li class="nav-item active">
                <a class="nav-link" href="pesanan.php">
                    <i class="fa-solid fa-cart-shopping">
                    <span class="badge badge-danger badge-counter" id="pesanan-link"></span>
                    </i>
                    <span>Pesanan</span>
                </a>
            </li>

            <!-- Include jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

            <!-- Your Badge Script with AJAX -->
            <script>
                setInterval(function () {
                    function loadDoc() {
                        var xhttp = new XMLHttpRequest();
                        xhttp.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("pesanan-link").innerHTML = this.responseText;
                            }
                        };
                        xhttp.open("GET", "check_data.php", true);
                        xhttp.send();
                    }
                    loadDoc();
                }, 1000);
            </script>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="d-sm-flex align-items-center justify-content-between mb-3">
                        <i class="fa-solid fa-cart-shopping mt-3 mr-3" style="color: #02406d;"></i>
                        <h1 class="h3 mr-2 mt-4" style="color: #02406d; font-size: 20px; font-weight: bold;">Pesanan
                        </h1>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>


                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Halo,
                                    <?php echo $email; ?>
                                </span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="profil.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
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

                <div id="venue-membership-cards"></div>

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Daftar Pesanan</h1>
                    </div>

                    <div class="row">

                        <div class="col-lg-6">

                            <!-- Collapsable Card Example -->
                            <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $database = "arenafinder";

                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $database);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }


                            $sql = "SELECT vm.*, v.sport AS venue_sport
                                    FROM venue_membership vm
                                    JOIN venues v ON vm.id_venue = v.id_venue
                                    ORDER BY vm.created_at DESC";


                            // Perform the query
                            $result = $conn->query($sql);

                            // Check if there are any results before generating HTML
                            if ($result->num_rows > 0) {
                                // Initialize $html variable
                                $html = '';

                                // Generate HTML for each venue membership entry
                                while ($row = $result->fetch_assoc()) {
                                    $html .= '
                                        <div class="card shadow mb-4">
                                            <!-- Card Header - Accordion -->
                                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                                <h6 class="m-0 font-weight-bold" style="color: #02406d">Pemesanan Lapangan ' . $row['venue_sport'] . '-Person A</h6>
                                
                                                <!-- Add a dropdown button with increased size -->
                                                <button id="toggleButton' . $row['id_membership'] . '" class="btn btn-info btn-lg dropdown-toggle" type="button" data-toggle="collapse" data-target="#collapseCard' . $row['id_membership'] . '" aria-expanded="false" aria-controls="collapseCard' . $row['id_membership'] . '">
                                                   
                                                </button>
                                            </div>
                                            <!-- Card Content - Collapse -->
                                            <div class="card-body collapse" id="collapseCard' . $row['id_membership'] . '">
                                                <h6>Nama : <strong>' . htmlspecialchars($row['nama']) . '</strong></h6>
                                                <h6>Alamat : <strong>' . htmlspecialchars($row['alamat']) . '</strong></h6>
                                                    <h6>No. Telepon : <strong>' . htmlspecialchars($row['no_telp']) . '</strong></h6>
                                                    <h6>Hari Main : <strong>' . htmlspecialchars($row['hari_main']) . '</strong></h6>
                                                    <h6>Waktu Main : <strong>' . htmlspecialchars($row['waktu_main']) . '</strong></h6>
                                                    <h6>Waktu Pemesanan : <strong>' . htmlspecialchars($row['created_at']) . '</strong></h6>
                                                    <h6>Total Harga : <strong>' . htmlspecialchars($row['harga']) . '</strong></h6>
                                                <!-- Add other details here -->
                                
                                                <div class="d-flex justify-content-end mt-auto">
                                                    <button type="button" class="btn btn-success mr-2">Konfirmasi</button>
                                                    <button type="button" class="btn btn-danger">Batalkan</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <script>
                                            // Add a click event handler to toggle the button class
                                            $("#toggleButton' . $row['id_membership'] . '").on("click", function() {
                                                $(this).toggleClass("btn-info btn-white");
                                            });
                                        </script>';
                                }
                            } else {
                                // Output a message or handle the case when there are no results
                                $html = '<p>No data available.</p>';
                            }

                            // Output the generated HTML
                            echo $html;

                            // Close the connection when you are done
                            $conn->close();
                            ?>

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
                    <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Akhiri aktivitas?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
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

</body>

</html>