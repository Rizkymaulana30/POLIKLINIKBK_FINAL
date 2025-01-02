<?php
if (!isset($_SESSION)) {
  session_start();
}

include_once("koneksi.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8 ">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>System Poliklinik</title>
  <link rel="stylesheet" href="css/index.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    body {
      background-color: #DEE6F6;
    }

    nav.navbar {
      background-color: #216AF4;
      border-bottom: 1px solid #0056b3;
      box-shadow: 0px 4px 2px -2px rgba(0, 0, 0, 0.1);
    }

    nav.navbar a.navbar-brand,
    nav.navbar button.navbar-toggler {
      color: #fff;
    }

    nav.navbar a.nav-link,
    nav.navbar button.btn-dark {
      color: #fff;
      transition: color 0.3s;
    }

    nav.navbar a.nav-link:hover,
    nav.navbar button.btn-dark:hover {
      color: #ffc107;
    }

    main.container {
      margin-top: 8rem;
    }

    .jumbotron {
      background-color: 	#000080;
      color: #fff;
      padding: 5rem;
      border-radius: 30px;
    }

    .jumbotron h1,
    .jumbotron h2 {
      margin-bottom: 0.5rem;
    }
  </style>
</head>

<body>

  <nav class="navbar fixed-top navbar-expand-lg py-3 navbar-dark">
    <div class="container d-flex align-items-center">
      <a class="navbar-brand" href="#">Poliklinik Mitra Sehat</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <?php
        if (isset($_SESSION['username'])) {
          // Jika pengguna sudah login, tampilkan tombol "Logout"
        ?>
        <ul class="navbar-nav d-flex align-items-lg-center ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item dropdown">
            <button class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              Dokter
            </button>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="index.php?page=dokter">Data Dokter</a></li>
              <li><a class="dropdown-item" href="index.php?page=jadwalDokter">Jadwal Dokter</a></li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=poli">Poli</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=obat">Obat</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=pasien">Pasien</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="Logout.php">Logout (<?php echo $_SESSION['fullname'] ?>)</a>
          </li>
        </ul>
        <?php
        } else {
          // Jika pengguna belum login, tampilkan tombol "Login" dan "Register"
        ?>
        <ul class="navbar-nav d-flex align-items-lg-center ms-auto">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=cekRM">Rawat Jalan</a>
          </li>
        </ul>
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=loginUser">Login</a>
          </li>
        </ul>
        <?php
        }
        ?>
      </div>
    </div>
  </nav>

  <main role="main" class="container">
    <?php
    if (isset($_GET['page'])) {
      include($_GET['page'] . ".php");
    } else {
      echo '<div class="jumbotron">
              <h1 class="display-4">Selamat Datang di Poliklinik,</h1>
              <h2 class="lead">Sehat berulah sakit baru tau rasa ';
      if (isset($_SESSION['username'])) {
        //jika sudah login tampilkan username
        echo '. ' . $_SESSION['fullname'] . '</h2><hr></div>';
      } else {
        echo '</h2><hr><p class="lead">Silakan Login terlebih dahulu .</p></div>';
      }
    }
    ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/71c2ab2c83.js" crossorigin="anonymous"></script>
</body>

</html>
