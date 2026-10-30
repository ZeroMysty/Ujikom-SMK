<?php
// Inisialisasi dan autentikasi admin
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul = 'Galeri Foto';

// Hapus foto dokumentasi beserta berkasnya jika ada parameter hapus
if (isset($_GET['hapus'])) {
    $id_foto    = (int) $_GET['hapus'];
    $pernyataan = koneksi_db()->prepare('SELECT gambar FROM galeri WHERE id = ?');
    $pernyataan->execute([$id_foto]);
    $baris = $pernyataan->fetch();

    if ($baris) {
        hapus_gambar($baris['gambar']);
        koneksi_db()->prepare('DELETE FROM galeri WHERE id = ?')->execute([$id_foto]);
        simpan_notifikasi('success', 'Foto galeri berhasil dihapus.');
    }

    pindah_halaman('index.php');
}

// Ambil semua data foto dokumentasi dari database
$daftar      = koneksi_db()->query('SELECT * FROM galeri ORDER BY created_at DESC, id DESC')->fetchAll();

// Tombol navigasi aksi tambah foto dokumentasi
$tombol_aksi = '<a class="btn btn-primary btn-sm" href="create.php"><i class="bi bi-plus-lg"></i> Tambah Foto</a>';

require __DIR__ . '/../includes/header.php';
?>

<!-- Notifikasi Status Aksi -->
<?php if ($notifikasi = ambil_notifikasi()): ?>
  <div class="alert alert-<?= e($notifikasi['tipe']) ?>">
    <?= e($notifikasi['pesan']) ?>
  </div>
<?php endif; ?>

<!-- Tabel Daftar Dokumentasi Galeri -->
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr>
        <th style="width: 100px;">Foto</th>
        <th>Judul Foto</th>
        <th>Keterangan Singkat</th>
        <th>Tanggal Unggah</th>
        <th style="width: 160px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <!-- Kondisi jika galeri masih kosong -->
      <?php if (empty($daftar)): ?>
        <tr>
          <td colspan="5" style="text-align: center; color: var(--muted); padding: 32px;">
            Belum ada dokumentasi foto. Klik tombol <strong>"Tambah Foto"</strong> untuk menambahkan.
          </td>
        </tr>
      <?php else: ?>
        <!-- Perulangan baris foto dokumentasi -->
        <?php foreach ($daftar as $baris): ?>
          <tr>
            <!-- Thumbnail foto -->
            <td>
              <img class="thumb"
                   style="width: 80px; height: 54px; object-fit: cover;"
                   src="<?= $root_base ?><?= e(gambar_item($baris['gambar'], 'galeri')) ?>"
                   alt="<?= e($baris['judul']) ?>">
            </td>
            <!-- Judul foto -->
            <td><strong><?= e($baris['judul']) ?></strong></td>
            <!-- Keterangan foto -->
            <td><?= e($baris['keterangan'] ?: '—') ?></td>
            <!-- Tanggal unggah -->
            <td><?= e(tanggal_id($baris['created_at'])) ?></td>
            <!-- Tombol aksi edit & hapus -->
            <td>
              <div style="display: flex; gap: 6px;">
                <a class="btn btn-outline btn-sm" href="edit.php?id=<?= (int) $baris['id'] ?>">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <a class="btn btn-danger btn-sm"
                   href="index.php?hapus=<?= (int) $baris['id'] ?>"
                   onclick="return confirm('Apakah Anda yakin ingin menghapus foto dokumentasi ini?');">
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
