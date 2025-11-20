<?php
session_start();

// Hanya seller yang bisa akses halaman ini
if (!isset($_SESSION['is_seller']) || $_SESSION['is_seller'] !== true) {
    echo "Akses ditolak.";
    exit;
}

// Inisialisasi produk dan pesanan toko jika belum ada
if (!isset($_SESSION['store_products'])) $_SESSION['store_products'] = [];
if (!isset($_SESSION['store_orders'])) $_SESSION['store_orders'] = []; // Akan kita gunakan nanti

$storeName = $_SESSION['store_info']['name'];
$products = $_SESSION['store_products'];

// Logika untuk hapus produk
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    if (isset($_SESSION['store_products'][$productId])) {
        unset($_SESSION['store_products'][$productId]);
        header("Location: store_dashboard.php"); // Refresh halaman
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Toko</title>
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
                <a href="store_dashboard.php" class="list-group-item list-group-item-action active">Kelola Produk</a>
                <a href="manage_orders.php" class="list-group-item list-group-item-action">Kelola Pesanan</a>
            </div>
        </div>
        <div class="col-md-9">
            <h3>Produk Anda</h3>
            <a href="add_product.php" class="btn btn-primary mb-3">Tambah Produk Baru</a>
            <table class="table table-bordered">
                <thead>
                    <tr><th>Nama Produk</th><th>Harga</th><th>Kategori</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach($products as $id => $product): ?>
                        <tr>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td>Rp <?= number_format($product['price']) ?></td>
                            <td><?= htmlspecialchars($product['category']) ?></td>
                            <td>
                                <a href="edit_product.php?id=<?= $id ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="?action=delete&id=<?= $id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center">Anda belum menambahkan produk.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>