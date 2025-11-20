<?php
session_start();

// MENAMBAHKAN LEBIH BANYAK PRODUK MENGGUNAKAN NAMA FILE GAMBAR ANDA
$products = [
    // Top Up Game (menggunakan gambar diamond, dm, uc)
    ['id' => 1, 'name' => '100 Diamonds MLBB', 'price' => 20000, 'original_price' => 25000, 'category' => 'Top Up Game', 'image' => 'image/ML.png', 'seller' => 'Toko Cepat', 'rating' => 4.9, 'sold' => '2rb+'],
    ['id' => 3, 'name' => '500 UC PUBG', 'price' => 100000, 'category' => 'Top Up Game', 'image' => 'image/pubg.png', 'seller' => 'Raja Voucher', 'rating' => 4.8, 'sold' => '1rb+'],
    ['id' => 6, 'name' => '800 Genesis Crystal', 'price' => 210000, 'category' => 'Top Up Game', 'image' => 'image/genesis.png', 'seller' => 'Raja Voucher', 'rating' => 5.0, 'sold' => '500+'],
    ['id' => 7, 'name' => 'Weekly Diamond Pass Mobile Legends', 'price' => 28000, 'category' => 'Top Up Game', 'image' => 'image/ML.png', 'seller' => 'Toko Cepat', 'rating' => 4.9, 'sold' => '3rb+'],
    ['id' => 13, 'name' => '355 Diamonds FF', 'price' => 48000, 'category' => 'Top Up Game', 'image' => 'image/diamond.jpg', 'seller' => 'Gaming Store', 'rating' => 4.9, 'sold' => '5rb+'],
    ['id' => 14, 'name' => '1050 Valorant Points', 'price' => 99000, 'category' => 'Top Up Game', 'image' => 'image/dm.jpeg', 'seller' => 'Raja Voucher', 'rating' => 5.0, 'sold' => '900+'],

    // Voucher Digital (menggunakan gambar images.jpeg, images1.jpeg, dst.)
    ['id' => 5, 'name' => 'Voucher Steam Rp 50.000', 'price' => 55000, 'category' => 'Voucher Digital', 'image' => 'image/images.jpeg', 'seller' => 'Toko Cepat', 'rating' => 4.9, 'sold' => '1.5rb+'],
    ['id' => 8, 'name' => 'Google Play IDR 100.000', 'price' => 99000, 'original_price' => 110000, 'category' => 'Voucher Digital', 'image' => 'image/images1.jpeg', 'seller' => 'Gaming Store', 'rating' => 4.8, 'sold' => '900+'],
    ['id' => 9, 'name' => 'PSN Wallet IDR 200.000', 'price' => 205000, 'category' => 'Voucher Digital', 'image' => 'image/images2.jpeg', 'seller' => 'Raja Voucher', 'rating' => 5.0, 'sold' => '750+'],
    ['id' => 10, 'name' => 'Nintendo eShop $10', 'price' => 140000, 'category' => 'Voucher Digital', 'image' => 'image/images3.jpeg', 'seller' => 'Gaming Store', 'rating' => 4.7, 'sold' => '300+'],
    ['id' => 15, 'name' => 'Razer Gold USD 5', 'price' => 75000, 'category' => 'Voucher Digital', 'image' => 'image/images4.jpeg', 'seller' => 'Toko Cepat', 'rating' => 4.9, 'sold' => '1rb+'],
    ['id' => 16, 'name' => 'Xbox Gift Card $10', 'price' => 150000, 'category' => 'Voucher Digital', 'image' => 'image/images5.jpeg', 'seller' => 'Raja Voucher', 'rating' => 4.8, 'sold' => '400+'],

    // Akun Game (Kategori Baru)
    ['id' => 17, 'name' => 'Akun Blox Fruit Max Level', 'price' => 350000, 'category' => 'Akun Game', 'image' => 'image/images.jpeg', 'seller' => 'Sultan Akun', 'rating' => 5.0, 'sold' => '150+'],
    ['id' => 18, 'name' => 'Akun Genshin Impact AR 55', 'price' => 800000, 'original_price' => 1000000, 'category' => 'Akun Game', 'image' => 'image/dm2.jpeg', 'seller' => 'Akun GG', 'rating' => 4.9, 'sold' => '80+'],
    ['id' => 19, 'name' => 'Akun Clash of Clans TH 15', 'price' => 1200000, 'category' => 'Akun Game', 'image' => 'image/images1.jpeg', 'seller' => 'Sultan Akun', 'rating' => 5.0, 'sold' => '200+'],
    ['id' => 20, 'name' => 'Akun Valorant Plat II', 'price' => 250000, 'category' => 'Akun Game', 'image' => 'image/dm.jpeg', 'seller' => 'Akun GG', 'rating' => 4.7, 'sold' => '300+'],
];

// Memisahkan produk berdasarkan kategori
// INI BAGIAN YANG DIPERBAIKI
$topUpProducts = array_filter($products, function($p) {
    return $p['category'] === 'Top Up Game';
});
$voucherProducts = array_filter($products, function($p) {
    return $p['category'] === 'Voucher Digital';
});
$akunGameProducts = array_filter($products, function($p) {
    return $p['category'] === 'Akun Game';
});
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>itemku - Marketplace Game Terpercaya</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        :root { --itemku-blue: #0C198B; --itemku-yellow: #FFC90E; --itemku-body-bg: #F1F3F6; }
        body { background-color: var(--itemku-body-bg); font-family: 'Inter', sans-serif; }
        .navbar-main { background-color: var(--itemku-blue); }
        .product-card { border: none; border-radius: 12px; background-color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); transition: all 0.2s ease; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .product-card .card-img-top { border-radius: 12px 12px 0 0; aspect-ratio: 1/1; object-fit: cover; }
        .product-card .price { color: var(--itemku-blue); }
        .product-section-title { font-weight: 700; font-size: 1.5rem; margin-bottom: 1.5rem; }
        .carousel-container { display: flex; overflow-x: auto; scroll-behavior: smooth; padding-bottom: 1rem; scrollbar-width: none; }
        .carousel-container::-webkit-scrollbar { display: none; }
        .carousel-item-container { flex: 0 0 auto; width: 50%; }
        @media (min-width: 768px) { .carousel-item-container { width: 33.33%; } }
        @media (min-width: 992px) { .carousel-item-container { width: 25%; } }
        @media (min-width: 1200px) { .carousel-item-container { width: 20%; } }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-main py-2 sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold fs-4" href="products.php">itemku</a>
        <div class="collapse navbar-collapse">
            <form class="d-flex w-100 justify-content-center px-4" role="search"><div class="input-group" style="max-width: 600px;"><input class="form-control" type="search" placeholder="Coba cari game, item, atau voucher..."><button class="btn bg-white" type="submit"><i class="bi bi-search text-muted"></i></button></div></form>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center flex-nowrap">
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-envelope fs-5"></i></a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#"><i class="bi bi-cart fs-5"></i></a></li>
                <li class="nav-item"><a href="#" class="btn btn-warning fw-bold btn-sm mx-2" style="background-color: var(--itemku-yellow); border:none;">Mulai Jualan</a></li>
                <?php if(isset($_SESSION['is_logged_in'])): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-person-circle fs-4 me-2"></i><?= htmlspecialchars($_SESSION['user_username'] ?? 'Pengguna'); ?></a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <li><a class="dropdown-item" href="edit_profile.php">Edit Profil</a></li>
                        <li><a class="dropdown-item" href="history.php">Riwayat Transaksi</a></li>
                        <li><a class="dropdown-item" href="register_store.php">Buka Toko</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
                <?php else: ?>
                 <li class="nav-item"><a href="login.php" class="btn btn-outline-light btn-sm">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container mt-4">

    <section class="mt-4">
        <h2 class="product-section-title">Top Up Terpopuler</h2>
        <div class="carousel-wrapper">
            <div class="carousel-container">
                <?php foreach($topUpProducts as $product): ?>
                <div class="carousel-item-container p-2">
                    <div class="card product-card h-100">
                        <img src="<?= $product['image'] ?>" class="card-img-top" alt="...">
                        <div class="card-body d-flex flex-column">
                            <p class="seller-info text-muted mb-1 small"><i class="bi bi-shop"></i> <?= htmlspecialchars($product['seller']) ?></p>
                            <h5 class="card-title fs-6 flex-grow-1"><?= htmlspecialchars($product['name']) ?></h5>
                            <?php if(isset($product['original_price'])): ?><p class="text-muted small mb-0"><del>Rp <?= number_format($product['original_price']) ?></del></p><?php endif; ?>
                            <p class="fw-bold fs-5 price mb-2">Rp <?= number_format($product['price']) ?></p>
                            <a href="product_detail.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-buy w-100 mt-auto">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="mt-5">
        <h2 class="product-section-title">Voucher Pilihan</h2>
        <div class="carousel-wrapper">
            <div class="carousel-container">
                <?php foreach($voucherProducts as $product): ?>
                <div class="carousel-item-container p-2">
                    <div class="card product-card h-100">
                        <img src="<?= $product['image'] ?>" class="card-img-top" alt="...">
                        <div class="card-body d-flex flex-column">
                            <p class="seller-info text-muted mb-1 small"><i class="bi bi-shop"></i> <?= htmlspecialchars($product['seller']) ?></p>
                            <h5 class="card-title fs-6 flex-grow-1"><?= htmlspecialchars($product['name']) ?></h5>
                            <?php if(isset($product['original_price'])): ?><p class="text-muted small mb-0"><del>Rp <?= number_format($product['original_price']) ?></del></p><?php endif; ?>
                            <p class="fw-bold fs-5 price mb-2">Rp <?= number_format($product['price']) ?></p>
                            <a href="product_detail.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-buy w-100 mt-auto">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="mt-5">
        <h2 class="product-section-title">Akun Game Sultan</h2>
        <div class="carousel-wrapper">
            <div class="carousel-container">
                <?php foreach($akunGameProducts as $product): ?>
                <div class="carousel-item-container p-2">
                    <div class="card product-card h-100">
                        <img src="<?= $product['image'] ?>" class="card-img-top" alt="...">
                        <div class="card-body d-flex flex-column">
                            <p class="seller-info text-muted mb-1 small"><i class="bi bi-shop"></i> <?= htmlspecialchars($product['seller']) ?></p>
                            <h5 class="card-title fs-6 flex-grow-1"><?= htmlspecialchars($product['name']) ?></h5>
                            <?php if(isset($product['original_price'])): ?><p class="text-muted small mb-0"><del>Rp <?= number_format($product['original_price']) ?></del></p><?php endif; ?>
                            <p class="fw-bold fs-5 price mb-2">Rp <?= number_format($product['price']) ?></p>
                            <a href="product_detail.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-buy w-100 mt-auto">Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>