<?php
// Inisialisasi dan autentikasi admin
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul        = 'Tambah Foto Galeri';
$daftar_error = [];

// Proses formulir penambahan foto dokumentasi baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_foto = trim($_POST['judul'] ?? '');
    $keterangan = trim($_POST['keterangan'] ?? '');

    // Validasi judul wajib diisi
    if ($judul_foto === '') {
        $daftar_error[] = 'Judul foto wajib diisi.';
    }

    // Unggah dan validasi berkas foto
    $gambar = unggah_gambar('gambar', 'galeri');
    if (!$gambar) {
        $daftar_error[] = 'Berkas foto dokumentasi wajib dipilih dan diunggah.';
    }

    // Simpan ke database jika tidak ada error
    if (empty($daftar_error)) {
        $pernyataan = koneksi_db()->prepare(
            'INSERT INTO galeri (judul, keterangan, gambar) VALUES (?, ?, ?)'
        );
        $pernyataan->execute([$judul_foto, $keterangan, $gambar]);

        simpan_notifikasi('success', 'Foto "' . $judul_foto . '" berhasil ditambahkan ke galeri.');
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

<!-- Formulir Tambah Foto Dokumentasi -->
<div class="table-wrap" style="padding: 24px;">
  <form method="post" enctype="multipart/form-data" class="form-grid" style="max-width: 640px;">

    <!-- Input Judul Foto -->
    <div>
      <label for="judul">Judul Foto / Dokumentasi *</label>
      <input class="input" type="text" id="judul" name="judul" required
             placeholder="Contoh: Rapat Kerja Tahunan 2026"
             value="<?= e($_POST['judul'] ?? '') ?>">
    </div>

    <!-- Input Keterangan Foto -->
    <div>
      <label for="keterangan">Keterangan Tambahan</label>
      <textarea class="input" id="keterangan" name="keterangan" rows="3"
                placeholder="Tuliskan cerita singkat atau lokasi dokumentasi ini..."><?= e($_POST['keterangan'] ?? '') ?></textarea>
    </div>

    <!-- Input Berkas Foto -->
    <div>
      <label for="gambar">Pilih Berkas Foto *</label>
      <input class="input" type="file" id="gambar" name="gambar" accept="image/*" required>
      <div class="form-hint">Mendukung file: JPG, PNG, WebP, SVG (ukuran maks 20 MB).</div>
    </div>

    <!-- Tombol Simpan & Batal -->
    <div style="display: flex; gap: 10px; margin-top: 10px;">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-cloud-arrow-up"></i> Simpan Foto
      </button>
      <a class="btn btn-outline" href="index.php">Batal</a>
    </div>

  </form>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
