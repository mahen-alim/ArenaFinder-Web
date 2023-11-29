<?php
session_start();
include('database.php');

?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Reset Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <style>
        body {
            font-family: "Kanit", sans-serif;
        }

        #btn-reset {
            background-color: #e7f5ff;
            color: #02406d;
        }

        #btn-reset:hover {
            background-color: #02406d;
            color: #e7f5ff;
            border: 1px solid #e7f5ff;
        }

        .small {
            color: #02406d;
        }

        .small:hover {
            color: #02406d;
            text-decoration: underline;
        }

        .message {
            background-color: #ffdddd;
            color: #8b0000;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>

</head>

<body class="bg-gradient" style="background-color: #e7f5ff">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-5 ">
                <div class="card o-hidden border-0 shadow-lg my-4" style="height: 700px;">
                    <div class="card-body p-10" id="card-email">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-10 mx-auto p-2">
                                <div class="p-3">
                                    <div class="text-center">
                                        <h1 class="h2 text-gray-900 mb-2 ">Ganti Sandi</h1>
                                        <p class="mb-4">Silahkan masukkan sandi akun Anda yang baru!</p>
                                        <?php
                                        if (isset($_GET['token'])) {
                                            $tokenWithExpiration = $_GET['token'];

                                            // Pisahkan token dan waktu kedaluwarsa
                                            list($token, $expirationTime) = explode('.', $tokenWithExpiration);

                                            // Verifikasi jika token belum kedaluwarsa
                                            if ($expirationTime >= time()) {
                                                // Jika token benar, proses pergantian sandi
                                        
                                                if (isset($_POST["reset"])) {
                                                    include('database.php');
                                                    $psw = $_POST["password"];

                                                    // Verifikasi token lagi (untuk menghindari pemalsuan)
                                                    if ($_SESSION['token'] === $tokenWithExpiration) {
                                                        $Email = $_SESSION['email'];

                                                        // Periksa apakah sandi kosong
                                                        if (empty($psw)) {
                                                            ?>
                                                            <script>
                                                                alert("Password tidak boleh kosong. Silahkan masukkan sandi lagi.");
                                                            </script>
                                                            <?php
                                                        } elseif (!isValidPassword($psw)) {
                                                            ?>
                                                            <script>
                                                                alert("Password harus memiliki 8 sampai 12 karakter, mengandung angka, huruf besar, huruf kecil, dan karakter khusus");
                                                            </script>
                                                            <?php
                                                        } else {
                                                            // Ambil sandi yang ada dari database
                                                            $existingPasswordQuery = mysqli_query($conn, "SELECT password FROM users WHERE email='$Email'");
                                                            $existingPasswordData = mysqli_fetch_assoc($existingPasswordQuery);
                                                            $existingPassword = $existingPasswordData['password'];

                                                            // Periksa apakah sandi baru sama dengan yang sudah ada
                                                            if (password_verify($psw, $existingPassword)) {
                                                                ?>
                                                                <script>
                                                                    alert("Password baru harus berbeda dengan password yang sudah ada sebelumnya.");
                                                                </script>
                                                                <?php
                                                            } else {
                                                                // Perbarui sandi jika berbeda
                                                                $hash = password_hash($psw, PASSWORD_DEFAULT);
                                                                mysqli_query($conn, "UPDATE users SET password='$hash' WHERE email='$Email'");
                                                                ?>
                                                                <script>
                                                                    window.location.replace("login.php");
                                                                    alert("Selamat, sandi akun anda berhasil diganti");
                                                                </script>
                                                                <?php
                                                            }
                                                        }
                                                    } else {
                                                        // Verifikasi token gagal
                                                        echo "Verifikasi token gagal.";
                                                    }
                                                }

                                            } else {
                                                // Tautan sudah kedaluwarsa, redirect ke halaman pemulihan sandi
                                                ?>
                                                <script>
                                                    window.location.replace("forgot-password.php");
                                                </script>
                                                <?php
                                                $message = "Link pergantian sandi telah kadaluwarsa, coba kirim ulang.";
                                            }
                                        } else {
                                            echo "Invalid request.";
                                            // Anda mungkin ingin melakukan redirect atau menampilkan pesan yang sesuai
                                        }

                                        // Fungsi untuk memeriksa kompleksitas sandi
                                        function isValidPassword($password)
                                        {
                                            // Sandi sekurang-kurangnya harus mengandung 8 karakter, huruf besar, huruf kecil, dan karakter khusus
                                            $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,12}$/";
                                            return preg_match($pattern, $password);
                                        }
                                        ?>
                                        <?php if (isset($message)): ?>
                                            <div class="message">
                                                <?php echo $message; ?>
                                            </div>
                                        <?php endif; ?>

                                        <img src="/ArenaFinder/img_asset/login.png" alt=""
                                            style="width: 200px; height: auto; margin-bottom: 20px" />
                                    </div>


                                    <form class="user" method="POST" action="#" autocomplete="off" name="login">
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputEmail" placeholder="Sandi Baru" name="password">
                                        </div>
                                        <input class="btn btn-primary btn-user btn-block" type="submit"
                                            value="Ganti Sandi" name="reset" id="btn-reset">
                                    </form>

                                    <hr />
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.php">Lupa Sandi?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.php">Buat Akun Anda!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.php">Sudah Memiliki Akun? Masuk Sekarang!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

<script>
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    toggle.addEventListener('click', function () {
        if (password.type === "password") {
            password.type = 'text';
        } else {
            password.type = 'password';
        }
        this.classList.toggle('bi-eye');
    });
</script>