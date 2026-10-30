<?php

// Konfigurasi koneksi database (PDO).
// Standar bawaan XAMPP: host 127.0.0.1, nama pengguna 'root', tanpa kata sandi.

define('NAMA_HOST', '127.0.0.1');
define('NAMA_DB', 'db_companyprofile');
define('NAMA_PENGGUNA', 'root');
define('KATA_SANDI', '');

// Tetap sediakan konstanta lama jika ada yang memerlukan
define('DB_HOST', NAMA_HOST);
define('DB_NAME', NAMA_DB);
define('DB_USER', NAMA_PENGGUNA);
define('DB_PASS', KATA_SANDI);

function koneksi_db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . NAMA_HOST . ';dbname=' . NAMA_DB . ';charset=utf8mb4';
        try {
            $pdo = new PDO($dsn, NAMA_PENGGUNA, KATA_SANDI, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $pesanKesalahan) {
            http_response_code(500);
            exit('Koneksi database gagal: ' . htmlspecialchars($pesanKesalahan->getMessage()) .
                 '<br>Pastikan MySQL berjalan dan sudah mengimpor config/database.sql');
        }
    }

    return $pdo;
}

// Alias pendek untuk memanggil koneksi database
function db(): PDO
{
    return koneksi_db();
}
