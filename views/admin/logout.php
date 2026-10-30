<?php
// Mulai sesi jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kosongkan seluruh data sesi
$_SESSION = [];

// Hapus cookie sesi pada browser jika aktif
if (ini_get('session.use_cookies')) {
    $parameter_kuki = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000, 
        $parameter_kuki['path'], 
        $parameter_kuki['domain'], 
        $parameter_kuki['secure'], 
        $parameter_kuki['httponly']
    );
}

// Hancurkan sesi di server
session_destroy();

// Alihkan kembali ke formulir login admin
require_once __DIR__ . '/../../config/helpers.php';
pindah_halaman('login.php');
