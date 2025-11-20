<?php
session_start();

if (!isset($_SESSION['is_logged_in'])) {
    header("Location: login.php");
    exit;
}

$trxId = $_GET['trx_id'] ?? null;
$transaction = $_SESSION['transaction_history'][$trxId] ?? null;

if ($transaction === null) {
    header("Location: history.php");
    exit;
}

$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulasi penyimpanan ulasan
    $message = "Terima kasih! Ulasan Anda telah kami simpan.";
    header("Refresh:2; url=history.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Beri Ulasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
             <div class="card">
                <div class="card-header">Beri Ulasan untuk Produk</div>
                <div class="card-body">
                    <?php if($message): ?>
                        <div class="alert alert-success"><?= $message ?></div>
                    <?php endif; ?>

                    <h5><?= htmlspecialchars($transaction['product_name']) ?></h5>
                    <p>Dibeli pada: <?= htmlspecialchars($transaction['date']) ?></p>
                    <hr>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Rating Anda</label>
                            <div>
                                <?php for ($i=1; $i <= 5; $i++): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="rating" id="rating<?= $i ?>" value="<?= $i ?>" required>
                                    <label class="form-check-label" for="rating<?= $i ?>"><?= $i ?> ★</label>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="review_text" class="form-label">Ulasan Anda</label>
                            <textarea name="review_text" id="review_text" rows="4" class="form-control" placeholder="Tulis pengalaman Anda..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                        <a href="history.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
             </div>
        </div>
    </div>
</div>
</body>
</html>