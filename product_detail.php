<?php
session_start();

// Pengguna harus login untuk membeli
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Data dummy produk (seharusnya dari database)
$products = [
    ['id' => 1, 'name' => '100 Diamonds (Game A)', 'price' => 20000, 'category' => 'Top Up Game'],
    ['id' => 2, 'name' => 'Starlight Member (Game A)', 'price' => 150000, 'category' => 'Pembelian Item'],
    ['id' => 3, 'name' => '500 UC (Game B)', 'price' => 100000, 'category' => 'Top Up Game'],
    ['id' => 4, 'name' => 'Royal Pass (Game B)', 'price' => 120000, 'category' => 'Pembelian Item'],
    ['id' => 5, 'name' => 'Voucher Steam Rp 50.000', 'price' => 55000, 'category' => 'Voucher Digital'],
];

$productId = $_GET['id'] ?? null;
$product = null;

// Cari produk berdasarkan ID dari URL
foreach ($products as $p) {
    if ($p['id'] == $productId) {
        $product = $p;
        break;
    }
}

// Jika produk tidak ditemukan, kembali ke halaman produk
if (!$product) {
    header("Location: products.php");
    exit;
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simpan item yang mau dibeli ke session (sebagai keranjang belanja)
    $_SESSION['cart'] = [
        'product_id' => $product['id'],
        'product_name' => $product['name'],
        'price' => $product['price'],
        'game_user_id' => $_POST['game_user_id'] ?? 'N/A'
    ];
    header("Location: checkout.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <a href="products.php" class="btn btn-secondary mb-3">< Kembali</a>
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title"><?= htmlspecialchars($product['name']) ?></h2>
                    <h4 class="text-success fw-bold">Rp <?= number_format($product['price']) ?></h4>
                    <hr>
                    <form method="POST">
                        <?php if ($product['category'] === 'Top Up Game'): ?>
                        <div class="mb-3">
                            <label for="game_user_id" class="form-label">User ID Game</label>
                            <input type="text" id="game_user_id" name="game_user_id" class="form-control" placeholder="Masukkan User ID Anda" required>
                        </div>
                        <?php endif; ?>
                        <p class="text-muted">Pastikan data yang Anda masukkan sudah benar.</p>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-lg btn-primary">Lanjut ke Pembayaran</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>