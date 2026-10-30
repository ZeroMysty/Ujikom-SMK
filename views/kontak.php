<!-- Hero Section -->
<section class="page-hero text-center">
  <div class="container">
    <!-- Judul & Pengantar Halaman -->
    <h1 class="display-5 fw-bold text-dark mb-3">Hubungi Tim Kami</h1>
    <p class="lead text-secondary max-w-700 mx-auto mb-0">
      Diskusikan kebutuhan proyek, integrasi sistem, atau konsultasi teknologi. Kami siap membantu Anda.
    </p>
  </div>
</section>

<!-- Informasi Kontak & Formulir Pesan -->
<section class="py-5 bg-light">
  <div class="container py-4">
    <div class="row g-5">
      
      <!-- Kolom Informasi Kontak -->
      <div class="col-lg-5">
        <!-- Kartu Rincian Kontak -->
        <div class="card card-modern border-0 shadow-sm p-4 p-lg-5 mb-4">
          <div class="eyebrow">Informasi Kontak</div>
          <h3 class="fw-bold mb-4 text-dark">Tetap Terhubung</h3>
          
          <ul class="list-unstyled d-flex flex-column gap-4 mb-4">
            <li class="d-flex align-items-start gap-3">
              <span class="icon-circle mb-0 flex-shrink-0"><i class="bi bi-geo-alt-fill"></i></span>
              <div>
                <strong class="text-dark d-block mb-1">Alamat Kantor</strong>
                <span class="text-secondary small lh-base">
                  <?= e($profil['alamat'] ?? 'Jl. Jenderal Sudirman Kav. 52-53, Jakarta Selatan') ?>
                </span>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3">
              <span class="icon-circle mb-0 flex-shrink-0"><i class="bi bi-telephone-fill"></i></span>
              <div>
                <strong class="text-dark d-block mb-1">Telepon Kantor</strong>
                <a href="tel:<?= e($profil['telepon'] ?? '') ?>" class="text-secondary small text-decoration-none">
                  <?= e($profil['telepon'] ?? '(021) 5296-8899') ?>
                </a>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3">
              <span class="icon-circle mb-0 flex-shrink-0"><i class="bi bi-envelope-fill"></i></span>
              <div>
                <strong class="text-dark d-block mb-1">Email Resmi</strong>
                <a href="mailto:<?= e($profil['email'] ?? '') ?>" class="text-secondary small text-decoration-none">
                  <?= e($profil['email'] ?? 'kontak@solusinusantara.com') ?>
                </a>
              </div>
            </li>

            <li class="d-flex align-items-start gap-3">
              <span class="icon-circle mb-0 flex-shrink-0" style="background: #ecfdf5; color: #059669;"><i class="bi bi-whatsapp"></i></span>
              <div>
                <strong class="text-dark d-block mb-1">WhatsApp Helpdesk</strong>
                <a href="https://wa.me/<?= e(preg_replace('/\D/', '', (string) ($profil['whatsapp'] ?? ''))) ?>" target="_blank" rel="noopener" class="text-secondary small text-decoration-none">
                  <?= e($profil['whatsapp'] ?? '0812-8899-1234') ?>
                </a>
              </div>
            </li>
          </ul>

          <!-- Jam Operasional -->
          <div class="p-3 rounded-3 bg-light border border-light-subtle">
            <div class="d-flex align-items-center gap-2 text-dark fw-semibold small mb-1">
              <i class="bi bi-clock-history text-primary"></i> Jam Operasional Kantor
            </div>
            <div class="text-muted small">
              Senin - Jumat: 08.30 - 17.30 WIB<br>
              Sabtu &amp; Minggu: Libur (Layanan Tanggap Darurat 24/7)
            </div>
          </div>
        </div>

        <!-- Lokasi Google Maps -->
        <div class="card card-modern border-0 shadow-sm overflow-hidden p-3">
          <h6 class="fw-bold mb-2 text-dark d-flex align-items-center gap-2">
            <i class="bi bi-map-fill text-primary"></i> Lokasi Kantor di Google Maps
          </h6>
          <div class="ratio ratio-16x9 rounded-3 overflow-hidden border border-light-subtle">
            <?php if (!empty($profil['maps_embed'])): ?>
              <?= $profil['maps_embed'] ?>
            <?php else: ?>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.297441584061!2d106.8048689758682!3d-6.224451093763704!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f14d30079f01%3A0x2e74f2341a6c0b32!2sSudirman%20Central%20Business%20District!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Kolom Formulir Pesan -->
      <div class="col-lg-7">
        <div class="card card-modern border-0 shadow-sm p-4 p-lg-5">
          <div class="eyebrow">Formulir Pesan</div>
          <h3 class="fw-bold mb-2 text-dark">Kirimkan Pertanyaan Anda</h3>
          <p class="text-muted mb-4">Isi formulir di bawah ini dan tim representatif kami akan menghubungi Anda dalam waktu 1x24 jam kerja.</p>

          <!-- Notifikasi Status Pengiriman -->
          <?php if ($notifikasi = ambil_notifikasi()): ?>
            <div class="alert alert-<?= e($notifikasi['tipe']) ?> alert-dismissible fade show rounded-3" role="alert">
              <i class="bi bi-info-circle-fill me-2"></i>
              <?= e($notifikasi['pesan']) ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
          <?php endif; ?>

          <!-- Formulir Pengiriman Pesan -->
          <form method="post" action="index.php?halaman=kontak">
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="nama" class="form-label fw-semibold text-dark small">Nama Lengkap <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-secondary"></i></span>
                  <input type="text" class="form-control border-start-0 py-2" id="nama" name="nama" required placeholder="Masukkan nama Anda">
                </div>
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label fw-semibold text-dark small">Alamat Email <span class="text-danger">*</span></label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-secondary"></i></span>
                  <input type="email" class="form-control border-start-0 py-2" id="email" name="email" required placeholder="nama@perusahaan.com">
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="subjek" class="form-label fw-semibold text-dark small">Perihal / Subjek</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-card-heading text-secondary"></i></span>
                <input type="text" class="form-control border-start-0 py-2" id="subjek" name="subjek" placeholder="Contoh: Konsultasi Pembuatan Website Korporat">
              </div>
            </div>

            <div class="mb-4">
              <label for="isi_pesan" class="form-label fw-semibold text-dark small">Isi Pesan <span class="text-danger">*</span></label>
              <textarea class="form-control py-3" id="isi_pesan" name="isi_pesan" rows="5" required placeholder="Ceritakan secara ringkas kebutuhan, tantangan, atau estimasi target waktu proyek Anda..."></textarea>
            </div>

            <!-- Tombol Kirim & Chat WhatsApp -->
            <div class="d-flex flex-wrap align-items-center gap-3">
              <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm fw-semibold">
                Kirim Pesan Sekarang
              </button>
              
              <?php if (!empty($profil['whatsapp'])): ?>
                <a href="https://wa.me/<?= e(preg_replace('/\D/', '', (string) $profil['whatsapp'])) ?>?text=<?= rawurlencode('Halo, saya ingin berkonsultasi mengenai solusi teknologi.') ?>"
                   target="_blank" 
                   rel="noopener" 
                   class="btn btn-success btn-lg rounded-pill px-4 shadow-sm fw-semibold d-inline-flex align-items-center gap-2">
                  <i class="bi bi-whatsapp"></i>
                  <span>Chat Sekarang</span>
                </a>
              <?php endif; ?>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>
