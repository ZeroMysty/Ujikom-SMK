<?php
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul = 'Edit Profil Perusahaan';
$daftar_error = [];

// Ambil data profil dari database
$profil = ambil_profil();

// Proses simpan perubahan profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama_perusahaan' => trim($_POST['nama_perusahaan'] ?? ''),
        'tagline'         => trim($_POST['tagline'] ?? ''),
        'deskripsi'       => trim($_POST['deskripsi'] ?? ''),
        'sejarah'         => trim($_POST['sejarah'] ?? ''),
        'visi'            => trim($_POST['visi'] ?? ''),
        'misi'            => trim($_POST['misi'] ?? ''),
        'alamat'          => trim($_POST['alamat'] ?? ''),
        'telepon'         => trim($_POST['telepon'] ?? ''),
        'email'           => trim($_POST['email'] ?? ''),
        'whatsapp'        => trim($_POST['whatsapp'] ?? ''),
        'instagram'       => trim($_POST['instagram'] ?? ''),
        'linkedin'        => trim($_POST['linkedin'] ?? ''),
        'maps_embed'      => trim($_POST['maps_embed'] ?? ''),
        'tahun_berdiri'   => (int) ($_POST['tahun_berdiri'] ?? 0) ?: null,
    ];

    if ($data['nama_perusahaan'] === '') {
        $daftar_error[] = 'Nama perusahaan wajib diisi.';
    }

    $logo_baru = unggah_gambar('logo', 'logo');

    if (empty($daftar_error)) {
        $logo_final = $logo_baru ?: ($profil['logo'] ?? null);

        if ($profil) {
            $kueri_sql = 'UPDATE profil SET 
                nama_perusahaan = ?, tagline = ?, deskripsi = ?, sejarah = ?, visi = ?, misi = ?,
                alamat = ?, telepon = ?, email = ?, whatsapp = ?, instagram = ?, linkedin = ?, 
                maps_embed = ?, tahun_berdiri = ?, logo = ?
                WHERE id = ?';
            
            $pernyataan = koneksi_db()->prepare($kueri_sql);
            $pernyataan->execute([...array_values($data), $logo_final, $profil['id']]);
        } else {
            $kueri_sql = 'INSERT INTO profil (
                nama_perusahaan, tagline, deskripsi, sejarah, visi, misi, 
                alamat, telepon, email, whatsapp, instagram, linkedin, 
                maps_embed, tahun_berdiri, logo
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            
            $pernyataan = koneksi_db()->prepare($kueri_sql);
            $pernyataan->execute([...array_values($data), $logo_final]);
        }

        simpan_notifikasi('success', 'Profil perusahaan berhasil diperbarui.');
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

<!-- Formulir Pengaturan Profil -->
<div class="table-wrap" style="padding: 24px;">
  <form method="post" enctype="multipart/form-data" class="form-grid" style="max-width: 760px;">
    
    <!-- Bagian Identitas Utama Perusahaan -->
    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 6px; padding-bottom: 8px; border-bottom: 1px solid var(--line);">
      <i class="bi bi-building text-primary"></i> Identitas Utama Perusahaan
    </h3>

    <div>
      <label for="nama_perusahaan">Nama Perusahaan *</label>
      <input class="input" 
             type="text" 
             id="nama_perusahaan" 
             name="nama_perusahaan" 
             required
             value="<?= e($_POST['nama_perusahaan'] ?? $profil['nama_perusahaan'] ?? '') ?>">
    </div>

    <div>
      <label for="tagline">Slogan / Tagline</label>
      <input class="input" 
             type="text" 
             id="tagline" 
             name="tagline" 
             placeholder="Contoh: Solusi Digital Terpercaya untuk Bisnis Modern"
             value="<?= e($_POST['tagline'] ?? $profil['tagline'] ?? '') ?>">
    </div>

    <div>
      <label for="deskripsi">Deskripsi Singkat</label>
      <textarea class="input" 
                id="deskripsi" 
                name="deskripsi" 
                rows="3" 
                placeholder="Rangkuman profil singkat yang tampil di beranda..."><?= e($_POST['deskripsi'] ?? $profil['deskripsi'] ?? '') ?></textarea>
    </div>

    <div>
      <label for="sejarah">Sejarah Lengkap Perusahaan</label>
      <textarea class="input" 
                id="sejarah" 
                name="sejarah" 
                rows="5" 
                placeholder="Tuliskan cerita berdirinya perusahaan, tonggak pencapaian, dan perkembangannya..."><?= e($_POST['sejarah'] ?? $profil['sejarah'] ?? '') ?></textarea>
    </div>

    <!-- Bagian Visi & Misi -->
    <div class="form-row">
      <div>
        <label for="visi">Visi Perusahaan</label>
        <textarea class="input" 
                  id="visi" 
                  name="visi" 
                  rows="4" 
                  placeholder="Cita-cita jangka panjang perusahaan..."><?= e($_POST['visi'] ?? $profil['visi'] ?? '') ?></textarea>
      </div>
      
      <div>
        <label for="misi">Misi Perusahaan</label>
        <textarea class="input" 
                  id="misi" 
                  name="misi" 
                  rows="4" 
                  placeholder="Satu butir misi per baris"><?= e($_POST['misi'] ?? $profil['misi'] ?? '') ?></textarea>
        <div class="form-hint">Tuliskan setiap poin misi dengan baris baru (tekan Enter).</div>
      </div>
    </div>

    <!-- Bagian Kontak & Lokasi -->
    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 14px; margin-bottom: 6px; padding-bottom: 8px; border-bottom: 1px solid var(--line);">
      <i class="bi bi-geo-alt text-primary"></i> Kontak &amp; Lokasi
    </h3>

    <div>
      <label for="alamat">Alamat Lengkap Kantor</label>
      <input class="input" 
             type="text" 
             id="alamat" 
             name="alamat" 
             value="<?= e($_POST['alamat'] ?? $profil['alamat'] ?? '') ?>">
    </div>

    <div class="form-row">
      <div>
        <label for="telepon">Nomor Telepon Kantor</label>
        <input class="input" 
               type="text" 
               id="telepon" 
               name="telepon" 
               placeholder="021-12345678"
               value="<?= e($_POST['telepon'] ?? $profil['telepon'] ?? '') ?>">
      </div>
      
      <div>
        <label for="whatsapp">Nomor WhatsApp Resmi</label>
        <input class="input" 
               type="text" 
               id="whatsapp" 
               name="whatsapp" 
               placeholder="Contoh: 081234567890"
               value="<?= e($_POST['whatsapp'] ?? $profil['whatsapp'] ?? '') ?>">
      </div>
    </div>

    <div class="form-row">
      <div>
        <label for="email">Alamat Email Resmi</label>
        <input class="input" 
               type="email" 
               id="email" 
               name="email" 
               placeholder="kontak@perusahaan.com"
               value="<?= e($_POST['email'] ?? $profil['email'] ?? '') ?>">
      </div>
      
      <div>
        <label for="tahun_berdiri">Tahun Berdiri</label>
        <input class="input" 
               type="number" 
               id="tahun_berdiri" 
               name="tahun_berdiri" 
               min="1900" 
               max="2100"
               placeholder="2020"
               value="<?= e($_POST['tahun_berdiri'] ?? $profil['tahun_berdiri'] ?? '') ?>">
      </div>
    </div>

    <!-- Bagian Media Sosial & Google Maps -->
    <h3 style="font-size: 16px; font-weight: 800; color: #0f172a; margin-top: 14px; margin-bottom: 6px; padding-bottom: 8px; border-bottom: 1px solid var(--line);">
      <i class="bi bi-share text-primary"></i> Media Sosial &amp; Google Maps
    </h3>

    <div class="form-row">
      <div>
        <label for="instagram">Akun Instagram</label>
        <input class="input" 
               type="text" 
               id="instagram" 
               name="instagram" 
               placeholder="@nama_akun"
               value="<?= e($_POST['instagram'] ?? $profil['instagram'] ?? '') ?>">
      </div>
      
      <div>
        <label for="linkedin">Nama / Link LinkedIn</label>
        <input class="input" 
               type="text" 
               id="linkedin" 
               name="linkedin" 
               placeholder="Nama Halaman LinkedIn"
               value="<?= e($_POST['linkedin'] ?? $profil['linkedin'] ?? '') ?>">
      </div>
    </div>

    <div>
      <label for="maps_embed">Sematkan Peta Google Maps (Kode Iframe HTML)</label>
      <textarea class="input" 
                id="maps_embed" 
                name="maps_embed" 
                rows="3" 
                placeholder="&lt;iframe src=...&gt;&lt;/iframe&gt;"><?= e($_POST['maps_embed'] ?? $profil['maps_embed'] ?? '') ?></textarea>
      <div class="form-hint">Buka Google Maps &gt; cari kantor Anda &gt; klik "Bagikan" &gt; tab "Sematkan peta" &gt; Salin HTML dan tempel di sini.</div>
    </div>

    <!-- Bagian Logo Perusahaan -->
    <div>
      <label for="logo">Logo Resmi Perusahaan</label>
      <?php if (!empty($profil['logo'])): ?>
        <div style="margin-bottom: 10px; display: flex; align-items: center; gap: 12px;">
          <img src="<?= $root_base ?><?= e(gambar_item($profil['logo'], 'profile')) ?>" 
               alt="Logo saat ini" 
               style="height: 60px; border-radius: 8px; border: 1px solid var(--line); padding: 4px; background: #ffffff;">
          <span class="form-hint" style="margin: 0;">Logo yang aktif saat ini.</span>
        </div>
      <?php endif; ?>
      <input class="input" 
             type="file" 
             id="logo" 
             name="logo" 
             accept="image/*">
      <div class="form-hint">Mendukung format PNG, JPG, WebP, SVG (maksimal 20 MB). Biarkan kosong jika tidak ingin mengubah logo.</div>
    </div>

    <!-- Tombol Aksi Simpan & Batal -->
    <div style="margin-top: 14px; display: flex; gap: 10px;">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Simpan Profil Perusahaan
      </button>
      <a class="btn btn-outline" href="index.php">Batal</a>
    </div>

  </form>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
