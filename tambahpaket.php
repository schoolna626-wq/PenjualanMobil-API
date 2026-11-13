<?php

include 'koneksi.php';

header('Content-Type: application/json');

$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $kodePaket = $_POST['kode_paket'] ?? '';
    $uangMuka  = $_POST['uang_muka'] ?? '';
    $tenor     = $_POST['tenor'] ?? '';
    $bunga     = $_POST['bunga_cicilan'] ?? '';

    if ($kodePaket && $uangMuka && $tenor && $bunga) {

        if (!is_numeric($uangMuka)
            || !is_numeric($tenor)
            || !is_numeric($bunga)) {

            $response['message'] =
                "Uang muka, tenor, dan bunga harus berupa angka!";

        } else {

            $stmt = $conn->prepare(
                "INSERT INTO paket
                (kode_paket, uang_muka, tenor, bunga_cicilan)
                VALUES (?, ?, ?, ?)"
            );

            if ($stmt) {

                $stmt->bind_param(
                    "siid",
                    $kodePaket,
                    $uangMuka,
                    $tenor,
                    $bunga
                );

                $response['success'] = $stmt->execute();

                $response['message'] =
                    $response['success']
                    ? "Data berhasil disimpan"
                    : "Gagal menyimpan data: " . $stmt->error;

                $stmt->close();

            } else {

                $response['message'] =
                    "Prepare gagal: " . $conn->error;
            }
        }

    } else {

        $response['message'] =
            "Semua data wajib diisi!";
    }

} else {

    $response['message'] =
        "Metode Request Tidak Valid";
}

echo json_encode($response);

?>