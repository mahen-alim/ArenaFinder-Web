<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Masuk</title>
  <link rel="stylesheet" type="text/css" href="/ArenaFinder/css/masuk.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/924b40cfb7.js" crossorigin="anonymous"></script>
</head>

<body>
  <nav class="navbar fixed-top navbar-expand-lg" style="background-color: #02406D;">
    <div class="container-fluid">
      <a class="navbar-brand" style="font-family: 'Kanit', sans-serif; color: white; margin-right: -235px;">Arena</a>
      <a class="navbar-brand" style="font-family: 'Kanit', sans-serif; color: #A1FF9F; margin-left: 235px;">Finder</a>
      <a class="navbar-brand" style="font-family: 'Kanit', sans-serif; color: white; padding-right: 300px;">|</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation"
        style="margin-top: 0px; background-color: white; color-scheme: #02406D;">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="/ArenaFinder/html/beranda.html">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="aktivitas.php">Aktivitas</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/ArenaFinder/html/referensi.html">Referensi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="info_mitra.php">Info Mitra</a>
          </li>
        </ul>
        <a class="daftar-btn" type="button" href="daftar.php"><i class="fa-solid fa-id-card fa-flip"></i>
          Daftar
        </a>
        <a class="masuk-btn" type="button"><i class="fa-solid fa-right-to-bracket"></i>
          Masuk
        </a>
        </form>
      </div>
    </div>
  </nav>

  <form method="POST" action="proses_masuk.php">
    <div class="container">
      <div class="judul">
        <h1 class="daftar">Masuk</h1>
        <h1 class="akun">Akun</h1>
      </div>
      <div class="separator"></div>
      <div class="username">Email
        <input type="email" name="email" autofocus required autocomplete="off"
          style="width: 300px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;flex-direction: column; height: 40px;">
      </div>
      <div class="username">Sandi
        <input type="password" name="password" required autocomplete="off">
      </div>
      <div class="separator2">
        <div class="line-1"></div>
        <div class="line-2"></div>
      </div>
      <div class="google-area">
        <button class="google-button">
          <img src="/ArenaFinder/img_asset/google.png" alt="">
          <a href="<?php echo $url; ?>" style="text-decoration: none; color: #02406D;">Masuk dengan Google</a>
        </button>
      </div>
      <div class="username">
        <button class="tombol-daftar-body">Masuk</button>
      </div>
    </div>
  </form>
</body>

</html>