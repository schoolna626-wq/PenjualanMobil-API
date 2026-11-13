<?php
require_once 'koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT kode_cash, ktp, kode_mobil, cash_tgl AS cash_tanggal, cash_bayar
        FROM beli_cash ORDER BY kode_cash DESC";
$result = mysqli_query($koneksi, $sql);
$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
