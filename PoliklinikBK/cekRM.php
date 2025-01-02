<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $no_rm = $_POST['no_rm'];

        $query = "SELECT * FROM pasien WHERE no_rm = '$no_rm'";
        $result = $mysqli->query($query);

        if (!$result) {
            die("Query error: " . $mysqli->error);
        }

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION['nama'] = $nama;
            $_SESSION['id_pasien'] = $row['id'];
            header("Location: index.php?page=rawatJalan&no_rm=$no_rm");
        } else {
            $error = "No. Rekam Medis tidak ditemukan";
        }
    }
?>

<main id="cekrm-page">
    <div class="container" style="margin-top: 5.5rem;">
        <div class="row justify-content-center">
            <h2 class="text-center mb-4">Pendaftaran Rawat Jalan</h2>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center fw-bold" style="font-size: 1.5rem;">MASUKKAN DATA ANDA</div>
                    <div class="card-body my-4">
                        <form method="POST" action="index.php?page=cekRM" class="ms-4">
                            <?php
                            if (isset($error)) {
                                echo '
                                    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                                        <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </symbol>
                                    </svg>
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" style="width: 20; height: 20;" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                        <div>
                                            ' . $error . '
                                        </div>
                                    </div>
                                ';
                            }
                            ?>
                            <div class="form-group">
                                <label for="no_rm">Nomor Rekam Medis (RM)</label>
                                <input type="text" name="no_rm" class="form-control" required placeholder="Masukkan no_rm anda">
                            </div>
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-outline-primary px-4 btn-block">Cari</button>
                            </div>
                        </form>
                        <div class="text-center">
                            <p class="mt-3">Belum terdaftar? <a href="index.php?page=registerPasien" style="text-decoration: none;">Menjadi pasien baru</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>