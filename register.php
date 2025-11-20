<?php
session_start();
require 'functions.php'; 
// Menggunakan array untuk menampung semua kemungkinan error
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil semua data dari form
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // --- MULAI PROSES VALIDASI ---

    // 1. Validasi Username
    $usernameValidationResult = validateUsername($username);
if ($usernameValidationResult !== true) {
    $errors['username'] = $usernameValidationResult;
}

    // 2. Validasi Email
    if (empty($email)) {
        $errors['email'] = "Email wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Format email tidak valid!";
    }

    // 3. Validasi Password
    if (empty($password)) {
        $errors['password'] = "Password wajib diisi!";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password minimal harus 8 karakter!";
    }

    // 4. Validasi Konfirmasi Password
    if (empty($confirm_password)) {
        $errors['confirm_password'] = "Konfirmasi password wajib diisi!";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Konfirmasi password tidak cocok dengan password di atas.";
    }

    // --- AKHIR PROSES VALIDASI ---

    // Jika tidak ada error sama sekali, proses pendaftaran
    if (empty($errors)) {
        // Cek duplikasi email (logika tetap sama)
        if (isset($_SESSION['user_email']) && $_SESSION['user_email'] === $email) {
            $errors['email'] = "Email sudah terdaftar. Silakan gunakan email lain.";
        } else {
            // Pendaftaran Berhasil
            $_SESSION['user_username'] = $username;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_password'] = password_hash($password, PASSWORD_DEFAULT);
            
            header("Location: verify_email.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="h4 mb-0">Registrasi Akun Baru</h2>
                </div>
                <div class="card-body p-4">
                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($username ?? '') ?>" required>
                            <?php if(isset($errors['username'])): ?>
                                <div class="invalid-feedback"><?= $errors['username'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($email ?? '') ?>" required>
                            <?php if(isset($errors['email'])): ?>
                                <div class="invalid-feedback"><?= $errors['email'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" required>
                            <?php if(isset($errors['password'])): ?>
                                <div class="invalid-feedback"><?= $errors['password'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" required>
                            <?php if(isset($errors['confirm_password'])): ?>
                                <div class="invalid-feedback"><?= $errors['confirm_password'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>