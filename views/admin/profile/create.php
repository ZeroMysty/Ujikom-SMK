<?php
// Inisialisasi dan autentikasi admin
require_once __DIR__ . '/../../../config/auth.php';
require_once __DIR__ . '/../../../config/helpers.php';

// Profil perusahaan bersifat tunggal, alihkan langsung ke halaman edit
pindah_halaman('edit.php');
