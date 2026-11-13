<?php
include 'koneksi.php';
header('Content-Type: application/json');

$periode = $_GET['periode'] ?? 'bulan';
$tanggal = $_GET['tanggal'] ?? date('Y-m');

if ($periode === 'tahun') {
    $tanggal = substr($tanggal, 0, 4);
    if (!preg_match('/^[0-9]{4}$/', $tanggal)) {
        echo json_encode([]);
        exit;
    }
    $sql = "SELECT k.kode_kredit, p.nama_pembeli, m.merk, m.type, k.tanggal_kredit, k.bayar_kredit
            FROM kredit k
            JOIN pembeli p ON k.ktp = p.ktp
        JOIN mobil m ON k.kode_mobil = m.kode_mobil
            WHERE YEAR(k.tanggal_kredit) = ?
            ORDER BY k.tanggal_kredit DESC";
} else {
    if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])$/', $tanggal)) {
        echo json_encode([]);
        exit;
    }
    $sql = "SELECT k.kode_kredit, p.nama_pembeli, m.merk, m.type, k.tanggal_kredit, k.bayar_kredit
            FROM kredit k
            JOIN pembeli p ON k.ktp = p.ktp
        JOIN mobil m ON k.kode_mobil = m.kode_mobil
            WHERE DATE_FORMAT(k.tanggal_kredit, '%Y-%m') = ?
            ORDER BY k.tanggal_kredit DESC";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $tanggal);
$stmt->execute();
$result = $stmt->get_result();
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
$stmt->close();
?>
