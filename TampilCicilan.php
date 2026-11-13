<?php
require_once 'koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$sql = "SELECT kode_cicilan, kode_kredit, tanggal_cicilan,
               cicilanke, jumlah_cicilan, sisacicilke, sisa_cicilan
        FROM bayar_cicilan ORDER BY tanggal_cicilan DESC, kode_cicilan DESC";

$result = mysqli_query($koneksi, $sql);
$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
?>
