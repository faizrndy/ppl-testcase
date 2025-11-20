<?php
// tests/StoreTest.php

use PHPUnit\Framework\TestCase;

require __DIR__ . '/../functions.php';

class StoreTest extends TestCase
{
    // NAMA FUNGSI DIUBAH DI SINI
    public function test_registrasi_toko_berhasil_dengan_data_valid()
    {
        $data = ['store_name' => 'Toko Gaming Keren', 'store_desc' => 'Menjual semua kebutuhan game'];
        $errors = validateStoreRegistration($data);
        $this->assertEmpty($errors);
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_registrasi_toko_gagal_jika_nama_toko_kosong()
    {
        $data = ['store_name' => '', 'store_desc' => 'Deskripsi ada'];
        $errors = validateStoreRegistration($data);
        $this->assertArrayHasKey('store_name', $errors);
    }

    // NAMA FUNGSI DIUBAH DI SINI
    public function test_registrasi_toko_gagal_jika_deskripsi_kosong()
    {
        $data = ['store_name' => 'Toko Keren', 'store_desc' => ''];
        $errors = validateStoreRegistration($data);
        $this->assertArrayHasKey('store_desc', $errors);
    }
}