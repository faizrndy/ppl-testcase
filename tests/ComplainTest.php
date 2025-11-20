<?php // tests/ComplainTest.php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../functions.php';

class ComplainTest extends TestCase {
    private $transactionHistory = [
        0 => ['product_name' => 'Produk A', 'price' => 50000],
        1 => ['product_name' => 'Produk B', 'price' => 100000],
    ];

    public function test_pengguna_bisa_komplain_untuk_transaksi_yang_valid() {
        // ID transaksi 1 ada di riwayat
        $this->assertTrue(canUserComplain(1, $this->transactionHistory));
    }
    public function test_pengguna_tidak_bisa_komplain_untuk_transaksi_invalid() {
        // ID transaksi 99 tidak ada di riwayat
        $this->assertFalse(canUserComplain(99, $this->transactionHistory));
    }
}