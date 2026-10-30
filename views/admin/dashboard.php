<?php
require_once __DIR__ . '/../../config/auth.php';
require_once __DIR__ . '/../../config/helpers.php';

$judul = 'Dashboard Ringkasan';

// Aksi cepat status pesan (toggle baca / hapus)
if (isset($_GET['toggle_pesan'])) {
    $id_pesan = (int) $_GET['toggle_pesan'];

    $pernyataan_status = koneksi_db()->prepare('SELECT is_dibaca FROM pesan WHERE id = ?');
    $pernyataan_status->execute([$id_pesan]);
    $status_saat_ini = $pernyataan_status->fetchColumn();

    if ($status_saat_ini !== false) {
        $status_baru = $status_saat_ini ? 0 : 1;
        koneksi_db()->prepare('UPDATE pesan SET is_dibaca = ? WHERE id = ?')
                    ->execute([$status_baru, $id_pesan]);

        simpan_notifikasi(
            'success', 
            $status_baru ? 'Pesan berhasil ditandai sebagai sudah dibaca.' : 'Pesan ditandai sebagai belum dibaca.'
        );
    }
    pindah_halaman('dashboard.php');
}

if (isset($_GET['hapus_pesan'])) {
    $id_pesan = (int) $_GET['hapus_pesan'];
    koneksi_db()->prepare('DELETE FROM pesan WHERE id = ?')->execute([$id_pesan]);
    simpan_notifikasi('success', 'Pesan berhasil dihapus.');
    pindah_halaman('dashboard.php');
}

// Data statistik ringkasan modul
$hitung_total = fn (string $nama_tabel): int => 
    (int) koneksi_db()->query("SELECT COUNT(*) FROM `$nama_tabel`")->fetchColumn();

$total_produk  = $hitung_total('produk');
$total_artikel = $hitung_total('artikel');
$total_galeri  = $hitung_total('galeri');
$total_pesan   = $hitung_total('pesan');

$pesan_baru = (int) koneksi_db()->query('SELECT COUNT(*) FROM pesan WHERE is_dibaca = 0')->fetchColumn();

// Pengambilan pesan terbaru
$pesan_terbaru = koneksi_db()->query(
    'SELECT * FROM pesan ORDER BY created_at DESC, id DESC LIMIT 6'
)->fetchAll();

require __DIR__ . '/includes/header.php';
?>

<!-- Notifikasi Aksi -->
<?php if ($notifikasi = ambil_notifikasi()): ?>
  <div class="alert alert-<?= e($notifikasi['tipe']) ?>" style="margin-bottom: 24px;">
    <i class="bi bi-info-circle-fill me-2"></i>
    <?= e($notifikasi['pesan']) ?>
  </div>
<?php endif; ?>

<!-- Kartu Statistik Modul -->
<div class="stat-cards">
  <!-- Total Produk & Layanan -->
  <div class="stat-card accent">
    <div class="label">Produk &amp; Layanan</div>
    <div class="value"><?= $total_produk ?></div>
    <div class="sub">
      <a href="produk/index.php" style="color: #ffffff; text-decoration: underline;">
        Kelola Layanan →
      </a>
    </div>
  </div>

  <!-- Total Artikel -->
  <div class="stat-card">
    <div class="label">Artikel &amp; Berita</div>
    <div class="value"><?= $total_artikel ?></div>
    <div class="sub">
      <a href="artikel/index.php">
        Kelola Artikel →
      </a>
    </div>
  </div>

  <!-- Total Galeri -->
  <div class="stat-card">
    <div class="label">Dokumentasi Galeri</div>
    <div class="value"><?= $total_galeri ?></div>
    <div class="sub">
      <a href="galeri/index.php">
        Kelola Foto →
      </a>
    </div>
  </div>

  <!-- Total Pesan Masuk -->
  <div class="stat-card">
    <div class="label">Pesan Masuk</div>
    <div class="value"><?= $total_pesan ?></div>
    <div class="sub">
      <a href="pesan/index.php" style="<?= $pesan_baru > 0 ? 'font-weight:700; color:#dc2626;' : '' ?>">
        <?= $pesan_baru ?> pesan belum dibaca →
      </a>
    </div>
  </div>
</div>

<!-- Tabel Pesan Masuk Terbaru -->
<div class="table-wrap">
  <div class="page-head-row" style="padding: 20px 24px 0; margin-bottom: 0;">
    <h2 style="font-size: 18px; margin: 0; font-weight: 800; color: #0f172a;">
      Pesan Masuk Terbaru
    </h2>
    <a href="pesan/index.php" class="btn btn-outline btn-sm">
      Lihat Semua Pesan Masuk →
    </a>
  </div>

  <table class="table" style="margin-top: 14px;">
    <thead>
      <tr>
        <th>Nama Pengirim</th>
        <th>Alamat Email</th>
        <th>Perihal / Subjek</th>
        <th>Waktu Masuk</th>
        <th style="width: 130px;">Status</th>
        <th style="width: 160px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($pesan_terbaru)): ?>
        <tr>
          <td colspan="6" style="text-align: center; color: var(--muted); padding: 36px 20px;">
            <i class="bi bi-inbox" style="font-size: 32px; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
            Belum ada pesan yang masuk dari formulir kontak.
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($pesan_terbaru as $pesan_item): ?>
          <tr style="<?= $pesan_item['is_dibaca'] ? '' : 'background: #f0f9ff; font-weight: 600;' ?>">
            <td>
              <strong><?= e($pesan_item['nama']) ?></strong>
            </td>
            <td>
              <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= urlencode($pesan_item['email']) ?>&su=<?= urlencode('Re: ' . ($pesan_item['subjek'] ?: 'Pesan Website')) ?>"
                 target="_blank" style="color: #0d6efd;" title="Klik untuk membalas lewat Gmail">
                <?= e($pesan_item['email']) ?>
              </a>
            </td>
            <td>
              <?= e($pesan_item['subjek'] ?: '— Tanpa Subjek —') ?>
            </td>
            <td style="color: #64748b; font-size: 13px;">
              <?= e(tanggal_id($pesan_item['created_at'], true)) ?>
            </td>
            <td>
              <a href="dashboard.php?toggle_pesan=<?= (int) $pesan_item['id'] ?>"
                 class="badge <?= $pesan_item['is_dibaca'] ? 'badge-ok' : 'badge-danger' ?>"
                 title="Klik untuk mengubah status pesan"
                 style="cursor: pointer; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; white-space: nowrap;">
                <?php if ($pesan_item['is_dibaca']): ?>
                  <i class="bi bi-check-circle-fill"></i> Dibaca
                <?php else: ?>
                  <i class="bi bi-envelope-fill"></i> Baru
                <?php endif; ?>
              </a>
            </td>
            <td>
              <div style="display: flex; align-items: center; gap: 6px;">
                <button type="button" class="btn btn-outline btn-sm" 
                        onclick="bukaModalPesan(<?= htmlspecialchars(json_encode($pesan_item), ENT_QUOTES, 'UTF-8') ?>)">
                  <i class="bi bi-eye"></i> Detail
                </button>
                <a class="btn btn-danger btn-sm" 
                   href="dashboard.php?hapus_pesan=<?= (int) $pesan_item['id'] ?>"
                   onclick="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');" 
                   title="Hapus pesan">
                  <i class="bi bi-trash"></i>
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Jendela Modal Detail Pesan -->
<div id="modal-pesan" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15,23,42,0.5); backdrop-filter: blur(3px); align-items: center; justify-content: center; padding: 16px;">
  <div style="background: #ffffff; width: 100%; max-width: 580px; border-radius: 16px; box-shadow: 0 20px 40px rgba(15,23,42,0.2); overflow: hidden; animation: fadeUp .25s ease;">
    <!-- Header Modal -->
    <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; background: #f8fafc;">
      <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: #0f172a;">Detail Pesan Masuk</h3>
      <button type="button" onclick="tutupModalPesan()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #94a3b8; line-height: 1;">&times;</button>
    </div>

    <!-- Isi Modal -->
    <div style="padding: 22px 24px;">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 16px; padding-bottom: 14px; border-bottom: 1px solid #f1f5f9;">
        <div>
          <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Nama Pengirim</span>
          <div id="modal-nama" style="font-weight: 700; color: #0f172a; margin-top: 2px; font-size: 15px;"></div>
        </div>

        <div>
          <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Alamat Email</span>
          <div>
            <a id="modal-email-link" href="" target="_blank" style="color: #0d6efd; font-weight: 600; font-size: 14px;" title="Kirim email via Gmail"></a>
          </div>
        </div>

        <div>
          <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Waktu Dikirim</span>
          <div id="modal-tanggal" style="color: #475569; font-size: 13.5px; margin-top: 2px;"></div>
        </div>

        <div>
          <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Status Pesan</span>
          <div id="modal-status" style="margin-top: 4px;"></div>
        </div>
      </div>

      <div>
        <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Perihal / Subjek</span>
        <div id="modal-subjek" style="font-weight: 700; color: #0f172a; margin: 3px 0 12px; font-size: 15px;"></div>
      </div>

      <div>
        <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Isi Pesan</span>
        <div id="modal-isi" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px; margin-top: 6px; color: #334155; line-height: 1.7; font-size: 14px; white-space: pre-wrap; max-height: 220px; overflow-y: auto;"></div>
      </div>
    </div>

    <!-- Tombol Aksi Bawah Modal -->
    <div style="padding: 14px 24px; border-top: 1px solid #e2e8f0; background: #f8fafc; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
      <a id="modal-btn-toggle" href="" class="btn btn-outline btn-sm"></a>
      <div style="display: flex; gap: 8px;">
        <a id="modal-btn-balas" href="" target="_blank" class="btn btn-sm" style="background: #ea4335; color: #ffffff; border-color: #ea4335; font-weight: 600;">
          <i class="bi bi-google"></i> Balas di Gmail
        </a>
        <button type="button" class="btn btn-outline btn-sm" onclick="tutupModalPesan()">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Skrip JavaScript Modal Pesan -->
<script>
  function bukaModalPesan(dataPesan) {
    document.getElementById('modal-nama').textContent = dataPesan.nama || '-';
    
    const drafBalasan = "Halo " + (dataPesan.nama || '') + ",\n\nTerima kasih telah menghubungi kami melalui website.\n\n---\nPesan Anda:\n\"" + (dataPesan.isi_pesan || '') + "\"\n---\n\n";
    const tautanGmail = 'https://mail.google.com/mail/?view=cm&fs=1&to=' + encodeURIComponent(dataPesan.email || '') + '&su=' + encodeURIComponent('Re: ' + (dataPesan.subjek || 'Pesan Website')) + '&body=' + encodeURIComponent(drafBalasan);

    const tautanEmail = document.getElementById('modal-email-link');
    tautanEmail.textContent = dataPesan.email || '-';
    tautanEmail.href = tautanGmail;
    
    document.getElementById('modal-tanggal').textContent = dataPesan.created_at || '-';
    document.getElementById('modal-subjek').textContent  = dataPesan.subjek || 'Tanpa Subjek';
    document.getElementById('modal-isi').textContent     = dataPesan.isi_pesan || '';

    const elemenStatus = document.getElementById('modal-status');
    const tombolToggle = document.getElementById('modal-btn-toggle');

    if (parseInt(dataPesan.is_dibaca, 10) === 1) {
      elemenStatus.innerHTML = '<span class="badge badge-ok"><i class="bi bi-check-circle-fill"></i> Sudah Dibaca</span>';
      tombolToggle.innerHTML = '<i class="bi bi-envelope"></i> Tandai Belum Dibaca';
      tombolToggle.href = 'dashboard.php?toggle_pesan=' + dataPesan.id;
    } else {
      elemenStatus.innerHTML = '<span class="badge badge-danger"><i class="bi bi-envelope-fill"></i> Belum Dibaca</span>';
      tombolToggle.innerHTML = '<i class="bi bi-check-circle"></i> Tandai Sudah Dibaca';
      tombolToggle.href = 'dashboard.php?toggle_pesan=' + dataPesan.id;
    }

    const tombolBalas = document.getElementById('modal-btn-balas');
    tombolBalas.href = tautanGmail;

    document.getElementById('modal-pesan').style.display = 'flex';
  }

  function tutupModalPesan() {
    document.getElementById('modal-pesan').style.display = 'none';
  }

  window.addEventListener('click', function(event) {
    const modal = document.getElementById('modal-pesan');
    if (event.target === modal) {
      tutupModalPesan();
    }
  });
</script>

<?php require __DIR__ . '/includes/footer.php'; ?>
