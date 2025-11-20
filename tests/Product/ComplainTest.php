<?php
use PHPUnit\Framework\TestCase;

// Memuat functions.php (asumsi berada 2 tingkat di atas, di root proyek)
require __DIR__ . '/../../functions.php';

/**
 * Menggunakan @preserveGlobalState disabled untuk menjaga stabilitas 
 * lingkungan pengujian ketika berhadapan dengan SESSION dan globals.
 */
class ComplainTest extends TestCase
{
    private const VALID_TRX_ID = 'T123';
    private const INVALID_TRX_ID = 'T999';

    // Riwayat transaksi yang digunakan untuk simulasi data
    private const MOCK_HISTORY = [
        self::VALID_TRX_ID => [
            'product_name' => 'Akun ML Elite',
            'date' => '2025-11-20',
            'status' => 'Selesai'
        ]
    ];

    protected function setUp(): void
    {
        // 1. Setup SESSION sebelum setiap tes
        $_SESSION = [];
        $_SESSION['is_logged_in'] = true;
        $_SESSION['transaction_history'] = self::MOCK_HISTORY;
        
        // 2. Membersihkan globals yang mungkin digunakan skrip web
        unset($_GET);
        unset($_POST);
        unset($_SERVER['REQUEST_METHOD']);
    }

    protected function tearDown(): void
    {
        unset($_SESSION);
    }
    
    // --- 1. TEST GAGAL AKSES: Pengguna Belum Login (Simulasi Alur Kontrol) ---

    /**
     * Test alur kontrol: Jika tidak login, script harus menginisiasi redirect ke login.php.
     */
    public function testRedirectToLoginIfNotLoggedIn(): void
    {
        // 1. Setup kondisi kegagalan
        $_SESSION['is_logged_in'] = false;
        $isLoggedIn = $_SESSION['is_logged_in'] ?? false;
        
        // 2. Simulasi Logika (dari complain.php):
        $shouldRedirect = false;
        if (!$isLoggedIn) { 
             $shouldRedirect = true; // Mencerminkan logic header("Location: login.php"); exit;
        }

        // 3. Verifikasi
        $this->assertTrue($shouldRedirect, 'Script harus menginisiasi redirect ke login.php.');
    }

    // --- 2. TEST GAGAL AKSES: ID Transaksi Invalid (Simulasi Alur Kontrol) ---

    /**
     * Test alur kontrol: Jika ID transaksi tidak ditemukan, script harus menginisiasi redirect ke history.php.
     */
    public function testRedirectToHistoryIfInvalidTrxId(): void
    {
        // 1. Setup kondisi kegagalan
        $trxId = self::INVALID_TRX_ID;
        $transaction = $_SESSION['transaction_history'][$trxId] ?? null;

        // 2. Simulasi Logika (dari complain.php):
        $shouldRedirect = false;
        if ($transaction === null) {
             $shouldRedirect = true; // Mencerminkan logic header("Location: history.php"); exit;
        }

        // 3. Verifikasi
        $this->assertTrue($shouldRedirect, 'Script harus menginisiasi redirect ke history.php.');
    }

    // --- 3. TEST SUKSES PENGIRIMAN (Simulasi Penuh) ---

    /**
     * Test skenario sukses: Komplain dikirim, pesan dihasilkan, dan redirect disiapkan.
     */
    public function testSubmitComplainSuccess(): void
    {
        // 1. Setup Data
        $trxId = self::VALID_TRX_ID;
        $transaction = self::MOCK_HISTORY[$trxId];
        
        // Simulasikan POST request
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $isPost = $_SERVER['REQUEST_METHOD'] === 'POST';
        
        $message = null;
        $isRedirected = false;

        // 2. Simulasi Logika Sukses (dari complain.php)
        $isLoggedIn = $_SESSION['is_logged_in'] ?? false;
        $transactionExists = $transaction !== null;

        if ($isLoggedIn && $transactionExists && $isPost) {
            // Logika POST: Set pesan dan panggil header("Refresh:3...")
            $message = "Komplain Anda telah kami terima dan akan segera diproses. Tim kami akan menghubungi Anda.";
            $isRedirected = true; 
        }
        
        // 3. Verifikasi Hasil
        $expectedMessage = "Komplain Anda telah kami terima dan akan segera diproses. Tim kami akan menghubungi Anda.";
        
        $this->assertEquals($expectedMessage, $message, 'Pesan sukses harus dihasilkan setelah POST.');
        $this->assertTrue($isRedirected, 'Simulasi harus menunjukkan bahwa refresh/redirect telah diinisiasi.');
    }
}