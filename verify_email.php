<?php
session_start();

// Jika pengguna belum melakukan registrasi, arahkan kembali
if (!isset($_SESSION['user_email'])) {
    header("Location: register.php");
    exit;
}

// Simulasi: Buat kode verifikasi dan simpan di session
// Dalam aplikasi nyata, kode ini dikirim ke email pengguna
if (!isset($_SESSION['verification_code'])) {
    $_SESSION['verification_code'] = rand(100000, 999999);
}

$message = "Kami telah 'mengirim' kode verifikasi ke " . $_SESSION['user_email'] . ". Silakan cek dan masukkan di bawah. Kode: <strong>" . $_SESSION['verification_code'] . "</strong>";
$messageType = "info";

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputCode = $_POST['code'] ?? '';

    if ($inputCode == $_SESSION['verification_code']) {
        // Verifikasi berhasil
        $_SESSION['is_verified'] = true;
        unset($_SESSION['verification_code']); // Hapus kode setelah berhasil
        $message = "Email berhasil diverifikasi! Anda akan diarahkan ke halaman Login.";
        $messageType = "success";
        header("Refresh:3; url=login.php");
    } else {
        // Verifikasi gagal
        $message = "Kode verifikasi salah. Silakan coba lagi.";
        $messageType = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TC-03 Verifikasi Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h2 class="h4 mb-0">Verifikasi Email Anda</h2>
                </div>
                <div class="card-body p-4">
                    <?php if ($message): ?>
                        <div class="alert alert-<?= $messageType; ?>">
                            <?= $message; // Pesan ini bisa berisi HTML, jadi tidak pakai htmlspecialchars ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="code" class="form-label">Kode Verifikasi (6 digit)</label>
                            <input type="text" id="code" name="code" class="form-control" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Verifikasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>