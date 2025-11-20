<?php
// tests/EmailVerificationTest.php

use PHPUnit\Framework\TestCase;

require __DIR__ . '/../functions.php';

class EmailVerificationTest extends TestCase
{
    private $correctCode = '123456';

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_verifikasi_berhasil_dengan_kode_yang_benar()
    {
        $result = validateVerificationCode('123456', $this->correctCode);
        $this->assertTrue($result);
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_verifikasi_gagal_dengan_kode_yang_salah()
    {
        $result = validateVerificationCode('654321', $this->correctCode);
        $this->assertFalse($result);
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_verifikasi_gagal_jika_kode_input_kosong()
    {
        $result = validateVerificationCode('', $this->correctCode);
        $this->assertFalse($result);
    }
}