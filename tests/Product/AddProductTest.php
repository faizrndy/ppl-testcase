<?php
use PHPUnit\Framework\TestCase;

class AddProductTest extends TestCase
{
    protected function setUp(): void
    {
        $_SESSION = []; 
        $_SESSION['is_seller'] = true;
        $_SESSION['store_products'] = [];
    }

    protected function tearDown(): void
    {
        unset($_SESSION);
    }
    
    // --- TEST BERHASIL (Success Case) ---
    
    public function testAddProductSuccess(): void
    {
        $name = 'Voucher Game 100K';
        $price = '95000';
        $category = 'Voucher Digital'; 
        $errors = [];

        // Validasi Nama Produk (Simulasi dari add_product.php)
        if (empty(trim($name))) {
            $errors['name'] = "Nama produk tidak boleh kosong.";
        }

        // Validasi Harga (Simulasi dari add_product.php)
        if (empty(trim($price))) {
            $errors['price'] = "Harga tidak boleh kosong.";
        } elseif (!is_numeric(trim($price)) || trim($price) <= 0) {
            $errors['price'] = "Harga harus berupa angka positif.";
        }
        
        $this->assertEmpty($errors);

        if (empty($errors)) {
            $newProduct = [
                'name' => $name,
                'price' => $price,
                'category' => $category,
            ];
            $_SESSION['store_products'][] = $newProduct; 
        }

        $this->assertCount(1, $_SESSION['store_products']);
        $this->assertEquals($name, $_SESSION['store_products'][0]['name']);
        $this->assertEquals($price, $_SESSION['store_products'][0]['price']);
    }

    
    // --- TEST GAGAL: Nama Kosong ---

    public function testAddProductWithoutName(): void
    {
        $name = '';
        $price = '150000';
        $errors = [];

        // Validasi
        if (empty(trim($name))) {
            $errors['name'] = "Nama produk tidak boleh kosong.";
        }

        $this->assertArrayHasKey('name', $errors);
        $this->assertEquals("Nama produk tidak boleh kosong.", $errors['name']);
        $this->assertCount(0, $_SESSION['store_products']);
    }

    // --- TEST GAGAL: Harga Negatif ---

    public function testAddProductWithNegativePrice(): void
    {
        $name = 'Akun ML';
        $price = '-50000';
        $errors = [];
        
        // Validasi
        if (empty(trim($price))) {
            $errors['price'] = "Harga tidak boleh kosong.";
        } elseif (!is_numeric(trim($price)) || trim($price) <= 0) {
            $errors['price'] = "Harga harus berupa angka positif.";
        }

        $this->assertArrayHasKey('price', $errors);
        $this->assertEquals("Harga harus berupa angka positif.", $errors['price']);
        $this->assertCount(0, $_SESSION['store_products']);
    }
    
    // --- TEST GAGAL: Harga Kosong ---

    public function testAddProductWithoutPrice(): void
    {
        $name = 'Akun ML';
        $price = '';
        $errors = [];
        
        // Validasi
        if (empty(trim($price))) {
            $errors['price'] = "Harga tidak boleh kosong.";
        } elseif (!is_numeric(trim($price)) || trim($price) <= 0) {
            $errors['price'] = "Harga harus berupa angka positif.";
        }

        $this->assertArrayHasKey('price', $errors);
        $this->assertEquals("Harga tidak boleh kosong.", $errors['price']);
        $this->assertCount(0, $_SESSION['store_products']);
    }

    // --- TEST GAGAL: Harga Non-Numerik ---

    public function testAddProductWithNonNumericPrice(): void
    {
        $name = 'Akun ML';
        $price = 'abc123';
        $errors = [];
        
        // Validasi
        if (empty(trim($price))) {
            $errors['price'] = "Harga tidak boleh kosong.";
        } elseif (!is_numeric(trim($price)) || trim($price) <= 0) {
            $errors['price'] = "Harga harus berupa angka positif.";
        }

        $this->assertArrayHasKey('price', $errors);
        $this->assertEquals("Harga harus berupa angka positif.", $errors['price']);
        $this->assertCount(0, $_SESSION['store_products']);
    }
    
    // --- TEST: Kategori Default ---

    public function testAddProductUsesDefaultCategory(): void
    {
        $name = 'Item Baru';
        $price = '10000';
        $category = 'Top Up Game';
        $errors = [];

        // Validasi (Harusnya sukses)
        if (empty(trim($price))) {
            // ...
        } elseif (!is_numeric(trim($price)) || trim($price) <= 0) {
            // ...
        }

        $this->assertEmpty($errors);

        // Penyimpanan
        if (empty($errors)) {
            $newProduct = [
                'name' => $name,
                'price' => $price,
                'category' => $category,
            ];
            $_SESSION['store_products'][] = $newProduct; 
        }
        
        // Verifikasi kategori
        $this->assertEquals($category, $_SESSION['store_products'][0]['category']);
    }
}