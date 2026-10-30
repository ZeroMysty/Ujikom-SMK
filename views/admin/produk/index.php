<?php
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul = 'Produk & Layanan';

// Proses hapus produk beserta gambarnya
if (isset($_GET['hapus'])) {
    $id_produk  = (int) $_GET['hapus'];
    $pernyataan = koneksi_db()->prepare('SELECT gambar FROM produk WHERE id = ?');
    $pernyataan->execute([$id_produk]);
    $baris = $pernyataan->fetch();

    if ($baris) {
        hapus_gambar($baris['gambar']);
        koneksi_db()->prepare('DELETE FROM produk WHERE id = ?')->execute([$id_produk]);
        simpan_notifikasi('success', 'Produk berhasil dihapus beserta gambarnya.');
    }

    pindah_halaman('index.php');
}

// Ambil seluruh daftar produk
$daftar     = koneksi_db()->query('SELECT * FROM produk ORDER BY created_at DESC, id DESC')->fetchAll();
$tombol_aksi = '<a class="btn btn-primary btn-sm" href="create.php"><i class="bi bi-plus-lg"></i> Tambah Produk</a>';

require __DIR__ . '/../includes/header.php';
?>

<!-- Notifikasi Status -->
<?php if ($notifikasi = ambil_notifikasi()): ?>
  <div class="alert alert-<?= e($notifikasi['tipe']) ?>">
    <?= e($notifikasi['pesan']) ?>
  </div>
<?php endif; ?>

<!-- Tabel Daftar Produk & Layanan -->
<div class="table-wrap">
  <table class="table">
    <thead>
      <tr>
        <th style="width: 80px;">Gambar</th>
        <th>Nama Produk / Layanan</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Status</th>
        <th style="width: 160px;">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($daftar)): ?>
        <tr>
          <td colspan="6" style="text-align: center; color: var(--muted); padding: 32px;">
            Belum ada data produk. Klik tombol <strong>"Tambah Produk"</strong> untuk memulai.
          </td>
        </tr>
      <?php else: ?>
        <?php foreach ($daftar as $baris): ?>
          <tr>
            <td>
              <img class="thumb"
                   src="<?= $root_base ?><?= e(gambar_item($baris['gambar'], 'produk')) ?>"
                   alt="<?= e($baris['nama']) ?>">
            </td>
            <td><strong><?= e($baris['nama']) ?></strong></td>
            <td><span class="badge"><?= e($baris['kategori']) ?></span></td>
            <td><?= e(rupiah($baris['harga'])) ?></td>
            <td>
              <?php if ($baris['is_aktif']): ?>
                <span class="badge badge-ok"><i class="bi bi-check-circle"></i> Aktif</span>
              <?php else: ?>
                <span class="badge badge-danger"><i class="bi bi-eye-slash"></i> Nonaktif</span>
              <?php endif; ?>
            </td>
            <td>
              <div style="display: flex; gap: 6px;">
                <a class="btn btn-outline btn-sm" href="edit.php?id=<?= (int) $baris['id'] ?>">
                  <i class="bi bi-pencil"></i> Edit
                </a>
                <a class="btn btn-danger btn-sm"
                   href="index.php?hapus=<?= (int) $baris['id'] ?>"
                   onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini? Gambar juga akan terhapus.');">
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
