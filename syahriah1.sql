-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2024 at 08:47 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `syahriah`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'maizulfikrifadilah');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `nis` int(11) DEFAULT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `status` enum('lunas','belum') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `jumlah` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Lunas','Belum Bayar') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `nama`, `nis`, `bulan`, `tanggal_bayar`, `jumlah`, `status`) VALUES
(7, '', '2001', 'januari', NULL, 20000.00, 'Lunas'),
(8, '', '2002', 'januari', NULL, 30000.00, ''),
(9, '', '21', 'januari', NULL, 20000.00, 'Lunas'),
(10, '', '2001', 'januari', NULL, 20000.00, 'Lunas'),
(11, '', '201', 'januari', NULL, 30000.00, 'Lunas'),
(12, '', '2000', 'januari', NULL, 10000.00, ''),
(13, '', '2001', 'januari', NULL, 20000.00, 'Lunas'),
(15, '', '201', 'januari', NULL, 30000.00, 'Lunas'),
(16, '', '201', 'januari', NULL, 30000.00, ''),
(17, '', '201', 'januari', NULL, 20000.00, 'Lunas'),
(19, '', '888', 'agustus', NULL, 20000.00, 'Lunas'),
(20, '', '22222', 'agustus', NULL, 30000.00, 'Lunas'),
(21, '', '2012', 'desember', NULL, 30000.00, ''),
(22, '', '2003', 'maret', NULL, 30000.00, ''),
(23, '', '201', 'maret', NULL, 30000.00, 'Lunas'),
(24, '', '2001', 'september', NULL, 30000.00, 'Lunas'),
(25, '', '201', 'januari', NULL, 30000.00, 'Lunas'),
(26, '', '202257001', 'januari', NULL, 20000.00, 'Lunas'),
(27, '', '202257002', 'agustus', NULL, 20000.00, 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `santri`
--

CREATE TABLE `santri` (
  `nis` int(11) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `kelas` int(11) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `santri`
--

INSERT INTO `santri` (`nis`, `nama`, `kelas`, `alamat`) VALUES
(202257001, 'ijul', 3, 'kemplang'),
(202257002, 'ari', 3, 'jatirokeh');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
