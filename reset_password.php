<?php
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['token']);
    $new_password = trim($_POST['new_password']);

    // Validasi input kosong
    if (empty($token)) {
        $errors['token'] = "Token Reset wajib diisi.";
    }
    if (empty($new_password)) {
        $errors['new_password'] = "Password Baru Sementara wajib diisi.";
    }

    if (empty($errors)) {
        if (isset($_SESSION['reset_token']) && isset($_SESSION['temp_password'])) {
            if ($token === $_SESSION['reset_token'] && $new_password === $_SESSION['temp_password']) {
                $_SESSION['user_password'] = password_hash($new_password, PASSWORD_DEFAULT);
                unset($_SESSION['reset_token'], $_SESSION['temp_password']);
                
                // Set pesan sukses untuk ditampilkan setelah redirect
                $_SESSION['success_message'] = 'Password Anda telah berhasil direset! Silakan login.';
                header("Location: login.php");
                exit;

            } else {
                $errors['form'] = 'Token atau password sementara salah!';
            }
        } else {
            $errors['form'] = 'Proses reset tidak valid atau sudah kedaluwarsa.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Reset Password Anda</h2>

            <?php if (isset($errors['form'])): ?>
                <div class="alert alert-danger"><?= $errors['form']; ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label for="token" class="form-label">Token Reset</label>
                            <input type="text" id="token" name="token" class="form-control <?= isset($errors['token']) ? 'is-invalid' : '' ?>" placeholder="Tempel token dari 'email' Anda" required>
                             <?php if(isset($errors['token'])): ?>
                                <div class="invalid-feedback"><?= $errors['token'] ?></div>
                            <?php endif; ?>
                        </div>
                         <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru Sementara</label>
                            <input type="text" id="new_password" name="new_password" class="form-control <?= isset($errors['new_password']) ? 'is-invalid' : '' ?>" placeholder="Masukkan password baru dari 'email'" required>
                             <?php if(isset($errors['new_password'])): ?>
                                <div class="invalid-feedback"><?= $errors['new_password'] ?></div>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>