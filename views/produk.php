<!-- Hero Section -->
<section class="page-hero text-center">
  <div class="container">
    <!-- Judul & Pengantar Halaman -->
    <h1 class="display-5 fw-bold text-dark mb-3">Produk &amp; Layanan Terintegrasi</h1>
    <p class="lead text-secondary max-w-700 mx-auto mb-0">
      Rangkaian solusi teknologi komprehensif untuk menjawab berbagai skala kebutuhan digital bisnis Anda.
    </p>
  </div>
</section>

<!-- Daftar Produk & Layanan -->
<section class="py-5 bg-light">
  <div class="container py-4">
    
    <!-- State Kosong jika Belum Ada Produk -->
    <?php if (empty($daftar_produk)): ?>
      <div class="card border-0 shadow-sm p-5 text-center rounded-4">
        <div class="icon-circle mx-auto mb-3"><i class="bi bi-inbox"></i></div>
        <h4 class="fw-bold">Belum Ada Layanan Tersedia</h4>
        <p class="text-muted">Layanan akan segera diperbarui. Silakan hubungi kami untuk permintaan kustom.</p>
        <div>
          <a href="index.php?halaman=kontak" class="btn btn-primary rounded-pill px-4">Hubungi Kami</a>
        </div>
      </div>
    <?php else: ?>
      
      <!-- Grid Kartu Produk -->
      <div class="row g-4">
        <?php foreach ($daftar_produk as $p): ?>
          <div class="col-md-6 col-lg-4" id="produk-<?= (int) $p['id'] ?>">
            <div class="card h-100 card-modern border-0 shadow-sm overflow-hidden d-flex flex-column">
              
              <!-- Gambar & Kategori Produk -->
              <div class="position-relative overflow-hidden" style="aspect-ratio: 16/10;">
                <img src="<?= e(gambar_item($p['gambar'], 'produk')) ?>" 
                     class="w-100 h-100 object-fit-cover" 
                     alt="<?= e($p['nama']) ?>" 
                     loading="lazy">
                <span class="position-absolute top-0 start-0 m-3 badge bg-primary bg-opacity-90 px-3 py-2 rounded-pill shadow-sm">
                  <?= e($p['kategori']) ?>
                </span>
              </div>
              
              <!-- Informasi Produk & Tombol Detail -->
              <div class="card-body d-flex flex-column p-4">
                <h5 class="card-title fw-bold mb-2 text-dark"><?= e($p['nama']) ?></h5>
                <p class="card-text text-muted small mb-4 flex-grow-1">
                  <?= e(mb_strimwidth((string) $p['deskripsi'], 0, 120, '...')) ?>
                </p>
                
                <div class="pt-3 border-top border-light-subtle d-flex align-items-center justify-content-between">
                  <div>
                    <span class="text-muted small d-block">Investasi mulai</span>
                    <strong class="fs-6 text-primary fw-bold"><?= e(rupiah($p['harga'])) ?></strong>
                  </div>
                  
                  <button type="button" 
                          class="btn btn-primary btn-sm rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1 shadow-sm"
                          data-bs-toggle="modal" 
                          data-bs-target="#modalProduk<?= (int) $p['id'] ?>">
                    <i class="bi bi-info-circle"></i>
                    <span>Detail</span>
                  </button>
                </div>
              </div>

            </div>
          </div>

          <!-- Modal Detail Produk -->
          <div class="modal fade" 
               id="modalProduk<?= (int) $p['id'] ?>" 
               tabindex="-1" 
               aria-labelledby="modalLabel<?= (int) $p['id'] ?>" 
               aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
                
                <!-- Header Modal -->
                <div class="modal-header bg-light text-dark border-bottom border-light-subtle px-4 py-3">
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary px-3 py-1 rounded-pill small"><?= e($p['kategori']) ?></span>
                    <h5 class="modal-title fw-bold text-dark mb-0" id="modalLabel<?= (int) $p['id'] ?>">
                      <?= e($p['nama']) ?>
                    </h5>
                  </div>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                
                <!-- Badan Modal -->
                <div class="modal-body p-4">
                  <div class="row g-4 align-items-center">
                    <!-- Foto & Estimasi Biaya -->
                    <div class="col-md-5">
                      <img src="<?= e(gambar_item($p['gambar'], 'produk')) ?>" 
                           alt="<?= e($p['nama']) ?>" 
                           class="w-100 rounded-3 shadow-sm object-fit-cover" 
                           style="aspect-ratio: 4/3;">
                      
                      <div class="mt-3 p-3 rounded-3 bg-light border border-light-subtle text-center">
                        <span class="text-muted small d-block">Estimasi Biaya Mulai</span>
                        <span class="fs-5 fw-bold text-primary"><?= e(rupiah($p['harga'])) ?></span>
                      </div>
                    </div>
                    
                    <!-- Deskripsi & Fitur Paket -->
                    <div class="col-md-7">
                      <h6 class="fw-bold text-dark text-uppercase small letter-spacing mb-2">Deskripsi Lengkap Layanan</h6>
                      <p class="text-secondary lh-base mb-4">
                        <?= nl2br(e($p['deskripsi'])) ?>
                      </p>
                      
                      <div class="p-3 rounded-3 bg-primary bg-opacity-10 border border-primary border-opacity-25 mb-4">
                        <div class="d-flex align-items-center gap-2 text-primary fw-semibold small mb-1">
                          <i class="bi bi-shield-check"></i> Termasuk dalam paket:
                        </div>
                        <ul class="list-unstyled small text-muted mb-0 d-flex flex-column gap-1 ps-3">
                          <li>• Konsultasi kebutuhan awal gratis</li>
                          <li>• Garansi pemeliharaan &amp; perbaikan bug</li>
                          <li>• Dokumentasi penggunaan sistem lengkap</li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Footer & Tombol Aksi Modal -->
                <div class="modal-footer bg-light px-4 py-3 border-top border-light-subtle d-flex justify-content-between">
                  <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                  
                  <div class="d-flex gap-2">
                    <?php if (!empty($profil['whatsapp'])): ?>
                      <a href="https://wa.me/<?= e(preg_replace('/\D/', '', (string) $profil['whatsapp'])) ?>?text=<?= rawurlencode('Halo, saya tertarik dengan layanan ' . $p['nama'] . '. Mohon informasi lebih lanjut.') ?>"
                         target="_blank" 
                         rel="noopener" 
                         class="btn btn-success rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm">
                        <i class="bi bi-whatsapp"></i>
                        <span>Pesan via WhatsApp</span>
                      </a>
                    <?php endif; ?>
                    
                    <a href="index.php?halaman=kontak" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
                      <i class="bi bi-envelope"></i>
                      <span>Kirim Penawaran</span>
                    </a>
                  </div>
                </div>

              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-white border-top border-light-subtle">
  <div class="container py-3">
    <!-- Banner Ajakan Konsultasi -->
    <div class="card border-0 rounded-4 p-4 p-md-5 text-white shadow-lg" style="background: linear-gradient(135deg, #0d6efd, #4f46e5);">
      <div class="row align-items-center g-4">
        <div class="col-lg-8">
          <h3 class="fw-bold mb-2 text-white">Memiliki Kebutuhan Sistem Spesifik?</h3>
          <p class="text-white text-opacity-85 mb-0">Diskusikan spesifikasi alur bisnis Anda bersama konsultan teknis kami untuk mendapatkan rancangan solusi yang tepat guna.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <a href="index.php?halaman=kontak" class="btn btn-light btn-lg rounded-pill px-4 fw-bold text-primary shadow">
            Konsultasi Kustom
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
