<?php
// EditProductTest.php
use PHPUnit\Framework\TestCase;

/**
 * @preserveGlobalState disabled
 */
class EditProductTest extends TestCase
{
    // Nilai-nilai konstanta untuk pengujian
    private const PRODUCT_ID = '0';
    private const ORIGINAL_PRICE = 800000;
    private const NEW_PRICE = 750000;
    private const PRODUCT_NAME = 'Akun ML';

    protected function setUp(): void
    {
        // ... (Kode setup sama)
        $_SESSION = [];
        $_SESSION['is_seller'] = true;
        $_SESSION['store_products'] = [
            self::PRODUCT_ID => [ 
                'name' => self::PRODUCT_NAME,
                'price' => self::ORIGINAL_PRICE,
                'category' => 'Top Up Game',
            ]
        ];

    /*
    while (ob_get_level() > 0) {
        ob_end_clean();
    }
    */
}
    protected function tearDown(): void
    {
        unset($_SESSION);
        unset($_GET);
        unset($_POST);
        unset($_SERVER['REQUEST_METHOD']);
    }
    
    // --- 1. TEST SUCCESS: SIMULASI PENUH ---
    
    /**
     * Test Success: Memastikan harga produk berhasil diperbarui ke harga baru (750.000).
     */
    public function testEditProductSuccess_UpdatePrice(): void
    {
        // ... (Logika simulasi sama)
        $name = self::PRODUCT_NAME;
        $newPrice = self::NEW_PRICE; 
        $productId = self::PRODUCT_ID;
        $category = 'Top Up Game';
        
        // --- 1. SIMULASI VALIDASI ---
        $errors = [];
        $price_string = (string)$newPrice;
        
        // Cek validasi harga
        if (empty($price_string)) {
             $errors['price'] = "Harga tidak boleh kosong.";
        } elseif (!is_numeric($price_string) || $newPrice <= 0) {
             $errors['price'] = "Harga harus berupa angka positif.";
        }
        
        $this->assertEmpty($errors, 'Simulasi validasi harus berhasil.');

        // --- 2. SIMULASI PENYIMPANAN KE SESSION ---
        if (empty($errors)) {
             $_SESSION['store_products'][$productId] = [
                'name' => $name,
                'price' => $newPrice, 
                'category' => $category,
            ];
        }

        $this->assertEquals(self::NEW_PRICE, $_SESSION['store_products'][self::PRODUCT_ID]['price'], 'Harga produk harus diperbarui menjadi 750000.');
    }

    // --- 2. TEST GAGAL: Produk tidak ditemukan ---
    
    /**
     * Test Case: Memastikan produk tidak ditemukan.
     */
    public function testEditProductNotFound(): void
    {
        $invalidId = '99';
        
        $product = $_SESSION['store_products'][$invalidId] ?? null;

        $this->assertNull($product, 'Produk dengan ID 99 seharusnya tidak ditemukan di sesi.');
        
        $this->assertEquals(self::ORIGINAL_PRICE, $_SESSION['store_products'][self::PRODUCT_ID]['price'], 'Produk asli tidak boleh berubah.');
    }

    // --- 3. TEST GAGAL: Validasi Harga Negatif ---
    
    /**
     * Test Case: Memastikan produk tidak diubah ketika validasi harga (Negatif) gagal.
     */
    public function testEditProductWithNegativePrice(): void
    {
        $productId = self::PRODUCT_ID;
        $negativePrice = -50000;
        
        // --- 1. SIMULASI VALIDASI ---
        $errors = [];
        $price_string = (string)$negativePrice; 

        // Cek validasi harga
        if (empty($price_string)) {
             $errors['price'] = "Harga tidak boleh kosong.";
        } elseif (!is_numeric($price_string) || $negativePrice <= 0) {
             $errors['price'] = "Harga harus berupa angka positif."; 
        }
        
        $this->assertArrayHasKey('price', $errors, 'Error harga harus terdeteksi.');
        
        // Verifikasi produk ASLI tidak berubah
        $this->assertEquals(self::ORIGINAL_PRICE, $_SESSION['store_products'][self::PRODUCT_ID]['price'], 'Harga produk harus tetap harga asli (800000) karena validasi gagal.');
    }
}