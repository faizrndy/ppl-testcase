<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../functions.php';

class TC05_VerifikasiEmailTest extends TestCase
{
    public function test_verifikasi_email_berhasil()
    {
        $sessionCode = "123456"; // kode verifikasi yang benar
        $inputCode = "123456";   // user klik link verifikasi

        $result = validateVerificationCode($inputCode, $sessionCode);

        $this->assertTrue($result, "Email harus terverifikasi.");
    }
}
