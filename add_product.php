<?php
session_start();
if (!isset($_SESSION['is_seller'])) { header("Location: login.php"); exit; }

$errors = [];
$name = '';
$price = '';
$category = 'Top Up Game'; // Default value

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $price = trim($_POST['price']);
    $category = $_POST['category'];

    // Validasi Nama Produk
    if (empty($name)) {
        $errors['name'] = "Nama produk tidak boleh kosong.";
    }

    // Validasi Harga
    if (empty($price)) {
        $errors['price'] = "Harga tidak boleh kosong.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors['price'] = "Harga harus berupa angka positif.";
    }

    // Jika tidak ada error, simpan produk
    if (empty($errors)) {
        $newProduct = [
            'name' => $name,
            'price' => $price,
            'category' => $category,
            // (Kita bisa tambahkan detail lain di sini nanti)
        ];
        $_SESSION['store_products'][] = $newProduct;
        header("Location: store_dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
<div class="container card p-4">
    <h3>Tambah Produk Baru</h3>
    <form method="POST" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" id="name" name="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($name) ?>" required>
            <?php if(isset($errors['name'])): ?>
                <div class="invalid-feedback"><?= $errors['name'] ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="text" id="price" name="price" class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($price) ?>" required>
            <?php if(isset($errors['price'])): ?>
                <div class="invalid-feedback"><?= $errors['price'] ?></div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Kategori</label>
             <select name="category" class="form-select">
                <option <?= $category == 'Top Up Game' ? 'selected' : '' ?>>Top Up Game</option>
                <option <?= $category == 'Pembelian Item' ? 'selected' : '' ?>>Pembelian Item</option>
                <option <?= $category == 'Voucher Digital' ? 'selected' : '' ?>>Voucher Digital</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Produk</button>
        <a href="store_dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>