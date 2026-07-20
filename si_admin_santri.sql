-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2026 at 09:49 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `si_admin_santri`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id_alumni` int(11) NOT NULL,
  `id_santri` int(11) NOT NULL,
  `tahun_lulus` year(4) NOT NULL,
  `pekerjaan` varchar(100) DEFAULT NULL,
  `keterangan` enum('Melanjutkan Pendidikan','Bekerja','Lainnya') NOT NULL DEFAULT 'Melanjutkan Pendidikan',
  `catatan_tambahan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id_alumni`, `id_santri`, `tahun_lulus`, `pekerjaan`, `keterangan`, `catatan_tambahan`, `created_at`) VALUES
(2, 2, '2026', 'Kerja', 'Bekerja', NULL, '2026-07-16 20:04:41'),
(3, 8, '2026', '', 'Lainnya', NULL, '2026-07-17 23:39:07'),
(4, 9, '2026', 'Universitar Al Azhar Kairo', 'Melanjutkan Pendidikan', NULL, '2026-07-18 17:07:01'),
(5, 11, '2026', 'Menikah', 'Lainnya', '', '2026-07-18 18:47:04'),
(6, 12, '2026', 'Universitar Al Azhar Kairo', 'Melanjutkan Pendidikan', '', '2026-07-18 19:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `id_santri` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tahun_masuk` year(4) NOT NULL,
  `status` enum('Aktif','Pengurus','Alumni','Keluar') DEFAULT 'Aktif',
  `no_hp` varchar(20) DEFAULT NULL,
  `nama_wali` varchar(150) DEFAULT NULL,
  `alamat_wali` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`id_santri`, `nis`, `nama`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `tahun_masuk`, `status`, `no_hp`, `nama_wali`, `alamat_wali`, `created_at`, `updated_at`) VALUES
(1, '81230013', 'Ahmad Zaki Mubarok', 'Laki-laki', 'Lamongan', '2008-05-14', 'Jl. Raya Kranji No. 12, Paciran, Lamongan', '2023', 'Aktif', '081234567890', 'H. Abdullah', NULL, '2026-07-16 18:53:31', '2026-07-17 23:34:33'),
(2, '202301002', 'Siti Nur Halizah', 'Perempuan', 'Gresik', '2009-08-21', 'Manyar, Gresik', '2023', 'Alumni', '085678901234', 'Siti Aminah', NULL, '2026-07-16 18:53:31', '2026-07-16 20:04:41'),
(3, '202201005', 'Muhammad Fahri', 'Laki-laki', 'Surabaya', '2007-01-10', 'Rungkut, Surabaya', '2022', 'Pengurus', '081345678901', 'Bambang Sugeni', NULL, '2026-07-16 18:53:31', '2026-07-16 19:45:48'),
(4, '10123230', 'Alfani', 'Laki-laki', 'Kedungwuni', '2001-01-01', 'Kedungwuni', '2026', 'Aktif', '081234567890', 'Muhammad', 'Kedungwuni', '2026-07-16 19:26:31', '2026-07-18 17:08:43'),
(5, '81260015', 'Unin', 'Laki-laki', NULL, NULL, NULL, '2026', 'Pengurus', NULL, NULL, NULL, '2026-07-17 23:34:07', '2026-07-18 16:44:00'),
(8, '81230023', 'Abdul', 'Laki-laki', NULL, NULL, NULL, '2024', 'Alumni', NULL, NULL, NULL, '2026-07-17 23:37:38', '2026-07-17 23:39:07'),
(9, '81220029', 'Khasan', 'Laki-laki', 'Kranji', '2003-03-03', 'Kranji', '2026', 'Alumni', '081234567890', 'Ahmad', 'Kranji', '2026-07-18 17:05:31', '2026-07-18 17:07:01'),
(10, '81220030', 'Khasan', 'Laki-laki', 'Bandar', '2003-03-03', 'Bandar', '2026', 'Aktif', '081234567890', 'Ahmad', 'Bandar', '2026-07-18 17:07:55', '2026-07-18 19:05:02'),
(11, 'ALM-1784400424', 'Ardi Muchroji', 'Laki-laki', NULL, NULL, 'Sragi', '2023', 'Alumni', '081234567890', NULL, NULL, '2026-07-18 18:47:04', '2026-07-18 18:47:04'),
(12, '81439905', ' Muchroji', 'Laki-laki', NULL, NULL, 'Gebangkerep', '2023', 'Alumni', '081234567890', NULL, NULL, '2026-07-18 19:03:56', '2026-07-18 19:03:56');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','Staff') DEFAULT 'Admin',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator Pesantren', 'admin', '$2y$10$rC8./wG6m1.f.K/1k./n.u/R6eR1234567890123456789012345', 'Admin', '2026-07-16 18:53:31'),
(2, 'admin1', 'admin1', 'admin123', 'Admin', '2026-07-18 19:12:55'),
(3, 'Admin', 'admin2', '$2y$10$Dsb27OX.2zhM6JIk.b.vtebLx0qgaKO12bl44KYeIy/3.dDF9A3rm', 'Admin', '2026-07-16 19:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `ustadz_pengurus`
--

CREATE TABLE `ustadz_pengurus` (
  `id_ustadz` int(11) NOT NULL,
  `id_santri` int(11) DEFAULT NULL,
  `nama` varchar(150) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL DEFAULT 'Laki-laki',
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `jabatan` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ustadz_pengurus`
--

INSERT INTO `ustadz_pengurus` (`id_ustadz`, `id_santri`, `nama`, `jenis_kelamin`, `alamat`, `no_hp`, `jabatan`, `created_at`) VALUES
(1, 3, 'Muhammad Fahri', 'Laki-laki', 'Rungkut, Surabaya', '081345678901', 'Pengurus Baru', '2026-07-16 19:45:48'),
(2, NULL, 'Ardan', 'Laki-laki', 'Buaran', '08151515151515', 'Ustadz', '2026-07-16 19:46:20'),
(5, 5, 'Unin', 'Laki-laki', NULL, NULL, 'Pengurus Baru', '2026-07-18 16:44:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id_alumni`),
  ADD KEY `fk_alumni_santri` (`id_santri`);

--
-- Indexes for table `santri`
--
ALTER TABLE `santri`
  ADD PRIMARY KEY (`id_santri`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `status` (`status`),
  ADD KEY `nis_2` (`nis`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `ustadz_pengurus`
--
ALTER TABLE `ustadz_pengurus`
  ADD PRIMARY KEY (`id_ustadz`),
  ADD KEY `fk_pengurus_santri` (`id_santri`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id_alumni` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `santri`
--
ALTER TABLE `santri`
  MODIFY `id_santri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ustadz_pengurus`
--
ALTER TABLE `ustadz_pengurus`
  MODIFY `id_ustadz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `fk_alumni_santri` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ustadz_pengurus`
--
ALTER TABLE `ustadz_pengurus`
  ADD CONSTRAINT `fk_pengurus_santri` FOREIGN KEY (`id_santri`) REFERENCES `santri` (`id_santri`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
