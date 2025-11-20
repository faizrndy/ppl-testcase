<?php // tests/CheckoutTest.php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../functions.php';

class CheckoutTest extends TestCase {
    private $promoCodes = ['DISKON10K' => 10000, 'GAMERHEMAT' => 25000];

    public function test_kode_promo_valid_mengembalikan_diskon() {
        $discount = applyPromoCode('DISKON10K', $this->promoCodes);
        $this->assertEquals(10000, $discount);
    }
    public function test_kode_promo_tidak_valid_mengembalikan_nol() {
        $discount = applyPromoCode('PROMOSALAH', $this->promoCodes);
        $this->assertEquals(0, $discount);
    }
    public function test_pembayaran_dompetku_berhasil_jika_saldo_cukup() {
        $result = processPayment('Dompetku', 50000, 100000);
        $this->assertTrue($result['success']);
    }
    public function test_pembayaran_dompetku_gagal_jika_saldo_kurang() {
        $result = processPayment('Dompetku', 100000, 50000);
        $this->assertFalse($result['success']);
    }
}