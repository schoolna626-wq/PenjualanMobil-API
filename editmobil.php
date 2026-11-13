<?php
require_once 'koneksi.php';
header('Content-Type: application/json; charset=utf-8');
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode_mobil'] ?? '');
    $merk = trim($_POST['merk_mobil'] ?? '');
    $type = trim($_POST['type_mobil'] ?? '');
    $warna = trim($_POST['warna_mobil'] ?? '');
    $harga = trim($_POST['harga_mobil'] ?? '');

    if ($kode !== '' && $merk !== '' && $type !== '' && $warna !== '' && is_numeric($harga)) {
        $stmt = $koneksi->prepare('UPDATE mobil SET merk=?, type=?, warna=?, harga=? WHERE kode_mobil=?');
        if ($stmt) {
            $stmt->bind_param('sssis', $merk, $type, $warna, $harga, $kode);
            try {
                $response['success'] = $stmt->execute();
                $response['message'] = $response['success'] ? 'Data mobil berhasil diupdate' : 'Gagal mengubah data mobil';
            } catch (mysqli_sql_exception $e) {
                $response['message'] = 'Gagal mengubah data mobil';
            }
            $stmt->close();
        } else {
            $response['message'] = 'Query tidak dapat disiapkan';
        }
    } else {
        $response['message'] = 'Lengkapi data mobil';
    }
} else {
    $response['message'] = 'Metode harus POST';
}

echo json_encode($response);
?>
