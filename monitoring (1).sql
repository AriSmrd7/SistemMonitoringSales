-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Sep 2021 pada 17.53
-- Versi server: 10.4.20-MariaDB
-- Versi PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', '$2y$10$A0EUAs4dTy4kWI0I.FCp6.30BVRA2U/WAvIece85SKZUCWPzdmnaS', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id_pelanggan` int(3) NOT NULL,
  `id_sales` int(3) NOT NULL,
  `nama_pelanggan` text NOT NULL,
  `jenis_pelanggan` enum('Transportation','Government','Manufacture','Banking & Financial','Hospitality','Retail Distribution','Cell Oprtr Provider','PLN Group','Energy Utility Mining','Data Comm Oprtr','Consultant, Contract','Telecommunication','Natural Resources','Health','Education','Professional Association','Media & Entertain','Property','UMKM & Retail','Finance','Kawasan, dll','Retail') NOT NULL,
  `jumlah_site` int(3) DEFAULT NULL,
  `status_pelanggan` enum('BARU','LAMA') NOT NULL,
  `kategori_pelanggan` enum('PLN','PUBLIK') NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id_pelanggan`, `id_sales`, `nama_pelanggan`, `jenis_pelanggan`, `jumlah_site`, `status_pelanggan`, `kategori_pelanggan`, `updated_at`, `created_at`) VALUES
(910, 17, 'DINAS KESEHATAN KOTA SUKABUMI', 'Government', NULL, 'BARU', 'PUBLIK', '2020-09-23 21:27:35', '2020-09-23 21:27:35'),
(1015, 17, 'PT APM GROUP', 'Kawasan, dll', NULL, 'BARU', 'PUBLIK', '2020-09-23 21:27:36', '2020-09-23 21:27:36'),
(1204, 17, 'KOPO ELOK', 'Retail', NULL, 'BARU', 'PUBLIK', '2020-09-23 21:27:38', '2020-09-23 21:27:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `offices`
--

CREATE TABLE `offices` (
  `id_kantor` int(3) NOT NULL,
  `nama_kantor` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `offices`
--

INSERT INTO `offices` (`id_kantor`, `nama_kantor`) VALUES
(3, 'KP Cirebon'),
(2, 'KP Tasikmalaya'),
(1, 'SBU Regional Jawa Barat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `potencies`
--

CREATE TABLE `potencies` (
  `id_potensi` int(10) NOT NULL,
  `id_sbu` int(3) NOT NULL,
  `id_pelanggan` int(3) NOT NULL,
  `id_service` int(3) NOT NULL,
  `kapasitas` int(5) NOT NULL,
  `satuan_kapasitas` enum('Mbps','Kbps','Units','Transaksi','VM','Impresi') NOT NULL,
  `originating` text DEFAULT NULL,
  `terminating` text DEFAULT NULL,
  `instalasi_otc` int(10) DEFAULT 0,
  `sewa_bln` int(10) DEFAULT NULL,
  `qty` int(10) NOT NULL,
  `target_aktivasi_bln` int(10) NOT NULL,
  `update_action_plan` enum('PENAWARAN','NEGOSIASI','CLOSING','LOSS','AKTIVASI') NOT NULL,
  `target_quote` date NOT NULL,
  `real_quote` date DEFAULT NULL,
  `quote_late` enum('NO','LATE') DEFAULT NULL,
  `target_nego` date NOT NULL,
  `real_nego` date DEFAULT NULL,
  `nego_late` enum('NO','LATE') DEFAULT NULL,
  `target_po` date NOT NULL,
  `real_po` date DEFAULT NULL,
  `po_late` enum('NO','LATE') DEFAULT NULL,
  `warna_potensi` enum('HIJAU','KUNING','MERAH') NOT NULL,
  `revenue_formula` bigint(15) DEFAULT NULL,
  `id_kantor` int(3) NOT NULL,
  `anggaran_pra_penjualan` int(10) DEFAULT 0,
  `sbu_originating` varchar(100) NOT NULL,
  `sbu_terminating` varchar(100) NOT NULL,
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `potencies`
--

INSERT INTO `potencies` (`id_potensi`, `id_sbu`, `id_pelanggan`, `id_service`, `kapasitas`, `satuan_kapasitas`, `originating`, `terminating`, `instalasi_otc`, `sewa_bln`, `qty`, `target_aktivasi_bln`, `update_action_plan`, `target_quote`, `real_quote`, `quote_late`, `target_nego`, `real_nego`, `nego_late`, `target_po`, `real_po`, `po_late`, `warna_potensi`, `revenue_formula`, `id_kantor`, `anggaran_pra_penjualan`, `sbu_originating`, `sbu_terminating`, `updated_at`, `created_at`) VALUES
(4451, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS CIKUNDUL - KOTA SUKABUMI', 0, 2700000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-03', 'NO', '2020-07-16', '2020-06-10', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 10800000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4452, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS CIBEUREM HILIR - KOTA SUKABUMI', 0, 2700000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-03', 'NO', '2020-07-16', '2020-06-10', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 10800000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4453, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS LIMUS NUNGGAL - KOTA SUKABUMI', 0, 2700000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-03', 'NO', '2020-07-16', '2020-06-10', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 10800000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4454, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS TIPAR - KOTA SUKABUMI', 0, 2700000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-03', 'NO', '2020-07-16', '2020-06-10', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 10800000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4455, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS GEDONG PANJANG - KOTA SUKABUMI', 0, 2700000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-03', 'NO', '2020-07-16', '2020-06-10', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 10800000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4456, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS NANGGELENG - KOTA SUKABUMI', 0, 2700000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-06', 'NO', '2020-07-16', '2020-06-13', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 10800000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4457, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS BENTENG - KOTA SUKABUMI', 0, 2700000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-06', 'NO', '2020-07-16', '2020-06-13', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 10800000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4458, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS PABUARAN - KOTA SUKABUMI', 0, 2700000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-06', 'NO', '2020-07-16', '2020-06-13', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 10800000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4459, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS SUKAKARYA - KOTA SUKABUMI', 0, 3237000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-11', 'NO', '2020-07-16', '2020-06-18', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 12948000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4460, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS CIPELANG - KOTA SUKABUMI', 0, 3237000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-12', 'NO', '2020-07-16', '2020-06-19', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 12948000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4461, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS KARANG TENGAH - KOTA SUKABUMI', 0, 3237000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-12', 'NO', '2020-07-16', '2020-06-19', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 12948000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4462, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS SELABATU - KOTA SUKABUMI', 0, 3237000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-12', 'NO', '2020-07-16', '2020-06-19', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 12948000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4463, 2, 910, 5, 10, 'Mbps', NULL, 'PUSKESMAS SUKABUMI - KOTA SUKABUMI', 0, 3237000, 1, 9, 'AKTIVASI', '2020-07-01', '2020-06-12', 'NO', '2020-07-16', '2020-06-19', 'NO', '2020-07-26', NULL, 'NO', 'MERAH', 12948000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4464, 2, 1015, 7, 1, 'Mbps', NULL, NULL, 0, 1223400, 10, 12, 'AKTIVASI', '2020-10-01', '2020-09-01', 'NO', '2020-10-16', '2020-09-08', 'NO', '2020-10-26', NULL, 'NO', 'HIJAU', 12234000, 1, 12112, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4465, 2, 1015, 46, 1, 'Units', NULL, NULL, 0, 190000, 10, 12, 'CLOSING', '2020-10-01', NULL, 'NO', '2020-10-16', NULL, 'NO', '2020-10-26', NULL, 'NO', 'HIJAU', 1900000, 1, 1881, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4466, 2, 1204, 17, 5, 'Mbps', NULL, 'KOPO ELOK - BANDUNG', 450000, 291000, 25, 12, 'LOSS', '2020-10-01', NULL, 'NO', '2020-10-16', NULL, 'NO', '2020-10-26', NULL, 'NO', 'KUNING', 7725000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38'),
(4467, 2, 1204, 17, 50, 'Units', NULL, 'KOPO ELOK - BANDUNG', 450000, 291000, 25, 12, 'LOSS', '2020-10-01', NULL, 'NO', '2020-10-16', NULL, 'NO', '2020-10-26', NULL, 'NO', 'KUNING', 7725000, 1, 0, 'RO JBB', 'RO JBB', '2021-01-06 05:50:38', '2021-01-06 05:50:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales`
--

CREATE TABLE `sales` (
  `id_sales` int(3) NOT NULL,
  `id` int(10) UNSIGNED NOT NULL,
  `nama_sales` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(150) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sales`
--

INSERT INTO `sales` (`id_sales`, `id`, `nama_sales`, `email`, `password`, `created_at`, `updated_at`) VALUES
(11, 1, 'ARIEF WITJAKSONO', 'us.arismrd@gmail.com', '$2y$10$iTAkrT./Dt/qcyXhjaYPnORHFHDLMngO51iUG5RdnYpGvRGlmzgy6', NULL, NULL),
(12, 1, 'DEWI KUSUMAWARDANI', 'japan.arismrd@gmail.com', '$2y$10$hFG6AIwvKJctitQJxapfQ.jPE8TsAlenTOPeUj4QG0DMEXowawaeW', NULL, NULL),
(13, 1, 'IRAWATI LESTARI', 'korea.arismrd@gmail.com', '$2y$10$zOHIU6iDY/f7LvLf5Cw1DeD7r5RumHDGvMQSPjDyWvnF14uQcUr4y', NULL, NULL),
(14, 1, 'ISTI DARMA ASTUTI', 'arismrd191@gmail.com', '$2y$10$LUysZgtvEPa2V8m7pOmATO0.4m86xm7B/8U3pHdsMjdkunMRTFvGm', NULL, NULL),
(15, 1, 'PRISKA SANJAYA', 'arismrd13@gmail.com', '$2y$10$T1ugIpRHS8lw5bjkWWh26.UyacoLuQF5vTaF91P2HB4UCAde95NMO', NULL, NULL),
(16, 1, 'FARIS', 'arismrd07@gmail.com', '$2y$10$qWPyF4w8bs2wNzFXIQi2d.n9oaEeCmJ.VeyC9tYAOiI7gQm418diW', NULL, NULL),
(17, 1, 'ARI SUMARDI', 'ari.sales@sales.com', '$2y$10$5lHn2V7Hf4lCBAY0/5GSveFwK/2mA0zo/4UrFlTegKEJ1/H3vV2xq', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sbu_names`
--

CREATE TABLE `sbu_names` (
  `id_sbu` int(3) NOT NULL,
  `sbu_region` varchar(50) NOT NULL,
  `sbu_originating` enum('RO BNR','RO JBB','RO JTG','RO JBT','RO KLM','RO SLW','RO SBS','RO SBT','RO SBU','RO JAKBAN') NOT NULL,
  `sbu_terminating` enum('RO BNR','RO JBB','RO JTG','RO JBT','RO KLM','RO SLW','RO SBS','RO SBT','RO SBU','RO JAKBAN') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sbu_names`
--

INSERT INTO `sbu_names` (`id_sbu`, `sbu_region`, `sbu_originating`, `sbu_terminating`) VALUES
(1, 'BALI DAN NUSRA', 'RO BNR', 'RO BNR'),
(2, 'JAWA BARAT', 'RO JBB', 'RO JBB'),
(3, 'JAWA TENGAH', 'RO JTG', 'RO JTG'),
(4, 'JAWA TIMUR', 'RO JBT', 'RO JBT'),
(5, 'KALIMANTAN', 'RO KLM', 'RO KLM'),
(6, 'SULAWESI DAN IBT', 'RO SLW', 'RO SLW'),
(7, 'SUMATERA SELATAN', 'RO SBS', 'RO SBS'),
(8, 'SUMATERA TENGAH', 'RO SBT', 'RO SBT'),
(9, 'SUMATERA UTARA', 'RO SBU', 'RO SBU'),
(10, 'JAKARTA', 'RO JAKBAN', 'RO JAKBAN');

-- --------------------------------------------------------

--
-- Struktur dari tabel `services`
--

CREATE TABLE `services` (
  `id_service` int(3) NOT NULL,
  `segmen_service` varchar(100) NOT NULL,
  `jenis_service` enum('Jaringan','Non Jaringan','Retail') NOT NULL,
  `kategori_service` enum('S1','S2','S3','S4') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `services`
--

INSERT INTO `services` (`id_service`, `segmen_service`, `jenis_service`, `kategori_service`) VALUES
(1, 'Manage Service PC Notebook', 'Non Jaringan', 'S3'),
(2, 'Lain-lain', 'Jaringan', 'S1'),
(3, 'Internet', 'Jaringan', 'S1'),
(4, 'i-SEE', 'Non Jaringan', 'S3'),
(5, 'IP VPN', 'Jaringan', 'S1'),
(6, 'Manage Service Router', 'Jaringan', 'S3'),
(7, 'Metronet', 'Jaringan', 'S1'),
(8, 'i-WON', 'Jaringan', 'S1'),
(9, 'Stroomnetz', 'Retail', 'S3'),
(10, 'i-WIN / Manage Service Wifi', 'Jaringan', 'S3'),
(11, 'Jaringan SCADA PLN', 'Jaringan', 'S1'),
(12, 'Comnetz Infra', 'Jaringan', 'S4'),
(13, 'IP VSAT', 'Jaringan', 'S1'),
(14, 'NET-ACCESS', 'Jaringan', 'S1'),
(15, 'Open Content', 'Non Jaringan', 'S2'),
(16, 'ICONCloud', 'Non Jaringan', 'S3'),
(17, 'Open Access', 'Jaringan', 'S1'),
(18, 'Colocation DC', 'Non Jaringan', 'S2'),
(19, 'Telicon', 'Jaringan', 'S1'),
(20, 'Clear Channel', 'Jaringan', 'S1'),
(21, 'Fiberisasi BTS', 'Jaringan', 'S1'),
(22, 'i-VIP Lite', 'Non Jaringan', 'S3'),
(23, 'Layanan IPTV', 'Non Jaringan', 'S2'),
(24, 'V-CO', 'Non Jaringan', 'S3'),
(25, 'i-VIP', 'Non Jaringan', 'S3'),
(26, 'NET-METRO', 'Jaringan', 'S1'),
(27, 'NET-VPN', 'Jaringan', 'S1'),
(28, 'Stroomnetz Biz', 'Retail', 'S3'),
(29, 'Dark Fiber', 'Jaringan', 'S1'),
(30, 'Pembangkitan-PLN', 'Non Jaringan', 'S2'),
(31, 'Penggunaan Tiang*', 'Jaringan', 'S1'),
(32, 'Comnetz Ads Service', 'Non Jaringan', 'S4'),
(33, 'Payment Gateway', 'Non Jaringan', 'S4'),
(34, 'V-CAM', 'Non Jaringan', 'S3'),
(35, 'NET-SAT', 'Jaringan', 'S1'),
(36, 'Clear Channel Kapasitas Besar Jawa-Bali', 'Jaringan', 'S1'),
(37, 'Customer Care dan Billing - PLN', 'Non Jaringan', 'S2'),
(38, 'Stroomnetz Ultimate', 'Retail', 'S3'),
(39, 'Distribusi/Transmisi/Perencanaan-PLN', 'Non Jaringan', 'S2'),
(40, 'Korporasi - PLN', 'Non Jaringan', 'S2'),
(41, 'i-SPOT', 'Jaringan', 'S1'),
(42, 'i-SEE Lite', 'Non Jaringan', 'S3'),
(43, 'Idescafe', 'Jaringan', 'S4'),
(44, 'IP VPN Premium', 'Jaringan', 'S1'),
(45, 'Teleproteksi PLN', 'Jaringan', 'S1'),
(46, 'MS Router', 'Jaringan', 'S1'),
(47, 'PLN Shared Service', 'Non Jaringan', 'S3');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `nama_pelanggan` (`nama_pelanggan`) USING HASH,
  ADD KEY `id_sales` (`id_sales`);

--
-- Indeks untuk tabel `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`id_kantor`),
  ADD UNIQUE KEY `nama_kantor` (`nama_kantor`);

--
-- Indeks untuk tabel `potencies`
--
ALTER TABLE `potencies`
  ADD PRIMARY KEY (`id_potensi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`),
  ADD KEY `id_service` (`id_service`),
  ADD KEY `id_kantor` (`id_kantor`),
  ADD KEY `id_sbu` (`id_sbu`);

--
-- Indeks untuk tabel `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id_sales`),
  ADD UNIQUE KEY `username` (`email`),
  ADD KEY `id` (`id`);

--
-- Indeks untuk tabel `sbu_names`
--
ALTER TABLE `sbu_names`
  ADD PRIMARY KEY (`id_sbu`);

--
-- Indeks untuk tabel `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id_service`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id_pelanggan` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1797;

--
-- AUTO_INCREMENT untuk tabel `offices`
--
ALTER TABLE `offices`
  MODIFY `id_kantor` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `potencies`
--
ALTER TABLE `potencies`
  MODIFY `id_potensi` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4469;

--
-- AUTO_INCREMENT untuk tabel `sales`
--
ALTER TABLE `sales`
  MODIFY `id_sales` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `sbu_names`
--
ALTER TABLE `sbu_names`
  MODIFY `id_sbu` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `services`
--
ALTER TABLE `services`
  MODIFY `id_service` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`id_sales`) REFERENCES `sales` (`id_sales`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `potencies`
--
ALTER TABLE `potencies`
  ADD CONSTRAINT `potencies_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `customers` (`id_pelanggan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `potencies_ibfk_3` FOREIGN KEY (`id_service`) REFERENCES `services` (`id_service`) ON UPDATE CASCADE,
  ADD CONSTRAINT `potencies_ibfk_4` FOREIGN KEY (`id_kantor`) REFERENCES `offices` (`id_kantor`) ON UPDATE CASCADE,
  ADD CONSTRAINT `potencies_ibfk_5` FOREIGN KEY (`id_sbu`) REFERENCES `sbu_names` (`id_sbu`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`id`) REFERENCES `admins` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
