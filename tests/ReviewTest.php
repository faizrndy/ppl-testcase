<?php
// tests/ReviewTest.php

use PHPUnit\Framework\TestCase;

require __DIR__ . '/../functions.php';

class ReviewTest extends TestCase
{
    private $transactionHistory = [
        0 => ['product_name' => 'Produk A'],
        1 => ['product_name' => 'Produk B'],
    ];

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_pengguna_bisa_memberi_review_untuk_transaksi_yang_ada()
    {
        // ID transaksi 1 ada di dalam riwayat
        $this->assertTrue(canUserReview(1, $this->transactionHistory));
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_pengguna_tidak_bisa_memberi_review_untuk_transaksi_yang_tidak_ada()
    {
        // ID transaksi 99 tidak ada di dalam riwayat
        $this->assertFalse(canUserReview(99, $this->transactionHistory));
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_pengguna_tidak_bisa_memberi_review_jika_id_transaksi_null()
    {
        $this->assertFalse(canUserReview(null, $this->transactionHistory));
    }
}