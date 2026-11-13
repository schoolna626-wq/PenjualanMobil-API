
<?php
require_once 'koneksi.php';

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Metode harus GET'
    ]);
    exit;
}

$sql = "SELECT
            kode_kredit,
            kode_paket,
            ktp,
            kode_mobil,
            tanggal_kredit,
            bayar_kredit
        FROM kredit
        ORDER BY tanggal_kredit DESC";

$result = mysqli_query($koneksi, $sql);

if (!$result) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Query gagal: ' . mysqli_error($koneksi)
    ]);
    exit;
}

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data, JSON_UNESCAPED_UNICODE);

mysqli_free_result($result);
mysqli_close($koneksi);
?>
