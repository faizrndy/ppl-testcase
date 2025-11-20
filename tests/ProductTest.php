<?php // tests/ProductTest.php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../functions.php';

class ProductTest extends TestCase {
    public function test_validasi_produk_berhasil_dengan_data_benar() {
        $errors = validateProductData(['name' => 'Produk Keren', 'price' => 50000]);
        $this->assertEmpty($errors);
    }
    public function test_validasi_produk_gagal_jika_nama_kosong() {
        $errors = validateProductData(['name' => '', 'price' => 50000]);
        $this->assertArrayHasKey('name', $errors);
    }
    public function test_validasi_produk_gagal_jika_harga_bukan_angka() {
        $errors = validateProductData(['name' => 'Produk Keren', 'price' => 'gratis']);
        $this->assertArrayHasKey('price', $errors);
    }
}
