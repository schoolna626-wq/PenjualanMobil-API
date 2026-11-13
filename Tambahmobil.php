<?php
include 'koneksi.php';
header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode_mobil'] ?? '');
    $merk = trim($_POST['merk'] ?? '');
    $tipe = trim($_POST['type'] ?? '');
    $warna = trim($_POST['warna'] ?? '');
    $harga = trim($_POST['harga'] ?? '');
    $foto = $_POST['foto'] ?? '';

    if ($kode === '' || $merk === '' || $tipe === '' || $warna === '' || $harga === '' || $foto === '') {
        $response['message'] = 'Data tidak lengkap';
    } elseif (!is_numeric($harga)) {
        $response['message'] = 'Harga harus berupa angka';
    } else {
        $gambar = base64_decode($foto, true);
        $informasiGambar = $gambar === false ? false : getimagesizefromstring($gambar);

        if ($gambar === false || strlen($gambar) > 5000000 || $informasiGambar === false || $informasiGambar['mime'] !== 'image/jpeg') {
            $response['message'] = 'Format gambar tidak sesuai';
        } else {
            $folder = __DIR__ . '/foto_mobil/';
            if (!is_dir($folder)) {
                mkdir($folder, 0777, true);
            }
            $namaFile = preg_replace('/[^a-zA-Z0-9_-]/', '_', $kode) . '_' . time() . '.jpg';
            $path = $folder . $namaFile;
            $relativePath = 'foto_mobil/' . $namaFile;
            $fileSaved = file_put_contents($path, $gambar);

            if ($fileSaved === false) {
                $response['message'] = 'Gagal menyimpan gambar ke folder';
            } else {
                $stmt = $conn->prepare('INSERT INTO mobil (kode_mobil, merk, type, warna, harga, foto) VALUES (?, ?, ?, ?, ?, ?)');
                if ($stmt) {
                    $stmt->bind_param('ssssis', $kode, $merk, $tipe, $warna, $harga, $relativePath);
                    try {
                        $response['success'] = $stmt->execute();
                        $response['message'] = $response['success'] ? 'Data berhasil disimpan' : 'Gagal menyimpan data';
                    } catch (mysqli_sql_exception $e) {
                        $response['message'] = 'Gagal menyimpan data';
                    }
                    $stmt->close();
                } else {
                    $response['message'] = 'Query tidak dapat disiapkan';
                }
                if (!$response['success']) {
                    unlink($path);
                }
            }
        }
    }
} else {
    $response['message'] = 'Metode Request Tidak Valid';
}

echo json_encode($response);
?>
