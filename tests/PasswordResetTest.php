<?php // tests/PasswordResetTest.php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../functions.php';

class PasswordResetTest extends TestCase {
    public function test_permintaan_lupa_password_berhasil() {
        $this->assertTrue(validateForgotPasswordRequest('test@example.com', 'test@example.com'));
    }
    public function test_permintaan_lupa_password_gagal() {
        $this->assertFalse(validateForgotPasswordRequest('salah@example.com', 'benar@example.com'));
    }
    public function test_reset_password_berhasil() {
        $this->assertTrue(validatePasswordReset('token123', 'token123', 'pass123', 'pass123'));
    }
    public function test_reset_password_gagal() {
        $this->assertFalse(validatePasswordReset('token_salah', 'token_benar', 'pass123', 'pass123'));
    }
}