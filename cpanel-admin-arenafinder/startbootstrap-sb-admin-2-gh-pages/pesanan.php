<?php
use Google\Service\CloudTrace\Span;

session_start();

if (!isset($_SESSION['email'])) {
    // Jika pengguna belum masuk, arahkan mereka kembali ke halaman login
    header("Location: login.php");
    exit();
}

// Pengguna sudah masuk, Anda dapat mengakses data sesi
$email = $_SESSION['email'];
$userName = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Bootstrap JS and Popper.js CDN -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
    <link rel="icon" href="../img_asset/login.png">
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }

        #wrapper {
            overflow-x: hidden;
        }

        #content-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        #content {
            margin-top: 0px;
            z-index: 0;
            flex: 1;

        }

        #accordionSidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            z-index: 1;
            overflow-y: auto;
        }

        .sidebar-brand-text {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 2px -2px gray;
            z-index: 1;
        }

        .navbar-nav {
            margin-top: 0px;
        }

        .nav-item {
            margin-right: 220px;
        }

        .container-fluid {
            width: 150rem;
            margin-top: 100px;
            margin-left: 220px;
        }

        .title-order-con {
            margin-top: 0px;
            margin-left: 222px;
        }

        .topbar {
            background-color: #ffffff;
            position: fixed;
            width: 100%;
            background-color: #ffffff;
            box-shadow: 0 4px 2px -2px gray;
            z-index: 1;

        }

        .navbar-light .navbar-toggler {
            color: #000000;
        }

        .navbar-toggler-icon {
            background-color: #000000;
        }

        .sidebar-brand {
            height: 56px;
        }



        @media (max-width: 768px) {
            #accordionSidebar {
                top: 0;
            }

            .navbar-nav {
                margin-top: 0;
            }

            .sidebar-brand {
                height: auto;
            }

            #content {
                margin-top: 0px;
                z-index: 0;
                flex: 1;
            }

            .title-order-con {
                margin-top: 0px;
                margin-left: 100px;
            }

            .nav-item {
                margin-right: 100px;
            }

            .container-fluid {
                width: 610px;
                margin-top: 100px;
                margin-left: 100px;
            }

        }
    </style>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
                <!-- Sidebar -->
                <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
                    style="background-color: #02406d;">

                    <!-- Sidebar - Brand -->
                    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                        <div class="sidebar-brand-icon">
                            <i class="fa-solid fa-circle-user mx-3 ml-auto"></i>
                        </div>
                        <div class="sidebar-brand-text" style="text-transform: none; font-weight: 500; font-size: 20px">
                            Arena
                        </div>
                        <div class="sidebar-brand-text"
                            style="color: #a1ff9f; text-transform: none; font-weight: 500; font-size: 20px">Finder <span
                                style="color: white;">|</span></div>
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
                        <a class="nav-link" href="../index.php">
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
                                <span class="badge badge-counter"
                                    style="background-color: #a1ff9f; color: #02406d; font-size: 15px;"
                                    id="pesanan-link"></span>
                            </i>
                            <span>Pesanan
                                <?php $_SESSION['id_venue'] ?>
                            </span>
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
                                        console.log("Response from check_data.php:", this.responseText); // Log the response
                                        document.getElementById("pesanan-link").innerHTML = this.responseText;
                                    }
                                };
                                xhttp.open("GET", "check_badge.php", true);
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

                    <!-- Include jQuery -->
                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                    <!-- Your jQuery script for handling sidebar toggle -->
                    <script>
                        $(document).ready(function () {
                            $("#sidebarToggle").on("click", function () {
                                // Toggle the "toggled" class on the topbar
                                $(".topbar").toggleClass("toggled");
                                $(".container-fluid").toggleClass("toggled");
                                $("#userDropdown").toggleClass("toggled");

                                // Check if the sidebar is currently toggled
                                if ($("#accordionSidebar").hasClass("toggled")) {
                                    // If sidebar is toggled, adjust the topbar width accordingly
                                    $(".topbar").css("margin-left", "-120px");
                                    $(".container-fluid").css("margin-left", "100px");
                                    $(".container-fluid").css("width", "165rem");
                                    $("#userDropdown").css("margin-left", "928.5px");
                                } else {
                                    // If sidebar is not toggled, set the topbar width to 100%
                                    $(".topbar").css("margin-left", "0");
                                    $(".container-fluid").css("margin-left", "220px");
                                    $(".container-fluid").css("width", "150rem");
                                    $("#userDropdown").css("margin-left", "0");
                                }
                            });
                        });
                    </script>

                </ul>
                <!-- End of Sidebar -->

                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <div id="content">

                        <!-- Topbar -->
                        <div class="title-order-con">
                            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                                <!-- Sidebar Toggle (Topbar) -->

                                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                                    <i class="fa fa-bars"></i>
                                </button>


                                <!-- Include jQuery -->
                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                                <!-- Your jQuery script for handling sidebar toggle -->
                                <script>
                                    $(document).ready(function () {
                                        $("#sidebarToggleTop").on("click", function () {
                                            // Toggle the "toggled" class on the topbar
                                            $(".topbar").toggleClass("toggled");
                                            $(".container-fluid").toggleClass("toggled");
                                            $("#img-profile").toggleClass("toggled");

                                            // Check if the sidebar is currently toggled
                                            if ($("#accordionSidebar").hasClass("toggled")) {
                                                // If sidebar is toggled, adjust the topbar width accordingly
                                                $(".topbar").css("margin-left", "-100px");
                                                $(".container-fluid").css("margin-left", "0px");
                                                $(".container-fluid").css("width", "100%");
                                                $("#img-profile").css("margin-left", "448px");
                                            } else {
                                                // If sidebar is not toggled, set the topbar width to 100%
                                                $(".topbar").css("margin-left", "0");
                                                $(".container-fluid").css("margin-left", "100px");
                                                $(".container-fluid").css("width", "86%");
                                                $("#img-profile").css("margin-left", "0");
                                            }
                                        });
                                    });
                                </script>


                                <div class="d-sm-flex align-items-center justify-content-between mb-3">
                                    <i class="fa-solid fa-cart-shopping mt-3 mr-3" style="color: #02406d;"></i>
                                    <h1 class="h3 mr-2 mt-4"
                                        style="color: #02406d; font-size: 20px; font-weight: bold;">
                                        Pesanan
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
                                        <a class="nav-link dropdown-toggle custom-dropdown-toggle" href="#"
                                            id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            <span class="mr-2 d-none d-lg-inline text-gray-600 small" id="text-profil">
                                                Halo,
                                                <?php echo $userName; ?>
                                            </span>
                                            <img class="img-profile rounded-circle fixed-width-image" id="img-profile"
                                                src="img/undraw_profile.svg">
                                        </a>
                                        <!-- Dropdown - User Information -->
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                            aria-labelledby="userDropdown">
                                            <a class="dropdown-item" href="profil.php">
                                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Profile
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#logoutModal">
                                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                                Logout
                                            </a>
                                        </div>
                                    </li>

                                </ul>

                            </nav>
                            <!-- End of Topbar -->
                        </div>

                        <div id="venue-membership-cards"></div>

                        <!-- Begin Page Content -->
                        <div class="container-fluid">

                            <div class="row">
                                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                                <div class="col-lg-6">

                                    <!-- Collapsable Card Example -->
                                    <?php
                                    include('database.php');

                                    // $sql = "SELECT vm.*, v.sport AS venue_sport
                                    // FROM venue_membership vm
                                    // JOIN venues v ON vm.id_venue = v.id_venue
                                    // ORDER BY vm.created_at DESC";
                                    
                                    $id_venue = $_SESSION['id_venue'];
                                    $sql = "SELECT v.id_booking AS id_membership, v.total_price as harga, v.created_at, 
                                    u.full_name as nama, u.no_hp, u.alamat, u.email,
                                    CONCAT(p.start_hour, ' - ',  p.end_hour) AS waktu_main, DAYNAME(p.date) AS hari_main 
                                    FROM venue_booking AS v
                                    JOIN users AS u 
                                    ON u.email = v.email
                                    JOIN venue_booking_detail AS vb 
                                    ON v.id_booking = vb.id_booking 
                                    JOIN venue_price AS p  
                                    ON p.id_price = vb.id_price 
                                    WHERE v.id_venue = $id_venue 
                                    AND v.payment_status = 'Pending' 
                                    GROUP BY v.id_booking 
                                    ORDER BY v.created_at DESC";

                                    // Perform the query
                                    $result = $conn->query($sql);

                                    // $data = $result->fetch_assoc();
                                    
                                    // Check if there are any results before generating HTML
                                    if ($result->num_rows > 0) {
                                        // Initialize $html variable
                                        $html = '';

                                        // Generate HTML for each venue membership entry
                                        while ($row = $result->fetch_assoc()) {
                                            $html .= '
                                        <div class="card shadow mb-4" id="cardContainer' . $row['id_membership'] . '">
                                            <!-- Card Header - Accordion -->
                                            <div class="card-header py-1 d-flex justify-content-between align-items-center" style="background-color: #02406d">
                                                <h6 class="m-0 font-weight-bold" style="color: white;">Pemesanan Lapangan ' . $row['venue_sport'] . '<span style="color: #a1ff9f;"> - ' . $row['nama'] . '</span></h6>
                                
                                                <!-- Add a dropdown button with increased size -->
                                                <button id="toggleButton' . $row['id_membership'] . '" class="btn btn-lg dropdown-toggle py-1" style="color: white; border: 1px solid white; font-size: 15px;"type="button" data-toggle="collapse" data-target="#collapseCard' . $row['id_membership'] . '" aria-expanded="false" aria-controls="collapseCard' . $row['id_membership'] . '">
                                                   
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
                                                <button type="button" class="btn btn-success mr-2 confirm-button" data-membership-id="' . $row["id_membership"] . '">Konfirmasi</button>
                                                <button type="button" class="btn btn-danger cancel-button" data-membership-id="' . $row["id_membership"] . '">Batalkan</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <script>
                                            // Add a click event handler to toggle the button class
                                            $("#toggleButton' . $row['id_membership'] . '").on("click", function() {
                                                $(this).toggleClass("btn btn-white");
                                            
                                                if ($(this).hasClass("btn")) {
                                                    $(this).css("background-color", "#02406d");
                                                    $(this).css("color", "white");
                                                } else {
                                                    
                                                    $(this).css("background-color", "white");
                                                    $(this).css("color", "#02406d");
                                                }
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

                                <script>
                                    // Variable to track whether confirmation has been received
                                    var confirmationReceived = false;

                                    // Event handler for Confirm button
                                    $(".confirm-button").on("click", function () {
                                        var membershipId = $(this).data("membership-id");

                                        // Check if confirmation has been received
                                        if (!confirmationReceived) {
                                            // Ask for confirmation only once
                                            var confirmMessage = "Apakah Anda yakin akan mengkonfirmasi pesanan ini?";
                                            if (confirm(confirmMessage)) {
                                                // Set confirmationReceived to true to prevent further confirmations
                                                confirmationReceived = true;

                                                // Make an AJAX request to delete_membership.php with the membershipId
                                                $.ajax({
                                                    type: "POST",
                                                    url: "confirm_booking.php",
                                                    data: { membershipId: membershipId, action: "confirm" },
                                                    success: function (response) {
                                                        // Handle success (if needed)
                                                        console.log(response);
                                                        // Remove the card from the DOM or update UI as necessary
                                                        $(this).closest(".card").remove();
                                                        // Update the badge count
                                                        updateBadge(response.count);
                                                        // Redirect to check_data.php
                                                        window.location.href = "confirm_booking.php?membershipId=" + membershipId;
                                                    },
                                                    error: function (error) {
                                                        // Handle error (if needed)
                                                        console.error(error);
                                                    }
                                                });
                                            }
                                        }
                                    });

                                    // Event handler for Cancel button
                                    $(".cancel-button").on("click", function () {
                                        var membershipId = $(this).data("membership-id");

                                        // Check if confirmation has been received
                                        if (!confirmationReceived) {
                                            // Ask for confirmation only once
                                            var confirmMessage = "Apakah Anda yakin akan membatalkan pesanan ini?";
                                            if (confirm(confirmMessage)) {
                                                // Set confirmationReceived to true to prevent further confirmations
                                                confirmationReceived = true;

                                                // Make an AJAX request to delete_membership.php with the membershipId
                                                $.ajax({
                                                    type: "POST",
                                                    url: "check_data.php",
                                                    data: { membershipId: membershipId, action: "cancel" },
                                                    success: function (response) {
                                                        // Handle success (if needed)
                                                        console.log(response);
                                                        // Remove the card from the DOM or update UI as necessary
                                                        $(this).closest(".card").remove();
                                                        // Update the badge count
                                                        updateBadge(response.count);
                                                        // Redirect to check_data.php
                                                        window.location.href = "check_data.php?membershipId=" + membershipId;
                                                    },
                                                    error: function (error) {
                                                        // Handle error (if needed)
                                                        console.error(error);
                                                    }
                                                });
                                            }
                                        }
                                    });

                                    function updateBadge(count) {
                                        // Update the badge count in the DOM
                                        $("#pesanan-link").text(count);
                                    }



                                </script>
                            </div>

                        </div>
                        <!-- /.container-fluid -->

                    </div>
                    <!-- End of Main Content -->

                    <!-- Footer -->
                    <footer class="sticky-footer bg-white">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">
                                <span>Copyright &copy; ArenaFinder 2023</span>
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