<?php

include 'koneksi.php';

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $ktp = $_POST['ktp'] ?? '';
    $nama = $_POST['nama_pembeli'] ?? '';
    $alamat = $_POST['alamat_pembeli'] ?? '';
    $noHp = $_POST['telp_pembeli'] ?? '';

    if ($ktp && $nama && $alamat && $noHp) {

        $stmt = $conn->prepare(
            "INSERT INTO pembeli
            (ktp, nama_pembeli, alamat_pembeli, telp_pembeli)
            VALUES (?, ?, ?, ?)"
        );

        if ($stmt) {

            $stmt->bind_param(
                "ssss",
                $ktp,
                $nama,
                $alamat,
                $noHp
            );

            $response['success'] = $stmt->execute();

            $response['message'] = $response['success']
                ? "Data berhasil disimpan"
                : "Gagal menyimpan data: " . $stmt->error;

            $stmt->close();

        } else {

            $response['message'] =
                "Prepare gagal: " . $conn->error;
        }

    } else {

        $response['message'] = "Semua data wajib diisi!";
    }

} else {

    $response['message'] = "Metode Request Tidak Valid";
}

echo json_encode($response);

?>