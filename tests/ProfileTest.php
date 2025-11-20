<?php // tests/ProfileTest.php
use PHPUnit\Framework\TestCase;
require __DIR__ . '/../functions.php';

class ProfileTest extends TestCase {
    public function test_update_profil_berhasil_dengan_username_valid() {
        $this->assertTrue(validateProfileUpdate('user_baru_123'));
    }
    public function test_update_profil_gagal_dengan_username_kosong() {
        $this->assertIsString(validateProfileUpdate(''));
    }
}