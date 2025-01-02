<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['username'])) {
        // Jika pengguna sudah login, tampilkan tombol "Logout"
        header("Location: index.php?page=loginUser");
        exit;
    }

    if (isset($_POST['simpanData'])) {
        $id_dokter = $_POST['id_dokter'];
        $hari = $_POST['hari'];
        $jam_mulai = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];
        $statues = $_POST['statues'];
    
        // If the new status is 'Active', set all other statuses to 'Inactive'
        if ($statues == 1) {
            $stmt = $mysqli->prepare("UPDATE jadwal_periksa SET statues=0 WHERE id_dokter=?");
            $stmt->bind_param("i", $id_dokter);
            $stmt->execute();
            $stmt->close();
        }
    
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $stmt = $mysqli->prepare("UPDATE jadwal_periksa SET id_dokter=?, hari=?, jam_mulai=?, jam_selesai=?, statues=? WHERE id=?");
            $stmt->bind_param("issssi", $id_dokter, $hari, $jam_mulai, $jam_selesai, $statues, $id);
    
            if ($stmt->execute()) {
                echo "
                    <script> 
                        alert('Berhasil mengubah data.');
                        document.location='index.php?page=jadwalDokter';
                    </script>
                ";
            } else {
                // Handle error
            }
    
            $stmt->close();
        } else {
            $stmt = $mysqli->prepare("INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai, statues) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isssi", $id_dokter, $hari, $jam_mulai, $jam_selesai, $statues);
    
            if ($stmt->execute()) {
                echo "
                    <script> 
                        alert('Berhasil menambah data.');
                        document.location='index.php?page=jadwalDokter';
                    </script>
                ";
            } else {
                // Handle error
            }
    
            $stmt->close();
        }
    }

    if (isset($_GET['aksi'])) {
        if ($_GET['aksi'] == 'hapus') {
            $id = $_GET['id'];
    
            // Delete the record from the jadwal_periksa table
            $stmt = $mysqli->prepare("DELETE FROM jadwal_periksa WHERE id = ?");
            $stmt->bind_param("i", $id);
    
            if ($stmt->execute()) {
                // Check if there are any jadwal_periksa records that reference the dokter
                $result = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa WHERE id_dokter = '$id_dokter'");
                if (mysqli_num_rows($result) == 0) {
                    // If there are no jadwal_periksa records that reference the dokter, delete the dokter
                    $stmt = $mysqli->prepare("DELETE FROM dokter WHERE id = ?");
                    $stmt->bind_param("i", $id_dokter);
    
                    if ($stmt->execute()) {
                        echo "
                            <script> 
                                alert('Berhasil menghapus data.');
                                document.location='index.php?page=jadwalDokter';
                            </script>
                        ";
                    } else {
                        echo "
                            <script> 
                                alert('Gagal menghapus data: " . mysqli_error($mysqli) . "');
                                document.location='index.php?page=jadwalDokter';
                            </script>
                        ";
                    }
                } else {
                    echo "
                        <script> 
                            alert('Gagal menghapus data: Dokter masih memiliki jadwal periksa.');
                            document.location='index.php?page=jadwalDokter';
                        </script>
                    ";
                }
            } else {
                echo "
                    <script> 
                        alert('Gagal menghapus data: " . mysqli_error($mysqli) . "');
                        document.location='index.php?page=jadwalDokter';
                    </script>
                ";
            }
    
            $stmt->close();
        }
    }
?>
<main id="jadwaldokter-page">
    <div class="container" style="margin-top: 5.5rem;">
        <div class="row">
            <h2 class="ps-0">Jadwal Dokter</h2>
            <div class="container">
                <form action="" method="POST" onsubmit="return(validate());">
                    <?php
                    $id_dokter = '';
                    $hari = '';
                    $jam_mulai = '';
                    $jam_selesai = '';
                    $statues = '';
                    if (isset($_GET['id'])) {
                        $get = mysqli_query($mysqli, "SELECT * FROM jadwal_periksa 
                                WHERE id='" . $_GET['id'] . "'");
                        while ($row = mysqli_fetch_array($get)) {
                            $id_dokter = $row['id_dokter'];
                            $hari = $row['hari'];
                            $jam_mulai = $row['jam_mulai'];
                            $jam_selesai = $row['jam_selesai'];
                            $statues = $row['statues'];
                        }
                    ?>
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                    <?php
                    }
                    ?>
                    <div class="dropdown mb-3 w-25">
                        <label for="id_dokter">Dokter <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_dokter" aria-label="id_dokter">
                            <option value="" selected>Pilih Dokter...</option>
                            <?php
                                $result = mysqli_query($mysqli, "SELECT * FROM dokter");
                                
                                while ($data = mysqli_fetch_assoc($result)) {
                                    $selected = ($data['id'] == $id_dokter) ? 'selected' : '';
                                    echo "<option value='" . $data['id'] . "' $selected>" . $data['nama'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="dropdown mb-3 w-25">
                        <label for="hari">Hari <span class="text-danger">*</span></label>
                        <select class="form-select" name="hari" aria-label="hari">
                            <option value="" selected>Pilih Hari...</option>
                            <?php
                                $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                                foreach ($days as $day) {
                                    $selected = ($day == $hari) ? 'selected' : '';
                                    echo "<option value='$day' $selected>$day</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3 w-25">
                        <label for="jam_mulai">Jam Mulai <span class="text-danger">*</span></label>
                        <input type="time" name="jam_mulai" class="form-control" required value="<?php echo $jam_mulai ?>">
                    </div>
                    <div class="mb-3 w-25">
                        <label for="jam_selesai">Jam Selesai <span class="text-danger">*</span></label>
                        <input type="time" name="jam_selesai" class="form-control" required value="<?php echo $jam_selesai ?>">
                    </div>
                    <div class="dropdown mb-3 w-25">
                        <label for="statues">Status <span class="text-danger">*</span></label>
                        <select class="form-select" name="statues" aria-label="statues">
                            <option value="" selected>Pilih Status...</option>
                            <?php
                                $statuses = ['1', '0'];
                                foreach ($statuses as $status) {
                                    $selected = ($status == $statues) ? 'selected' : '';
                                    echo "<option value='$status' $selected>$status</option>";
                                }
                            ?>
                        </select>
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
                            <th valign="middle">Nama Dokter</th>
                            <th valign="middle">Hari</th>
                            <th valign="middle" style="width: 25%;" colspan="2">Waktu</th>
                            <th valign="middle">Status</th>
                            <!-- <th valign="middle">Jam Selesai</th> -->
                            <th valign="middle" style="width: 0.5%;" colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $result = mysqli_query($mysqli, "SELECT dokter.nama, jadwal_periksa.id, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai, jadwal_periksa.statues FROM dokter JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter");
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) :
                            ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td><?php echo $data['hari'] ?></td>
                                    <td><?php echo $data['jam_mulai'] ?> WIB</td>
                                    <td><?php echo $data['jam_selesai'] ?> WIB</td>
                                    <td>
                                      <?php 
                                        echo ($data['statues'] == 1) 
                                          ? '<p class="bg-success text-white border rounded p-1 mb-0">Active</p>' 
                                          : '<p class="bg-danger text-white border rounded p-1 mb-0">Inactive</p>'; 
                                      ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-warning text-white" href="index.php?page=jadwalDokter&id=<?php echo $data['id'] ?>">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </td>
                                    <!-- <td>
                                        <a href="index.php?page=jadwalDokter&id=
                                        <-?php echo $data['id'] ?>
                                        &aksi=hapus" class="btn btn-sm btn-danger text-white">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    </td> -->
                                </tr>

                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>