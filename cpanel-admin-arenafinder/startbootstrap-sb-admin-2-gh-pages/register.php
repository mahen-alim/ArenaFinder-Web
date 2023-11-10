<?php session_start(); ?>
<?php
include('database.php');

if (isset($_POST["register"])) {
  $username = $_POST["username"];
  $email = $_POST["email"];
  $password = $_POST["password"];
  $level = $_POST["level"];

  $check_query = mysqli_query($conn, "SELECT * FROM users where email ='$email'");
  $rowCount = mysqli_num_rows($check_query);

  if ($rowCount > 0) {
    ?>
    <script>
      alert("Pengguna dengan email ini sudah terdaftar!");
    </script>
    <?php
  } else {
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $result = mysqli_query($conn, "INSERT INTO users (username, email, password, is_verified, level) VALUES ('$username', '$email', '$password_hash', 0, '$level')");

    if ($result) {
      $otp = rand(100000, 999999);
      $_SESSION['otp'] = $otp;
      $_SESSION['mail'] = $email;
      require "Mail/phpmailer/PHPMailerAutoload.php";
      $mail = new PHPMailer;

      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 587;
      $mail->SMTPAuth = true;
      $mail->SMTPSecure = 'tls';

      $mail->Username = 'mahennekkers27@gmail.com';
      $mail->Password = 'fxqa zwoq vuji mhlk';

      $mail->setFrom('arenafinder.app@gmail.com', 'OTP Verification');
      $mail->addAddress($_POST["email"]);

      $mail->isHTML(true);
      $mail->Subject = "Kode verifikasi akun anda";
      $mail->Body = "<p>Kepada admin, </p> <h3>Kode OTP anda adalah $otp <br></h3>
                    <br><br>
                    <p>Berikan pesan anda lewat email ini,</p>
                    <b>arenafinder.app@gmail.com</b>";

      if (!$mail->send()) {
        ?>
        <script>
          alert("<?php echo "Daftar akun gagal, email tidak valid" ?>");
        </script>
        <?php
      } else {
        ?>
        <script>
          alert("<?php echo "Daftar akun sukses, kode OTP dikirim ke " . $email ?>");
          window.location.replace('verification.php');
        </script>
        <?php
      }
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Register</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <style>
    #btn-login {
      background-color: #e7f5ff;
      color: #02406d;
    }

    #btn-login:hover {
      background-color: #02406d;
      color: #e7f5ff;
      border: 1px solid #e7f5ff;
    }

    #card-email {
      background-color: white;
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
                    <h1 class="h2 text-gray-900 mb-2 ">Daftar Akun</h1>
                    <img src="/ArenaFinder/img_asset/login.png" alt=""
                      style="width: 200px; height: auto; margin-bottom: 20px" />
                  </div>
                  <form class="user" method="POST" action="#" autocomplete="off" name="register">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" id="exampleFirstName"
                        placeholder="Masukkan Nama Pengguna" name="username" autofocus>
                    </div>
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="email-input" name="email"
                        aria-describedby="emailHelp" placeholder="Masukkan Alamat Email" />
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword"
                        placeholder="Masukkan Sandi" name="password" />
                      <input type="hidden" name="level" value="ADMIN" id="level" />
                    </div>
                    <div class="form-group">
                      <button class="btn btn-user btn-block" id="btn-login" name="register">Daftar</button>
                    </div>

                  </form>
                  <hr />
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