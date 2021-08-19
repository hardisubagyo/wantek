-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2021 at 10:18 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL,
  `id_vendor` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `nama`, `harga`, `stok`, `id_vendor`, `created_at`, `updated_at`) VALUES
(4, 'Pipa', 10000, 50, 4, '2021-08-19 00:26:24', '2021-08-19 00:26:24'),
(5, 'Truck', 200000000, 10, 4, '2021-08-19 00:27:03', '2021-08-19 00:27:03'),
(6, 'Monitor', 1500000, 20, 5, '2021-08-19 00:27:45', '2021-08-19 00:27:45'),
(7, 'Tv LED', 5000000, 50, 5, '2021-08-19 00:28:03', '2021-08-19 00:28:03'),
(8, 'Semen', 50000, 100, 8, '2021-08-19 01:06:57', '2021-08-19 01:06:57');

-- --------------------------------------------------------

--
-- Table structure for table `detail_permintaan`
--

CREATE TABLE `detail_permintaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_permintaan` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `qty` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_permintaan`
--

INSERT INTO `detail_permintaan` (`id`, `id_permintaan`, `id_barang`, `harga`, `created_at`, `updated_at`, `qty`) VALUES
(26, 2118713012, 6, 6000000, '2021-08-19 01:09:48', '2021-08-19 01:09:48', '20'),
(27, 2118713012, 7, 2000000, '2021-08-19 01:10:08', '2021-08-19 01:10:08', '10');

-- --------------------------------------------------------

--
-- Table structure for table `master_pemintaan`
--

CREATE TABLE `master_pemintaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_pertamina` int(11) DEFAULT NULL,
  `id_vendor` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_permintaan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_pemintaan`
--

INSERT INTO `master_pemintaan` (`id`, `id_pertamina`, `id_vendor`, `harga`, `status`, `created_at`, `updated_at`, `id_permintaan`) VALUES
(10, 6, NULL, 140000000, 1, '2021-08-19 01:10:11', '2021-08-19 01:10:11', '2118713012');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2021_08_19_022625_add_akses_to_table_users', 2),
(4, '2021_08_19_033951_create_barang_table', 3),
(5, '2021_08_19_040500_create_master_pemintaan_table', 4),
(6, '2021_08_19_040749_create_detail_permintaan_table', 5),
(7, '2021_08_19_041823_add_id_permintaan_to_master_permintaan', 6),
(8, '2021_08_19_044427_add_qty_to_detail_permintaan', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `akses` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `akses`) VALUES
(1, 'Super Admin', 'superadmin@gmail.com', NULL, '$2y$10$qGbPEBo9sT/zn2uMjYkXAeqMILBvAZYwlLelfjdVm6Rqbm0fLyO5u', NULL, '2021-08-18 19:30:35', '2021-08-18 20:28:34', 0),
(2, 'Admin Marketing', 'adminmarketing@gmail.com', NULL, '$2y$10$xRleGewUgXpOCaej4G8TdedqKBzxqJrKeEZAqbhydndgM4jsRNedq', NULL, '2021-08-18 20:29:17', '2021-08-18 20:29:17', 1),
(3, 'Procurement', 'procurement@gmail.com', NULL, '$2y$10$XQncC892M97uM0JdMPglcODjw2G3jZ5u8qLTP/MLgp/DVQiRcIKS2', NULL, '2021-08-18 20:29:43', '2021-08-18 20:29:43', 2),
(4, 'Vendor1', 'vendor1@gmail.com', NULL, '$2y$10$RnzCzlDuBXEw5mL3cg6Fp.w3Mh/HmZoThdgLDgPSNPwbRwtM3hW.O', NULL, '2021-08-18 20:30:09', '2021-08-18 20:30:09', 3),
(5, 'vendor2', 'vendor2@gmail.com', NULL, '$2y$10$iYzfqpYB6JEPwtnUIOwB/OZglxlsd/ZsrChPfhS/R10HH.WM5WhV6', NULL, '2021-08-18 20:30:31', '2021-08-18 20:30:31', 3),
(6, 'Pertamina', 'Pertamina@pertamina.com', NULL, '$2y$10$8TqszvKaiYGEKKkprPm5iuGoIAZdEd88vU9jK6PA0mrpfwbw3HKmO', NULL, '2021-08-18 20:31:06', '2021-08-18 20:31:06', 4),
(7, 'vendor3', 'admin3@gmail.com', NULL, '$2y$10$JCY/MmuTtvF/q2z7rwf1be9eWBAn6Cli27GZGOQG/gxGDwTjZupTy', NULL, '2021-08-19 00:55:35', '2021-08-19 00:55:35', 3),
(8, 'vendor4', 'vendor4@gmail.com', NULL, '$2y$10$7ntAFwJfkg2TuZiT3fOgX.Z9nT9uDDdzVf9Jz5083Gm2i0KBcCIfO', NULL, '2021-08-19 01:06:16', '2021-08-19 01:06:16', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_permintaan`
--
ALTER TABLE `detail_permintaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_pemintaan`
--
ALTER TABLE `master_pemintaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `detail_permintaan`
--
ALTER TABLE `detail_permintaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `master_pemintaan`
--
ALTER TABLE `master_pemintaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
