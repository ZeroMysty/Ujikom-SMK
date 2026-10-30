-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2026 at 03:19 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_companyprofile`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL DEFAULT 'Administrator',
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'Administrator Web', 'admin', '$2y$10$fg5toGJU7wllHhboTjPLDevqCL/UY6MChjIHmUvutoI.vhYjX5cQK', '2026-09-13 05:49:49');

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `penulis` varchar(100) NOT NULL DEFAULT 'Admin',
  `isi` mediumtext DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `is_publikasi` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `artikel`
--

INSERT INTO `artikel` (`id`, `judul`, `slug`, `penulis`, `isi`, `gambar`, `is_publikasi`, `created_at`) VALUES
(7, 'Mengapa Website Company Profile Dinamis Sangat Penting untuk Citra Perusahaan Modern?', 'mengapa-website-company-profile-dinamis-sangat-penting-untuk-citra-perusahaan-modern', 'Admin', '<p>Di era digital saat ini, website company profile bukan lagi sekadar brosur digital yang kaku, melainkan platform utama dalam membangun kredibilitas bisnis. Website dinamis memungkinkan perusahaan untuk terus memperbarui informasi produk, membagikan berita terkini, hingga berinteraksi langsung dengan calon klien secara efisien.</p><p>Dengan tampilan yang responsif dan sistem manajemen konten (CMS) yang user-friendly, perusahaan dapat dengan mudah menyesuaikan strategi pemasaran tanpa tergantung pada pihak ketiga. Kecepatan dalam menyajikan informasi terbaru inilah yang menjadi kunci utama dalam memenangkan kepercayaan publik dan calon mitra bisnis.</p>', 'artikel-20260913124409-025b6012.jpg', 1, '2026-09-13 10:44:09'),
(8, 'Strategi Membangun Infrastruktur Jaringan Kantor yang Stabil dan Bebas Lag', 'strategi-membangun-infrastruktur-jaringan-kantor-yang-stabil-dan-bebas-lag', 'Tim IT Solusi', '<p>Pertumbuhan jumlah perangkat terhubung di lingkungan kantor sering kali membuat lalu lintas jaringan menjadi lambat jika tidak dirancang dengan baik. Untuk mengatasi hal tersebut, penerapan arsitektur jaringan LAN/WAN yang terstruktur serta manajemen bandwith yang tepat sangat diperlukan.</p><p>Penggunaan perangkat keras kelas industri, penataan manajemen kabel yang rapi, serta pemisahan jaringan internal dan tamu (Guest Network) dapat meningkatkan efisiensi kerja tim secara signifikan. Langkah-langkah ini meminimalisasi risiko downtime yang dapat mengganggu operasional harian perusahaan.</p>', 'artikel-20260913124554-d20d74fa.jpg', 1, '2026-09-13 10:45:54'),
(9, '5 Celah Keamanan IT yang Sering Diabaikan Perusahaan dan Cara Mencegahnya', '5-celah-keamanan-it-yang-sering-diabaikan-perusahaan-dan-cara-mencegahnya', 'Security Specialist', '<p>Keamanan siber sering kali baru menjadi perhatian utama setelah insiden kebocoran data terjadi. Beberapa celah yang paling umum ditemui antara lain penggunaan kata sandi yang lemah, perangkat lunak yang jarang diperbarui, serta ketiadaan enkripsi pada saluran komunikasi internal.</p><p>Melakukan audit keamanan secara berkala dan menerapkan autentikasi dua faktor (2FA) adalah langkah awal yang sangat krusial. Selain itu, pelatihan kesadaran keamanan siber bagi seluruh karyawan juga terbukti efektif menekan risiko serangan cyber phishing hingga lebih dari 60%.</p>', 'artikel-20260913124743-28362e9b.jpg', 1, '2026-09-13 10:47:43'),
(10, 'Panduan Migrasi Server Lokal ke Cloud untuk Efisiensi Operasional', 'panduan-migrasi-server-lokal-ke-cloud-untuk-efisiensi-operasional', 'Cloud Architect', '<p>Beralih dari server fisik lokal (<em>on-premise</em>) ke infrastruktur berbasis cloud memberikan fleksibilitas luar biasa bagi perusahaan yang sedang berkembang pesat. Selain memangkas biaya pemeliharaan perangkat keras, cloud memungkinkan akses data yang aman dari mana saja.</p><p>Proses migrasi membutuhkan perencanaan matang, mulai dari pemetaan ketergantungan aplikasi, pemilihan model layanan (IaaS, PaaS, atau SaaS), hingga strategi pembuatan cadangan data (<em>backup</em>) darurat. Dengan pendekatan yang tepat, transisi dapat berjalan mulus tanpa mengganggu aktivitas bisnis harian.</p>', 'artikel-20260913124859-c83954f8.jpg', 1, '2026-09-13 10:48:59');

-- --------------------------------------------------------

--
-- Table structure for table `galeri`
--

CREATE TABLE `galeri` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(150) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `galeri`
--

INSERT INTO `galeri` (`id`, `judul`, `keterangan`, `gambar`, `created_at`) VALUES
(7, 'Migrasi Server & Penataan Data Center Klien', 'Dokumentasi tim teknisi PT Digital Solusi Nusantara saat melakukan proses migrasi server dan penataan kabel terstruktur di ruang Data Center untuk memperkuat keamanan dan efisiensi jaringan klien.', 'galeri-20260913125103-4d8a5684.jpg', '2026-09-13 10:51:03'),
(8, 'Sesi Konsultasi Strategy & Roadmap IT Perusahaan', 'Diskusi interaktif antara konsultan IT PT Digital Solusi Nusantara dengan jajaran manajemen klien dalam memetakan kebutuhan arsitektur sistem dan transformasi digital jangka panjang.', 'galeri-20260913125137-358893c7.jpg', '2026-09-13 10:51:37'),
(9, 'Proses Co-Working & Sprint Development Web App', 'Tim Software Engineer sedang melakukan pengodean dan pengujian antarmuka aplikasi web custom guna memastikan performa yang cepat, responsif, dan bebas bug sebelum siap diluncurkan.', 'galeri-20260913125217-308a4019.jpg', '2026-09-13 10:52:17'),
(10, 'Instalasi & Pengujian Akses Poin Jaringan Kantor', 'Kegiatan pengujian jangkauan sinyal dan instalasi perangkat keras jaringan Wi-Fi Enterprise di gedung perkantoran baru untuk menjamin koneksi internet yang stabil di seluruh area kerja.', 'galeri-20260913125250-03e63ada.jpg', '2026-09-13 10:52:50'),
(11, 'Pelatihan Penggunaan Sistem CMS Website untuk Klien', 'Sesi pendampingan dan pelatihan teknis dari tim pengembang kepada staf internal klien terkait cara mengelola konten, artikel, dan produk pada dashboard admin website baru.', 'galeri-20260913125322-bc6e3ba0.jpg', '2026-09-13 10:53:22'),
(12, 'Diskusi Internal Tim Technical Support & Engineering', 'Suasana koordinasi rutin tim teknis PT Digital Solusi Nusantara dalam mengevaluasi kualitas layanan pemeliharaan (maintenance) serta merencanakan peningkatan keamanan sistem klien secara berkala.', 'galeri-20260913125355-9d097a1f.jpg', '2026-09-13 10:53:55');

-- --------------------------------------------------------

--
-- Table structure for table `pesan`
--

CREATE TABLE `pesan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subjek` varchar(150) DEFAULT NULL,
  `isi_pesan` text NOT NULL,
  `is_dibaca` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pesan`
--

INSERT INTO `pesan` (`id`, `nama`, `email`, `subjek`, `isi_pesan`, `is_dibaca`, `created_at`) VALUES
(3, 'Hendra Wijaya', 'hendra.w@mitraberkaya.co.id', 'Konsultasi Pembuatan Website Profil & Catalog Perusahaan', 'Halo tim PT Digital Solusi Nusantara, kami dari PT Mitra Berkarya ingin memperbarui website profil perusahaan kami agar lebih modern dan memiliki fitur katalog produk dinamis. Bisakah dikirimkan proposal penawaran beserta estimasi waktu pengerjaannya? Terima kasih.', 0, '2026-09-13 11:10:23'),
(4, 'Budi Santoso', 'budi.santoso@megatama.com', 'Penawaran Setup Jaringan LAN & Server Kantor Baru', 'Selamat pagi, kantor kami sedang berencana pindah ke gedung baru bulan depan dan membutuhkan jasa instalasi jaringan LAN untuk 50 user serta perancangan ruang server lokal. Mohon informasikan jadwal yang memungkinkan untuk tim Anda melakukan survey lokasi.', 0, '2026-09-13 11:13:37'),
(5, 'Siti Rahmawati', 'siti.rahma@sumbersejahtera.id', 'Diskusi Konsultasi Audit Keamanan Sistem IT', 'Halo, kami bermaksud ingin melakukan audit keamanan (vulnerability assessment) pada aplikasi web internal perusahaan kami. Apakah ada sesi konsultasi awal untuk membahas cakupan kerja dan skema kerja samanya?', 0, '2026-09-13 11:14:19');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(150) NOT NULL,
  `kategori` varchar(80) NOT NULL DEFAULT 'Layanan',
  `deskripsi` text NOT NULL,
  `harga` decimal(14,2) NOT NULL DEFAULT 0.00,
  `gambar` varchar(255) DEFAULT NULL,
  `is_aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `deskripsi`, `harga`, `gambar`, `is_aktif`, `created_at`) VALUES
(8, 'Pengembangan Website Company Profile Dinamis', 'Layanan', 'Layanan pembuatan website profil perusahaan yang modern, responsif, dan mudah dikelola melalui Panel Admin. Dirancang khusus untuk memperkuat citra merek (branding), memperkenalkan layanan perusahaan, serta mempublikasikan informasi dan artikel secara real-time.', 7500000.00, 'produk-20260913123416-c1c8faad.jpg', 1, '2026-09-13 10:34:16'),
(9, 'Pengembang Aplikasi Web Enterprise (Custom Application)', 'Layanan', 'Solusi pembuatan aplikasi berbasis web yang disesuaikan penuh dengan kebutuhan alur kerja internal perusahaan Anda (seperti Sistem CRM, ERP, atau Manajemen Operasional). Dilengkapi integrasi API, sistem otorisasi pengguna, dan keamanan data berlapis.', 25000000.00, 'produk-20260913123530-c62fd9e1.jpg', 1, '2026-09-13 10:35:30'),
(10, 'Perancangan & Setup Infrastruktur Jaringan LAN/WAN', 'Layanan', 'Layanan perancangan, pemasangan kabel terstruktur, kustomisasi router/switch, serta konfigurasi jaringan area lokal (LAN) maupun antarkantor (WAN). Menjamin konektivitas internet dan pertukaran data internal perusahaan yang stabil, cepat, dan aman.', 12000000.00, 'produk-20260913123723-5ad56b24.jpg', 1, '2026-09-13 10:36:56'),
(11, 'Jasa Konsultasi IT & Audit Keamanan Siber', 'Konsultasi', 'Layanan peninjauan komprehensif atas arsitektur IT dan potensi celah keamanan (vulnerability) pada sistem perusahaan Anda. Kami memberikan analisis mendalam serta rekomendasi strategi terbaik untuk meningkatkan efisiensi dan keamanan infrastruktur teknologi Anda.', 10000000.00, 'produk-20260913123839-2c4eb152.jpg', 1, '2026-09-13 10:38:39'),
(12, 'Layanan Migrasi & Pengelolaan Server Cloud', 'Layanan', 'Solusi migrasi server lokal ke lingkungan cloud (AWS, Google Cloud, atau VPS) beserta pengelolaannya. Mencakup pengaturan load balancing, penyetelan performa, pemantauan 24/7, dan otomatisasi pembuatan salinan cadangan (backup) data.', 15000000.00, 'produk-20260913123951-a3d2001c.jpg', 1, '2026-09-13 10:39:51'),
(13, 'Paket Maintenance & Dukungan Teknis IT Bulanan', 'Layanan', 'Layanan pemeliharaan berkala untuk seluruh perangkat lunak, sistem jaringan, dan perangkat keras perusahaan. Tim teknisi ahli kami siap menangani kendala teknis (troubleshooting) secara cepat demi menjaga operasional bisnis tetap berjalan tanpa gangguan.', 5000000.00, 'produk-20260913124056-884d3210.jpg', 1, '2026-09-13 10:40:56');

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(150) NOT NULL DEFAULT 'PT Digital Solusi Nusantara',
  `tagline` varchar(255) DEFAULT 'Mitra Digital Terpercaya untuk Solusi Teknologi Bisnis Anda',
  `deskripsi` text DEFAULT NULL,
  `sejarah` text DEFAULT NULL,
  `visi` text DEFAULT NULL,
  `misi` text DEFAULT NULL,
  `nilai` text DEFAULT NULL,
  `alamat` varchar(255) DEFAULT 'Jl. Sudirman No. 128, Gedung Menara Digital Lt. 14, Jakarta Selatan',
  `telepon` varchar(30) DEFAULT '(021) 5790-1234',
  `email` varchar(100) DEFAULT 'info@solusinusantara.com',
  `whatsapp` varchar(30) DEFAULT '081234567890',
  `instagram` varchar(100) DEFAULT '@digitalsolusinusantara',
  `linkedin` varchar(150) DEFAULT 'PT Digital Solusi Nusantara',
  `maps_embed` text DEFAULT NULL,
  `tahun_berdiri` year(4) DEFAULT 2018,
  `logo` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profil`
--

INSERT INTO `profil` (`id`, `nama_perusahaan`, `tagline`, `deskripsi`, `sejarah`, `visi`, `misi`, `nilai`, `alamat`, `telepon`, `email`, `whatsapp`, `instagram`, `linkedin`, `maps_embed`, `tahun_berdiri`, `logo`, `updated_at`) VALUES
(1, 'PT Digital Solusi Nusantara', 'Solusi Digital Terintegrasi & Inovatif untuk Mengakselerasi Pertumbuhan Bisnis Anda', 'PT Digital Solusi Nusantara adalah perusahaan penyedia layanan Teknologi Informasi terkemuka yang berdedikasi untuk memberikan solusi digital terpadu bagi berbagai skala bisnis. Kami menghadirkan inovasi melalui Pengembangan Website, Infrastruktur Jaringan Komputer, dan Konsultasi IT secara profesional. Dengan berfokus pada efisiensi, keamanan, dan efektivitas, kami siap membantu mentransformasi dan mengakselerasi pertumbuhan bisnis Anda di era digital.', 'PT Digital Solusi Nusantara didirikan dengan komitmen untuk menjawab tantangan dan pesatnya perkembangan dunia teknologi di Indonesia. Berawal dari sekelompok profesional IT yang memiliki visi yang sama, perusahaan ini tumbuh menjadi mitra terpercaya bagi instansi swasta maupun pemerintah.\r\n\r\nSeiring berjalannya waktu, kami terus memperluas jangkauan layanan kami, mulai dari pembuatan platform web yang dinamis, perancangan arsitektur jaringan yang aman dan andal, hingga penyediaan strategi konsultasi IT yang komprehensif. Berkat pengalaman dan integritas yang konsisten, PT Digital Solusi Nusantara terus berkembang sebagai salah satu pelopor transformasi digital nasional yang dapat diandalkan.', 'Menjadi perusahaan teknologi informasi terdepan dan terpercaya di Indonesia yang mampu mengakselerasi transformasi digital serta memberikan dampak positif bagi pertumbuhan bisnis dan masyarakat.', 'Menyediakan Solusi Teknologi Terbaik: Menghadirkan layanan pengembangan website, sistem jaringan, dan konsultasi IT yang inovatif, aman, serta berkualitas tinggi.\r\n\r\nMengutamakan Kepuasan Klien: Memberikan layanan konsultasi dan dukungan teknis secara responsif dan berorientasi pada kebutuhan mitra.\r\n\r\nMendorong Efisiensi Bisnis: Membantu mengoptimalkan operasional dan infrastruktur teknologi perusahaan klien untuk mencapai potensi pertumbuhan maksimal.\r\n\r\nPengembangan Inovasi Berkelanjutan: Terus memperbarui keahlian dan mengikuti perkembangan teknologi terkini demi menghadirkan solusi yang selalu relevan dan andal.', 'Integritas, Inovasi, Kemitraan Jangka Panjang, Keunggulan Eksekusi', '57 Rue du Pere Boiteau, Cilaos 97413, Reunion', '(021)  1234-5678', 'kontak@solusinusantara.id', '08123456789', '@digitalsolusinusantara', 'PT Digital Solusi Nusantara', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d357.5538910697269!2d55.47134360999075!3d-21.134170742006688!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x21829d737e613ee5%3A0xf6bd2722883f54ab!2s57%20Rue%20du%20Pere%20Boiteau%2C%20Cilaos%2097413%2C%20Reunion!5e1!3m2!1sid!2sid!4v1789293851594!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"strict-origin-when-cross-origin\"></iframe>', '1945', 'logo-20260913115931-76ad57d7.jpg', '2026-09-13 10:04:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_admin_username` (`username`);

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_artikel_slug` (`slug`),
  ADD KEY `idx_artikel_publikasi` (`is_publikasi`);

--
-- Indexes for table `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesan`
--
ALTER TABLE `pesan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_produk_aktif` (`is_aktif`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pesan`
--
ALTER TABLE `pesan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `profil`
--
ALTER TABLE `profil`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
