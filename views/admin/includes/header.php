<?php
// Inisialisasi dan autentikasi admin
require_once __DIR__ . '/../../../config/auth.php';

$nama_admin = $_SESSION['admin_nama'] ?? 'Administrator';

// Penentuan basis URL relatif berdasarkan posisi file modul
$folder_skrip     = str_replace('\\', '/', rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '.'), '/'));
$di_dalam_modul   = (bool) preg_match('~/(produk|artikel|galeri|profile|pesan)$~', $folder_skrip);
$basis_admin      = $di_dalam_modul ? '../' : '';
$basis_utama      = $basis_admin . '../../';

$admin_base = $basis_admin;
$root_base  = $basis_utama;

$adalah_dashboard = basename($_SERVER['SCRIPT_NAME'] ?? '') === 'dashboard.php';
$cek_modul = static function (string $nama_modul) use ($folder_skrip): bool {
    return substr($folder_skrip, -strlen($nama_modul) - 1) === '/' . $nama_modul;
};
$is_module = $cek_modul;
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <!-- Metadata Halaman & Judul -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($judul ?? 'Admin') ?> — Panel Admin</title>

  <!-- Resource Font & Ikon -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- Stylesheet Utama -->
  <link rel="stylesheet" href="<?= $basis_utama ?>assets/css/style.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      overflow: hidden;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    html::-webkit-scrollbar,
    body::-webkit-scrollbar {
      display: none;
      width: 0;
      height: 0;
    }
  </style>
</head>
<body>
<!-- Pembungkus Utama Area Admin -->
<div class="admin-wrap">

  <!-- Sidebar Navigasi Admin -->
  <aside class="admin-sidebar">
    <!-- Brand Logo Panel Admin -->
    <a class="brand" href="<?= $basis_admin ?>dashboard.php">
      <span class="dot">N</span>
      <span>Panel Admin</span>
    </a>

    <!-- Menu Utama -->
    <span class="nav-label">Menu Utama</span>
    <a href="<?= $basis_admin ?>dashboard.php" class="<?= $adalah_dashboard ? 'active' : '' ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <a href="<?= $basis_admin ?>profile/index.php" class="<?= $cek_modul('profile') ? 'active' : '' ?>"><i class="bi bi-building"></i> Profil Perusahaan</a>
    <a href="<?= $basis_admin ?>produk/index.php" class="<?= $cek_modul('produk') ? 'active' : '' ?>"><i class="bi bi-box-seam"></i> Produk &amp; Layanan</a>
    <a href="<?= $basis_admin ?>artikel/index.php" class="<?= $cek_modul('artikel') ? 'active' : '' ?>"><i class="bi bi-journal-text"></i> Artikel</a>
    <a href="<?= $basis_admin ?>galeri/index.php" class="<?= $cek_modul('galeri') ? 'active' : '' ?>"><i class="bi bi-images"></i> Galeri</a>
    <a href="<?= $basis_admin ?>pesan/index.php" class="<?= $cek_modul('pesan') ? 'active' : '' ?>" style="display:flex; align-items:center;">
      <i class="bi bi-chat-left-text"></i>
      <span>Pesan Masuk</span>
      <?php
      try {
          $jumlah_belum_baca = (int) koneksi_db()->query('SELECT COUNT(*) FROM pesan WHERE is_dibaca = 0')->fetchColumn();
          if ($jumlah_belum_baca > 0) {
              echo '<span class="badge badge-danger" style="margin-left:auto; font-size:10.5px; padding:2px 7px; border-radius:10px;">' . $jumlah_belum_baca . '</span>';
          }
      } catch (\Throwable $e) {}
      ?>
    </a>

    <div class="divider"></div>

    <!-- Menu Tambahan -->
    <span class="nav-label">Lainnya</span>
    <a href="<?= $basis_utama ?>index.php" target="_blank"><i class="bi bi-globe"></i> Lihat Website</a>
    <a href="<?= $basis_admin ?>logout.php" class="text-danger-link"><i class="bi bi-power"></i> Keluar</a>

    <span class="spacer"></span>

    <!-- Info Profil Admin yang Sedang Login -->
    <div class="admin-user">
      <i class="bi bi-person-circle me-1"></i> Login sebagai<br>
      <strong><?= e($nama_admin) ?></strong>
    </div>
  </aside>

  <!-- Area Konten Utama Halaman Admin -->
  <main class="admin-main">
    <!-- Topbar Header Admin -->
    <div class="admin-topbar">
      <div class="d-flex align-items-center gap-3">
        <button class="sidebar-toggle" aria-label="Buka menu"><i class="bi bi-list"></i></button>
        <h1><?= e($judul ?? '') ?></h1>
      </div>
      <!-- Tombol Aksi Kanan Topbar -->
      <div class="d-flex align-items-center gap-2">
        <?php if (!empty($tombol_aksi)): ?>
          <?= $tombol_aksi ?>
        <?php endif; ?>
        <a href="<?= $basis_utama ?>index.php" target="_blank" class="btn btn-outline btn-sm d-flex align-items-center gap-2">
          <i class="bi bi-globe" style="font-size:15px;"></i>
          <span>Lihat Website</span>
        </a>
      </div>
    </div>
