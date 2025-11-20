<?php
session_start();

// Cek login dan parameter URL
if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit;
}

$trxId = $_GET['trx_id'] ?? null;
$transaction = $_SESSION['transaction_history'][$trxId] ?? null;

// Jika transaksi tidak valid, kembalikan ke riwayat
if ($transaction === null) {
    header("Location: history.php");
    exit;
}

$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulasi pengiriman komplain
    $message = "Komplain Anda telah kami terima dan akan segera diproses. Tim kami akan menghubungi Anda.";
    header("Refresh:3; url=history.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Ajukan Komplain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <h2 class="mb-3">Ajukan Komplain</h2>

            <div class="alert alert-info">
                🛡️ **Jaminan Safe Trading:** Semua transaksi di GameStore dilindungi. Dana Anda aman hingga transaksi dinyatakan selesai.
            </div>

            <?php if($message): ?>
                <div class="alert alert-success"><?= $message ?></div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">Detail Transaksi</div>
                <div class="card-body">
                    <h5>Produk: <?= htmlspecialchars($transaction['product_name']) ?></h5>
                    <p>Tanggal: <?= htmlspecialchars($transaction['date']) ?></p>
                    <hr>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori Komplain</label>
                            <select name="category" id="category" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option>Produk belum diterima</option>
                                <option>Produk tidak sesuai deskripsi</option>
                                <option>Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="details" class="form-label">Jelaskan Masalah Anda</label>
                            <textarea name="details" id="details" rows="5" class="form-control" placeholder="Berikan detail masalah agar kami dapat membantu lebih cepat." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger">Kirim Komplain</button>
                        <a href="history.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>