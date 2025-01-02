<?php
if (isset($_POST['simpanData'])) {
    $id_daftar_poli = $_GET['id']; // Get the id from the URL
    $id_obats = $_POST['id_obat']; // Get the id_obat values from the form
    $base_biaya_periksa = 150000;
    $biaya_periksa = 0;
    $tgl_periksa = date('Y-m-d H:i:s'); // Get the current datetime
    $catatan = $_POST['catatan']; // Get the catatan value from the form

    // Process the first "obat" separately
    $first_obat = array_shift($id_obats);
    $result = mysqli_query($mysqli, "SELECT harga FROM obat WHERE id = '$first_obat'");
    $data = mysqli_fetch_assoc($result);
    $harga_obat = $data['harga'];
    $biaya_periksa += $base_biaya_periksa + $harga_obat;

    // Process the rest of the "obat"
    foreach ($id_obats as $id_obat) {
        $result = mysqli_query($mysqli, "SELECT harga FROM obat WHERE id = '$id_obat'");
        $data = mysqli_fetch_assoc($result);
        $harga_obat = $data['harga'];
        $biaya_periksa += $harga_obat;
    }

    // Insert into periksa table
    $sql = "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) VALUES ('$id_daftar_poli', '$tgl_periksa', '$catatan', '$biaya_periksa')";
    $tambah = mysqli_query($mysqli, $sql);

    // Get the id_periksa of the record just inserted
    $id_periksa = mysqli_insert_id($mysqli);

    // Insert into detail_periksa table for each obat
    array_unshift($id_obats, $first_obat); // Add the first obat back to the array
    foreach ($id_obats as $id_obat) {
        $sql = "INSERT INTO detail_periksa (id_periksa, id_obat) VALUES ('$id_periksa', '$id_obat')";
        $tambah = mysqli_query($mysqli, $sql);
    }

    echo "
        <script> 
            alert('resep obat telah siap');
            window.location.href='berandaDokter.php?page=periksa';
        </script>
    ";
    exit();
}
?>

<main id="periksapasien-page">
    <div class="container" style="margin-top: 5.5rem;">
        <div class="row">
            <h2 class="ps-0">Data Pasien Saya</h2>

            <div class="container">
            <form action="" method="POST">
                    <?php
                        $id_pasien = '';
                        $id_dokter = $_SESSION['id'];
                        $nama_dokter= $_SESSION['nama'];
                        $tgl_periksa = '';
                        $catatan = '';
                        $nama_pasien = '';
                        $no_antrian = '';
                        $keluhan = '';
                        if (isset($_GET['id'])) {
                            $get = mysqli_query($mysqli, "
                                SELECT daftar_poli.*, pasien.nama AS nama
                                FROM daftar_poli
                                JOIN pasien ON daftar_poli.id_pasien = pasien.id
                                WHERE daftar_poli.id='" . $_GET['id'] . "'
                            ");
                            while ($row = mysqli_fetch_array($get)) {
                                $id_pasien = $row['id_pasien'];
                                $nama_pasien = $row['nama'];
                                $no_antrian = $row['no_antrian'];
                                $keluhan = $row['keluhan'];
                            }
                        }
                    ?>
                    <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                    <input type="hidden" name="id_pasien" value="<?php echo $id_pasien; ?>">
                    <input type="hidden" name="id_dokter" value="<?php echo $id_dokter; ?>">
                    <div class="mb-3 w-25">
                        <label for="no_antrian">No. Antrian <span class="text-danger">*</span></label>
                        <input disabled type="text" name="no_antrian" class="form-control" required value="<?php echo $no_antrian ?>">
                    </div>
                    <div class="mb-3 w-25">
                        <label for="id_pasien">Nama Pasien <span class="text-danger">*</span></label>
                        <input disabled type="text" name="id_pasien" class="form-control" required value="<?php echo $nama_pasien ?>">
                    </div>
                    <div class="mb-3 w-25">
                        <label for="id_dokter">Nama Dokter <span class="text-danger">*</span></label>
                        <input disabled type="text" name="id_dokter" class="form-control" required value="<?php echo $nama_dokter ?>">
                    </div>
                    <div class="mb-3 w-25">
                        <label for="catatan">Catatan <span class="text-danger">*</span></label>
                        <input type="text" name="catatan" class="form-control" required value="<?php echo $catatan ?>">
                    </div>
                    <div class="dropdown mb-3 w-25">
                        <label for="id_obat">Obat <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_obat[]" aria-label="id_obat">
                            <option value="" selected>Pilih Obat...</option>
                            <?php
                                $result = mysqli_query($mysqli, "SELECT * FROM obat");
                                
                                while ($data = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $data['id'] . "'>" . $data['nama_obat'] . "</option>";
                                }
                            ?>
                            
                        </select>
                        <button id="addObat" type="button" class="btn btn-primary">Add Obat</button>
                    </div>

                    <div id="additionalObat"></div>

                    <script>
                        document.getElementById('addObat').addEventListener('click', function() {
                            var obatDropdown = `
                                <div class="dropdown mb-3 w-25">
                                    <label for="id_obat">Obat <span class="text-danger">*</span></label>
                                    <select class="form-select" name="id_obat[]" aria-label="id_obat">
                                        <option value="" selected>Pilih Obat...</option>
                                        <?php
                                            $result = mysqli_query($mysqli, "SELECT * FROM obat");
                                            
                                            while ($data = mysqli_fetch_assoc($result)) {
                                                echo "<option value='" . $data['id'] . "'>" . $data['nama_obat'] . "</option>";
                                            }
                                        ?>
                                        
                                    </select>
                                    <button type="button" class="btn btn-danger deleteObat">Delete Obat</button>
                                </div>
                            `;

                            document.getElementById('additionalObat').innerHTML += obatDropdown;
                        });

                        // Event delegation to handle click events on dynamically created delete buttons
                        document.getElementById('additionalObat').addEventListener('click', function(e) {
                            if (e.target && e.target.classList.contains('deleteObat')) {
                                e.target.parentNode.remove();
                            }
                        });
                    </script>
                    <div class="d-flex justify-content-end mt-2">
                        <button type="submit" name="simpanData" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
                <script>
                    function checkForm() {
                        var no_antrian = document.querySelector('input[name="no_antrian"]').value;
                        var id_pasien = document.querySelector('input[name="id_pasien"]').value;
                        var id_dokter = document.querySelector('input[name="id_dokter"]').value;
                        var catatan = document.querySelector('input[name="catatan"]').value;
                        var id_obat = document.querySelector('select[name="id_obat[]"]').value;

                        if(no_antrian == "" || id_pasien == "" || id_dokter == "" || catatan == "" || id_obat == "") {
                            document.querySelector('button[name="simpanData"]').disabled = true;
                        } else {
                            document.querySelector('button[name="simpanData"]').disabled = false;
                        }
                    }

                    // Call checkForm function every time form inputs change
                    document.querySelector('form').addEventListener('change', checkForm);

                    // Call checkForm function on page load to ensure button is in correct state
                    window.onload = checkForm;
                </script>
            </div>

            <div class="table-responsive mt-3 px-0">
            <?php
                $id_dokter = $_SESSION['id'];
                $result_jadwal = mysqli_query($mysqli, "
                    SELECT DISTINCT id_jadwal
                    FROM daftar_poli
                    JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id 
                    WHERE jadwal_periksa.id_dokter = '$id_dokter'
                ");

                while ($jadwal = mysqli_fetch_array($result_jadwal)) :
                    $id_jadwal = $jadwal['id_jadwal'];
            ?>

                <table class="table text-center">
                    <thead class="table-primary">
                        <tr>
                            <th valign="middle">No</th>
                            <th valign="middle">Nama Pasien</th>
                            <th valign="middle">No. Antrian</th>
                            <th valign="middle">Hari</th>
                            <th valign="middle">Jam Periksa</th>
                            <th valign="middle">Keluhan</th>
                            <th valign="middle" style="width: 0.5%;" colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $result = mysqli_query($mysqli, "
                                SELECT daftar_poli.*, pasien.nama AS nama, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai
                                FROM daftar_poli
                                JOIN (
                                    SELECT id_pasien, MAX(tanggal) as max_tanggal
                                    FROM daftar_poli
                                    GROUP BY id_pasien
                                ) as latest_poli ON daftar_poli.id_pasien = latest_poli.id_pasien AND daftar_poli.tanggal = latest_poli.max_tanggal
                                JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id 
                                JOIN pasien ON daftar_poli.id_pasien = pasien.id
                                LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli
                                WHERE jadwal_periksa.id_dokter = '$id_dokter' AND periksa.id_daftar_poli IS NULL AND daftar_poli.id_jadwal = '$id_jadwal'
                            ");
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) :
                        ?>
                            <tr>
                                <td><?php echo $no++ ?></td>
                                <td><?php echo $data['nama'] ?></td>
                                <td><?php echo $data['no_antrian'] ?></td>
                                <td><?php echo $data['hari'] ?></td>
                                <td><?php echo $data['jam_mulai'] . ' - ' . $data['jam_selesai'] ?></td>
                                <td><?php echo $data['keluhan'] ?></td>
                                <td>
                                    <a class="btn btn-sm btn-warning text-white" href="berandaDokter.php?page=periksa&id=<?php echo $data['id'] ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php endwhile; ?>
            </div>
        </div>
    </div>
</main>