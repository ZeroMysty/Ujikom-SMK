<!-- Hero Banner -->
<section class="hero-banner py-5 py-lg-6 border-bottom border-light-subtle">
  <div class="container py-4 py-lg-5">
    <div class="row align-items-center g-5">
      
      <!-- Kolom Teks Pembuka & CTA -->
      <div class="col-lg-7 text-center text-lg-start">
        <h1 class="display-4 fw-bold text-dark mb-3 fade-up lh-tight">
          Solusi Digital <span class="grad">Elegan &amp; Inovatif</span> untuk Akselerasi Bisnis Anda
        </h1>
        
        <p class="lead text-secondary mb-4 fade-up delay-2">
          <?= e($profil['tagline'] ?? 'Membantu organisasi enterprise dan UMKM mencapai efisiensi tertinggi melalui teknologi modern.') ?>
        </p>
        
        <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 fade-up delay-3">
          <a href="index.php?halaman=produk" 
             class="btn btn-primary btn-lg rounded-pill px-4 py-3 shadow fw-semibold d-inline-flex align-items-center gap-2">
            <span>Jelajahi Layanan</span>
            <i class="bi bi-arrow-right"></i>
          </a>
          
          <a href="index.php?halaman=kontak" 
             class="btn btn-outline-primary btn-lg rounded-pill px-4 py-3 fw-semibold d-inline-flex align-items-center gap-2 bg-white shadow-sm">
            <i class="bi bi-chat-text"></i>
            <span>Konsultasi Gratis</span>
          </a>
        </div>
      </div>

      <!-- Kolom Indikator Kualitas & Performa -->
      <div class="col-lg-5 d-none d-lg-block">
        <div class="position-relative fade-up delay-2">
          <div class="card border border-light-subtle rounded-4 shadow-lg overflow-hidden bg-white text-dark p-4">
            
            <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-light-subtle">
              <div>
                <h6 class="mb-0 fw-bold text-dark"><?= e($profil['nama_perusahaan'] ?? 'PT Digital Solusi Nusantara') ?></h6>
                <span class="text-muted small">Standar Mutu Perusahaan</span>
              </div>
            </div>
            
            <div class="row g-3">
              <div class="col-6">
                <div class="p-3 rounded-3 bg-light border border-light-subtle">
                  <div class="fs-4 fw-bold text-primary">99.9%</div>
                  <div class="small text-muted">Waktu Aktif Sistem</div>
                </div>
              </div>
              
              <div class="col-6">
                <div class="p-3 rounded-3 bg-light border border-light-subtle">
                  <div class="fs-4 fw-bold text-warning">150+</div>
                  <div class="small text-muted">Proyek Sukses</div>
                </div>
              </div>
              
              <div class="col-6">
                <div class="p-3 rounded-3 bg-light border border-light-subtle">
                  <div class="fs-4 fw-bold text-success">98%</div>
                  <div class="small text-muted">Kepuasan Klien</div>
                </div>
              </div>
              
              <div class="col-6">
                <div class="p-3 rounded-3 bg-light border border-light-subtle">
                  <div class="fs-4 fw-bold text-info">24/7</div>
                  <div class="small text-muted">Dukungan Ahli</div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Profil Singkat & Statistik -->
<section class="py-5 bg-white border-bottom border-light-subtle">
  <div class="container py-4">
    <div class="row align-items-center g-5">
      
      <!-- Narasi Profil Singkat -->
      <div class="col-lg-6">
        <div class="eyebrow">Profil Singkat</div>
        <h2 class="fw-bold display-6 mb-3">
          Mengenal Lebih Dekat <span class="grad"><?= e($profil['nama_perusahaan'] ?? 'Kami') ?></span>
        </h2>
        
        <p class="text-muted fs-5 mb-4 lh-base">
          <?= e(mb_strimwidth((string) ($profil['deskripsi'] ?? 'Kami adalah mitra solusi teknologi terpercaya yang berfokus pada efisiensi bisnis.'), 0, 320, '...')) ?>
        </p>
        
        <div class="d-flex flex-wrap gap-3">
          <a href="index.php?halaman=profile_perusahaan" 
             class="btn btn-outline-primary rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2">
            <span>Pelajari Sejarah &amp; Visi Misi</span>
            <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- Grid 4 Statistik Pencapaian -->
      <div class="col-lg-6">
        <div class="row g-3">
          <div class="col-sm-6">
            <div class="p-4 rounded-4 bg-light border border-light-subtle h-100 card-modern">
              <div class="icon-circle mb-3"><i class="bi bi-calendar-event"></i></div>
              <div class="fs-3 fw-bold text-dark"><?= e($profil['tahun_berdiri'] ?? '2018') ?></div>
              <div class="text-muted small">Tahun Berdiri Perusahaan</div>
            </div>
          </div>
          
          <div class="col-sm-6">
            <div class="p-4 rounded-4 bg-light border border-light-subtle h-100 card-modern">
              <div class="icon-circle mb-3"><i class="bi bi-check2-all"></i></div>
              <div class="fs-3 fw-bold text-dark">150+</div>
              <div class="text-muted small">Proyek Selesai Tepat Waktu</div>
            </div>
          </div>
          
          <div class="col-sm-6">
            <div class="p-4 rounded-4 bg-light border border-light-subtle h-100 card-modern">
              <div class="icon-circle mb-3"><i class="bi bi-people-fill"></i></div>
              <div class="fs-3 fw-bold text-dark">40+</div>
              <div class="text-muted small">Tenaga Ahli Profesional</div>
            </div>
          </div>
          
          <div class="col-sm-6">
            <div class="p-4 rounded-4 bg-light border border-light-subtle h-100 card-modern">
              <div class="icon-circle mb-3"><i class="bi bi-trophy-fill"></i></div>
              <div class="fs-3 fw-bold text-dark">98%</div>
              <div class="text-muted small">Tingkat Retensi Mitra</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- Keunggulan Perusahaan -->
<section class="py-5 bg-light border-bottom border-light-subtle">
  <div class="container py-4">
    <!-- Judul Keunggulan -->
    <div class="text-center max-w-700 mx-auto mb-5">
      <div class="eyebrow">Mengapa Memilih Kami</div>
      <h2 class="fw-bold display-6 mb-3">Keunggulan Standar Industri</h2>
      <p class="text-muted">Kami memadukan kecanggihan teknologi, riset pengguna mendalam, dan strategi bisnis untuk menghadirkan nilai nyata.</p>
    </div>

    <!-- Grid 4 Kartu Keunggulan -->
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 card-modern border-0 shadow-sm">
          <div class="icon-circle"><i class="bi bi-code-slash"></i></div>
          <h5 class="fw-bold mb-2 text-dark">Teknologi Terkini</h5>
          <p class="text-muted small mb-0">Dibangun di atas arsitektur modern yang cepat, andal, dan siap mendukung skalabilitas masa depan.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 card-modern border-0 shadow-sm">
          <div class="icon-circle"><i class="bi bi-sliders"></i></div>
          <h5 class="fw-bold mb-2 text-dark">Solusi Disesuaikan</h5>
          <p class="text-muted small mb-0">Setiap aplikasi dirancang spesifik sesuai alur kerja dan tantangan bisnis perusahaan Anda.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 card-modern border-0 shadow-sm">
          <div class="icon-circle"><i class="bi bi-shield-lock-fill"></i></div>
          <h5 class="fw-bold mb-2 text-dark">Keamanan Teruji</h5>
          <p class="text-muted small mb-0">Penerapan standar enkripsi dan audit keamanan siber berkala demi melindungi aset data penting.</p>
        </div>
      </div>

      <div class="col-md-6 col-lg-3">
        <div class="card h-100 p-4 card-modern border-0 shadow-sm">
          <div class="icon-circle"><i class="bi bi-headset"></i></div>
          <h5 class="fw-bold mb-2 text-dark">Dukungan 24/7</h5>
          <p class="text-muted small mb-0">Tim bantuan responsif selalu siap mendampingi operasional sistem tanpa jeda downtime.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Katalog Layanan Unggulan -->
<section class="py-5 bg-white border-bottom border-light-subtle">
  <div class="container py-4">
    <!-- Header Katalog Layanan -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
      <div>
        <div class="eyebrow">Layanan Unggulan</div>
        <h2 class="fw-bold display-6 mb-2">Produk &amp; Layanan Solutif</h2>
        <p class="text-muted mb-0">Solusi menyeluruh dari website hingga sistem enterprise terpadu.</p>
      </div>
      <div>
        <a href="index.php?halaman=produk" class="btn btn-outline-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
          <span>Semua Produk</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>

    <!-- Grid Kartu Layanan -->
    <div class="row g-4">
      <?php if (empty($pratinjau_produk)): ?>
        <div class="col-12">
          <div class="alert alert-info text-center py-4 rounded-4">
            Belum ada produk yang dipublikasikan. Tambahkan melalui panel admin.
          </div>
        </div>
      <?php else: ?>
        <?php foreach ($pratinjau_produk as $p): ?>
          <div class="col-md-6 col-lg-4">
            <div class="card h-100 card-modern border-0 shadow-sm overflow-hidden d-flex flex-column">
              <!-- Foto & Kategori Produk -->
              <div class="position-relative overflow-hidden" style="aspect-ratio: 16/10;">
                <img src="<?= e(gambar_item($p['gambar'], 'produk')) ?>" 
                     class="w-100 h-100 object-fit-cover" 
                     alt="<?= e($p['nama']) ?>" 
                     loading="lazy">
                <span class="position-absolute top-0 start-0 m-3 badge bg-primary bg-opacity-90 px-3 py-2 rounded-pill shadow-sm">
                  <?= e($p['kategori']) ?>
                </span>
              </div>
              
              <!-- Informasi Produk & Harga -->
              <div class="card-body d-flex flex-column p-4">
                <h5 class="card-title fw-bold mb-2 text-dark"><?= e($p['nama']) ?></h5>
                <p class="card-text text-muted small mb-4 flex-grow-1">
                  <?= e(mb_strimwidth((string) $p['deskripsi'], 0, 110, '...')) ?>
                </p>
                
                <div class="d-flex align-items-center justify-content-between pt-3 border-top border-light-subtle">
                  <div>
                    <span class="text-muted small d-block">Mulai dari</span>
                    <strong class="fs-6 text-primary fw-bold"><?= e(rupiah($p['harga'])) ?></strong>
                  </div>
                  <a href="index.php?halaman=produk" class="btn btn-sm btn-primary rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1">
                    <span>Detail</span>
                    <i class="bi bi-arrow-right-short fs-6"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Wawasan & Artikel Terkini -->
<section class="py-5 bg-light border-bottom border-light-subtle">
  <div class="container py-4">
    <!-- Header Artikel Terkini -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 gap-3">
      <div>
        <div class="eyebrow">Wawasan Terkini</div>
        <h2 class="fw-bold display-6 mb-2">Artikel &amp; Tren Teknologi</h2>
        <p class="text-muted mb-0">Kumpulan wawasan, strategi, dan praktik terbaik dunia digital.</p>
      </div>
      <div>
        <a href="index.php?halaman=artikel" class="btn btn-outline-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
          <span>Semua Artikel</span>
          <i class="bi bi-arrow-right"></i>
        </a>
      </div>
    </div>

    <!-- Grid Kartu Artikel -->
    <div class="row g-4">
      <?php if (empty($pratinjau_artikel)): ?>
        <div class="col-12">
          <div class="alert alert-info text-center py-4 rounded-4">
            Belum ada artikel yang dipublikasikan. Tulis artikel baru lewat panel admin.
          </div>
        </div>
      <?php else: ?>
        <?php foreach ($pratinjau_artikel as $a): ?>
          <div class="col-md-6 col-lg-4">
            <article class="card h-100 card-modern border-0 shadow-sm overflow-hidden d-flex flex-column">
              <!-- Sampul Artikel -->
              <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9;">
                <img src="<?= e(gambar_item($a['gambar'], 'artikel')) ?>" 
                     class="w-100 h-100 object-fit-cover" 
                     alt="<?= e($a['judul']) ?>" 
                     loading="lazy">
              </div>
              
              <!-- Konten Ringkas Artikel -->
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
                  <?= e(mb_strimwidth(strip_tags((string) $a['isi']), 0, 115, '...')) ?>
                </p>
                
                <div class="pt-3 border-top border-light-subtle">
                  <a href="index.php?halaman=artikel&d=<?= e($a['slug']) ?>" class="text-primary fw-semibold small d-inline-flex align-items-center gap-1">
                    <span>Baca Selengkapnya</span>
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Call to Action -->
<section class="py-5 bg-white">
  <div class="container py-4">
    <!-- Banner Ajakan Bertindak -->
    <div class="rounded-5 p-5 text-white position-relative overflow-hidden shadow-lg" style="background: linear-gradient(135deg, #0d6efd, #4f46e5);">
      <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
        <div class="col-lg-8 text-center text-lg-start">
          <h2 class="display-6 fw-bold mb-3 text-white">Siap Membawa Bisnis Anda ke Level Berikutnya?</h2>
          <p class="fs-5 text-white text-opacity-85 mb-0">Konsultasikan ide dan tantangan digital Anda bersama tim ahli kami — gratis tanpa komitmen.</p>
        </div>
        <div class="col-lg-4 text-center text-lg-end">
          <a href="index.php?halaman=kontak" class="btn btn-light btn-lg rounded-pill px-4 py-3 fw-bold text-primary shadow">
            <i class="bi bi-envelope-fill me-2"></i>Hubungi Kami Sekarang
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
