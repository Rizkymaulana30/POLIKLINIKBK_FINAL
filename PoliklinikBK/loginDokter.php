<?php
    if (!isset($_SESSION)) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nip = $_POST['nip'];
        $password = $_POST['password'];
    
        $query = "SELECT * FROM dokter WHERE nip = '$nip'";
        $result = $mysqli->query($query);
    
        if (!$result) {
            die("Query error: " . $mysqli->error);
        }
    
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['nip'] = $nip;
                $_SESSION['nama'] = $row['nama'];
                header("Location: berandaDokter.php");
            } else {
                $error = "password salah";
            }
        } else {
            $error = "User tidak ditemukan";
        }
    }
?>

<main id="logindokter-page">
    <div class="container" style="margin-top: 10rem;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <!-- <div class="card-header text-center" style="font-weight: bold; font-size: 32px;">Login</div> -->
                    <div class="card-body">
                        <div class="row d-flex justify-content-center align-items-center px-5 py-4">
                            <div class="col lg-6">
                                <img src="images/logindokter.jpg" class="img-fluid" alt="login-pic">
                            </div>
                            <div class="col-lg-6">
                                <h1 class="text-center">Login</h1>
                                <form method="POST" action="index.php?page=loginDokter">
                                    <?php
                                    if (isset($error)) {
                                        echo '<div class="alert alert-danger">' . $error . '
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>';
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label for="nip">NIP Dokter</label>
                                        <input type="text" name="nip" class="form-control" required placeholder="Masukkan NIP">
                                    </div>
                                    <div class="form-group mt-2">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" class="form-control" required placeholder="Masukkan password anda">
                                    </div>
                                    <div class="text-center mt-3">
                                        <button type="submit" class="btn btn-outline-primary px-4 btn-block">Login</button>
                                    </div>
                                </form>
                                <div class="text-center">
                                    <p class="mt-3">Login sebagai admin? <a style="text-decoration: none;" href="index.php?page=loginUser">Ya, Saya Admin</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>