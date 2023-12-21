<?php
session_start();
include('database.php');

if (isset($_POST["login"])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $level = $_POST['level'];

  // Validation: Check if email and password are not empty
  if (empty($email) && empty($password)) {
    ?>
        <script>
          alert("Mohon isi email dan sandi.");
          window.location.replace('login.php');
        </script>
        <?php
        exit();
  } elseif (empty($email)) {
    ?>
        <script>
          alert("Mohon isi email.");
          window.location.replace('login.php');
        </script>
        <?php
        exit();
  } elseif (empty($password)) {
    ?>
        <script>
          alert("Mohon isi sandi.");
          window.location.replace('login.php');
        </script>
        <?php
        exit();
  }

  // Fetch user data and venue data based on the email
  $sql = mysqli_query($conn,
    "SELECT u.*, 
      IFNULL(v.id_venue, 0) AS id_venue, 
      v.venue_name AS nama_venue, 
      v.sport AS sport
      FROM users AS u 
      LEFT JOIN venues AS v 
      ON u.email = v.email 
      WHERE u.email = '$email' 
      LIMIT 1"
  );

  $count = mysqli_num_rows($sql);

  if ($count > 0) {
    $fetch = mysqli_fetch_assoc($sql);
    $hashpassword = $fetch["password"];

    // Get user level and other details
    $userLevel = $fetch["level"];
    $userName = $fetch["username"];
    $sportFromDB = $fetch["sport"];

    $_SESSION['level'] = $userLevel; // Set session with user level

    if ($fetch["is_verified"] == 0) {
      $_SESSION['message'] = "Tolong Verifikasi Akun Email sebelum Login.";
      header("Location: login.php");
      exit();
    } elseif (password_verify($password, $hashpassword)) {
      $_SESSION['email'] = $email; // Save email in session
      $_SESSION['level'] = $userLevel;
      $_SESSION['id_venue'] = $fetch['id_venue'];
      $_SESSION['nama_venue'] = $fetch['nama_venue'];
      $_SESSION['username'] = $userName;
      $_SESSION['sport'] = $sportFromDB; // Save sport in session
      header("Location: index.php");
      exit();
    } else {
      ?>
            <script>
              alert("<?php echo "Password Salah, Mohon Coba Lagi." ?>");
              window.location.replace('login.php');
            </script>
            <?php
            exit();
    }
  } else {
    // Email not registered
    ?>
        <script>
          alert("<?php echo "Email belum terdaftar. Silakan daftar terlebih dahulu." ?>");
          window.location.replace('register.php'); // Change 'register.php' to your registration page
        </script>
        <?php
        exit();
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>ArenaFinder - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet" />
  <link rel="icon" href="../img_asset/login.png">

  <style>
    body {
      font-family: "Kanit", sans-serif;
    }

    #btn-login {
      background-color: #e7f5ff;
      color: #02406d;
    }

    #btn-login:hover {
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
                    <h1 class="h2 text-gray-900 mb-2 ">Masuk Akun</h1>
                    <img src="../img_asset/login.png" alt="" style="width: 200px; height: auto; margin-bottom: 20px" />
                  </div>

                  <form class="user" method="POST" action="#" autocomplete="off" name="login">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="email-input" name="email"
                        aria-describedby="emailHelp" placeholder="Enter Email Address..." autocomplete="off"
                        autofocus />
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputEmail"
                        placeholder="Password" name="password" autocomplete="off" />

                      <input type="hidden" name="level" value="<?php echo $levelValue; ?>" id="level" />
                    </div>
                    <div class="form-group">
                      <button class="btn btn-user btn-block" id="btn-login" name="login">Masuk</button>
                    </div>
                  </form>

                  <hr />
                  <div class="text-center">
                    <a class="small" href="forgot-password.php">Lupa Sandi?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="register.php">Buat Akun Anda!</a>
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

  <!-- JavaScript (tambahkan sebelum tag </body>) -->
  <script>
    document.getElementById('show-hide-password').addEventListener('click', function () {
      var passwordInput = document.getElementById('exampleInputPassword');
      var passwordFieldType = passwordInput.getAttribute('type');

      if (passwordFieldType === 'password') {
        passwordInput.setAttribute('type', 'text');
      } else {
        passwordInput.setAttribute('type', 'password');
      }
    });
  </script>
</body>

</html>