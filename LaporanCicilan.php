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
    $sql = "SELECT b.kode_cicilan, b.kode_kredit, p.nama_pembeli, b.tanggal_cicilan, b.jumlah_cicilan
            FROM bayar_cicilan b
            JOIN kredit k ON b.kode_kredit = k.kode_kredit
        JOIN pembeli p ON k.ktp = p.ktp
            WHERE YEAR(b.tanggal_cicilan) = ?
            ORDER BY b.tanggal_cicilan DESC";
} else {
    if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])$/', $tanggal)) {
        echo json_encode([]);
        exit;
    }
    $sql = "SELECT b.kode_cicilan, b.kode_kredit, p.nama_pembeli, b.tanggal_cicilan, b.jumlah_cicilan
            FROM bayar_cicilan b
            JOIN kredit k ON b.kode_kredit = k.kode_kredit
        JOIN pembeli p ON k.ktp = p.ktp
            WHERE DATE_FORMAT(b.tanggal_cicilan, '%Y-%m') = ?
            ORDER BY b.tanggal_cicilan DESC";
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
