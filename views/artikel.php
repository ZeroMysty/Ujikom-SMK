<?php if (isset($artikel_detail)): ?>

  <!-- Kondisi Detail Artikel -->
  <?php if (!$artikel_detail): ?>
    <!-- State 404: Artikel Tidak Ditemukan -->
    <section class="py-5 bg-light my-auto">
      <div class="container py-5 text-center">
        <div class="card border-0 shadow-sm rounded-4 p-5 max-w-600 mx-auto">
          <div class="icon-circle mx-auto mb-3" style="background: #fee2e2; color: #ef4444;">
            <i class="bi bi-exclamation-triangle-fill"></i>
          </div>
          <h3 class="fw-bold mb-2">Artikel Tidak Ditemukan</h3>
          <p class="text-muted mb-4">Artikel yang Anda tuju mungkin telah dihapus atau tautan tidak valid.</p>
          <div>
            <a class="btn btn-primary rounded-pill px-4" href="index.php?halaman=artikel">
              <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar Artikel
            </a>
          </div>
        </div>
      </div>
    </section>

  <?php else: ?>
    <!-- Header Artikel (Judul, Tanggal, Penulis) -->
    <section class="page-hero">
      <div class="container">
        <a href="index.php?halaman=artikel" class="text-primary text-decoration-none small fw-semibold d-inline-flex align-items-center gap-1 mb-3">
          <i class="bi bi-arrow-left"></i> Semua Artikel &amp; Wawasan
        </a>
        <h1 class="display-5 fw-bold text-dark mb-3 lh-tight">
          <?= e($artikel_detail['judul']) ?>
        </h1>
        <div class="d-flex flex-wrap align-items-center gap-3 text-secondary small">
          <span class="d-flex align-items-center gap-1">
            <i class="bi bi-calendar3 text-primary"></i> <?= e(tanggal_id($artikel_detail['created_at'], true)) ?>
          </span>
          <span>•</span>
          <span class="d-flex align-items-center gap-1">
            <i class="bi bi-person-fill text-primary"></i> Ditulis oleh <?= e($artikel_detail['penulis']) ?>
          </span>
        </div>
      </div>
    </section>

    <!-- Konten Artikel -->
    <section class="py-5 bg-white">
      <div class="container py-3" style="max-width: 860px;">
        
        <!-- Foto Sampul Utama -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
          <img src="<?= e(gambar_item($artikel_detail['gambar'], 'artikel')) ?>" 
               alt="<?= e($artikel_detail['judul']) ?>" 
               class="w-100 object-fit-cover" 
               style="aspect-ratio: 16/9;">
        </div>

        <!-- Isi Konten Artikel -->
        <div class="article-body px-lg-2">
          <?php
          $isi_konten = (string) ($artikel_detail['isi'] ?? '');
          if (strip_tags($isi_konten) === $isi_konten) {
              $paragraf = array_filter(array_map('trim', explode("\n\n", str_replace("\r", "", $isi_konten))));
              echo implode('', array_map(fn($p) => '<p>' . nl2br(e($p)) . '</p>', $paragraf));
          } else {
              echo $isi_konten;
          }
          ?>
        </div>

        <!-- Info Penulis & Tombol Navigasi -->
        <div class="p-4 rounded-4 bg-light border border-light-subtle mt-5 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
          <div>
            <span class="text-muted small d-block">Penulis Artikel</span>
            <strong class="text-dark fs-6"><?= e($artikel_detail['penulis']) ?></strong>
          </div>
          <div class="d-flex gap-2">
            <a href="index.php?halaman=artikel" class="btn btn-outline-secondary rounded-pill px-4 btn-sm">
              <i class="bi bi-arrow-left me-1"></i> Artikel Lainnya
            </a>
            <a href="index.php?halaman=kontak" class="btn btn-primary rounded-pill px-4 btn-sm">
              Konsultasikan Topik Ini
            </a>
          </div>
        </div>

      </div>
    </section>
  <?php endif; ?>

<?php else: ?>

  <!-- Hero Section -->
  <section class="page-hero text-center">
    <div class="container">
      <!-- Judul & Pengantar Halaman -->
      <h1 class="display-5 fw-bold text-dark mb-3">Artikel, Tips &amp; Wawasan Terkini</h1>
      <p class="lead text-secondary max-w-700 mx-auto mb-0">
        Pelajari tren teknologi informasi, arsitektur perangkat lunak, keamanan siber, dan transformasi digital.
      </p>
    </div>
  </section>

  <!-- Daftar Semua Artikel -->
  <section class="py-5 bg-light">
    <div class="container py-4">
      
      <!-- State Kosong jika Belum Ada Artikel -->
      <?php if (empty($daftar_artikel)): ?>
        <div class="card border-0 shadow-sm p-5 text-center rounded-4">
          <div class="icon-circle mx-auto mb-3"><i class="bi bi-journal-x"></i></div>
          <h4 class="fw-bold">Belum Ada Artikel</h4>
          <p class="text-muted">Artikel akan tampil di sini setelah dipublikasikan melalui panel admin.</p>
        </div>
      <?php else: ?>
        
        <!-- Grid Kartu Artikel -->
        <div class="row g-4">
          <?php foreach ($daftar_artikel as $a): ?>
            <div class="col-md-6 col-lg-4">
              <article class="card h-100 card-modern border-0 shadow-sm overflow-hidden d-flex flex-column">
                
                <!-- Sampul Artikel -->
                <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9;">
                  <img src="<?= e(gambar_item($a['gambar'], 'artikel')) ?>" 
                       class="w-100 h-100 object-fit-cover" 
                       alt="<?= e($a['judul']) ?>" 
                       loading="lazy">
                </div>
                
                <!-- Rincian Teks & Tautan Baca -->
                <div class="card-body d-flex flex-column p-4">
                  <div class="d-flex align-items-center gap-1 text-muted small mb-2">
                    <i class="bi bi-calendar3"></i>
                    <span><?= e(tanggal_id($a['created_at'])) ?></span>
                  </div>
                  
                  <h5 class="card-title fw-bold mb-2 text-dark">
                    <a href="index.php?halaman=artikel&d=<?= e($a['slug']) ?>" class="text-dark text-decoration-none">
                      <?= e($a['judul']) ?>
                    </a>
                  </h5>
                  
                  <p class="card-text text-muted small mb-4 flex-grow-1">
                    <?= e(mb_strimwidth(strip_tags((string) $a['isi']), 0, 120, '...')) ?>
                  </p>
                  
                  <div class="pt-3 border-top border-light-subtle">
                    <a href="index.php?halaman=artikel&d=<?= e($a['slug']) ?>" 
                       class="btn btn-outline-primary btn-sm rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                      <span>Baca Selengkapnya</span>
                      <i class="bi bi-arrow-right"></i>
                    </a>
                  </div>
                </div>

              </article>
            </div>
          <?php endforeach; ?>
        </div>

      <?php endif; ?>

    </div>
  </section>

<?php endif; ?>
