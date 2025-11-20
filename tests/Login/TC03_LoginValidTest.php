<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../functions.php';

class TC03_LoginValidTest extends TestCase
{
    public function test_login_valid()
    {
        $registeredUser = [
            'email' => 'ahmad.rizki@email.com',
            'password' => password_hash('Rizki123!', PASSWORD_DEFAULT)
        ];

        $result = validateLogin('ahmad.rizki@email.com', 'Rizki123!', $registeredUser);

        $this->assertTrue($result, "Login harus berhasil.");
    }
}
