<?php
// tests/LoginTest.php

use PHPUnit\Framework\TestCase;

require __DIR__ . '/../functions.php';

class LoginTest extends TestCase
{
    private $registeredUser;

    protected function setUp(): void
    {
        $this->registeredUser = [
            'email' => 'user@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT)
        ];
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_login_berhasil_dengan_email_dan_password_yang_benar()
    {
        $result = validateLogin('user@example.com', 'password123', $this->registeredUser);
        $this->assertTrue($result);
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_login_gagal_dengan_password_yang_salah()
    {
        $result = validateLogin('user@example.com', 'password_salah', $this->registeredUser);
        $this->assertStringContainsString('salah', $result);
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_login_gagal_dengan_email_yang_tidak_terdaftar()
    {
        $result = validateLogin('tidakada@example.com', 'password123', $this->registeredUser);
        $this->assertStringContainsString('salah', $result);
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_login_gagal_jika_email_kosong()
    {
        $result = validateLogin('', 'password123', $this->registeredUser);
        $this->assertStringContainsString('wajib diisi', $result);
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_login_gagal_jika_password_kosong()
    {
        $result = validateLogin('user@example.com', '', $this->registeredUser);
        $this->assertStringContainsString('wajib diisi', $result);
    }
}