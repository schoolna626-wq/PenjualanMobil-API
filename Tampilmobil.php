<?php
include 'koneksi.php';

$result = $conn->query('SELECT * FROM mobil ORDER BY kode_mobil ASC');
$mobil = array();
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$server_url = $scheme . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';

while ($row = $result->fetch_assoc()) {
    $row['foto'] = empty($row['foto']) ? '' : $server_url . $row['foto'];
    $mobil[] = $row;
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($mobil);
?>
