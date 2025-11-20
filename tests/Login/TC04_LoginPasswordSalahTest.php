<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../functions.php';

class TC04_LoginPasswordSalahTest extends TestCase
{
    public function test_login_password_salah()
    {
        // Mock data user yang terdaftar
        $registeredUser = [
            'email' => 'ahmad.rizki@email.com',
            'password' => password_hash('Rizki123!', PASSWORD_DEFAULT)
        ];

        // User memasukkan password salah
        $result = validateLogin(
            'ahmad.rizki@email.com',
            'salah123',
            $registeredUser
        );

        // validateLogin() mengembalikan string:
        // "Email atau password salah."
        $this->assertEquals(
            "Email atau password salah.",
            $result,
            "Harus muncul pesan error ketika password salah."
        );
    }
}
