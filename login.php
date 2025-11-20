<?php
session_start();

if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
    header("Location: products.php");
    exit;
}

// Menggunakan array untuk menampung error
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi input kosong
    if (empty($email)) {
        $errors['email'] = "Email wajib diisi!";
    }
    if (empty($password)) {
        $errors['password'] = "Password wajib diisi!";
    }

    // Jika tidak ada error validasi, lanjutkan proses login
    if (empty($errors)) {
        if (!isset($_SESSION['user_email'])) {
            $errors['form'] = "Tidak ada akun terdaftar. Silakan registrasi terlebih dahulu.";
        } else {
            $isEmailMatch = ($_SESSION['user_email'] === $email);
            $isPasswordMatch = password_verify($password, $_SESSION['user_password']);

            if ($isEmailMatch && $isPasswordMatch) {
                $_SESSION['is_logged_in'] = true;
                header("Location: products.php");
                exit;
            } else {
                $errors['form'] = "Email atau password salah!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">
                    <h2 class="h4 mb-0">Login ke Akun Anda</h2>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($errors['form'])): ?>
                        <div class="alert alert-danger"><?= $errors['form']; ?></div>
                    <?php endif; ?>

                    <form method="POST" novalidate>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" required>
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
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Login</button>
                        </div>
                    </form>
                     <div class="text-center mt-3">
                        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                        <a href="forgot_password.php">Lupa Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>