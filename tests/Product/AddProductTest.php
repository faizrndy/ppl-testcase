<?php
use PHPUnit\Framework\TestCase;

// Memuat definisi fungsi validasi dari functions.php
require_once __DIR__ . '/../functions.php'; 

class AddProductTest extends TestCase
{
    protected function setUp(): void
    {
        // Setup SESSION sebelum setiap tes
        $_SESSION = []; 
        $_SESSION['is_seller'] = true; // Simulasikan status login seller
        $_SESSION['store_products'] = [];
    }

    protected function tearDown(): void
    {
        // Bersihkan data SESSION setelah tes
        unset($_SESSION);
    }
    
    // ==========================================================
    // ** FUNGSI INI SESUAI DENGAN DATA UJI**
    // ==========================================================
    
    public function testAddProductSuccess(): void
    {
        // Data input berdasarkan
        $name = 'Akun ML Mythic 5000 Matches';
        $price = '800000'; // Sesuai Rp800.000
        $category = 'Top Up Game'; // Kategori default dari form add_product.php
        $stock = 1; // Sesuai Stok: 1
        $description = 'Deskripsi Akun (simulasi)'; // Deskripsi (diperlukan simulasi)

        $postData = ['name' => $name, 'price' => $price];

        // 1. Validasi Input (menggunakan functions.php)
        $errors = validateProductData($postData);

        // Verifikasi: Harus berhasil melewati validasi
        $this->assertEmpty($errors, 'Produk valid harus melewati validasi.');

        // 2. Simulasi Penyimpanan ke SESSION
        if (empty($errors)) {
            $newProduct = [
                'name' => $name,
                'price' => $price,
                'category' => $category, 
                'stock' => $stock,       // Data Stok diverifikasi
                'description' => $description, 
            ];
            $_SESSION['store_products'][] = $newProduct; 
        }

        // 3. Verifikasi Hasil 
        $this->assertCount(1, $_SESSION['store_products'], 'Harus ada satu produk tersimpan.');
        $product = $_SESSION['store_products'][0];

        // Verifikasi detail: Nama, Harga, dan Stok harus sesuai data uji
        $this->assertEquals($name, $product['name'], 'Nama produk harus sesuai ');
        $this->assertEquals($price, $product['price'], 'Harga produk harus sesuai (800000).');
        $this->assertEquals($stock, $product['stock'], 'Stok produk harus sesuai  (1).');
        // Verifikasi Kategori
        $this->assertEquals('Top Up Game', $product['category'], 'Kategori harus terisi.');
    }

    
    // --- 2. TEST GAGAL (Validation Failure Cases) ---

    public function testAddProductWithoutName(): void
    {
        $postData = ['name' => '', 'price' => '150000'];
        $errors = validateProductData($postData);
        $this->assertArrayHasKey('name', $errors);
        $this->assertCount(0, $_SESSION['store_products']);
    }

    public function testAddProductWithNegativePrice(): void
    {
        $postData = ['name' => 'Akun ML', 'price' => '-50000'];
        $errors = validateProductData($postData);
        $this->assertArrayHasKey('price', $errors);
        $this->assertCount(0, $_SESSION['store_products']);
    }
    
    public function testAddProductWithoutPrice(): void
    {
        $postData = ['name' => 'Akun ML', 'price' => ''];
        $errors = validateProductData($postData);
        $this->assertArrayHasKey('price', $errors);
        $this->assertCount(0, $_SESSION['store_products']);
    }

    public function testAddProductWithNonNumericPrice(): void
    {
        $postData = ['name' => 'Akun ML', 'price' => 'abc123'];
        $errors = validateProductData($postData);
        $this->assertArrayHasKey('price', $errors);
        $this->assertCount(0, $_SESSION['store_products']);
    }
    
    // --- 3. TEST MULTIPLE PRODUCTS ---

    public function testAddMultipleProducts(): void
    {
        $products = [
            ['name' => 'Akun ML Mythic', 'price' => '150000', 'category' => 'Top Up Game'],
            ['name' => 'Voucher Playstore 100K', 'price' => '100000', 'category' => 'Voucher Digital'],
        ];

        foreach ($products as $product) {
            $errors = validateProductData($product);
            $this->assertEmpty($errors);
            if (empty($errors)) {
                 $_SESSION['store_products'][] = $product;
            }
        }
        
        $this->assertCount(2, $_SESSION['store_products']);
    }
}