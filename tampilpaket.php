<?php

include 'koneksi.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM paket");

$paket = array();

if ($result) {

    while ($row = $result->fetch_assoc()) {
        $paket[] = $row;
    }
}

echo json_encode($paket);

?>