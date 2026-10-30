<!-- Kaki Halaman (Footer) -->
<footer class="bg-white text-dark pt-5 pb-4 mt-auto border-top border-light-subtle site-footer shadow-sm">
  <div class="container">
    <div class="row g-4 mb-4">
      
      <!-- Kolom Profil & Media Sosial -->
      <div class="col-lg-5 col-md-12">
        <div class="d-flex align-items-center gap-2 mb-3">
          <span class="brand-badge bg-primary text-white rounded-3 d-inline-flex align-items-center justify-content-center shadow-sm">
            <i class="bi bi-cpu-fill"></i>
          </span>
          <h5 class="mb-0 fw-bold text-dark"><?= e($profil['nama_perusahaan'] ?? 'PT Digital Solusi Nusantara') ?></h5>
        </div>
        
        <p class="text-secondary small mb-3 lh-base pe-lg-4">
          <?= e($profil['tagline'] ?? 'Mitra digital terpercaya untuk transformasi bisnis Anda.') ?>
        </p>
        
        <!-- Ikon Tautan Media Sosial -->
        <div class="d-flex gap-2 social-links">
          <?php if (!empty($profil['whatsapp'])): ?>
            <a href="https://wa.me/<?= e(preg_replace('/\D/', '', (string) $profil['whatsapp'])) ?>" 
               target="_blank" 
               rel="noopener" 
               class="btn btn-light border border-light-subtle btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
               style="width: 36px; height: 36px;" 
               title="WhatsApp">
              <i class="bi bi-whatsapp text-success"></i>
            </a>
          <?php endif; ?>
          
          <?php if (!empty($profil['email'])): ?>
            <a href="mailto:<?= e($profil['email']) ?>" 
               class="btn btn-light border border-light-subtle btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
               style="width: 36px; height: 36px;" 
               title="Email">
              <i class="bi bi-envelope-fill text-primary"></i>
            </a>
          <?php endif; ?>
          
          <?php if (!empty($profil['instagram'])): ?>
            <a href="https://instagram.com" 
               target="_blank" 
               rel="noopener" 
               class="btn btn-light border border-light-subtle btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
               style="width: 36px; height: 36px;" 
               title="Instagram">
              <i class="bi bi-instagram text-danger"></i>
            </a>
          <?php endif; ?>
          
          <?php if (!empty($profil['linkedin'])): ?>
            <a href="https://linkedin.com" 
               target="_blank" 
               rel="noopener" 
               class="btn btn-light border border-light-subtle btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
               style="width: 36px; height: 36px;" 
               title="LinkedIn">
              <i class="bi bi-linkedin text-primary"></i>
            </a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Kolom Navigasi Cepat -->
      <div class="col-lg-3 col-md-6 col-6">
        <h6 class="fw-bold text-dark mb-3 text-uppercase small letter-spacing">Navigasi</h6>
        <ul class="list-unstyled d-flex flex-column gap-2 small mb-0">
          <li><a href="index.php" class="text-secondary text-decoration-none hover-primary">Beranda</a></li>
          <li><a href="index.php?halaman=profile_perusahaan" class="text-secondary text-decoration-none hover-primary">Profil Perusahaan</a></li>
          <li><a href="index.php?halaman=produk" class="text-secondary text-decoration-none hover-primary">Produk &amp; Layanan</a></li>
          <li><a href="index.php?halaman=artikel" class="text-secondary text-decoration-none hover-primary">Artikel &amp; Wawasan</a></li>
          <li><a href="index.php?halaman=galeri" class="text-secondary text-decoration-none hover-primary">Galeri Kegiatan</a></li>
          <li><a href="index.php?halaman=kontak" class="text-secondary text-decoration-none hover-primary">Kontak</a></li>
        </ul>
      </div>

      <!-- Kolom Informasi Kontak -->
      <div class="col-lg-4 col-md-6 col-12">
        <h6 class="fw-bold text-dark mb-3 text-uppercase small letter-spacing">Hubungi Kami</h6>
        <ul class="list-unstyled d-flex flex-column gap-2 small text-secondary mb-0">
          <li class="d-flex align-items-start gap-2">
            <i class="bi bi-geo-alt-fill text-primary mt-1"></i>
            <span><?= e($profil['alamat'] ?? '-') ?></span>
          </li>
          <li class="d-flex align-items-center gap-2">
            <i class="bi bi-telephone-fill text-primary"></i>
            <span><?= e($profil['telepon'] ?? '-') ?></span>
          </li>
          <li class="d-flex align-items-center gap-2">
            <i class="bi bi-envelope-fill text-primary"></i>
            <span><?= e($profil['email'] ?? '-') ?></span>
          </li>
          <li class="d-flex align-items-center gap-2">
            <i class="bi bi-clock-fill text-primary"></i>
            <span>Senin - Jumat: 08:30 - 17:30</span>
          </li>
        </ul>
      </div>

    </div>

    <!-- Baris Hak Cipta -->
    <hr class="border-light-subtle my-3">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center small text-secondary gap-2">
      <div>
        &copy; <?= date('Y') ?> <strong class="text-dark"><?= e($profil['nama_perusahaan'] ?? 'PT Digital Solusi Nusantara') ?></strong>. Seluruh hak cipta dilindungi.
      </div>
      <div class="d-flex gap-3">
        <a href="index.php?halaman=kontak" class="text-secondary text-decoration-none hover-primary">Pusat Bantuan</a>
      </div>
    </div>
  </div>
</footer>

<!-- Pemuatan Skrip JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="assets/js/main.js"></script>
</body>
</html>