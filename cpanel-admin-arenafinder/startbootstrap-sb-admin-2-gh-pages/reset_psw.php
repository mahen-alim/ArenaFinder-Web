<?php

session_start();
include('database.php');

?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

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

                                            // Separate the token and expiration time
                                            list($token, $expirationTime) = explode('.', $tokenWithExpiration);

                                            // Verify if the token is not expired
                                            if ($expirationTime >= time()) {
                                                // Token is valid; process the password reset
                                                // ...
                                        
                                                if (isset($_POST["reset"])) {
                                                    include('database.php');
                                                    $psw = $_POST["password"];

                                                    // Verify the token again (in case it was tampered with)
                                                    if ($_SESSION['token'] === $tokenWithExpiration) {
                                                        $Email = $_SESSION['email'];

                                                        $hash = password_hash($psw, PASSWORD_DEFAULT);

                                                        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email='$Email'");
                                                        $query = mysqli_num_rows($sql);
                                                        $fetch = mysqli_fetch_assoc($sql);

                                                        if ($Email) {
                                                            $new_pass = $hash;
                                                            mysqli_query($conn, "UPDATE users SET password='$new_pass' WHERE email='$Email'");
                                                            ?>
                                                            <script>
                                                                window.location.replace("login.php");
                                                                alert("<?php echo "Selamat, sandi akun anda berhasil diganti" ?>");
                                                            </script>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <script>
                                                                alert("<?php echo "Coba lagi" ?>");
                                                            </script>
                                                            <?php
                                                        }
                                                    } else {
                                                        // Token verification failed
                                                        echo "Token verification failed.";
                                                    }
                                                }

                                            } else {
                                                // Link is expired, redirect to password recovery page
                                                ?>
                                                <script>
                                                    window.location.replace("forgot-password.php");
                                                </script>
                                                <?php
                                                $message = "Link pergantian sandi telah kadaluwarsa, coba kirim ulang.";
                                            }
                                        } else {
                                            echo "Invalid request.";
                                            // You may want to redirect or display an appropriate message
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