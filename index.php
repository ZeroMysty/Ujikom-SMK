<?php
// Pengendali utama (front controller) website publik

// Inisialisasi sesi pengguna jika belum berjalan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Muat fungsi pembantu dan koneksi basis data
require_once __DIR__ . '/config/helpers.php';

// Validasi rute halaman yang diminta
$daftar_halaman_valid = ['beranda', 'profile_perusahaan', 'produk', 'artikel', 'galeri', 'kontak'];
$halaman = $_GET['halaman'] ?? 'beranda';
if (!in_array($halaman, $daftar_halaman_valid, true)) {
    $halaman = 'beranda';
}

// Pemetaan judul title tag untuk setiap halaman
$judul_halaman = [
    'beranda'            => 'Beranda',
    'profile_perusahaan' => 'Profil Perusahaan',
    'produk'             => 'Produk & Layanan',
    'artikel'            => 'Artikel',
    'galeri'             => 'Galeri',
    'kontak'             => 'Kontak',
][$halaman];

// Ambil data profil perusahaan untuk identitas navbar dan footer
$profil = ambil_profil();

// Proses pengiriman formulir pesan kontak via metode POST
if ($halaman === 'kontak' && ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    $nama    = trim($_POST['nama'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subjek  = trim($_POST['subjek'] ?? '');
    $isi     = trim($_POST['isi_pesan'] ?? '');

    if ($nama === '' || $email === '' || $isi === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        simpan_notifikasi('danger', 'Mohon lengkapi nama, email yang valid, dan isi pesan.');
    } else {
        $pernyataan = koneksi_db()->prepare('INSERT INTO pesan (nama, email, subjek, isi_pesan) VALUES (?, ?, ?, ?)');
        $pernyataan->execute([$nama, $email, $subjek, $isi]);
        simpan_notifikasi('success', 'Terima kasih! Pesan Anda sudah kami terima dan akan segera ditindaklanjuti.');
    }
    pindah_halaman('index.php?halaman=kontak');
}

// Pengambilan data spesifik sesuai halaman yang sedang aktif
$artikel_detail = null;
if ($halaman === 'produk') {
    // Ambil semua produk yang berstatus aktif
    $daftar_produk = koneksi_db()->query(
        'SELECT * FROM produk WHERE is_aktif = 1 ORDER BY created_at DESC'
    )->fetchAll();
} elseif ($halaman === 'artikel' && isset($_GET['d'])) {
    // Ambil detail satu artikel berdasarkan slug
    $pernyataan = koneksi_db()->prepare('SELECT * FROM artikel WHERE slug = ? AND is_publikasi = 1 LIMIT 1');
    $pernyataan->execute([$_GET['d']]);
    $artikel_detail = $pernyataan->fetch();
    if (!$artikel_detail) {
        http_response_code(404);
    }
    $judul_halaman = $artikel_detail ? $artikel_detail['judul'] : 'Artikel Tidak Ditemukan';
} elseif ($halaman === 'artikel') {
    // Ambil seluruh daftar artikel yang berstatus publik
    $daftar_artikel = koneksi_db()->query(
        'SELECT * FROM artikel WHERE is_publikasi = 1 ORDER BY created_at DESC'
    )->fetchAll();
} elseif ($halaman === 'galeri') {
    // Ambil seluruh foto dokumentasi galeri
    $daftar_galeri = koneksi_db()->query('SELECT * FROM galeri ORDER BY created_at DESC')->fetchAll();
} elseif ($halaman === 'beranda') {
    // Ambil data pratinjau produk dan artikel terbaru untuk beranda
    $pratinjau_produk  = koneksi_db()->query(
        'SELECT * FROM produk WHERE is_aktif = 1 ORDER BY created_at DESC LIMIT 3'
    )->fetchAll();
    $pratinjau_artikel = koneksi_db()->query(
        'SELECT * FROM artikel WHERE is_publikasi = 1 ORDER BY created_at DESC LIMIT 3'
    )->fetchAll();
    
    // Variabel kompatibilitas
    $produk_preview  = $pratinjau_produk;
    $artikel_preview = $pratinjau_artikel;
}

// Render struktur tata letak halaman publik
require __DIR__ . '/views/includes/header.php';
require __DIR__ . '/views/includes/navbar.php';
require __DIR__ . '/views/' . $halaman . '.php';
require __DIR__ . '/views/includes/footer.php';
