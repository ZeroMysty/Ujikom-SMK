<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../config/helpers.php';

// Jika sudah login, langsung ke dashboard
if (!empty($_SESSION['admin_id'])) {
    pindah_halaman('dashboard.php');
}

$pesan_kesalahan = '';

// Autentikasi akun admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pengguna = trim($_POST['username'] ?? '');
    $kata_sandi    = (string) ($_POST['password'] ?? '');

    $pernyataan = koneksi_db()->prepare('SELECT * FROM admin WHERE username = ? LIMIT 1');
    $pernyataan->execute([$nama_pengguna]);
    $pengguna = $pernyataan->fetch();

    if ($pengguna && password_verify($kata_sandi, $pengguna['password'])) {
        session_regenerate_id(true);

        $_SESSION['admin_id']   = $pengguna['id'];
        $_SESSION['admin_nama'] = $pengguna['nama'];

        pindah_halaman('dashboard.php');
    }

    $pesan_kesalahan = 'Username atau password yang Anda masukkan tidak sesuai.';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <!-- Metadata & Stylesheet -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Administrator — Panel CMS</title>
  
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='22' fill='%230d6efd'/><text x='50' y='68' font-size='52' text-anchor='middle' fill='white' font-family='Arial' font-weight='bold'>N</text></svg>">
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

  <!-- Kartu Formulir Login -->
  <div class="login-bg">
    <div class="login-card p-4 p-md-5">
      
      <!-- Header Kartu Login -->
      <div class="text-center mb-4">
        <h4 class="fw-bold text-dark mb-1">Panel Administrator</h4>
        <p class="text-muted small mb-0">Silakan masuk untuk mengelola seluruh konten website</p>
      </div>

      <!-- Peringatan Kesalahan Login -->
      <?php if ($pesan_kesalahan): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 small py-2 px-3 mb-3 rounded-3" role="alert">
          <i class="bi bi-exclamation-circle-fill"></i>
          <div><?= e($pesan_kesalahan) ?></div>
        </div>
      <?php endif; ?>

      <form method="post">
        <!-- Input Username -->
        <div class="mb-3">
          <label for="username" class="form-label small fw-semibold text-dark">Username</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
              <i class="bi bi-person text-secondary"></i>
            </span>
            <input type="text" 
                   class="form-control border-start-0" 
                   id="username" 
                   name="username" 
                   required 
                   autofocus 
                   placeholder="Masukkan username" 
                   value="<?= e($_POST['username'] ?? '') ?>">
          </div>
        </div>

        <!-- Input Password -->
        <div class="mb-4">
          <label for="password" class="form-label small fw-semibold text-dark">Kata Sandi (Password)</label>
          <div class="input-group">
            <span class="input-group-text bg-light border-end-0">
              <i class="bi bi-key text-secondary"></i>
            </span>
            <input type="password" 
                   class="form-control border-start-0" 
                   id="password" 
                   name="password" 
                   required 
                   placeholder="Masukkan password">
          </div>
        </div>

        <!-- Tombol Kirim Form -->
        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold rounded-pill shadow-sm mb-3 d-flex align-items-center justify-content-center gap-2">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Masuk ke CMS</span>
        </button>

        <!-- Tautan Kembali ke Website -->
        <div class="text-center">
          <a href="../../index.php" class="text-secondary text-decoration-none small hover-white">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Halaman Utama Website
          </a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
