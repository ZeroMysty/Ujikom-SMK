<?php
// Inisialisasi dan autentikasi admin
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul        = 'Edit Foto Galeri';
$daftar_error = [];

$id_foto    = (int) ($_GET['id'] ?? 0);

// Ambil data foto galeri dari database
$pernyataan = koneksi_db()->prepare('SELECT * FROM galeri WHERE id = ?');
$pernyataan->execute([$id_foto]);
$baris = $pernyataan->fetch();

if (!$baris) {
    simpan_notifikasi('danger', 'Data foto galeri tidak ditemukan.');
    pindah_halaman('index.php');
}

// Proses pembaruan data foto galeri
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_foto = trim($_POST['judul'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    // Validasi judul wajib diisi
    if ($judul_foto === '') {
        $daftar_error[] = 'Judul foto wajib diisi.';
    }

    // Unggah gambar baru jika dipilih
    $gambar_baru = unggah_gambar('gambar', 'galeri');

    // Simpan perubahan ke database jika lolos validasi
    if (empty($daftar_error)) {
        if ($gambar_baru) {
            hapus_gambar($baris['gambar']);
            $gambar_final = $gambar_baru;
        } else {
            $gambar_final = $baris['gambar'];
        }

        $pernyataan_ubah = koneksi_db()->prepare(
            'UPDATE galeri SET judul = ?, keterangan = ?, gambar = ? WHERE id = ?'
        );
        $pernyataan_ubah->execute([$judul_foto, $keterangan, $gambar_final, $baris['id']]);

        simpan_notifikasi('success', 'Foto dokumentasi galeri berhasil diperbarui.');
        pindah_halaman('index.php');
    }
}

// Tombol navigasi kembali ke daftar galeri
$tombol_aksi = '<a class="btn btn-outline btn-sm" href="index.php"><i class="bi bi-arrow-left"></i> Kembali</a>';

require __DIR__ . '/../includes/header.php';
?>

<!-- Notifikasi Daftar Error Validasi -->
<?php if (!empty($daftar_error)): ?>
  <div class="alert alert-danger">
    <?= implode('<br>', array_map('e', $daftar_error)) ?>
  </div>
<?php endif; ?>

<!-- Formulir Edit Foto Dokumentasi -->
<div class="table-wrap" style="padding: 24px;">
  <form method="post" enctype="multipart/form-data" class="form-grid" style="max-width: 640px;">

    <!-- Input Judul Foto -->
    <div>
      <label for="judul">Judul Foto / Dokumentasi *</label>
      <input class="input" type="text" id="judul" name="judul" required
             value="<?= e($_POST['judul'] ?? $baris['judul']) ?>">
    </div>

    <!-- Input Keterangan Foto -->
    <div>
      <label for="keterangan">Keterangan Tambahan</label>
      <textarea class="input" id="keterangan" name="keterangan" rows="3"><?= e($_POST['keterangan'] ?? $baris['keterangan']) ?></textarea>
    </div>

    <!-- Penggantian Berkas Foto & Tampilan Foto Saat Ini -->
    <div>
      <label for="gambar">Ganti Berkas Foto</label>
      <input class="input" type="file" id="gambar" name="gambar" accept="image/*">
      <div class="form-hint">Biarkan kosong bila tidak ingin mengganti file gambar yang sudah ada.</div>

      <!-- Tampilan Foto Saat Ini -->
      <div style="margin-top: 12px;">
        <span class="form-hint" style="display: block; margin-bottom: 6px;">Foto yang saat ini digunakan:</span>
        <img style="width: 200px; height: 130px; object-fit: cover; border-radius: 10px; border: 1px solid var(--line);"
             src="<?= $root_base ?><?= e(gambar_item($baris['gambar'], 'galeri')) ?>"
             alt="Foto galeri saat ini">
      </div>
    </div>

    <!-- Tombol Simpan & Batal -->
    <div style="display: flex; gap: 10px; margin-top: 10px;">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Simpan Perubahan
      </button>
      <a class="btn btn-outline" href="index.php">Batal</a>
    </div>

  </form>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
