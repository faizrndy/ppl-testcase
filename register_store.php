<?php
session_start();

if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Jika sudah punya toko, langsung ke dashboard toko
if (isset($_SESSION['is_seller']) && $_SESSION['is_seller'] === true) {
    header("Location: store_dashboard.php");
    exit;
}

$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $storeName = trim($_POST['store_name']);
    $storeDesc = trim($_POST['store_desc']);

    if (empty($storeName) || empty($storeDesc)) {
        $message = "Nama dan deskripsi toko wajib diisi!";
    } else {
        // Pendaftaran toko berhasil
        $_SESSION['is_seller'] = true;
        $_SESSION['store_info'] = ['name' => $storeName, 'description' => $storeDesc];
        header("Location: store_dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Buka Toko Gratis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h2>Buka Toko Gratis</h2>
                    <p class="mb-0">Mulai berjualan di GameStore sekarang juga!</p>
                </div>
                <div class="card-body p-4">
                    <?php if($message): ?>
                        <div class="alert alert-danger"><?= $message ?></div>
                    <?php endif; ?>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="store_name" class="form-label">Nama Toko</label>
                            <input type="text" id="store_name" name="store_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="store_desc" class="form-label">Deskripsi Singkat Toko</label>
                            <textarea id="store_desc" name="store_desc" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Buka Toko</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>