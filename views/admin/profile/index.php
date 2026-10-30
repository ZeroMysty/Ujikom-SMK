<?php
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

$judul = 'Profil Perusahaan';
$profil = ambil_profil();

$tombol_aksi = '<a class="btn btn-primary btn-sm" href="edit.php"><i class="bi bi-pencil-square"></i> Edit Profil</a>';

require __DIR__ . '/../includes/header.php';
?>

<!-- Notifikasi Status -->
<?php if ($notifikasi = ambil_notifikasi()): ?>
  <div class="alert alert-<?= e($notifikasi['tipe']) ?>">
    <?= e($notifikasi['pesan']) ?>
  </div>
<?php endif; ?>

<!-- Kartu Ringkasan Profil Perusahaan -->
<div class="table-wrap" style="padding: 28px;">
  <!-- Logo & Nama Perusahaan -->
  <div style="display: flex; align-items: center; gap: 18px; margin-bottom: 24px;">
    <img src="<?= $root_base ?><?= e(gambar_item($profil['logo'] ?? null, 'profile')) ?>" 
         alt="Logo Resmi"
         style="width: 76px; height: 76px; border-radius: 16px; object-fit: cover; border: 1px solid var(--line); box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
    <div>
      <h2 style="margin: 0; font-size: 22px; font-weight: 800; color: #0f172a;">
        <?= e($profil['nama_perusahaan'] ?? 'Belum ada data profil') ?>
      </h2>
      <p style="margin: 4px 0 0; color: var(--muted); font-size: 14.5px;">
        <?= e($profil['tagline'] ?? '') ?>
      </p>
    </div>
  </div>

  <!-- Tabel Informasi Rinci Profil -->
  <table class="table" style="min-width: 0;">
    <tbody>
      <tr>
        <th style="width: 190px;">Deskripsi Singkat</th>
        <td><?= e(mb_strimwidth((string) ($profil['deskripsi'] ?? ''), 0, 140, '…')) ?></td>
      </tr>
      <tr>
        <th>Visi Perusahaan</th>
        <td><?= e(mb_strimwidth((string) ($profil['visi'] ?? ''), 0, 140, '…')) ?></td>
      </tr>
      <tr>
        <th>Misi Perusahaan</th>
        <td><?= e(mb_strimwidth((string) ($profil['misi'] ?? ''), 0, 140, '…')) ?></td>
      </tr>
      <tr>
        <th>Alamat Kantor</th>
        <td><?= e($profil['alamat'] ?? '-') ?></td>
      </tr>
      <tr>
        <th>Telepon / WhatsApp</th>
        <td><?= e(($profil['telepon'] ?? '-') . ' / ' . ($profil['whatsapp'] ?? '-')) ?></td>
      </tr>
      <tr>
        <th>Email Resmi</th>
        <td><?= e($profil['email'] ?? '-') ?></td>
      </tr>
      <tr>
        <th>Tahun Berdiri</th>
        <td><?= e($profil['tahun_berdiri'] ?? '-') ?></td>
      </tr>
      <tr>
        <th>Terakhir Diperbarui</th>
        <td><?= e(tanggal_id($profil['updated_at'] ?? null, true)) ?></td>
      </tr>
    </tbody>
  </table>

  <!-- Tombol Aksi Edit -->
  <div style="margin-top: 24px;">
    <a class="btn btn-primary" href="edit.php">
      <i class="bi bi-pencil-square"></i> Edit Profil Perusahaan
    </a>
  </div>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
