<?php
session_start();

$message = null;
$messageType = 'info';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    // Cek apakah email yang dimasukkan sama dengan email yang terdaftar di session
    if (isset($_SESSION['user_email']) && $email === $_SESSION['user_email']) {
        // Simulasi berhasil: Buat token dan password baru
        $reset_token = bin2hex(random_bytes(16)); // Membuat token acak
        $new_temp_password = 'passwordbaru123'; // Password baru sementara
        
        // Simpan token dan password baru ini di session untuk diverifikasi nanti
        $_SESSION['reset_token'] = $reset_token;
        $_SESSION['temp_password'] = $new_temp_password;
        
        $message = "<b>Simulasi Pengiriman Email Berhasil!</b><br>
                    Di aplikasi nyata, data ini akan dikirim ke email Anda. Untuk pengujian, silakan gunakan data di bawah ini di halaman reset password.<br><br>
                    <b>Token Reset:</b> " . $reset_token . "<br>
                    <b>Password Baru Sementara:</b> " . $new_temp_password;
        $messageType = 'success';
        
    } else {
        $message = "Email tidak ditemukan atau tidak terdaftar.";
        $messageType = 'danger';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Lupa Password</h2>
            <p>Masukkan alamat email Anda yang terdaftar. Kami akan mengirimkan instruksi untuk mereset password Anda.</p>
            
            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType; ?>"><?= $message; ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Instruksi</button>
                    </form>
                </div>
            </div>
            <div class="mt-3">
                <a href="login.php">&larr; Kembali ke halaman Login</a>
            </div>
        </div>
    </div>
</div>
</body>
</html>