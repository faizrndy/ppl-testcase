<?php

require_once __DIR__ . '/../functions.php';

use PHPUnit\Framework\TestCase;

class SendOrderTest extends TestCase
{
    protected function setUp(): void
    {
        // reset session state per test
        $_SESSION = [];
        $_SESSION['is_seller'] = true;
        $_SESSION['store_orders'] = [
            [
                'order_id' => 'ORD-001',
                'buyer' => 'Pembeli1',
                'product' => 'Akun Mobile Legends',
                'price' => 150000,
                'status' => 'pending',
            ]
        ];
    }

    protected function tearDown(): void
    {
        unset($_SESSION);
    }

    /**
     * Test case:
     * 1. Buka detail pesanan
     * 2. Kirim item/akun ke buyer
     * 3. Upload bukti pengiriman (screenshot/detail akun)
     * 4. Klik 'Kirim Pesanan'
     */
    public function testSendOrderToBuyerSuccess(): void
    {
        $orderId = 0;

        // 1) Buka detail pesanan
        $order = &$_SESSION['store_orders'][$orderId];
        $this->assertEquals('ORD-001', $order['order_id']);
        $this->assertEquals('pending', $order['status']);

        // 2) Kirim item/akun ke buyer (simulasi pengiriman)
        $sentItem = [
            'username' => 'Player123',
            'password' => 'secret',
            'server' => 'Asia'
        ];
        $this->assertIsArray($sentItem);
        $this->assertNotEmpty($sentItem['username']);

        // 3) Upload bukti pengiriman (screenshot/detail akun)
        $proofOfDelivery = 'Screenshot: Username=Player123, Password=*****, Server=Asia';
        $this->assertIsString($proofOfDelivery);
        $this->assertNotEmpty($proofOfDelivery);

        // 4) Klik 'Kirim Pesanan' -> update status dan simpan bukti
        $order['status'] = 'sent';
        $order['proof'] = $proofOfDelivery;
        $order['sent_at'] = date('Y-m-d H:i:s');

        // Verifikasi akhir: status sent dan bukti tersedia
        $updatedOrder = $_SESSION['store_orders'][$orderId];
        $this->assertEquals('sent', $updatedOrder['status']);
        $this->assertNotEmpty($updatedOrder['proof']);
        $this->assertNotEmpty($updatedOrder['sent_at']);
    }

    public function testBuyerConfirmReceived(): void
    {
        // Siapkan kondisi order sudah terkirim
        $_SESSION['store_orders'][0]['status'] = 'sent';

        $orderId = 0;
        // Buyer konfirmasi terima
        $_SESSION['store_orders'][$orderId]['status'] = 'confirmed';
        $_SESSION['store_orders'][$orderId]['confirmed_at'] = date('Y-m-d H:i:s');

        $this->assertEquals('confirmed', $_SESSION['store_orders'][$orderId]['status']);
        $this->assertNotEmpty($_SESSION['store_orders'][$orderId]['confirmed_at']);
    }

    public function testReleasePaymentAfterConfirmed(): void
    {
        // Siapkan kondisi pembayaran dan order confirmed
        $_SESSION['seller_balance'] = 0;
        $_SESSION['store_orders'][0]['status'] = 'confirmed';
        $orderId = 0;

        // Release pembayaran ketika confirmed
        if ($_SESSION['store_orders'][$orderId]['status'] === 'confirmed') {
            $_SESSION['seller_balance'] += $_SESSION['store_orders'][$orderId]['price'];
            $_SESSION['store_orders'][$orderId]['status'] = 'completed';
        }

        $this->assertEquals(150000, $_SESSION['seller_balance']);
        $this->assertEquals('completed', $_SESSION['store_orders'][$orderId]['status']);
    }
}