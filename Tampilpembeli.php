<?php

include 'koneksi.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM pembeli");

$pembeli = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $pembeli[] = $row;
    }
}

echo json_encode($pembeli);

?>