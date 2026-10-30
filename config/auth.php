<?php

// Pelindung sesi admin. Dipanggil di awal setiap halaman admin (kecuali login).
// Mengalihkan ke halaman masuk (login) dengan memperhitungkan kedalaman folder halaman.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/helpers.php';

if (empty($_SESSION['admin_id'])) {
    $folder_skrip = str_replace('\\', '/', rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '.'), '/'));
    $awalan       = preg_match('~/(produk|artikel|galeri|profile|pesan)$~', $folder_skrip) ? '../' : '';
    pindah_halaman($awalan . 'login.php');
}
