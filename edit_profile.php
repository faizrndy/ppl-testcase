<?php
session_start();

// Hanya pengguna yang sudah login yang bisa mengakses halaman ini
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Inisialisasi pesan
$message = null;
$messageType = 'success';

// Ambil data pengguna dari session
$username = $_SESSION['user_username'] ?? '';
$email = $_SESSION['user_email'] ?? '';

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username']);
    
    // Validasi dasar
    if (empty($newUsername)) {
        $message = 'Username tidak boleh kosong!';
        $messageType = 'danger';
    } else {
        // Update username di session
        $_SESSION['user_username'] = $newUsername;
        
        // Update variabel username untuk ditampilkan langsung
        $username = $newUsername;
        
        $message = 'Profil berhasil diperbarui!';
        $messageType = 'success';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<?php 
// Kita akan gunakan file header terpisah nanti, untuk sekarang kita copy-paste navbarnya
// atau Anda bisa langsung ke halaman edit_profile.php setelah login
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="products.php">GameStore</a>
        <div>
            <a href="history.php" class="btn btn-outline-info me-2">Riwayat</a>
            <a href="register_store.php" class="btn btn-outline-warning me-2">Buka Toko</a>
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </div>
    </div>
</nav>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Edit Profil Anda</h2>

            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType; ?>"><?= htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" value="<?= htmlspecialchars($username); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($email); ?>" disabled readonly>
                            <div class="form-text">Email tidak dapat diubah.</div>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
             <div class="mt-3">
                <a href="products.php">&larr; Kembali ke halaman produk</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>