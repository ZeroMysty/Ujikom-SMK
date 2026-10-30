<?php
// Inisialisasi dan autentikasi admin
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul        = 'Tulis Artikel';
$daftar_error = [];

// Proses formulir penambahan artikel baru
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_artikel = trim($_POST['judul'] ?? '');
    $slug          = buat_slug($_POST['slug'] ?? '') ?: buat_slug($judul_artikel);
    $penulis       = trim($_POST['penulis'] ?? '') ?: 'Admin';
    $isi           = trim($_POST['isi'] ?? '');
    $publikasi     = isset($_POST['is_publikasi']) ? 1 : 0;

    // Validasi judul wajib diisi
    if ($judul_artikel === '') {
        $daftar_error[] = 'Judul artikel wajib diisi.';
    }

    // Penanganan keunikan slug
    if (!$daftar_error) {
        $pernyataan_slug = koneksi_db()->prepare('SELECT COUNT(*) FROM artikel WHERE slug = ?');
        $pernyataan_slug->execute([$slug]);
        if ($pernyataan_slug->fetchColumn() > 0) {
            $slug .= '-' . date('His');
        }
    }

    // Unggah gambar sampul jika dilampirkan
    $error_unggah = null;
    $gambar = unggah_gambar('gambar', 'artikel', $error_unggah);
    if ($error_unggah) {
        $daftar_error[] = $error_unggah;
    }

    // Simpan ke database jika tidak ada error
    if (!$daftar_error) {
        $pernyataan_simpan = koneksi_db()->prepare(
            'INSERT INTO artikel (judul, slug, penulis, isi, gambar, is_publikasi) VALUES (?, ?, ?, ?, ?, ?)'
        );
        $pernyataan_simpan->execute([$judul_artikel, $slug, $penulis, $isi, $gambar, $publikasi]);

        simpan_notifikasi('success', 'Artikel "' . $judul_artikel . '" berhasil disimpan.');
        pindah_halaman('index.php');
    }
}

// Tombol navigasi kembali ke daftar artikel
$tombol_aksi = '<a class="btn btn-outline btn-sm" href="index.php"><i class="bi bi-arrow-left"></i> Kembali</a>';

require __DIR__ . '/../includes/header.php';
?>

<!-- Resource CSS Quill Editor -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
  .ql-toolbar.ql-snow {
    border: 1px solid #e2e8f0 !important;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    background: #f8fafc;
    padding: 10px 12px;
  }
  .ql-container.ql-snow {
    height: auto !important;
    border: 1px solid #e2e8f0 !important;
    border-top: none !important;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    font-family: inherit !important;
    font-size: 15px;
    background: #ffffff;
  }
  .ql-editor {
    min-height: 280px;
    line-height: 1.75;
    color: #1e293b;
  }
  .ql-editor img {
    max-width: 100%;
    border-radius: 8px;
    margin: 10px 0;
  }
  .form-group-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-bottom: 18px;
  }
</style>

<!-- Notifikasi Daftar Error Validasi -->
<?php if ($daftar_error): ?>
  <div class="alert alert-danger" style="margin-bottom: 20px;">
    <i class="bi bi-exclamation-triangle-fill me-2"></i>
    <?= implode('<br>', array_map('e', $daftar_error)) ?>
  </div>
<?php endif; ?>

<!-- Formulir Pembuatan Artikel -->
<div class="table-wrap" style="padding: 28px;">
  <form id="form-artikel" method="post" enctype="multipart/form-data" class="form-grid" style="max-width: 860px;">

    <!-- Input Judul Artikel -->
    <div class="form-group-item">
      <label for="judul" style="font-weight: 700; color: #1e293b;">
        Judul Artikel <span style="color: #ef4444;">*</span>
      </label>
      <input class="input" type="text" id="judul" name="judul" required
             placeholder="Tuliskan judul artikel yang menarik..."
             value="<?= e($_POST['judul'] ?? '') ?>">
      <div class="form-hint">Judul artikel yang akan dibaca oleh pengunjung website.</div>
    </div>

    <!-- Baris Slug URL & Penulis -->
    <div class="form-row">
      <div class="form-group-item">
        <label for="slug" style="font-weight: 700; color: #1e293b;">Slug URL</label>
        <input class="input" type="text" id="slug" name="slug"
               placeholder="dibuat otomatis dari judul..."
               value="<?= e($_POST['slug'] ?? '') ?>">
        <div class="form-hint">Kosongkan saja untuk dibuat otomatis berdasarkan judul di atas.</div>
      </div>

      <div class="form-group-item">
        <label for="penulis" style="font-weight: 700; color: #1e293b;">Nama Penulis</label>
        <input class="input" type="text" id="penulis" name="penulis"
               placeholder="Admin"
               value="<?= e($_POST['penulis'] ?? 'Admin') ?>">
        <div class="form-hint">Nama penulis yang ditampilkan pada detail artikel.</div>
      </div>
    </div>

    <!-- Editor Konten Artikel (Quill) -->
    <div class="form-group-item">
      <label style="font-weight: 700; color: #1e293b;">Isi Konten Artikel</label>
      <div id="editor-container"><?= $_POST['isi'] ?? '' ?></div>
      <input type="hidden" name="isi" id="isi_input">
      <div class="form-hint" style="margin-top: 8px;">
        <i class="bi bi-info-circle me-1"></i> Gunakan tombol di atas untuk membuat judul bab (Heading), format tebal/miring, daftar angka/poin, kutipan, dan gambar langsung di dalam teks.
      </div>
    </div>

    <!-- Unggah Gambar Sampul & Pratinjau -->
    <div class="form-group-item">
      <label for="gambar" style="font-weight: 700; color: #1e293b;">
        Gambar Sampul Utama (Featured Image)
      </label>
      <input class="input" type="file" id="gambar" name="gambar" accept="image/*">
      <div class="form-hint">Format: JPG, PNG, WebP, SVG, GIF (Maksimal 20 MB). Kosongkan jika ingin memakai gambar standar.</div>

      <!-- Kotak Pratinjau Gambar -->
      <div id="preview_box" style="margin-top: 14px; display: none; align-items: center; gap: 16px; padding: 14px 18px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
        <img id="image_preview" src="" alt="Pratinjau"
             style="width: 110px; height: 74px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; background: #eff6ff;">
        <div>
          <span id="preview_badge" class="badge badge-ok" style="display: inline-block; margin-bottom: 4px; font-size: 11px;">Gambar Terpilih</span>
          <div id="preview_filename" style="font-size: 14px; color: #1e293b; font-weight: 700;"></div>
          <div id="preview_filesize" style="font-size: 12.5px; color: #64748b; margin-top: 2px;"></div>
        </div>
      </div>
    </div>

    <!-- Pengaturan Status Publikasi -->
    <div class="checkbox-row" style="margin: 10px 0 24px;">
      <input type="checkbox" id="is_publikasi" name="is_publikasi" value="1" checked>
      <label for="is_publikasi" style="margin: 0; font-weight: 600; cursor: pointer; color: #1e293b;">
        Publikasikan langsung agar tampil di website publik
      </label>
    </div>

    <!-- Tombol Simpan & Batal -->
    <div style="display: flex; gap: 10px; align-items: center; padding-top: 10px; border-top: 1px solid #f1f5f9;">
      <button type="submit" id="btn-submit" class="btn btn-primary" style="padding: 10px 22px;">
        <i class="bi bi-send-check"></i> Simpan Artikel
      </button>
      <a class="btn btn-outline" href="index.php" style="padding: 10px 18px;">Batal</a>
    </div>

  </form>
</div>

<!-- Script Inisialisasi Editor Quill & Pratinjau Gambar -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
  // Inisialisasi Quill editor
  const quill = new Quill('#editor-container', {
    theme: 'snow',
    placeholder: 'Tulis isi artikel lengkap di sini...',
    modules: {
      toolbar: [
        [{ 'header': [2, 3, 4, false] }],
        ['bold', 'italic', 'underline', 'strike'],
        [{ 'color': [] }, { 'background': [] }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        ['blockquote', 'code-block'],
        [{ 'align': [] }],
        ['link', 'image'],
        ['clean']
      ]
    }
  });

  // Sinkronisasi HTML editor ke input hidden sebelum submit
  document.getElementById('form-artikel').addEventListener('submit', function() {
    const html = quill.root.innerHTML;
    document.getElementById('isi_input').value =
      (quill.getText().trim().length === 0 && !html.includes('<img')) ? '' : html;
  });

  // Logika live preview gambar dan validasi ukuran
  const gambarInput     = document.getElementById('gambar');
  const previewBox      = document.getElementById('preview_box');
  const imagePreview    = document.getElementById('image_preview');
  const previewBadge    = document.getElementById('preview_badge');
  const previewFilename = document.getElementById('preview_filename');
  const previewFilesize = document.getElementById('preview_filesize');
  const btnSubmit       = document.getElementById('btn-submit');

  gambarInput.addEventListener('change', function(e) {
    const berkas = e.target.files[0];
    if (berkas) {
      previewFilename.textContent = berkas.name;
      const ukuranKB   = (berkas.size / 1024).toFixed(1);
      const teksUkuran = berkas.size > 1024 * 1024
        ? (berkas.size / (1024 * 1024)).toFixed(2) + ' MB'
        : ukuranKB + ' KB';

      if (berkas.size > 20 * 1024 * 1024) {
        previewBadge.className   = 'badge badge-danger';
        previewBadge.textContent = 'Ukuran Terlalu Besar (Maks 20 MB)';
        previewFilesize.textContent = 'Ukuran berkas: ' + teksUkuran + ' — Mohon pilih berkas di bawah 20 MB.';
        btnSubmit.disabled = true;
      } else {
        previewBadge.className   = 'badge badge-ok';
        previewBadge.textContent = 'Gambar Terpilih (Siap Diunggah)';
        previewFilesize.textContent = 'Ukuran berkas: ' + teksUkuran;
        btnSubmit.disabled = false;
      }

      const pembacaBerkas = new FileReader();
      pembacaBerkas.onload = function(event) {
        imagePreview.src = event.target.result;
        previewBox.style.display = 'flex';
      };
      pembacaBerkas.readAsDataURL(berkas);
    } else {
      previewBox.style.display = 'none';
      btnSubmit.disabled = false;
    }
  });
</script>

<?php require __DIR__ . '/../includes/footer.php'; ?>
