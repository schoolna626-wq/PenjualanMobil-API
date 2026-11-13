<?php

include 'koneksi.php';

header('Content-Type: application/json');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$response = array();

if ($username === '' || $password === '') {
    $response['success'] = false;
    $response['message'] = 'Username dan password tidak boleh kosong';
} else {
    $stmt = $conn->prepare('SELECT level FROM user WHERE username = ? AND password = ? LIMIT 1');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response['success'] = true;
        $response['level'] = (int) $row['level'];
        $response['message'] = 'Login berhasil';
    } else {
        $response['success'] = false;
        $response['message'] = 'Username atau password salah';
    }

    $stmt->close();
}

echo json_encode($response);

?>
