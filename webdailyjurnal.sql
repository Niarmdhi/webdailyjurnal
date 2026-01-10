-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 09, 2026 at 09:45 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4_general_ci */;

--
-- Database: `webdailyjurnal`
--

-- --------------------------------------------------------

--
-- Table structure for table `articel`
--

CREATE TABLE `articel` (
  `id` int NOT NULL,
  `judul` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `isi` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `gambar` text CHARACTER SET latin1 COLLATE latin1_swedish_ci,
  `tanggal` datetime DEFAULT NULL,
  `username` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4_general_ci COLLATE=utf8mb4_general_ci_general_ci;

--
-- Dumping data for table `articel`
--

INSERT INTO `articel` (`id`, `judul`, `isi`, `gambar`, `tanggal`, `username`) VALUES
(1, 'Foto perpisahan dengan STI-04', 'Momen perpisahan dengan teman STI-04 untuk melanjutkan ke semester 3', 'foto_3.jpg', '2025-04-08 15:16:29', 'admin'),
(2, 'Foto bukber STI-04', 'Momen buka bersama STI-04 untuk pertama kalinyaa', 'foto_4.jpg', '2025-03-10 04:51:55', 'admin'),
(3, 'Foto gedung udinus', 'Foto gedung H udinus pada saat malam hari', 'foto_9.jpg', '2023-11-08 04:45:33', 'admin'),
(4, 'foto ber3', 'Momen foto upacara bendera di udinus', '20251211085305.jpeg', '2025-12-11 08:53:05', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id_gallery` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal_upload` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4_general_ci COLLATE=utf8mb4_general_ci_0900_ai_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id_gallery`, `judul`, `deskripsi`, `gambar`, `tanggal_upload`) VALUES
(1, 'Kegiatan pagi', 'Dokumentasi Aktivitas pagi hari', 'pagi.jpg', '2026-01-09 16:33:34'),
(2, 'Belajar coding', 'Belajar Pemograman PHP', 'coding.jpg', '2026-01-09 16:33:34'),
(3, 'Rapat tim', 'Diskusi Proyek Harian', 'rapat.jpg', '2026-01-09 16:33:34'),
(4, 'Makan siang', 'Istirahat dan Makan Siang', 'makan.jpg', '2026-01-09 16:33:34'),
(5, 'Olahgara sore', 'Jooging Sore untuk Kesehatan', 'olahraga.jpg', '2026-01-09 16:33:34'),
(6, 'Curug sewu', 'Pemandangan Curug Siang hari', 'curug.jpg', '2026-01-09 16:33:34'),
(7, 'testing', 'testing', '20260109094204.png', '2026-01-09 09:42:04');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4_general_ci COLLATE=utf8mb4_general_ci_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `foto`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'admin.jpg'),
(2, 'danny', '21232f297a57a5a743894a0e4a801fc3', 'danny.jpg'),
(3, 'user1', '482c811da5d5b4bc6d497ffa98491e38', 'user1.jpg'),
(4, 'user2', '482c811da5d5b4bc6d497ffa98491e38', 'user2.jpg'),
(5, 'user3', '482c811da5d5b4bc6d497ffa98491e38', 'user3.jpg'),
(6, 'user4', '482c811da5d5b4bc6d497ffa98491e38', 'user4.jpg'),
(7, 'user5', '482c811da5d5b4bc6d497ffa98491e38', 'user5.jpg'),
(8, 'user6', '482c811da5d5b4bc6d497ffa98491e38', 'user6.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articel`
--
ALTER TABLE `articel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id_gallery`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id_gallery` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
