<!-- Hero Section -->
<section class="page-hero text-center">
  <div class="container">
    <!-- Judul & Pengantar Halaman -->
    <h1 class="display-5 fw-bold text-dark mb-3">Galeri Kegiatan Perusahaan</h1>
    <p class="lead text-secondary max-w-700 mx-auto mb-0">
      Rangkuman dokumentasi aktivitas, workshop teknologi, kolaborasi mitra, dan dinamika tim profesional kami.
    </p>
  </div>
</section>

<!-- Grid Foto Galeri -->
<section class="py-5 bg-light">
  <div class="container py-4">
    
    <!-- State Kosong jika Belum Ada Foto -->
    <?php if (empty($daftar_galeri)): ?>
      <div class="card border-0 shadow-sm p-5 text-center rounded-4">
        <div class="icon-circle mx-auto mb-3"><i class="bi bi-camera"></i></div>
        <h4 class="fw-bold">Belum Ada Foto Kegiatan</h4>
        <p class="text-muted">Dokumentasi kegiatan akan tampil di sini. Unggah foto lewat panel administrator.</p>
      </div>
    <?php else: ?>
      
      <!-- Daftar Item Foto -->
      <div class="row g-4">
        <?php foreach ($daftar_galeri as $g): ?>
          <div class="col-md-6 col-lg-4">
            <!-- Kartu Foto & Efek Hover -->
            <div class="gallery-card shadow-sm h-100" 
                 data-bs-toggle="modal" 
                 data-bs-target="#modalGaleri<?= (int) $g['id'] ?>">
              
              <img src="<?= e(gambar_item($g['gambar'], 'galeri')) ?>" 
                   alt="<?= e($g['judul']) ?>" 
                   loading="lazy">
              
              <div class="gallery-overlay">
                <h6 class="fw-bold text-white mb-1"><?= e($g['judul']) ?></h6>
                <?php if (!empty($g['keterangan'])): ?>
                  <p class="small text-white-50 mb-0"><?= e($g['keterangan']) ?></p>
                <?php endif; ?>
                <div class="mt-2 text-info small fw-semibold d-flex align-items-center gap-1">
                  <i class="bi bi-zoom-in"></i>
                  <span>Perbesar Foto</span>
                </div>
              </div>

            </div>
          </div>

          <!-- Modal Preview Foto -->
          <div class="modal fade" 
               id="modalGaleri<?= (int) $g['id'] ?>" 
               tabindex="-1" 
               aria-labelledby="labelGaleri<?= (int) $g['id'] ?>" 
               aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden bg-white text-dark">
                
                <!-- Header Modal -->
                <div class="modal-header bg-light border-bottom border-light-subtle px-4 py-3">
                  <h5 class="modal-title fw-bold text-dark mb-0" id="labelGaleri<?= (int) $g['id'] ?>">
                    <?= e($g['judul']) ?>
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                
                <!-- Tampilan Foto Penuh -->
                <div class="modal-body p-2 text-center bg-light">
                  <img src="<?= e(gambar_item($g['gambar'], 'galeri')) ?>" 
                       alt="<?= e($g['judul']) ?>" 
                       class="img-fluid rounded-3 max-vh-75 object-fit-contain shadow-sm">
                </div>
                
                <!-- Keterangan & Tombol Tutup -->
                <div class="modal-footer bg-white border-top border-light-subtle px-4 py-3 justify-content-between">
                  <span class="text-secondary small">
                    <?= e($g['keterangan'] ?: 'Dokumentasi kegiatan resmi.') ?>
                  </span>
                  <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">
                    Tutup
                  </button>
                </div>

              </div>
            </div>
          </div>

        <?php endforeach; ?>
      </div>

    <?php endif; ?>

  </div>
</section>
