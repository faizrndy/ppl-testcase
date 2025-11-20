<?php
// tests/RegistrationTest.php

use PHPUnit\Framework\TestCase;

// WAJIB: gunakan require_once supaya functions.php tidak dideklarasi ulang
require_once __DIR__ . '/../functions.php';

class RegistrationTest extends TestCase
{
    // Data valid untuk referensi
    private $validData = [
        'username' => 'testuser',
        'email' => 'test@example.com',
        'password' => 'password123',
        'confirm_password' => 'password123'
    ];

    public function test_pengguna_bisa_registrasi_dengan_data_valid()
    {
        $errors = validateRegistrationData($this->validData);
        $this->assertEmpty($errors);
    }

    public function test_registrasi_gagal_jika_username_kosong()
    {
        $data = $this->validData;
        $data['username'] = ''; 

        $errors = validateRegistrationData($data);
        $this->assertArrayHasKey('username', $errors);
    }

    public function test_registrasi_gagal_jika_username_mengandung_karakter_ilegal()
    {
        $data = $this->validData;
        $data['username'] = 'user spasi';

        $errors = validateRegistrationData($data);
        $this->assertArrayHasKey('username', $errors);
    }

    public function test_registrasi_gagal_jika_email_kosong()
    {
        $data = $this->validData;
        $data['email'] = '';

        $errors = validateRegistrationData($data);
        $this->assertArrayHasKey('email', $errors);
    }

    public function test_registrasi_gagal_jika_format_email_salah()
    {
        $data = $this->validData;
        $data['email'] = 'bukan-email';

        $errors = validateRegistrationData($data);
        $this->assertArrayHasKey('email', $errors);
    }

    public function test_registrasi_gagal_jika_password_kurang_dari_8_karakter()
    {
        $data = $this->validData;
        $data['password'] = '123';
        $data['confirm_password'] = '123';

        $errors = validateRegistrationData($data);
        $this->assertArrayHasKey('password', $errors);
    }

    public function test_registrasi_gagal_jika_konfirmasi_password_tidak_cocok()
    {
        $data = $this->validData;
        $data['confirm_password'] = 'password_salah';

        $errors = validateRegistrationData($data);
        $this->assertArrayHasKey('confirm_password', $errors);
    }
}
