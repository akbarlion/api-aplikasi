-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2024 at 11:12 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aplikasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_mahasiswa`
--

CREATE TABLE `data_mahasiswa` (
  `ID` tinyint(4) NOT NULL,
  `NAMA_MAHASISWA` varchar(50) NOT NULL,
  `NIM` varchar(20) NOT NULL,
  `FAKULTAS_ID` tinyint(4) NOT NULL,
  `PROGDI_ID` tinyint(4) NOT NULL,
  `IS_ACTIVE` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_mahasiswa`
--

INSERT INTO `data_mahasiswa` (`ID`, `NAMA_MAHASISWA`, `NIM`, `FAKULTAS_ID`, `PROGDI_ID`, `IS_ACTIVE`) VALUES
(1, 'Muhammad Akbar Choiri Lion', 'G.231.23.0071', 1, 5, '0'),
(2, 'Ahmad Widyan Luthfil Huda', 'G.231.23.0079', 6, 1, '0'),
(3, 'Rully Miftahur Rozaq', 'G.231.23.0114', 6, 1, '0'),
(4, 'Dyah Ayu Ni\'mah', 'G.231.23.0124', 1, 5, '0'),
(5, 'Azka Rois Syahbana', 'G.231.23.0102', 6, 1, '0'),
(6, 'Rachmat Nuryanto', 'G.231.23.0077', 6, 1, '0'),
(7, 'Azura Chairuni Zahra', 'G.231.23.0083', 6, 1, '1'),
(8, 'Alfin Rangga Bagaskoro', 'G.231.23.0106', 6, 1, '0');

-- --------------------------------------------------------

--
-- Table structure for table `fakultas_mst`
--

CREATE TABLE `fakultas_mst` (
  `ID` tinyint(4) NOT NULL,
  `FAKULTAS_NAME` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fakultas_mst`
--

INSERT INTO `fakultas_mst` (`ID`, `FAKULTAS_NAME`) VALUES
(1, 'Fakultas Hukum'),
(3, 'Fakultas Teknik'),
(4, 'Fakultas Teknologi Pertanian\r\n'),
(5, 'Fakultas Psikologi'),
(6, 'Fakultas Tekonlogi Informasi dan Komunikasi'),
(7, 'Pasca Sarjana'),
(8, 'Fakultas Ekonomi');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan_mst`
--

CREATE TABLE `jurusan_mst` (
  `ID` tinyint(4) NOT NULL,
  `PROGRAM_STUDI` varchar(30) NOT NULL,
  `FAKULTAS_ID` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurusan_mst`
--

INSERT INTO `jurusan_mst` (`ID`, `PROGRAM_STUDI`, `FAKULTAS_ID`) VALUES
(1, 'Teknik Informatika', 6),
(2, 'Pariwisata', 6),
(3, 'Sistem Informasi', 6),
(4, 'Ilmu Komunikasi', 6),
(5, 'Ilmu Hukum', 1),
(6, 'Manajemen Perusahaan', 8),
(7, 'Manajemen', 8),
(8, 'Akuntansi', 8),
(9, 'Teknik Sipil', 3),
(10, 'Teknik Elektro', 3),
(11, 'Perencanaan Wilayah Dan Kota', 3),
(12, 'Teknologi Hasil Pertanian', 4),
(13, 'Psikologi', 5),
(14, 'Magister Manajemen', 7),
(15, 'Magister Hukum', 7),
(16, 'Magister Psikologi', 7);

-- --------------------------------------------------------

--
-- Table structure for table `keys`
--

CREATE TABLE `keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT 0,
  `is_private_key` tinyint(1) NOT NULL DEFAULT 0,
  `ip_addresses` text DEFAULT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `keys`
--

INSERT INTO `keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 2, 'user123', 1, 0, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `USERNAME` varchar(50) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `NAME` varchar(100) NOT NULL,
  `CREATED_AT` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`USERNAME`, `PASSWORD`, `NAME`, `CREATED_AT`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', '2024-07-01 08:32:30'),
('AKBARLION', '2b2e2cb1c9e369358d2bc9a189e4cf49', 'Muhammad Akbar Choiri Lion', '2024-06-24 11:13:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_mahasiswa`
--
ALTER TABLE `data_mahasiswa`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FAKULTAS_ID` (`FAKULTAS_ID`),
  ADD KEY `PROGDI_ID` (`PROGDI_ID`);

--
-- Indexes for table `fakultas_mst`
--
ALTER TABLE `fakultas_mst`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `jurusan_mst`
--
ALTER TABLE `jurusan_mst`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FAKULTAS_ID` (`FAKULTAS_ID`);

--
-- Indexes for table `keys`
--
ALTER TABLE `keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`USERNAME`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_mahasiswa`
--
ALTER TABLE `data_mahasiswa`
  MODIFY `ID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fakultas_mst`
--
ALTER TABLE `fakultas_mst`
  MODIFY `ID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jurusan_mst`
--
ALTER TABLE `jurusan_mst`
  MODIFY `ID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `keys`
--
ALTER TABLE `keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `data_mahasiswa`
--
ALTER TABLE `data_mahasiswa`
  ADD CONSTRAINT `data_mahasiswa_ibfk_1` FOREIGN KEY (`FAKULTAS_ID`) REFERENCES `fakultas_mst` (`ID`),
  ADD CONSTRAINT `data_mahasiswa_ibfk_2` FOREIGN KEY (`PROGDI_ID`) REFERENCES `jurusan_mst` (`ID`);

--
-- Constraints for table `jurusan_mst`
--
ALTER TABLE `jurusan_mst`
  ADD CONSTRAINT `jurusan_mst_ibfk_1` FOREIGN KEY (`FAKULTAS_ID`) REFERENCES `fakultas_mst` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
