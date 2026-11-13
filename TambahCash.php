<?php
require_once 'koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode_cash'] ?? '');
    $ktp = trim($_POST['ktp'] ?? '');
    $mobil = trim($_POST['kode_mobil'] ?? '');
    $tanggal = trim($_POST['cash_tgl'] ?? '');
    $bayar = trim($_POST['cash_bayar'] ?? '');

    if ($kode !== '' && $ktp !== '' && $mobil !== '' && $tanggal !== '' && is_numeric($bayar)) {
        $stmt = $koneksi->prepare(
            'INSERT INTO beli_cash (kode_cash, ktp, kode_mobil, cash_tgl, cash_bayar)
             VALUES (?, ?, ?, ?, ?)'
        );
        if ($stmt) {
            $stmt->bind_param('ssssi', $kode, $ktp, $mobil, $tanggal, $bayar);
            try {
                $response['success'] = $stmt->execute();
                $response['message'] = $response['success'] ? 'Data cash berhasil disimpan' : 'Gagal menyimpan data cash';
            } catch (mysqli_sql_exception $e) {
                $response['message'] = 'Gagal menyimpan data cash. Periksa kode yang digunakan.';
            }
            $stmt->close();
        } else {
            $response['message'] = 'Query tidak dapat disiapkan';
        }
    } else {
        $response['message'] = 'Semua data wajib diisi';
    }
} else {
    $response['message'] = 'Metode harus POST';
}

echo json_encode($response);
?>
