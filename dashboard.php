<?php
session_start();

// Jika pengguna belum login, tendang kembali ke halaman login
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['user_username'] ?? 'Pengguna';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h1>Selamat Datang di Dashboard, <?= htmlspecialchars($username); ?>!</h1>
        <p>Anda telah berhasil login.</p>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>