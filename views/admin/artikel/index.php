<?php
// Inisialisasi dan autentikasi admin
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul        = 'Daftar Artikel';

// Hapus artikel beserta berkas gambarnya jika ada parameter hapus
if (isset($_GET['hapus'])) {
    $id_artikel = (int) $_GET['hapus'];
    $pernyataan_cari = koneksi_db()->prepare('SELECT gambar FROM artikel WHERE id = ?');
    $pernyataan_cari->execute([$id_artikel]);
    $baris = $pernyataan_cari->fetch();

    if ($baris) {
        hapus_gambar($baris['gambar']);
        koneksi_db()->prepare('DELETE FROM artikel WHERE id = ?')->execute([$id_artikel]);
        simpan_notifikasi('success', 'Artikel berhasil dihapus.');
    }

    pindah_halaman('index.php');
}

// Ambil seluruh data artikel dari database
$daftar_artikel = koneksi_db()->query(
    'SELECT * FROM artikel ORDER BY created_at DESC, id DESC'
)->fetchAll();

// Tombol navigasi aksi tambah artikel baru
$tombol_aksi = '<a class="btn btn-primary btn-sm" href="create.php"><i class="bi bi-plus-lg"></i> Tulis Artikel Baru</a>';

require __DIR__ . '/../includes/header.php';
?>

<!-- Notifikasi Status Aksi -->
<?php if ($notifikasi = ambil_notifikasi()): ?>
  <div class="alert alert-<?= e($notifikasi['tipe']) ?>" style="margin-bottom: 20px;">
    <i class="bi bi-info-circle-fill me-2"></i>
    <?= e($notifikasi['pesan']) ?>
  </div>
<?php endif; ?>

<!-- Tabel Daftar Artikel -->
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr>
        <th style="width: 90px;">Sampul</th>
        <th>Judul Artikel</th>
        <th>Penulis</th>
        <th>Tanggal Dibuat</th>
        <th style="width: 120px;">Status</th>
        <th style="width: 170px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- Kondisi jika data artikel masih kosong -->
      <?php if (empty($daftar_artikel)): ?>
        <tr>
          <td colspan="6" style="text-align: center; color: var(--muted); padding: 40px 20px;">
            <i class="bi bi-journal-x" style="font-size: 32px; display: block; margin-bottom: 8px; opacity: 0.5;"></i>
            Belum ada artikel yang dibuat. Klik tombol <strong>"Tulis Artikel Baru"</strong> di kanan atas untuk memulai.
          </td>
        </tr>
      <?php else: ?>
        <!-- Perulangan baris artikel -->
        <?php foreach ($daftar_artikel as $baris): ?>
          <tr>
            <!-- Sampul artikel -->
            <td>
              <img class="thumb"
                   src="<?= $root_base ?><?= e(gambar_item($baris['gambar'], 'artikel')) ?>"
                   alt="Sampul <?= e($baris['judul']) ?>"
                   style="border-radius: 8px; object-fit: cover;">
            </td>
            <!-- Judul & Slug URL -->
            <td>
              <strong style="color: #0f172a; font-size: 14.5px; display: block;">
                <?= e($baris['judul']) ?>
              </strong>
              <span style="font-size: 12px; color: var(--muted);">
                /<?= e($baris['slug']) ?>
              </span>
            </td>
            <!-- Penulis artikel -->
            <td style="color: #475569;">
              <i class="bi bi-person me-1"></i><?= e($baris['penulis']) ?>
            </td>
            <!-- Tanggal pembuatan -->
            <td style="color: #64748b; font-size: 13px;">
              <?= e(tanggal_id($baris['created_at'])) ?>
            </td>
            <!-- Status publikasi -->
            <td>
              <?php if ($baris['is_publikasi']): ?>
                <span class="badge badge-ok"><i class="bi bi-check-circle-fill"></i> Publik</span>
              <?php else: ?>
                <span class="badge badge-danger"><i class="bi bi-file-earmark"></i> Draf</span>
              <?php endif; ?>
            </td>
            <!-- Tombol aksi edit dan hapus -->
            <td>
              <div style="display: flex; gap: 6px; align-items: center;">
                <a class="btn btn-outline btn-sm" href="edit.php?id=<?= (int) $baris['id'] ?>">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <a class="btn btn-danger btn-sm" href="index.php?hapus=<?= (int) $baris['id'] ?>"
                   onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini? Berkas gambar juga akan ikut terhapus.');">
                  <i class="bi bi-trash"></i> Hapus
                </a>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
