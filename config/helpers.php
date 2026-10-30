<?php

require_once __DIR__ . '/koneksi.php';

// Mengamankan teks dari karakter berbahaya (Anti-XSS).
function amankan(?string $nilai): string
{
    return htmlspecialchars((string) $nilai, ENT_QUOTES, 'UTF-8');
}

// Alias pendek untuk amankan()
function e(?string $nilai): string
{
    return amankan($nilai);
}

// Format angka menjadi Rupiah (misal: Rp 50.000).
function rupiah($angka): string
{
    return 'Rp ' . number_format((float) $angka, 0, ',', '.');
}

// Format tanggal ke bahasa Indonesia (misal: "13 September 2026").
function tanggal_id(?string $tanggal, bool $denganJam = false): string
{
    if (!$tanggal) {
        return '-';
    }
    $waktuStempel = strtotime($tanggal);
    $daftarBulan = [1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $hasil = date('j', $waktuStempel) . ' ' . $daftarBulan[(int) date('n', $waktuStempel)] . ' ' . date('Y', $waktuStempel);
    return $denganJam ? $hasil . ' ' . date('H:i', $waktuStempel) : $hasil;
}

// Buat slug teks untuk URL yang ramah SEO (misal: "Halo Dunia" jadi "halo-dunia").
function buat_slug(string $judul): string
{
    $slug = strtolower(trim($judul));
    $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
    return trim($slug, '-');
}

// Memotong teks panjang dan memberi akhiran titik-titik (…).
function potong_teks(string $teks, int $panjang = 100): string
{
    return mb_strimwidth($teks, 0, $panjang, '…');
}

// Menentukan path gambar item dengan fallback bila kosong.
function gambar_item(?string $namaBerkas, string $tipe = 'produk'): string
{
    if ($namaBerkas && file_exists(__DIR__ . '/../assets/img/' . $namaBerkas)) {
        return 'assets/img/' . $namaBerkas;
    }
    return 'assets/img/placeholder-' . $tipe . '.svg';
}

// Mengalihkan browser ke halaman lain lalu menghentikan proses kode.
function pindah_halaman(string $alamat): void
{
    header('Location: ' . $alamat);
    exit;
}

// Alias untuk pindah_halaman()
function redirect(string $alamat): void
{
    pindah_halaman($alamat);
}

// Mengambil satu baris data profil perusahaan dari basis data.
function ambil_profil(): array
{
    $baris = koneksi_db()->query('SELECT * FROM profil ORDER BY id LIMIT 1')->fetch();
    return $baris ?: [];
}

// Alias untuk ambil_profil()
function get_profil(): array
{
    return ambil_profil();
}

// Memproses unggahan (upload) berkas gambar ke folder assets/img.
// $namaInput = nama kolom input berkas form.
function unggah_gambar(string $namaInput, string $awalan = 'img', ?string &$pesan_error = null): ?string
{
    if (empty($_FILES[$namaInput]['name'])) {
        return null;
    }

    $kodeError = $_FILES[$namaInput]['error'] ?? UPLOAD_ERR_OK;
    if ($kodeError !== UPLOAD_ERR_OK) {
        if ($kodeError === UPLOAD_ERR_NO_FILE) {
            return null;
        }
        $pesan_error = match ($kodeError) {
            UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'Ukuran berkas melebihi batas unggah maksimal server.',
            UPLOAD_ERR_PARTIAL => 'Berkas gambar hanya terunggah sebagian.',
            UPLOAD_ERR_NO_TMP_DIR => 'Folder sementara server tidak ditemukan.',
            UPLOAD_ERR_CANT_WRITE => 'Gagal menulis berkas ke disk server.',
            default => 'Terjadi kesalahan saat mengunggah berkas (kode: ' . $kodeError . ').'
        };
        simpan_notifikasi('danger', $pesan_error);
        return null;
    }

    if (!is_uploaded_file($_FILES[$namaInput]['tmp_name'])) {
        $pesan_error = 'Berkas unggahan tidak valid.';
        simpan_notifikasi('danger', $pesan_error);
        return null;
    }

    $ekstensiDiizinkan = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
    $ekstensi = strtolower(pathinfo($_FILES[$namaInput]['name'], PATHINFO_EXTENSION));
    if (!in_array($ekstensi, $ekstensiDiizinkan, true)) {
        $pesan_error = 'Format file (' . $ekstensi . ') tidak didukung. Gunakan: ' . implode(', ', $ekstensiDiizinkan);
        simpan_notifikasi('danger', $pesan_error);
        return null;
    }

    if ($_FILES[$namaInput]['size'] > 20 * 1024 * 1024) {
        $pesan_error = 'Ukuran gambar melebihi 20 MB.';
        simpan_notifikasi('danger', $pesan_error);
        return null;
    }

    $namaBaru = $awalan . '-' . date('YmdHis') . '-' . bin2hex(random_bytes(4)) . '.' . $ekstensi;
    $tujuan = __DIR__ . '/../assets/img/' . $namaBaru;
    if (!move_uploaded_file($_FILES[$namaInput]['tmp_name'], $tujuan)) {
        $pesan_error = 'Gagal menyimpan file ke assets/img. Pastikan folder dapat ditulis.';
        simpan_notifikasi('danger', $pesan_error);
        return null;
    }

    return $namaBaru;
}

// Alias untuk unggah_gambar()
function handle_upload(string $namaInput, string $awalan = 'img', ?string &$pesan_error = null): ?string
{
    return unggah_gambar($namaInput, $awalan, $pesan_error);
}

// Menghapus berkas gambar dari assets/img.
function hapus_gambar(?string $namaBerkas): void
{
    if ($namaBerkas) {
        $jalurBerkas = __DIR__ . '/../assets/img/' . basename($namaBerkas);
        if (is_file($jalurBerkas)) {
            @unlink($jalurBerkas);
        }
    }
}

// Menyimpan pesan notifikasi kilat ke session browser.
function simpan_notifikasi(string $tipe, string $pesan): void
{
    $_SESSION['flash'] = ['tipe' => $tipe, 'pesan' => $pesan];
}

// Alias untuk simpan_notifikasi()
function set_flash(string $tipe, string $pesan): void
{
    simpan_notifikasi($tipe, $pesan);
}

// Mengambil dan membersihkan pesan notifikasi dari session.
function ambil_notifikasi(): ?array
{
    if (!empty($_SESSION['flash'])) {
        $notifikasi = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $notifikasi;
    }
    return null;
}

// Alias untuk ambil_notifik asi()
function get_flash(): ?array
{
    return ambil_notifikasi();
}
