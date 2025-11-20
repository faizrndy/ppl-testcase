<?php
session_start();

if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit;
}

$transactions = $_SESSION['transaction_history'] ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-T">
    <title>Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="products.php">GameStore</a>
        <div>
            <a href="register_store.php" class="btn btn-outline-warning me-2">Buka Toko</a>
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h2>Riwayat Transaksi Anda</h2>
    <hr>
    <?php if (!empty($transactions)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Total Bayar</th>
                    <th>Tanggal Transaksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_reverse($transactions) as $index => $trx): ?>
                <tr>
                    <td><?= count($transactions) - $index ?></td>
                    <td><?= htmlspecialchars($trx['product_name']) ?></td>
                    <td>Rp <?= number_format($trx['price']) ?></td>
                    <td><?= htmlspecialchars($trx['date']) ?></td>
                    <td>
                        <a href="review.php?trx_id=<?= array_search($trx, $transactions) ?>" class="btn btn-warning btn-sm">Beri Ulasan</a>
                        
                        <a href="complain.php?trx_id=<?= array_search($trx, $transactions) ?>" class="btn btn-danger btn-sm">Komplain</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Anda belum memiliki riwayat transaksi.</p>
    <?php endif; ?>
</div>

</body>
</html>