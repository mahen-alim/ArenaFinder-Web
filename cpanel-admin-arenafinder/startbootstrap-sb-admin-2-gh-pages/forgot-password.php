<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Forgot Password</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Lupa Sandi?</h1>
                                        <p class="mb-4">Kami punya solusinya. Anda tinggal memasukkan email dan kita
                                            akan kirimkan sebuah link ke email anda untuk merubah sandi!</p>
                                    </div>
                                    <form class="user" action="#" method="POST" name="recover_psw">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" placeholder="Alamat Email" name="email">
                                        </div>
                                        <input class="btn btn-primary btn-user btn-block" type="submit"
                                            value="Ganti Sandi" name="recover">

                                    </form>
                                    <hr>
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

<?php
if (isset($_POST["recover"])) {
    include('database.php');
    $email = $_POST["email"];

    $sql = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $query = mysqli_num_rows($sql);
    $fetch = mysqli_fetch_assoc($sql);

    if (mysqli_num_rows($sql) <= 0) {
        ?>
        <script>
            alert("<?php echo "Maaf, email tidak tersedia " ?>");
        </script>
        <?php
    } else if ($fetch["is_verified"] == 0) {
        ?>
            <script>
                alert("Maaf, akun anda harus diverifikasi terlebih dahulu sebelum mengganti sandi!");
                window.location.replace("index.html");
            </script>
        <?php
    } else {
        // generate token by binaryhexa 
        $token = bin2hex(random_bytes(50));

        //session_start ();
        $_SESSION['token'] = $token;
        $_SESSION['email'] = $email;

        require "Mail/phpmailer/PHPMailerAutoload.php";
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';

        // h-hotel account
        $mail->Username = 'mahennekkers27@gmail.com';
        $mail->Password = 'fxqa zwoq vuji mhlk';

        // send by h-hotel email
        $mail->setFrom('arenafinder.app@gmail.com', 'Password Reset');
        // get email from input
        $mail->addAddress($_POST["email"]);
        //$mail->addReplyTo('lamkaizhe16@gmail.com');

        // HTML body
        $mail->isHTML(true);
        $mail->Subject = "Ganti sandi akun";
        $mail->Body = "<b>Kepada Admin</b>
                        <h3>Kami menanggapi permintaan pergantian sandi akun anda.</h3>
                        <p>Dibawah ini adalah link untuk menuju ke halaman pergantian sandi, klik link untuk berpindah halaman!</p>
                        http://localhost/ArenaFinder/cpanel-admin-arenafinder/startbootstrap-sb-admin-2-gh-pages/reset_psw.php
                        <br><br>
                        <p>Berikan pesan anda lewat email ini,</p>
                        <b>arenafinder.app@gmail.com</b>";

        if (!$mail->send()) {
            ?>
                <script>
                    alert("<?php echo "Email salah" ?>");
                </script>
            <?php
        } else {
            ?>
                <script>
                    window.location.replace("notification.html");
                </script>
            <?php
        }
    }
}


?>