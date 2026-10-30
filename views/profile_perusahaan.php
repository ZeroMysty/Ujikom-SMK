<!-- Hero Section -->
<section class="page-hero text-center">
  <div class="container">
    <!-- Judul & Deskripsi Pembuka -->
    <h1 class="display-5 fw-bold text-dark mb-3">Profil &amp; Dedikasi Kami</h1>
    <p class="lead text-secondary max-w-700 mx-auto mb-0">
      Mengenal rekam jejak, visi strategis, misi operasional, dan nilai-nilai inti yang memandu setiap karya kami.
    </p>
  </div>
</section>

<!-- Sejarah Perusahaan -->
<section class="py-5 bg-white border-bottom border-light-subtle">
  <div class="container py-4">
    <div class="row align-items-center g-5">
      
      <!-- Kolom Narasi Sejarah & Pencapaian -->
      <div class="col-lg-6">
        <div class="eyebrow">Sejarah Perusahaan</div>
        <h2 class="fw-bold display-6 mb-3">Perjalanan Tumbuh Bersama Mitra di Seluruh Indonesia</h2>
        
        <p class="text-muted fs-6 lh-lg mb-4">
          <?= nl2br(e($profil['sejarah'] ?? $profil['deskripsi'] ?? 'Perusahaan ini didirikan dengan tekad menghadirkan solusi teknologi terbaik bagi bisnis di era transformasi digital.')) ?>
        </p>
        
        <!-- Info Tahun Berdiri -->
        <div class="p-4 rounded-4 bg-light border border-light-subtle mb-4">
          <div class="d-  flex align-items-center gap-3">
            <span class="brand-badge text-white rounded-3 d-inline-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 48px; height: 48px; min-width: 48px; min-height: 48px; font-size: 22px;">
              <i class="bi bi-hourglass-split"></i>
            </span>
            <div>
              <h6 class="fw-bold mb-1">Berdiri Sejak Tahun <?= e($profil['tahun_berdiri'] ?? '2018') ?></h6>
              <p class="text-muted small mb-0">Telah melayani lebih dari 150+ instansi enterprise, BUMN, dan UMKM di tingkat nasional.</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Kolom Foto Logo & Lokasi Kantor -->
      <div class="col-lg-6">
        <div class="card card-modern border-0 shadow-lg overflow-hidden">
          <img src="<?= e(gambar_item($profil['logo'] ?? null, 'profile')) ?>" 
               alt="Tentang <?= e($profil['nama_perusahaan'] ?? '') ?>" 
               class="w-100 object-fit-cover" 
               style="aspect-ratio: 16/10;">
          
          <div class="card-body p-4 bg-white text-dark border-top border-light-subtle">
            <h5 class="fw-bold mb-1 text-dark"><?= e($profil['nama_perusahaan'] ?? 'PT Digital Solusi Nusantara') ?></h5>
            <p class="text-muted small mb-0">
              <i class="bi bi-geo-alt-fill text-primary me-1"></i> <?= e($profil['alamat'] ?? 'Jakarta Selatan, Indonesia') ?>
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Visi dan Misi -->
<section class="py-5 bg-light border-bottom border-light-subtle">
  <div class="container py-4">
    
    <!-- Judul Bagian Visi & Misi -->
    <div class="text-center max-w-700 mx-auto mb-5">
      <div class="eyebrow">Arah Strategis</div>
      <h2 class="fw-bold display-6 mb-3">Visi &amp; Misi Kami</h2>
      <p class="text-muted">Komitmen jangka panjang untuk menghadirkan kontribusi positif bagi kemajuan ekonomi digital Indonesia.</p>
    </div>

    <div class="row g-4">
      
      <!-- Kartu Visi -->
      <div class="col-lg-6">
        <div class="card h-100 p-4 p-lg-5 card-modern border-0 shadow-sm">
          <div class="d-flex align-items-center gap-3 mb-4">
            <span class="icon-circle mb-0"><i class="bi bi-compass-fill"></i></span>
            <div>
              <span class="badge px-3 py-1 rounded-pill small fw-bold" style="background: #eff6ff; color: #0d6efd; border: 1px solid #bfdbfe;">VISI PERUSAHAAN</span>
              <h3 class="fw-bold h4 mb-0 text-dark">Pandangan Masa Depan</h3>
            </div>
          </div>
          <p class="fs-5 text-secondary lh-base mb-0">
            <?= nl2br(e($profil['visi'] ?? 'Menjadi mitra penyedia solusi digital dan transformasi teknologi nomor satu yang terpercaya, inovatif, dan berdaya saing global.')) ?>
          </p>
        </div>
      </div>

      <!-- Kartu Misi -->
      <div class="col-lg-6">
        <div class="card h-100 p-4 p-lg-5 card-modern border-0 shadow-sm">
          <div class="d-flex align-items-center gap-3 mb-4">
            <span class="icon-circle mb-0" style="background: #fef3c7; color: #d97706;"><i class="bi bi-bullseye"></i></span>
            <div>
              <span class="badge px-3 py-1 rounded-pill small fw-bold" style="background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">MISI OPERASIONAL</span>
              <h3 class="fw-bold h4 mb-0 text-dark">Langkah Nyata Kami</h3>
            </div>
          </div>
          
          <!-- Daftar Poin Misi -->
          <ul class="list-unstyled d-flex flex-column gap-3 mb-0">
            <?php 
              $daftar_misi = array_filter(array_map('trim', explode("\n", (string) ($profil['misi'] ?? ''))));
              if (empty($daftar_misi)) {
                $daftar_misi = [
                  'Mengembangkan produk dan layanan digital berstandar industri dengan teknologi terkini.',
                  'Memberikan layanan konsultasi dan dukungan teknis prima yang berorientasi pada kepuasan mitra bisnis.',
                  'Membangun talenta digital unggul yang adaptif, berintegritas, dan solutif.',
                  'Mendorong digitalisasi sektor usaha di Indonesia demi percepatan ekonomi digital.'
                ];
              }
              foreach ($daftar_misi as $idx => $m):
            ?>
              <li class="d-flex align-items-start gap-3">
                <span class="badge rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0 mt-1" style="width: 24px; height: 24px; font-size: 12px;">
                  <?= $idx + 1 ?>
                </span>
                <span class="text-secondary lh-base"><?= e($m) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

    </div>
  </div> 
</section>

<!-- Nilai-Nilai Perusahaan -->
<section class="py-5 bg-white">
  <div class="container py-4">
    
    <!-- Judul Bagian Nilai Budaya -->
    <div class="text-center max-w-700 mx-auto mb-5">
      <div class="eyebrow">Fondasi Budaya</div>
      <h2 class="fw-bold display-6 mb-3">Nilai-Nilai Perusahaan</h2>
      <p class="text-muted">Prinsip fundamental yang tertanam dalam setiap interaksi, keputusan, dan implementasi proyek kami.</p>
    </div>

    <!-- Grid 4 Nilai Inti -->
    <div class="row g-4">
      
      <!-- Nilai 1: Integritas -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 card-modern border-0 shadow-sm text-center">
          <div class="icon-circle mx-auto mb-3"><i class="bi bi-award-fill"></i></div>
          <h5 class="fw-bold mb-2">Integritas Tinggi</h5>
          <p class="text-muted small mb-0">Mengutamakan keterbukaan, kejujuran kode etik, dan akuntabilitas dalam seluruh kemitraan kerja.</p>
        </div>
      </div>

      <!-- Nilai 2: Inovasi -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 card-modern border-0 shadow-sm text-center">
          <div class="icon-circle mx-auto mb-3" style="background: #e0e7ff; color: #4338ca;"><i class="bi bi-lightbulb-fill"></i></div>
          <h5 class="fw-bold mb-2">Inovasi Berkelanjutan</h5>
          <p class="text-muted small mb-0">Tak henti mengeksplorasi metodologi dan teknologi mutakhir untuk memberikan solusi yang relevan.</p>
        </div>
      </div>

      <!-- Nilai 3: Kemitraan -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 card-modern border-0 shadow-sm text-center">
          <div class="icon-circle mx-auto mb-3" style="background: #ecfdf5; color: #059669;"><i class="bi bi-people-fill"></i></div>
          <h5 class="fw-bold mb-2">Kemitraan Sejati</h5>
          <p class="text-muted small mb-0">Memandang klien sebagai partner kolaboratif jangka panjang dan sukses bersama dalam setiap langkah.</p>
        </div>
      </div>

      <!-- Nilai 4: Keunggulan -->
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 card-modern border-0 shadow-sm text-center">
          <div class="icon-circle mx-auto mb-3" style="background: #fef2f2; color: #dc2626;"><i class="bi bi-lightning-charge-fill"></i></div>
          <h5 class="fw-bold mb-2">Keunggulan Eksekusi</h5>
          <p class="text-muted small mb-0">Menjaga standar kualitas kode yang ketat, pengujian mendalam, dan ketepatan waktu pengiriman proyek.</p>
        </div>
      </div>

    </div>
  </div>
</section>
