<?php 
    if (!isset($_SESSION)) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $keluhan = $_POST['keluhan'];
        $id_jadwal = $_POST['id_jadwal'];
    
        // Check if the patient has already registered
        $check_query = "SELECT * FROM daftar_poli WHERE id_pasien = '".$_SESSION['id_pasien']."'";
        $check_result = $mysqli->query($check_query);
        
        // Check if the form fields are not empty
        $query = "SELECT MAX(no_antrian) as max_no FROM daftar_poli WHERE id_jadwal = '$id_jadwal'";
        $result = $mysqli->query($query);
        $row = $result->fetch_assoc();
        $no_antrian = $row['max_no'] !== null ? $row['max_no'] + 1 : 1;

        // Insert the new poli registration into the daftar_poli table
        $insert_query = "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian, tanggal) VALUES ('".$_SESSION['id_pasien']."', '$id_jadwal', '$keluhan', '$no_antrian', NOW())";
        if (mysqli_query($mysqli, $insert_query)) {
            // echo "<script>alert('No antrian anda adalah $no_antrian');</script>";
            $success = "No antrian anda adalah $no_antrian";
            // $button_disabled = "disabled";
            // Redirect to prevent form resubmission
            header("Location: index.php?page=rawatJalan&no_antrian=$no_antrian");
        } else {
            $error = "Pendaftaran gagal";
        }
    }

$query = "SELECT dokter.id AS dokter_id, dokter.nama AS dokter_nama, jadwal_periksa.id AS jadwal_id, jadwal_periksa.hari AS hari, jadwal_periksa.jam_mulai AS jam_mulai, jadwal_periksa.jam_selesai AS jam_selesai, jadwal_periksa.statues AS statues FROM dokter JOIN jadwal_periksa ON dokter.id = jadwal_periksa.id_dokter";
$result = $mysqli->query($query);
if (!$result) {
    die("Query error: " . $mysqli->error);
}
$dokter_schedules = $result->fetch_all(MYSQLI_ASSOC);
?>

<main id="rawatjalan-page">
    <div class="container" style="margin-top: 5.5rem;">
        <div class="row justify-content-center">
            <h2 class="text-center mb-4">Pendaftaran Rawat Jalan</h2>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center fw-bold" style="font-size: 1.5rem;">Pilih Klinik</div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <?php
                            if (!isset($error) && isset($_GET['no_antrian'])) {
                                echo '
                                    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                                        <symbol id="check-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                        </symbol>
                                    </svg>
                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" style="width: 20; height: 20;" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                        <div>
                                            Nomor antrian anda adalah ' .$_GET['no_antrian']. '
                                        </div>
                                    </div>
                                ';
                            }
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
                            <div class="row">
                                <div class="col-6">
                                    <div class="dropdown mb-3">
                                        <label for="id_poli">Poli Dokter <span class="text-danger">*</span></label>
                                        <select class="form-select" name="id_poli" aria-label="id_poli">
                                            <option value="" selected>Pilih Poli...</option>
                                            <?php
                                                $result = mysqli_query($mysqli, "SELECT * FROM poli");
        
                                                while ($data = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $data['id'] . "'>" . $data['nama_poli'] . "</option>";
                                                }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="dropdown mb-3">
                                        <label for="id_dokter">Dokter <span class="text-danger">*</span></label>
                                        <select disabled class="form-select" name="id_dokter" aria-label="id_dokter">
                                            <option value="" selected>Pilih Dokter...</option>
                                            <?php
                                                $result = mysqli_query($mysqli, "SELECT * FROM dokter");
                                                
                                                while ($data = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $data['id'] . "'>" . $data['nama'] . "</option>";
                                                }
                                            ?>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <ul class="list-group mb-3">
                                
                            </ul>
                            <div class="mb-3">
                                <label for="keluhan">Keluhan <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="keluhan" id="keluhan" style="resize: none; height: 8rem" required></textarea>
                            </div>
                            <div class="text-center mt-3">
                                <button disabled type="submit" class="btn btn-outline-primary px-4 btn-block">Daftar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Display the no_antrian alert
    if (isset($_GET['no_antrian'])) {
        $success = "No antrian anda adalah ".$_GET['no_antrian']."";
    }
?>

<script>
    document.querySelector("select[name='id_poli']").addEventListener('change', function() {
        let id_poli = this.value;
        let dokterDropdown = document.querySelector("select[name='id_dokter']");
        if (id_poli != "") {
            dokterDropdown.disabled = false;
        } else {
            dokterDropdown.disabled = true;
        }
        
        fetch('get_dokter.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id_poli=' + id_poli
        })
        .then(response => response.json())
        .then(data => {
            var select = document.querySelector("select[name='id_dokter']");
            select.innerHTML = "<option value='' selected>Pilih Dokter...</option>";
            
            data.forEach(function(dokter) {
                var option = document.createElement('option');
                option.value = dokter.id;
                option.text = dokter.nama;
                select.add(option);
            });
        });
    });

    window.addEventListener('load', function() {
        let id_dokter = document.querySelector("select[name='id_dokter']").value;
        let listGroup = document.querySelector(".list-group");
        if (id_dokter == "") {
            listGroup.innerHTML = "<li class='list-group-item disabled text-center'>Jadwal tidak tersedia</li>";
        }
    });

    document.querySelector("select[name='id_dokter']").addEventListener('change', function() {
        let id_dokter = this.value;
        let listGroup = document.querySelector(".list-group");

        if (id_dokter == "") {
            listGroup.innerHTML = "<li class='list-group-item disabled text-center'>Anda harus memilih dokter terlebih dahulu!</li>";
        } else {
            fetch('get_jadwal.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id_dokter=' + id_dokter
            })
            .then(response => response.json())
            .then(data => {
                let listGroup = document.querySelector(".list-group");
                
                if (data != "") {
                listGroup.innerHTML = "";
                data.forEach(function(jadwal) {
                    let listItem = document.createElement('li');
                    listItem.className = "list-group-item d-flex justify-content-between mb-1";
                    listItem.style.cursor = "pointer"
                    let isDisabled = (jadwal.statues != 1) ? 'disabled' : '';
                    let status = (jadwal.statues != 1) ? '<p class="bg-danger text-white border rounded p-1 mb-0">Inactive</p>' : '<p class="bg-success text-white border rounded p-1 mb-0">Active</p>';
                    listItem.innerHTML = '<div><input style="cursor: pointer" class="form-check-input me-1" type="radio" name="id_jadwal" value="' + jadwal.id + '" id="id_jadwal" '+ isDisabled +'><label class="form-check-label" for="id_jadwal" style="cursor: pointer">' + jadwal.hari + ', ' + jadwal.jam_mulai + ' - ' + jadwal.jam_selesai + '</label></div>' + status;
                    listGroup.appendChild(listItem);
                });

                document.querySelectorAll("input[type=radio]").forEach(function(radio) {
                radio.addEventListener("change", function() {
                    document.querySelector("button[type=submit]").removeAttribute('disabled');
                });
            });
            } else {
                listGroup.innerHTML = "<li class='list-group-item disabled text-center'>Jadwal tidak tersedia</li>";
            }
            });
        }
    });
</script>