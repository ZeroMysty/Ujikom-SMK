<?php
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul        = 'Edit Produk';
$daftar_error = [];

// Ambil data produk berdasarkan ID
$id_produk = (int) ($_GET['id'] ?? 0);
$pernyataan = koneksi_db()->prepare('SELECT * FROM produk WHERE id = ?');
$pernyataan->execute([$id_produk]);
$baris = $pernyataan->fetch();

if (!$baris) {
    simpan_notifikasi('danger', 'Data produk tidak ditemukan.');
    pindah_halaman('index.php');
}

// Proses pembaruan data produk
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = trim($_POST['nama'] ?? '');
    $kategori  = trim($_POST['kategori'] ?? '') ?: 'Layanan';
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $harga     = (float) preg_replace('/[^\d]/', '', (string) ($_POST['harga'] ?? '0'));
    $is_aktif  = isset($_POST['is_aktif']) ? 1 : 0;

    if ($nama === '') {
        $daftar_error[] = 'Nama produk wajib diisi.';
    }
    if ($harga <= 0) {
        $daftar_error[] = 'Harga produk harus berupa angka dan lebih dari 0.';
    }

    $gambar_baru = unggah_gambar('gambar', 'produk');

    if (empty($daftar_error)) {
        if ($gambar_baru) {
            hapus_gambar($baris['gambar']);
            $gambar_final = $gambar_baru;
        } else {
            $gambar_final = $baris['gambar'];
        }

        $pernyataan_ubah = koneksi_db()->prepare(
            'UPDATE produk SET nama = ?, kategori = ?, deskripsi = ?, harga = ?, gambar = ?, is_aktif = ? WHERE id = ?'
        );
        $pernyataan_ubah->execute([$nama, $kategori, $deskripsi, $harga, $gambar_final, $is_aktif, $baris['id']]);

        simpan_notifikasi('success', 'Produk "' . $nama . '" berhasil diperbarui.');
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

<!-- Formulir Edit Produk -->
<div class="table-wrap" style="padding: 24px;">
  <form method="post" enctype="multipart/form-data" class="form-grid" style="max-width: 640px;">
    
    <!-- Input Nama Produk -->
    <div>
      <label for="nama">Nama Produk / Layanan *</label>
      <input class="input" type="text" id="nama" name="nama" required
             value="<?= e($_POST['nama'] ?? $baris['nama']) ?>">
    </div>

    <!-- Pilihan Kategori & Input Harga -->
    <div class="form-row">
      <div>
        <label for="kategori">Kategori</label>
        <select class="input" id="kategori" name="kategori">
          <?php foreach (['Layanan', 'Solusi', 'Produk', 'Konsultasi'] as $kat): ?>
            <option value="<?= $kat ?>" <?= ($_POST['kategori'] ?? $baris['kategori']) === $kat ? 'selected' : '' ?>>
              <?= $kat ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="harga">Harga (Rp) *</label>
        <input class="input" type="text" id="harga" name="harga" required
               value="<?= e($_POST['harga'] ?? (string) (int) $baris['harga']) ?>">
        <div class="form-hint">Tulis tanpa tanda titik atau koma (contoh: 7500000).</div>
      </div>
    </div>

    <!-- Input Deskripsi Produk -->
    <div>
      <label for="deskripsi">Deskripsi</label>
      <textarea class="input" id="deskripsi" name="deskripsi" rows="4"><?= e($_POST['deskripsi'] ?? $baris['deskripsi']) ?></textarea>
    </div>

    <!-- Penggantian Foto Produk -->
    <div>
      <label for="gambar">Ganti Foto Produk</label>
      <input class="input" type="file" id="gambar" name="gambar" accept="image/*">
      <div class="form-hint">Biarkan kosong bila tidak ingin mengganti foto saat ini.</div>

      <?php if (!empty($baris['gambar'])): ?>
        <div style="margin-top: 10px; display: flex; align-items: center; gap: 10px;">
          <img class="thumb" src="<?= $root_base ?><?= e(gambar_item($baris['gambar'], 'produk')) ?>" alt="Foto produk saat ini">
          <span class="form-hint" style="margin: 0;">Foto yang aktif digunakan saat ini.</span>
        </div>
      <?php endif; ?>
    </div>

    <!-- Pengaturan Status Publikasi -->
    <div>
      <label style="display: flex; align-items: center; gap: 10px; font-weight: 500; cursor: pointer;">
        <input type="checkbox" name="is_aktif" value="1"
               <?= ($_POST['is_aktif'] ?? $baris['is_aktif']) ? 'checked' : '' ?>>
        <span>Tampilkan produk ini di halaman katalog website publik</span>
      </label>
    </div>

    <!-- Tombol Aksi Simpan & Batal -->
    <div style="display: flex; gap: 10px; margin-top: 10px;">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Simpan Perubahan
      </button>
      <a class="btn btn-outline" href="index.php">Batal</a>
    </div>

  </form>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
