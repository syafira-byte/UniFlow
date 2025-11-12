<?php
session_start();
include 'config.php'; // pastikan $koneksi didefinisikan di sini

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// cek kosong dulu
if ($username === '' || $password === '') {
    header('Location: ../index.php?error=2');
    exit;
}

// prepared statement untuk keamanan
$stmt = $koneksi->prepare("SELECT username, password FROM tb_user WHERE username = ? LIMIT 1");
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();
    // bandingkan md5 hasil input dengan value di DB secara timing-safe
    if (hash_equals($user['password'], md5($password))) {
        session_regenerate_id(true);
        $_SESSION['username'] = $user['username'];
        $_SESSION['login'] = true;
        header('Location: ../app/index.php');
        exit;
    } else {
        header('Location: ../index.php?error=1');
        exit;
    }
} else {
    header('Location: ../index.php?error=1');
    exit;
}
