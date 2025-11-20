<?php
session_start();
if (!isset($_SESSION['is_seller'])) { exit("Akses ditolak."); }

$storeName = $_SESSION['store_info']['name'];
$orders = $_SESSION['store_orders'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand">Dashboard Toko: <?= htmlspecialchars($storeName) ?></a>
        <a href="products.php" class="btn btn-outline-light">Kembali ke Toko</a>
    </div>
</nav>

<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
             <div class="list-group">
                <a href="store_dashboard.php" class="list-group-item list-group-item-action">Kelola Produk</a>
                <a href="manage_orders.php" class="list-group-item list-group-item-action active">Kelola Pesanan</a>
            </div>
        </div>
        <div class="col-md-9">
            <h3>Pesanan Masuk</h3>
            <p class="text-muted">Fitur ini akan menampilkan pesanan yang dibuat oleh pembeli untuk produk Anda.</p>
            <p class="text-center mt-4">Belum ada pesanan masuk.</p>
        </div>
    </div>
</div>
</body>
</html>