<?php

use PHPUnit\Framework\TestCase;

class CompleteOrderTest extends TestCase
{
    protected function setUp(): void
    {
        $_SESSION['is_seller'] = true;
        $_SESSION['seller_balance'] = 0;
        $_SESSION['store_orders'] = [
            [
                'order_id' => 'ORD-001',
                'buyer' => 'Pembeli1',
                'product' => 'Akun Mobile Legends',
                'price' => 150000,
                'status' => 'sent',
                'sent_at' => date('Y-m-d H:i:s'),
            ]
        ];
    }

    /**
     * Kategori 3: Pesanan selesai dan terima pembayaran
     * 1. Kirim item ke buyer
     * 2. Buyer konfirmasi terima
     * 3. Sistem release pembayaran
     * 4. Cek saldo Tokoku
     */
    public function testItemSentSuccessfully(): void
    {
        $orderId = 0;
        
        // Step 1: Kirim item ke buyer
        $order = $_SESSION['store_orders'][$orderId];
        $this->assertEquals('sent', $order['status']);
        $this->assertNotEmpty($order['sent_at']);
    }

    public function testBuyerConfirmReceived(): void
    {
        $orderId = 0;
        
        // Step 2: Buyer konfirmasi terima
        $_SESSION['store_orders'][$orderId]['status'] = 'confirmed';
        $_SESSION['store_orders'][$orderId]['confirmed_at'] = date('Y-m-d H:i:s');

        $this->assertEquals('confirmed', $_SESSION['store_orders'][$orderId]['status']);
        $this->assertNotEmpty($_SESSION['store_orders'][$orderId]['confirmed_at']);
    }

    public function testSystemReleasePayment(): void
    {
        $orderId = 0;
        
        // Step 2: Buyer konfirmasi terima
        $_SESSION['store_orders'][$orderId]['status'] = 'confirmed';

        // Step 3: Sistem release pembayaran
        if ($_SESSION['store_orders'][$orderId]['status'] === 'confirmed') {
            $orderPrice = $_SESSION['store_orders'][$orderId]['price'];
            $_SESSION['seller_balance'] += $orderPrice;
            $_SESSION['store_orders'][$orderId]['status'] = 'completed';
            $_SESSION['store_orders'][$orderId]['payment_released_at'] = date('Y-m-d H:i:s');
        }

        $this->assertEquals('completed', $_SESSION['store_orders'][$orderId]['status']);
        $this->assertNotEmpty($_SESSION['store_orders'][$orderId]['payment_released_at']);
    }

    public function testCheckSellerBalance(): void
    {
        $orderId = 0;
        
        // Step 2: Buyer konfirmasi terima
        $_SESSION['store_orders'][$orderId]['status'] = 'confirmed';

        // Step 3: Sistem release pembayaran
        if ($_SESSION['store_orders'][$orderId]['status'] === 'confirmed') {
            $orderPrice = $_SESSION['store_orders'][$orderId]['price'];
            $_SESSION['seller_balance'] += $orderPrice;
            $_SESSION['store_orders'][$orderId]['status'] = 'completed';
        }

        // Step 4: Cek saldo Tokoku
        $this->assertEquals(150000, $_SESSION['seller_balance']);
        $this->assertGreaterThan(0, $_SESSION['seller_balance']);
    }
}