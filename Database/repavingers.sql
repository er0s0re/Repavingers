-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2024 at 01:56 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `repavingers`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(255) NOT NULL,
  `email_admin` varchar(255) NOT NULL,
  `password_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `nama_admin`, `email_admin`, `password_admin`) VALUES
(1, 'Admin 1', 'admin1@email.com', 'password_admin1'),
(2, 'Admin 2', 'admin2@email.com', 'password_admin2');

-- --------------------------------------------------------

--
-- Table structure for table `kebutuhan_sampah`
--

CREATE TABLE `kebutuhan_sampah` (
  `id_kebutuhan` int(11) NOT NULL,
  `id_pabrik` int(11) NOT NULL,
  `jenis_sampah` varchar(255) NOT NULL,
  `jumlah_sampah` int(11) NOT NULL,
  `satuan_sampah` varchar(255) NOT NULL,
  `tanggal_kebutuhan` date NOT NULL,
  `status_kebutuhan` enum('menunggu verifikasi','disetujui','ditolak') DEFAULT 'menunggu verifikasi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kebutuhan_sampah`
--

INSERT INTO `kebutuhan_sampah` (`id_kebutuhan`, `id_pabrik`, `jenis_sampah`, `jumlah_sampah`, `satuan_sampah`, `tanggal_kebutuhan`, `status_kebutuhan`) VALUES
(1, 1, 'Plastik', 100, 'kg', '2023-01-01', 'disetujui'),
(2, 2, 'Kertas', 50, 'kg', '2023-01-02', 'disetujui'),
(3, 1, 'Besi', 200, 'kg', '2023-01-03', 'disetujui'),
(5, 1, 'masyarakat', 100, 'kg', '2024-01-12', 'ditolak');

-- --------------------------------------------------------

--
-- Table structure for table `komunitas`
--

CREATE TABLE `komunitas` (
  `id_komunitas` int(11) NOT NULL,
  `nama_komunitas` varchar(255) NOT NULL,
  `email_komunitas` varchar(255) NOT NULL,
  `password_komunitas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `komunitas`
--

INSERT INTO `komunitas` (`id_komunitas`, `nama_komunitas`, `email_komunitas`, `password_komunitas`) VALUES
(1, 'Komunitas 1', 'komunitas1@email.com', 'password_komunitas1'),
(2, 'Komunitas 2', 'komunitas2@email.com', 'password_komunitas2');

-- --------------------------------------------------------

--
-- Table structure for table `laporan_penjualan_sampah`
--

CREATE TABLE `laporan_penjualan_sampah` (
  `id_laporan` int(11) NOT NULL,
  `id_pabrik` int(11) NOT NULL,
  `id_penjualan` int(11) NOT NULL,
  `tanggal_laporan` date NOT NULL,
  `total_penjualan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `laporan_penjualan_sampah`
--

INSERT INTO `laporan_penjualan_sampah` (`id_laporan`, `id_pabrik`, `id_penjualan`, `tanggal_laporan`, `total_penjualan`) VALUES
(3, 1, 5, '2024-01-12', 10);

-- --------------------------------------------------------

--
-- Table structure for table `pabrik_paving`
--

CREATE TABLE `pabrik_paving` (
  `id_pabrik` int(11) NOT NULL,
  `nama_pabrik` varchar(255) NOT NULL,
  `alamat_pabrik` varchar(255) NOT NULL,
  `email_pabrik` varchar(255) NOT NULL,
  `telepon_pabrik` varchar(255) NOT NULL,
  `password_pabrik` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pabrik_paving`
--

INSERT INTO `pabrik_paving` (`id_pabrik`, `nama_pabrik`, `alamat_pabrik`, `email_pabrik`, `telepon_pabrik`, `password_pabrik`) VALUES
(1, 'Pabrik Paving 1', 'Jl. Raya 1', 'pabrik1@email.com', '021-1234567', 'password1'),
(2, 'Pabrik Paving 2', 'Jl. Raya 2', 'pabrik2@email.com', '021-2345678', 'password2');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan_sampah`
--

CREATE TABLE `penjualan_sampah` (
  `id_penjualan` int(11) NOT NULL,
  `id_penjual` int(11) NOT NULL,
  `id_kebutuhan` int(11) NOT NULL,
  `jumlah_sampah` int(11) NOT NULL,
  `satuan_sampah` varchar(255) NOT NULL,
  `tanggal_penjualan` date NOT NULL,
  `status_penjualan` enum('menunggu verifikasi','disetujui','ditolak') DEFAULT 'menunggu verifikasi',
  `foto_sampah` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjualan_sampah`
--

INSERT INTO `penjualan_sampah` (`id_penjualan`, `id_penjual`, `id_kebutuhan`, `jumlah_sampah`, `satuan_sampah`, `tanggal_penjualan`, `status_penjualan`, `foto_sampah`) VALUES
(2, 2, 2, 25, 'kg', '2023-01-05', 'disetujui', 'foto_sampah2.jpg'),
(5, 1, 3, 10, 'kg', '2024-01-30', 'disetujui', ''),
(6, 1, 2, 2, 'kg', '2024-01-19', 'menunggu verifikasi', '');

-- --------------------------------------------------------

--
-- Table structure for table `penjual_sampah`
--

CREATE TABLE `penjual_sampah` (
  `id_penjual` int(11) NOT NULL,
  `nama_penjual` varchar(255) NOT NULL,
  `alamat_penjual` varchar(255) NOT NULL,
  `email_penjual` varchar(255) NOT NULL,
  `telepon_penjual` varchar(255) NOT NULL,
  `password_penjual` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penjual_sampah`
--

INSERT INTO `penjual_sampah` (`id_penjual`, `nama_penjual`, `alamat_penjual`, `email_penjual`, `telepon_penjual`, `password_penjual`) VALUES
(1, 'Penjual Sampah 1', 'Jalan Prof. Hamka, Ngaliyan, Kota Semarang 50185, Jawa Tengah, Indonesia', 'penjual1@email.com', '021-3456789', 'password3'),
(2, 'Penjual Sampah 2', 'Jl. Raya 4', 'penjual2@email.com', '021-4567890', 'password4'),
(3, 'Penjual Sampah 3', 'Jl. Raya 5', 'penjual3@email.com', '021-5678901', 'password5'),
(4, 'Odin', 'Jl.Kebelakang', 'odin432@gmail.com', '08776326432', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `kebutuhan_sampah`
--
ALTER TABLE `kebutuhan_sampah`
  ADD PRIMARY KEY (`id_kebutuhan`),
  ADD KEY `id_pabrik` (`id_pabrik`);

--
-- Indexes for table `komunitas`
--
ALTER TABLE `komunitas`
  ADD PRIMARY KEY (`id_komunitas`);

--
-- Indexes for table `laporan_penjualan_sampah`
--
ALTER TABLE `laporan_penjualan_sampah`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_pabrik` (`id_pabrik`),
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `pabrik_paving`
--
ALTER TABLE `pabrik_paving`
  ADD PRIMARY KEY (`id_pabrik`);

--
-- Indexes for table `penjualan_sampah`
--
ALTER TABLE `penjualan_sampah`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_penjual` (`id_penjual`),
  ADD KEY `id_kebutuhan` (`id_kebutuhan`);

--
-- Indexes for table `penjual_sampah`
--
ALTER TABLE `penjual_sampah`
  ADD PRIMARY KEY (`id_penjual`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kebutuhan_sampah`
--
ALTER TABLE `kebutuhan_sampah`
  MODIFY `id_kebutuhan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `komunitas`
--
ALTER TABLE `komunitas`
  MODIFY `id_komunitas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laporan_penjualan_sampah`
--
ALTER TABLE `laporan_penjualan_sampah`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pabrik_paving`
--
ALTER TABLE `pabrik_paving`
  MODIFY `id_pabrik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `penjualan_sampah`
--
ALTER TABLE `penjualan_sampah`
  MODIFY `id_penjualan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penjual_sampah`
--
ALTER TABLE `penjual_sampah`
  MODIFY `id_penjual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kebutuhan_sampah`
--
ALTER TABLE `kebutuhan_sampah`
  ADD CONSTRAINT `kebutuhan_sampah_ibfk_1` FOREIGN KEY (`id_pabrik`) REFERENCES `pabrik_paving` (`id_pabrik`);

--
-- Constraints for table `laporan_penjualan_sampah`
--
ALTER TABLE `laporan_penjualan_sampah`
  ADD CONSTRAINT `laporan_penjualan_sampah_ibfk_1` FOREIGN KEY (`id_pabrik`) REFERENCES `pabrik_paving` (`id_pabrik`),
  ADD CONSTRAINT `laporan_penjualan_sampah_ibfk_2` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan_sampah` (`id_penjualan`);

--
-- Constraints for table `penjualan_sampah`
--
ALTER TABLE `penjualan_sampah`
  ADD CONSTRAINT `penjualan_sampah_ibfk_1` FOREIGN KEY (`id_penjual`) REFERENCES `penjual_sampah` (`id_penjual`),
  ADD CONSTRAINT `penjualan_sampah_ibfk_2` FOREIGN KEY (`id_kebutuhan`) REFERENCES `kebutuhan_sampah` (`id_kebutuhan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
