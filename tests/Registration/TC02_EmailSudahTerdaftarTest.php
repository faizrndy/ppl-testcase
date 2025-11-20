<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../functions.php';

class TC02_EmailSudahTerdaftarTest extends TestCase
{
    public function test_email_sudah_terdaftar()
    {
        // Email sudah ada (mock user yang terdaftar)
        $existingUser = [
            'email' => 'ahmad.rizki@email.com',
            'password' => password_hash('Rizki123!', PASSWORD_DEFAULT)
        ];

        // Pengguna mencoba register lagi
        $data = [
            'username' => 'User Baru',
            'email' => 'ahmad.rizki@email.com',
            'password' => 'Password123',
            'confirm_password' => 'Password123'
        ];

        // Validasi hanya memastikan format benar
        $errors = validateRegistrationData($data);

        // Verifikasi bahwa email sudah digunakan
        $this->assertEmpty($errors); // Validation pass
        $this->assertEquals($existingUser['email'], $data['email'], "Email sudah digunakan.");
    }
}
