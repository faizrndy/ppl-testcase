<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../functions.php';

class TC01_RegistrasiValidTest extends TestCase
{
    public function test_registrasi_valid()
    {
        $data = [
            'username' => 'Ahmad Rizki',
            'email' => 'ahmad.rizki@email.com',
            'password' => 'Rizki123!',
            'confirm_password' => 'Rizki123!'
        ];

        $errors = validateRegistrationData($data);

        $this->assertEmpty($errors, "Registrasi seharusnya berhasil tanpa error.");
    }
}
