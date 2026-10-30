<?php
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul        = 'Tambah Produk';
$daftar_error = [];

// Proses penambahan produk baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = trim($_POST['nama'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? '') ?: 'Layanan';
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $harga     = (float) preg_replace('/[^\d]/', '', (string) ($_POST['harga'] ?? '0'));

    if ($nama === '') {
        $daftar_error[] = 'Nama produk wajib diisi.';
    }
    if ($harga <= 0) {
        $daftar_error[] = 'Harga produk harus berupa angka dan lebih dari 0.';
    }

    $gambar = unggah_gambar('gambar', 'produk');

    if (empty($daftar_error)) {
        $pernyataan = koneksi_db()->prepare(
            'INSERT INTO produk (nama, kategori, deskripsi, harga, gambar) VALUES (?, ?, ?, ?, ?)'
        );
        $pernyataan->execute([$nama, $kategori, $deskripsi, $harga, $gambar]);

        simpan_notifikasi('success', 'Produk "' . $nama . '" berhasil ditambahkan.');
        pindah_halaman('index.php');
    }
}

$tombol_aksi = '<a class="btn btn-outline btn-sm" href="index.php"><i class="bi bi-arrow-left"></i> Kembali</a>';

require __DIR__ . '/../includes/header.php';
?>

<!-- Kotak Peringatan Validasi -->
<?php if (!empty($daftar_error)): ?>
  <div class="alert alert-danger">
    <?= implode('<br>', array_map('e', $daftar_error)) ?>
  </div>
<?php endif; ?>

<!-- Formulir Tambah Produk -->
<div class="table-wrap" style="padding: 24px;">
  <form method="post" enctype="multipart/form-data" class="form-grid" style="max-width: 640px;">

    <!-- Input Nama Produk -->
    <div>
      <label for="nama">Nama Produk / Layanan *</label>
      <input class="input" type="text" id="nama" name="nama" required
             placeholder="Contoh: Pembuatan Website Bisnis"
             value="<?= e($_POST['nama'] ?? '') ?>">
    </div>

    <!-- Pilihan Kategori & Input Harga -->
    <div class="form-row">
      <div>
        <label for="kategori">Kategori</label>
        <select class="input" id="kategori" name="kategori">
          <?php foreach (['Layanan', 'Solusi', 'Produk', 'Konsultasi'] as $kat): ?>
            <option value="<?= $kat ?>" <?= ($_POST['kategori'] ?? '') === $kat ? 'selected' : '' ?>>
              <?= $kat ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="harga">Harga (Rp) *</label>
        <input class="input" type="text" id="harga" name="harga" required
               placeholder="Contoh: 7500000"
               value="<?= e($_POST['harga'] ?? '') ?>">
        <div class="form-hint">Tulis angka tanpa tanda titik/koma.</div>
      </div>
    </div>

    <!-- Input Deskripsi Produk -->
    <div>
      <label for="deskripsi">Deskripsi Lengkap</label>
      <textarea class="input" id="deskripsi" name="deskripsi" rows="4"
                placeholder="Jelaskan fitur, manfaat, dan rincian produk/layanan ini..."><?= e($_POST['deskripsi'] ?? '') ?></textarea>
    </div>

    <!-- Unggah Foto Produk -->
    <div>
      <label for="gambar">Foto Produk</label>
      <input class="input" type="file" id="gambar" name="gambar" accept="image/*">
      <div class="form-hint">Format yang didukung: JPG, PNG, WebP, SVG (maks 20 MB). Jika dikosongkan, gambar bawaan akan digunakan.</div>
    </div>

    <!-- Tombol Aksi Simpan & Batal -->
    <div style="display: flex; gap: 10px; margin-top: 10px;">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Simpan Produk
      </button>
      <a class="btn btn-outline" href="index.php">Batal</a>
    </div>

  </form>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
