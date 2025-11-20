<?php

use PHPUnit\Framework\TestCase;

class ManageOrderTest extends TestCase
{
    protected function setUp(): void
    {
        $_SESSION['is_seller'] = true;
        $_SESSION['store_orders'] = [];
    }

    /**
     * C. Test Kelola Pesanan
     * 1. Login ke Tokoku
     * 2. Notifikasi pesanan baru muncul
     * 3. Cek detail pesanan
     */
    public function testManageOrderSuccess(): void
    {
        // Step 1: Login sebagai seller
        $this->assertTrue($_SESSION['is_seller']);

        // Step 2: Simulasi pesanan baru
        $newOrder = [
            'order_id' => 'ORD-001',
            'buyer' => 'Pembeli1',
            'product' => 'Akun Mobile Legends',
            'price' => 150000,
            'status' => 'pending',
        ];

        $_SESSION['store_orders'][] = $newOrder;

        // Step 3: Cek detail pesanan
        $this->assertCount(1, $_SESSION['store_orders']);
        $order = $_SESSION['store_orders'][0];
        $this->assertEquals('ORD-001', $order['order_id']);
        $this->assertEquals('pending', $order['status']);
        $this->assertEquals(150000, $order['price']);
    }

    public function testMultipleOrders(): void
    {
        $_SESSION['store_orders'] = [
            [
                'order_id' => 'ORD-001',
                'buyer' => 'Pembeli1',
                'product' => 'Akun ML',
                'price' => 150000,
                'status' => 'pending',
            ],
            [
                'order_id' => 'ORD-002',
                'buyer' => 'Pembeli2',
                'product' => 'Akun FF',
                'price' => 100000,
                'status' => 'pending',
            ]
        ];

        $this->assertCount(2, $_SESSION['store_orders']);
    }
}