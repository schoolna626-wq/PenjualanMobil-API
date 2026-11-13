<?php
require_once 'koneksi.php';
header('Content-Type: application/json; charset=utf-8');
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode_mobil'] ?? '');
    if ($kode !== '') {
        $stmt = $koneksi->prepare('DELETE FROM mobil WHERE kode_mobil=?');
        if ($stmt) {
            $stmt->bind_param('s', $kode);
            try {
                $response['success'] = $stmt->execute();
                $response['message'] = $response['success'] ? 'Data mobil berhasil dihapus' : 'Gagal menghapus data mobil';
            } catch (mysqli_sql_exception $e) {
                $response['message'] = 'Data mobil tidak dapat dihapus';
            }
            $stmt->close();
        } else {
            $response['message'] = 'Query tidak dapat disiapkan';
        }
    } else {
        $response['message'] = 'Kode mobil wajib diisi';
    }
} else {
    $response['message'] = 'Metode harus POST';
}

echo json_encode($response);
?>
