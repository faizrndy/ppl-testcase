<?php
session_start();

// Pengguna harus login dan punya item di keranjang
if (!isset($_SESSION['is_logged_in']) || !isset($_SESSION['cart'])) {
    header("Location: login.php");
    exit;
}

// Simulasi saldo dompet pengguna dan kode promo
if (!isset($_SESSION['wallet_balance'])) {
    $_SESSION['wallet_balance'] = 100000; // Saldo awal Rp 100.000
}
$promoCodes = ['DISKON10K' => 10000, 'GAMERHEMAT' => 25000]; // Kode promo => potongan harga

// Ambil detail item dari keranjang
$cart = $_SESSION['cart'];
$originalPrice = $cart['price'];
$discount = 0;
$finalPrice = $originalPrice;
$message = null;
$messageType = null;

// Logika untuk menangani form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- A. Logika untuk Terapkan Kode Promo ---
    if (isset($_POST['apply_promo'])) {
        $inputPromo = strtoupper(trim($_POST['promo_code']));
        if (array_key_exists($inputPromo, $promoCodes)) {
            $_SESSION['applied_promo'] = ['code' => $inputPromo, 'discount' => $promoCodes[$inputPromo]];
            $message = "Kode promo berhasil diterapkan!";
            $messageType = "success";
        } else {
            unset($_SESSION['applied_promo']);
            $message = "Kode promo tidak valid.";
            $messageType = "danger";
        }
    }

    // --- B. Logika untuk Proses Pembayaran ---
    if (isset($_POST['process_payment'])) {
        $paymentMethod = $_POST['payment_method'] ?? null;
        $currentFinalPrice = $_SESSION['applied_promo']['discount'] ?? 0;
        $finalPriceAfterPromo = $originalPrice - $currentFinalPrice;

        if ($paymentMethod === 'Dompetku') {
            if ($_SESSION['wallet_balance'] >= $finalPriceAfterPromo) {
                // Pembayaran dengan dompet berhasil
                $_SESSION['wallet_balance'] -= $finalPriceAfterPromo;
                // Pindahkan ke riwayat transaksi
                $_SESSION['transaction_history'][] = [
                    'product_name' => $cart['product_name'],
                    'price' => $finalPriceAfterPromo,
                    'date' => date('Y-m-d H:i:s'),
                    'status' => 'Selesai'
                ];
                unset($_SESSION['cart'], $_SESSION['applied_promo']);
                header("Location: payment_success.php");
                exit;
            } else {
                $message = "Saldo Dompetku tidak mencukupi!";
                $messageType = "danger";
            }
        } elseif ($paymentMethod) {
             // Pembayaran dengan metode lain (simulasi selalu berhasil)
             $_SESSION['transaction_history'][] = [
                'product_name' => $cart['product_name'],
                'price' => $finalPriceAfterPromo,
                'date' => date('Y-m-d H:i:s'),
                'status' => 'Selesai'
            ];
            unset($_SESSION['cart'], $_SESSION['applied_promo']);
            header("Location: payment_success.php");
            exit;
        } else {
            $message = "Silakan pilih metode pembayaran.";
            $messageType = "warning";
        }
    }
}

// Hitung ulang harga setelah promo (jika ada)
if (isset($_SESSION['applied_promo'])) {
    $discount = $_SESSION['applied_promo']['discount'];
    $finalPrice = $originalPrice - $discount;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h2>Checkout</h2>
            <?php if ($message): ?>
                <div class="alert alert-<?= $messageType; ?>"><?= htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <div class="card mb-4">
                <div class="card-header">Ringkasan Pesanan</div>
                <div class="card-body">
                    <h5><?= htmlspecialchars($cart['product_name']) ?></h5>
                    <p>Harga Asli: Rp <?= number_format($originalPrice) ?></p>
                    <?php if ($discount > 0): ?>
                    <p class="text-success">Diskon (<?= $_SESSION['applied_promo']['code'] ?>): - Rp <?= number_format($discount) ?></p>
                    <?php endif; ?>
                    <hr>
                    <h4 class="fw-bold">Total Bayar: Rp <?= number_format($finalPrice) ?></h4>
                </div>
            </div>

            <div class="card mb-4">
                 <div class="card-header">Kode Promo</div>
                 <div class="card-body">
                    <form method="POST">
                        <div class="input-group">
                            <input type="text" name="promo_code" class="form-control" placeholder="Masukkan kode promo">
                            <button type="submit" name="apply_promo" class="btn btn-secondary">Terapkan</button>
                        </div>
                    </form>
                 </div>
            </div>

            <div class="card">
                <div class="card-header">Pilih Metode Pembayaran</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="dompetku" value="Dompetku">
                            <label class="form-check-label" for="dompetku">
                                <strong>Dompetku</strong> (Saldo: Rp <?= number_format($_SESSION['wallet_balance']) ?>)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="va" value="Virtual Account">
                            <label class="form-check-label" for="va">Virtual Account</label>
                        </div>
                         <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="minimarket" value="Minimarket">
                            <label class="form-check-label" for="minimarket">Minimarket</label>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" name="process_payment" class="btn btn-lg btn-success">Bayar Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>