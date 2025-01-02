<?php
    if (!isset($_SESSION)) {
        session_start();
    }
?>

<main id="periksapasien-page">
    <div class="container" style="margin-top: 5.5rem;">
        <div class="row">
            <h2 class="ps-0">Riwayat Periksa Pasien</h2>

            <div class="table-responsive mt-3 px-0">
                <table class="table text-center">
                    <thead class="table-primary">
                        <tr>
                            <th valign="middle">No</th>
                            <th valign="middle">Nama Pasien</th>
                            <th valign="middle">No. Antrian</th>
                            <th valign="middle">Keluhan</th>
                            <th valign="middle">Hari</th>
                            <th valign="middle">Tanggal Diperiksa</th>
                            <th valign="middle">Catatan</th>
                            <th valign="middle">Biaya Periksa</th>
                            <th valign="middle">Nama Obat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $id_dokter = $_SESSION['id'];
                            $result = mysqli_query($mysqli, "
                                SELECT daftar_poli.*, pasien.nama AS nama, jadwal_periksa.hari, periksa.tgl_periksa, periksa.catatan, periksa.biaya_periksa, GROUP_CONCAT(obat.nama_obat SEPARATOR ', ') as nama_obat
                                FROM daftar_poli
                                JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id 
                                JOIN pasien ON daftar_poli.id_pasien = pasien.id
                                LEFT JOIN periksa ON daftar_poli.id = periksa.id_daftar_poli
                                LEFT JOIN detail_periksa ON periksa.id = detail_periksa.id_periksa
                                LEFT JOIN obat ON detail_periksa.id_obat = obat.id
                                WHERE jadwal_periksa.id_dokter = '$id_dokter' AND periksa.id_daftar_poli IS NOT NULL
                                GROUP BY daftar_poli.id, pasien.nama, jadwal_periksa.hari, periksa.tgl_periksa, periksa.catatan, periksa.biaya_periksa
                            ");
                            $no = 1;
                            while ($data = mysqli_fetch_array($result)) :
                        ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $data['nama'] ?></td>
                                    <td><?php echo $data['no_antrian'] ?></td>
                                    <td><?php echo $data['keluhan'] ?></td>
                                    <td><?php echo $data['hari'] ?></td>
                                    <td><?php echo $data['tgl_periksa'] ?></td>
                                    <td><?php echo $data['catatan'] ?></td>
                                    <td><?php echo $data['biaya_periksa'] ?></td>
                                    <td><?php echo $data['nama_obat'] ?></td>
                                </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>