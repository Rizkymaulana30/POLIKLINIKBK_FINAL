<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['username'])) {
    header("Location: index.php?page=loginUser");
    exit;
}

if (isset($_POST['simpanData'])) {
    $nama_poli = $_POST['nama_poli'];
    $keterangan = $_POST['keterangan'];
    
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE poli SET nama_poli='$nama_poli', keterangan='$keterangan' WHERE id='$id'";
        $edit = mysqli_query($mysqli, $sql);

        echo "
            <script> 
                alert('Berhasil mengubah data.');
                document.location='index.php?page=poli';
            </script>
        ";
    } else {
        $sql = "INSERT INTO poli (nama_poli, keterangan) VALUES ('$nama_poli', '$keterangan')";
        $tambah = mysqli_query($mysqli, $sql);

        echo "
            <script> 
                alert('Berhasil menambah data.');
                document.location='index.php?page=poli';
            </script>
        ";
    }
}

if (isset($_GET['aksi'])) {
    if ($_GET['aksi'] == 'hapus') {
        $hapus = mysqli_query($mysqli, "DELETE FROM poli WHERE id = '" . $_GET['id'] . "'");

        if ($hapus) {
            echo "
                <script> 
                    alert('Berhasil menghapus data.');
                    document.location='index.php?page=poli';
                </script>
            ";
        } else {
            echo "
                <script> 
                    alert('Gagal menghapus data: " . mysqli_error($mysqli) . "');
                    document.location='index.php?page=poli';
                </script>
            ";
        }
    }
}
?>
<main id="obat-page">
    <div class="container" style="margin-top: 5.5rem;">
    <div class="row">
            <h2 class="ps-0">Halaman Poli</h2>
            <div class="container">
                <form action="" method="POST" onsubmit="return(validate());">
                    <?php
                    $nama_poli = '';
                    $keterangan = '';
                    if (isset($_GET['id'])) {
                        $get = mysqli_query($mysqli, "SELECT * FROM poli 
                                WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($get)) {
                            $nama_poli = $row['nama_poli'];
                            $keterangan = $row['keterangan'];
                        }
                    ?>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <?php
                    }
                    ?>
                    <div class="mb-3 w-25">
                        <label for="nama_poli">Nama Poli <span class="text-danger">*</span></label>
                        <input type="text" name="nama_poli" class="form-control" required placeholder="Masukkan nama poli" value="<?php echo $nama_poli ?>">
                    </div>
                    <div class="mb-3 w-25">
                        <label for="keterangan">Keterangan <span class="text-danger">*</span></label>
                        <textarea name="keterangan" class="form-control" required placeholder="Masukkan keterangan"><?php echo $keterangan ?></textarea>
                    </div>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="submit" name="simpanData" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive mt-3 px-0">
                <table class="table text-center">
                    <thead class="table-primary">
                        <tr>
                            <th valign="middle">No</th>
                            <th valign="middle">Nama Poli</th>
                            <th valign="middle">Keterangan</th>
                            <th valign="middle" style="width: 0.5%;" colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $result = mysqli_query($mysqli, "SELECT * FROM poli");
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) :
                            ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data['nama_poli'] ?></td>
                                    <td><?php echo $data['keterangan'] ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-warning text-white" href="index.php?page=poli&id=<?php echo $data['id'] ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="index.php?page=poli&id=<?php echo $data['id'] ?>&aksi=hapus" class="btn btn-sm btn-danger text-white">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>