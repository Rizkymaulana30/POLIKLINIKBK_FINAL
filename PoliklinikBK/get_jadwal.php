<?php
    include_once("koneksi.php");
    $id_dokter = $_POST['id_dokter'];  
    $result = $mysqli->query("SELECT * FROM jadwal_periksa WHERE id_dokter=".$id_dokter);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
?>