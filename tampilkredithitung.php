<?php
include 'koneksi.php';
header('Content-Type: application/json; charset=UTF-8');

$sql = "SELECT k.kode_kredit, k.bayar_kredit,
               COALESCE(p.tenor, 0) AS tenor,
               COUNT(b.kode_cicilan) AS jumlah_cicilan
        FROM kredit k
        LEFT JOIN paket p ON k.kode_paket = p.kode_paket
        LEFT JOIN bayar_cicilan b ON k.kode_kredit = b.kode_kredit
        GROUP BY k.kode_kredit, k.bayar_kredit, p.tenor
        ORDER BY k.kode_kredit";

$result = mysqli_query($koneksi, $sql);
if (!$result) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Gagal membaca data kredit']);
    exit;
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $jumlah_cicilan = (int) $row['jumlah_cicilan'];
    $tenor = (int) $row['tenor'];
    $bayar_kredit = (int) $row['bayar_kredit'];

    $row['cicilan_ke'] = $jumlah_cicilan + 1;
    $row['sisa_ke'] = max(0, $tenor - $jumlah_cicilan);
    $row['sisa_harga'] = $bayar_kredit * $row['sisa_ke'];
    $data[] = $row;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);
mysqli_free_result($result);
mysqli_close($koneksi);
?>
