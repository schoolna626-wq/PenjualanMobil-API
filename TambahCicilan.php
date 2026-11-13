<?php
include 'koneksi.php';
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $kode_cicilan = $_POST['kode_cicilan'] ?? '';
    $kode_kredit = $_POST['kode_kredit'] ?? '';
    $tanggal = $_POST['tanggal_cicilan'] ?? '';
    $cicilanke = $_POST['cicilanke'] ?? '';
    $jumlah_cicilan = $_POST['jumlah_cicilan'] ?? '';
    $sisacicilke = $_POST['sisacicilke'] ?? '';
    $sisa_cicilan = $_POST['sisa_cicilan'] ?? '';

    if ($kode_cicilan !== '' && $kode_kredit !== ''
        && $tanggal !== '' && $cicilanke !== ''
        && $jumlah_cicilan !== '' && $sisacicilke !== ''
        && $sisa_cicilan !== '') {

        $cek = $koneksi->prepare(
            "SELECT COUNT(*) AS jml FROM kredit WHERE kode_kredit=?"
        );

        $cek->bind_param("s", $kode_kredit);
        $cek->execute();
        $hasil = $cek->get_result()->fetch_assoc();
        $cek->close();

        if ($hasil['jml'] == 0) {
            $response['message'] = "Kode kredit tidak ditemukan";
            echo json_encode($response);
            exit;
        }

        $sql = "INSERT INTO bayar_cicilan
                (kode_cicilan, kode_kredit, tanggal_cicilan,
                 cicilanke, jumlah_cicilan, sisacicilke, sisa_cicilan)
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $koneksi->prepare($sql);

        $stmt->bind_param(
            "sssiiii",
            $kode_cicilan,
            $kode_kredit,
            $tanggal,
            $cicilanke,
            $jumlah_cicilan,
            $sisacicilke,
            $sisa_cicilan
        );

        try {
            $berhasil = $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            $berhasil = false;
        }

        if ($berhasil) {
            $response['success'] = true;
            $response['message'] = "Data berhasil disimpan";
        } else {
            $response['message'] = "Gagal menyimpan data";
        }

        $stmt->close();

    } else {
        $response['message'] = "Semua data wajib diisi";
    }

} else {
    $response['message'] = "Metode request tidak sesuai";
}

echo json_encode($response);
?>
