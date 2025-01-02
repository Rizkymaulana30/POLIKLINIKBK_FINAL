<?php
    include_once("koneksi.php");
    $id_poli = $_POST['id_poli'];  
    if ($id_poli == "") {
        $result = $mysqli->query("SELECT * FROM dokter");
    } else {
        $result = $mysqli->query("SELECT * FROM dokter WHERE id_poli=".$id_poli);
    }
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
?>