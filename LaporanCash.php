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
    $sql = "SELECT b.kode_cash, COALESCE(p.nama_pembeli, b.ktp) AS nama_pembeli, COALESCE(m.merk, 'Data mobil tidak ditemukan') AS merk, COALESCE(m.type, '') AS type, b.cash_tgl AS cash_tanggal, b.cash_bayar
            FROM beli_cash b
            LEFT JOIN pembeli p ON b.ktp = p.ktp
        LEFT JOIN mobil m ON b.kode_mobil = m.kode_mobil
            WHERE YEAR(b.cash_tgl) = ?
            ORDER BY b.cash_tgl DESC";
} else {
    if (!preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])$/', $tanggal)) {
        echo json_encode([]);
        exit;
    }
    $sql = "SELECT b.kode_cash, COALESCE(p.nama_pembeli, b.ktp) AS nama_pembeli, COALESCE(m.merk, 'Data mobil tidak ditemukan') AS merk, COALESCE(m.type, '') AS type, b.cash_tgl AS cash_tanggal, b.cash_bayar
            FROM beli_cash b
            LEFT JOIN pembeli p ON b.ktp = p.ktp
        LEFT JOIN mobil m ON b.kode_mobil = m.kode_mobil
            WHERE DATE_FORMAT(b.cash_tgl, '%Y-%m') = ?
            ORDER BY b.cash_tgl DESC";
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
