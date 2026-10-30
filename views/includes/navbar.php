<?php
// Konfigurasi menu navigasi website
$menu = [
    'beranda'            => ['label' => 'Beranda', 'icon' => 'bi-house'],
    'profile_perusahaan' => ['label' => 'Profil Perusahaan', 'icon' => 'bi-building'],
    'produk'             => ['label' => 'Produk & Layanan', 'icon' => 'bi-grid-fill'],
    'artikel'            => ['label' => 'Artikel', 'icon' => 'bi-journal-text'],
    'galeri'             => ['label' => 'Galeri', 'icon' => 'bi-images'],
    // 'kontak'             => ['label' => 'Kontak', 'icon' => 'bi-envelope'],
];
?>
<!-- Bilah Navigasi Utama -->
<nav class="navbar navbar-expand-lg bg-white sticky-top py-3 border-bottom border-light-subtle main-navbar">
  <div class="container">
    <!-- Brand Logo & Nama -->
    <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-dark fs-5" href="index.php">
      <span class="brand-badge bg-primary text-white rounded-3 d-inline-flex align-items-center justify-content-center shadow-sm">
        <i class="bi bi-cpu-fill"></i>
      </span>
      <span><?= e($profil['nama_perusahaan'] ?? 'PT Digital Solusi Nusantara') ?></span>
    </a>

    <!-- Tombol Toggle Menu Mobile -->
    <button class="navbar-toggler border-0 shadow-none" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarMain" 
            aria-controls="navbarMain" 
            aria-expanded="false" 
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Kontainer Tautan Navigasi -->
    <div class="collapse navbar-collapse" id="navbarMain">
      <!-- Menu Navigasi Tengah -->
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-1">
        <?php foreach ($menu as $key => $item): ?>
          <li class="nav-item">
            <a class="nav-link px-3 py-2 rounded-pill transition-all <?= $halaman === $key ? 'active' : '' ?>"
               href="index.php?halaman=<?= $key ?>">
              <?= $item['label'] ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>

      <!-- Tombol Aksi Cepat (Konsultasi) -->
      <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
        <a href="index.php?halaman=kontak" class="btn btn-primary btn-sm rounded-pill px-3 py-2 shadow-sm d-flex align-items-center gap-2">
          <i class="bi bi-chat-dots-fill"></i>
          <span>Kontak</span>
        </a>
      </div>
    </div>
  </div>
</nav>