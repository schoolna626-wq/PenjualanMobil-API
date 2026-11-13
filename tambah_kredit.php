<?php
require_once 'koneksi.php';

header('Content-Type: application/json; charset=UTF-8');

$response = [
    'success' => false,    
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Metode harus POST';
    echo json_encode($response);
    exit;
}

$kode_kredit = trim($_POST['kode_kredit'] ?? '');
$kode_paket = trim($_POST['kode_paket'] ?? '');
$ktp = trim($_POST['ktp'] ?? '');
$kode_mobil = trim($_POST['kode_mobil'] ?? '');
$tanggal_kredit = trim($_POST['tanggal_kredit'] ?? '');
$bayar_kredit = trim($_POST['bayar_kredit'] ?? '');

if (
    $kode_kredit === '' ||
    $kode_paket === '' ||
    $ktp === '' ||
    $kode_mobil === '' ||
    $tanggal_kredit === '' ||
    $bayar_kredit === ''
) {
    $response['message'] = 'Semua kolom harus diisi';
    echo json_encode($response);
    exit;
}

$sql = "INSERT INTO kredit
        (kode_kredit, kode_paket, ktp, kode_mobil,
         tanggal_kredit, bayar_kredit)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);

if (!$stmt) {
    $response['message'] = 'Query gagal disiapkan';
    echo json_encode($response);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    'ssssss',
    $kode_kredit,
    $kode_paket,
    $ktp,
    $kode_mobil,
    $tanggal_kredit,
    $bayar_kredit
);

if (mysqli_stmt_execute($stmt)) {
    $response['success'] = true;
    $response['message'] = 'Berhasil menyimpan data kredit';
} else {
    $response['message'] = 'Gagal menyimpan: '
                         . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
echo json_encode($response);
?>
