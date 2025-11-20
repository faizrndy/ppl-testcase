<?php
// ================================
//  FUNGSI REGISTRASI
// ================================
if (!function_exists('validateRegistrationData')) {
    function validateRegistrationData(array $data) {
        $errors = [];
        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';
        $confirm_password = $data['confirm_password'] ?? '';

        if (empty($username)) {
            $errors['username'] = "Username wajib diisi!";
        }
        // perbaikan → izinkan huruf + spasi saja
        elseif (!preg_match('/^[a-zA-Z\s]+$/', $username)) {
            $errors['username'] = "Username hanya boleh berisi huruf dan spasi.";
        }
        

        if (empty($email)) $errors['email'] = "Email wajib diisi!";
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            $errors['email'] = "Format email tidak valid!";

        if (empty($password)) $errors['password'] = "Password wajib diisi!";
        elseif (strlen($password) < 8) 
            $errors['password'] = "Password minimal harus 8 karakter!";

        if ($password !== $confirm_password) 
            $errors['confirm_password'] = "Konfirmasi password tidak cocok.";

        return $errors;
    }
}


// ================================
//  FUNGSI LOGIN
// ================================
if (!function_exists('validateLogin')) {
    function validateLogin(string $email, string $password, ?array $registeredUser) {
        if (empty($email) || empty($password)) return "Email dan password wajib diisi.";
        if ($registeredUser === null) return "Akun tidak terdaftar.";

        $isEmailMatch = ($email === $registeredUser['email']);
        $isPasswordMatch = password_verify($password, $registeredUser['password']);

        if ($isEmailMatch && $isPasswordMatch) return true;
        return "Email atau password salah.";
    }
}


// ================================
//  FUNGSI PRODUK
// ================================
if (!function_exists('validateProductData')) {
    function validateProductData(array $data) {
        $errors = [];
        $name = $data['name'] ?? '';
        $price = $data['price'] ?? '';

        if (empty($name)) $errors['name'] = "Nama produk tidak boleh kosong.";
        if (empty($price)) $errors['price'] = "Harga tidak boleh kosong.";
        elseif (!is_numeric($price) || $price <= 0) 
            $errors['price'] = "Harga harus berupa angka positif.";

        return $errors;
    }
}


// ================================
//  FUNGSI EDIT PROFIL
// ================================
if (!function_exists('validateProfileUpdate')) {
    function validateProfileUpdate(string $username) {
        if (empty($username)) return "Username tidak boleh kosong.";
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) 
            return "Username hanya boleh berisi huruf, angka, dan underscore (_).";
        return true;
    }
}


// ================================
//  FUNGSI LUPA & RESET PASSWORD
// ================================
if (!function_exists('validateForgotPasswordRequest')) {
    function validateForgotPasswordRequest(string $inputEmail, ?string $registeredEmail) {
        return !empty($inputEmail) && $inputEmail === $registeredEmail;
    }
}

if (!function_exists('validatePasswordReset')) {
    function validatePasswordReset(string $inputToken, string $sessionToken, string $inputPassword, string $sessionPassword) {
        if (empty($inputToken) || empty($inputPassword)) return false;
        return $inputToken === $sessionToken && $inputPassword === $sessionPassword;
    }
}


// ================================
//  FUNGSI CHECKOUT
// ================================
if (!function_exists('applyPromoCode')) {
    function applyPromoCode(string $code, array $validCodes) {
        $upperCaseCode = strtoupper($code);
        return $validCodes[$upperCaseCode] ?? 0;
    }
}

if (!function_exists('processPayment')) {
    function processPayment(string $method, float $price, float $walletBalance) {
        if ($method === 'Dompetku') {
            return $walletBalance >= $price 
                ? ['success' => true]
                : ['success' => false, 'message' => 'Saldo Dompetku tidak mencukupi!'];
        }
        return ['success' => true]; // metode lain selalu berhasil
    }
}


// ================================
//  FUNGSI KOMPLAIN & REVIEW
// ================================
if (!function_exists('canUserComplain')) {
    function canUserComplain(int $transactionId, array $transactionHistory) {
        return isset($transactionHistory[$transactionId]);
    }
}

if (!function_exists('canUserReview')) {
    function canUserReview(?int $transactionId, array $transactionHistory) {
        return $transactionId !== null && isset($transactionHistory[$transactionId]);
    }
}


// ================================
//  FUNGSI VERIFIKASI EMAIL
// ================================
if (!function_exists('validateVerificationCode')) {
    function validateVerificationCode(string $inputCode, string $sessionCode) {
        return !empty($inputCode) && $inputCode === $sessionCode;
    }
}
