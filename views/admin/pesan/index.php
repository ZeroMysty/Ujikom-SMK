<?php
// Inisialisasi dan autentikasi admin
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul = 'Pesan Masuk';

// Ubah status baca (sudah/belum) satu pesan berdasarkan ID
if (isset($_GET['toggle'])) {
    $id_pesan   = (int) $_GET['toggle'];
    $pernyataan = koneksi_db()->prepare('SELECT is_dibaca FROM pesan WHERE id = ?');
    $pernyataan->execute([$id_pesan]);
    $status_saat_ini = $pernyataan->fetchColumn();

    if ($status_saat_ini !== false) {
        $status_baru = $status_saat_ini ? 0 : 1;
        koneksi_db()->prepare('UPDATE pesan SET is_dibaca = ? WHERE id = ?')->execute([$status_baru, $id_pesan]);
        simpan_notifikasi('success', $status_baru ? 'Pesan ditandai sudah dibaca.' : 'Pesan ditandai belum dibaca.');
    }

    pindah_halaman('index.php' . (isset($_GET['filter']) ? '?filter=' . urlencode($_GET['filter']) : ''));
}

// Tandai seluruh pesan yang belum dibaca menjadi sudah dibaca
if (isset($_GET['tandai_semua'])) {
    koneksi_db()->query('UPDATE pesan SET is_dibaca = 1 WHERE is_dibaca = 0');
    simpan_notifikasi('success', 'Semua pesan berhasil ditandai sudah dibaca.');
    pindah_halaman('index.php');
}

// Hapus pesan dari database berdasarkan parameter ID
if (isset($_GET['hapus'])) {
    $id_pesan = (int) $_GET['hapus'];
    koneksi_db()->prepare('DELETE FROM pesan WHERE id = ?')->execute([$id_pesan]);
    simpan_notifikasi('success', 'Pesan berhasil dihapus.');
    pindah_halaman('index.php' . (isset($_GET['filter']) ? '?filter=' . urlencode($_GET['filter']) : ''));
}

// Filter tampilan data pesan (semua, belum dibaca, atau sudah dibaca)
$filter          = $_GET['filter'] ?? 'semua';
$kondisi_filter  = match($filter) {
    'baru'   => 'WHERE is_dibaca = 0',
    'dibaca' => 'WHERE is_dibaca = 1',
    default  => ''
};

// Ambil daftar pesan sesuai filter dan hitung ringkasan jumlah
$daftar_pesan = koneksi_db()->query("SELECT * FROM pesan $kondisi_filter ORDER BY created_at DESC, id DESC")->fetchAll();
$total_semua  = (int) koneksi_db()->query('SELECT COUNT(*) FROM pesan')->fetchColumn();
$total_baru   = (int) koneksi_db()->query('SELECT COUNT(*) FROM pesan WHERE is_dibaca = 0')->fetchColumn();
$total_baca   = (int) koneksi_db()->query('SELECT COUNT(*) FROM pesan WHERE is_dibaca = 1')->fetchColumn();

// Tombol navigasi aksi tandai semua pesan dibaca
$tombol_aksi = '';
if ($total_baru > 0) {
    $tombol_aksi = '<a class="btn btn-outline btn-sm" href="index.php?tandai_semua=1" onclick="return confirm(\'Tandai semua pesan sebagai sudah dibaca?\');"><i class="bi bi-check2-all text-primary"></i> Tandai Semua Dibaca</a>';
}

require __DIR__ . '/../includes/header.php';
?>

<!-- Notifikasi Status Aksi -->
<?php if ($notifikasi = ambil_notifikasi()): ?>
  <div class="alert alert-<?= e($notifikasi['tipe']) ?>">
    <?= e($notifikasi['pesan']) ?>
  </div>
<?php endif; ?>

<!-- Tab Filter Status Pesan -->
<div style="display: flex; gap: 10px; margin-bottom: 18px; flex-wrap: wrap;">
  <a href="index.php?filter=semua" class="btn btn-sm <?= $filter === 'semua' ? 'btn-primary' : 'btn-outline' ?>">
    Semua (<?= $total_semua ?>)
  </a>
  <a href="index.php?filter=baru" class="btn btn-sm <?= $filter === 'baru' ? 'btn-primary' : 'btn-outline' ?>">
    <i class="bi bi-envelope-fill"></i> Belum Dibaca (<?= $total_baru ?>)
  </a>
  <a href="index.php?filter=dibaca" class="btn btn-sm <?= $filter === 'dibaca' ? 'btn-primary' : 'btn-outline' ?>">
    <i class="bi bi-envelope-open"></i> Sudah Dibaca (<?= $total_baca ?>)
  </a>
</div>

<!-- Tabel Daftar Pesan Masuk -->
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr>
        <th style="width: 170px;">Pengirim</th>
        <th style="width: 200px;">Email</th>
        <th>Subjek &amp; Pesan</th>
        <th style="width: 160px;">Tanggal</th>
        <th style="width: 150px;">Status</th>
        <th style="width: 160px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- Kondisi jika tidak ada pesan pada filter ini -->
      <?php if (empty($daftar_pesan)): ?>
        <tr>
          <td colspan="6" style="text-align: center; color: var(--muted); padding: 36px;">
            Belum ada pesan pada kategori ini.
          </td>
        </tr>
      <?php else: ?>
        <!-- Perulangan baris pesan masuk -->
        <?php foreach ($daftar_pesan as $ps): ?>
          <tr style="<?= $ps['is_dibaca'] ? '' : 'background: #f0f9ff; font-weight: 600;' ?>">
            <!-- Nama pengirim -->
            <td><strong><?= e($ps['nama']) ?></strong></td>
            <!-- Tautan email pengirim (buka Gmail) -->
            <td>
              <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?= urlencode($ps['email']) ?>&su=<?= urlencode('Re: ' . ($ps['subjek'] ?: 'Pesan Website')) ?>"
                 target="_blank" style="color: #0d6efd;" title="Balas via Gmail">
                <?= e($ps['email']) ?>
              </a>
            </td>
            <!-- Subjek dan cuplikan isi pesan -->
            <td>
              <div style="font-weight: 700; color: #0f172a; margin-bottom: 3px;">
                <?= e($ps['subjek'] ?: 'Tanpa Subjek') ?>
              </div>
              <div style="font-size: 12.5px; color: #64748b; font-weight: normal; max-width: 340px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <?= e($ps['isi_pesan']) ?>
              </div>
            </td>
            <!-- Waktu pengiriman -->
            <td style="font-size: 12.5px; color: #64748b;">
              <?= e(tanggal_id($ps['created_at'], true)) ?>
            </td>
            <!-- Status baca / belum dibaca -->
            <td>
              <a href="index.php?toggle=<?= (int) $ps['id'] ?>&filter=<?= urlencode($filter) ?>"
                 class="badge <?= $ps['is_dibaca'] ? 'badge-ok' : 'badge-danger' ?>"
                 title="Klik untuk mengubah status pesan"
                 style="cursor: pointer; display: inline-flex; align-items: center; gap: 5px; text-decoration: none; white-space: nowrap;">
                <?php if ($ps['is_dibaca']): ?>
                  <i class="bi bi-check-circle-fill"></i> Dibaca
                <?php else: ?>
                  <i class="bi bi-envelope-fill"></i> Baru
                <?php endif; ?>
              </a>
            </td>
            <!-- Tombol aksi detail dan hapus -->
            <td>
              <div style="display: flex; align-items: center; gap: 6px;">
                <button type="button" class="btn btn-outline btn-sm"
                        onclick="bukaModalPesan(<?= htmlspecialchars(json_encode($ps), ENT_QUOTES, 'UTF-8') ?>)">
                  <i class="bi bi-eye"></i> Detail
                </button>
                <a class="btn btn-danger btn-sm"
                   href="index.php?hapus=<?= (int) $ps['id'] ?>&filter=<?= urlencode($filter) ?>"
                   onclick="return confirm('Hapus pesan dari <?= e(addslashes($ps['nama'])) ?>?');"
                   title="Hapus">
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

<!-- Modal Dialog Detail Pesan Masuk -->
<div id="modal-pesan"
     style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(15, 23, 42, 0.5); backdrop-filter: blur(3px); align-items: center; justify-content: center; padding: 16px;">
  <div style="background: #ffffff; width: 100%; max-width: 600px; border-radius: 16px; box-shadow: 0 20px 40px rgba(15, 23, 42, 0.2); overflow: hidden; animation: fadeUp .25s ease;">
    <!-- Header Modal -->
    <div style="padding: 18px 24px; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; background: #f8fafc;">
      <h3 style="margin: 0; font-size: 17px; font-weight: 800; color: #0f172a;">Detail Pesan Masuk</h3>
      <button type="button" onclick="tutupModalPesan()"
              style="background: none; border: none; font-size: 22px; cursor: pointer; color: #94a3b8;">&times;</button>
    </div>

    <!-- Informasi Meta Pengirim Pesan -->
    <div style="padding: 24px;">
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #f1f5f9;">
        <div>
          <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Nama Pengirim</span>
          <div id="modal-nama" style="font-weight: 700; color: #0f172a; margin-top: 2px; font-size: 15px;"></div>
        </div>
        <div>
          <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Email</span>
          <div><a id="modal-email-link" href="" target="_blank" style="color: #0d6efd; font-weight: 600; font-size: 14px;" title="Kirim email via Gmail"></a></div>
        </div>
        <div>
          <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Tanggal Dikirim</span>
          <div id="modal-tanggal" style="color: #475569; font-size: 13.5px; margin-top: 2px;"></div>
        </div>
        <div>
          <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Status Saat Ini</span>
          <div id="modal-status" style="margin-top: 4px;"></div>
        </div>
      </div>

      <!-- Subjek & Isi Pesan Lengkap -->
      <div>
        <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Subjek</span>
        <div id="modal-subjek" style="font-weight: 700; color: #0f172a; margin: 3px 0 12px; font-size: 15px;"></div>
      </div>
      <div>
        <span style="font-size: 11.5px; text-transform: uppercase; letter-spacing: .05em; color: #94a3b8; font-weight: 700;">Isi Pesan</span>
        <div id="modal-isi" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 16px; margin-top: 6px; color: #334155; line-height: 1.7; font-size: 14px; white-space: pre-wrap; max-height: 220px; overflow-y: auto;"></div>
      </div>
    </div>

    <!-- Tombol Aksi Modal (Ubah Status & Balas) -->
    <div style="padding: 14px 24px; border-top: 1px solid #e2e8f0; background: #f8fafc; display: flex; align-items: center; justify-content: space-between; gap: 10px;">
      <a id="modal-btn-toggle" href="" class="btn btn-outline btn-sm"></a>
      <div style="display: flex; gap: 8px;">
        <a id="modal-btn-balas" href="" target="_blank" class="btn btn-sm"
           style="background: #ea4335; color: #ffffff; border-color: #ea4335; font-weight: 600;">
          <i class="bi bi-google"></i> Balas di Gmail
        </a>
        <button type="button" class="btn btn-outline btn-sm" onclick="tutupModalPesan()">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Script Logika Modal Interaktif & Tautan Balas Email -->
<script>
  function bukaModalPesan(ps) {
    document.getElementById('modal-nama').textContent = ps.nama || '-';

    const drafIsi   = "Halo " + (ps.nama || '') + ",\n\nTerima kasih telah menghubungi kami melalui website.\n\n---\nPesan Anda:\n\"" + (ps.isi_pesan || '') + "\"\n---\n\n";
    const tautanGmail = 'https://mail.google.com/mail/?view=cm&fs=1'
      + '&to=' + encodeURIComponent(ps.email || '')
      + '&su=' + encodeURIComponent('Re: ' + (ps.subjek || 'Pesan Website'))
      + '&body=' + encodeURIComponent(drafIsi);

    const tautanEmail = document.getElementById('modal-email-link');
    tautanEmail.textContent = ps.email || '-';
    tautanEmail.href = tautanGmail;

    document.getElementById('modal-tanggal').textContent = ps.created_at || '-';
    document.getElementById('modal-subjek').textContent  = ps.subjek || 'Tanpa Subjek';
    document.getElementById('modal-isi').textContent     = ps.isi_pesan || '';

    const statusEl = document.getElementById('modal-status');
    const btnToggle = document.getElementById('modal-btn-toggle');
    const filter = '<?= urlencode($filter) ?>';

    if (parseInt(ps.is_dibaca, 10) === 1) {
      statusEl.innerHTML  = '<span class="badge badge-ok"><i class="bi bi-check-circle-fill"></i> Sudah Dibaca</span>';
      btnToggle.innerHTML = '<i class="bi bi-envelope"></i> Tandai Belum Dibaca';
    } else {
      statusEl.innerHTML  = '<span class="badge badge-danger"><i class="bi bi-envelope-fill"></i> Belum Dibaca</span>';
      btnToggle.innerHTML = '<i class="bi bi-check-circle"></i> Tandai Sudah Dibaca';
    }
    btnToggle.href = 'index.php?toggle=' + ps.id + '&filter=' + filter;

    document.getElementById('modal-btn-balas').href = tautanGmail;
    document.getElementById('modal-pesan').style.display = 'flex';
  }

  function tutupModalPesan() {
    document.getElementById('modal-pesan').style.display = 'none';
  }

  window.addEventListener('click', function(e) {
    const modal = document.getElementById('modal-pesan');
    if (e.target === modal) tutupModalPesan();
  });
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>
