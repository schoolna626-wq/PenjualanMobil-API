-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 13, 2026 at 06:08 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penjualan_mobil`
--

-- --------------------------------------------------------

--
-- Table structure for table `bayar_cicilan`
--

CREATE TABLE `bayar_cicilan` (
  `kode_cicilan` varchar(255) NOT NULL,
  `kode_kredit` varchar(255) NOT NULL,
  `tanggal_cicilan` varchar(255) NOT NULL,
  `cicilanke` int NOT NULL,
  `jumlah_cicilan` int NOT NULL,
  `sisacicilke` int DEFAULT NULL,
  `sisa_cicilan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bayar_cicilan`
--

INSERT INTO `bayar_cicilan` (`kode_cicilan`, `kode_kredit`, `tanggal_cicilan`, `cicilanke`, `jumlah_cicilan`, `sisacicilke`, `sisa_cicilan`) VALUES
('BC001', 'K001', '2026-10-21', 1, 373333, 48, 17919984),
('BC002', 'K002', '2026-10-21', 2, 373, 47, 17531),
('BC003', 'K003', '2026-10-21', 1, 373, 48, 17904);

-- --------------------------------------------------------

--
-- Table structure for table `beli_cash`
--

CREATE TABLE `beli_cash` (
  `kode_cash` varchar(255) NOT NULL,
  `ktp` varchar(255) NOT NULL,
  `kode_mobil` varchar(255) NOT NULL,
  `cash_tgl` varchar(255) NOT NULL,
  `cash_bayar` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `beli_cash`
--

INSERT INTO `beli_cash` (`kode_cash`, `ktp`, `kode_mobil`, `cash_tgl`, `cash_bayar`) VALUES
('C001', '320111223344', 'M002', '2026-09-10', 12),
('C004', '320199887766', 'M002', '2026-12-22', 5);

-- --------------------------------------------------------

--
-- Table structure for table `kredit`
--

CREATE TABLE `kredit` (
  `kode_kredit` varchar(255) NOT NULL,
  `kode_paket` varchar(255) NOT NULL,
  `ktp` varchar(255) NOT NULL,
  `kode_mobil` varchar(255) NOT NULL,
  `tanggal_kredit` varchar(255) NOT NULL,
  `bayar_kredit` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kredit`
--

INSERT INTO `kredit` (`kode_kredit`, `kode_paket`, `ktp`, `kode_mobil`, `tanggal_kredit`, `bayar_kredit`) VALUES
('K001', 'P001', '5656565556565', 'M002', '2026-10-13', 373333),
('K002', 'P001', '45454544646', 'M003', '2026-10-13', 373),
('K003', 'P001', '45454544646', 'M003', '2026-10-13', 373);

-- --------------------------------------------------------

--
-- Table structure for table `mobil`
--

CREATE TABLE `mobil` (
  `kode_mobil` varchar(255) NOT NULL,
  `merk` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `warna` varchar(255) NOT NULL,
  `harga` int NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mobil`
--

INSERT INTO `mobil` (`kode_mobil`, `merk`, `type`, `warna`, `harga`, `foto`) VALUES
('M001', 'Ferrari', 'Sport', 'Merah', 20000000, 'foto_mobil/M001_1794406382.jpg'),
('M002', 'ferrari', 'Sport', 'Merah', 20000000, NULL),
('M003', 'Avanza', 'Z', 'Putih', 2000000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paket`
--

CREATE TABLE `paket` (
  `kode_paket` varchar(255) NOT NULL,
  `uang_muka` int NOT NULL,
  `tenor` int NOT NULL,
  `bunga_cicilan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `paket`
--

INSERT INTO `paket` (`kode_paket`, `uang_muka`, `tenor`, `bunga_cicilan`) VALUES
('P001', 20, 48, 3),
('P002', 30, 45, 5);

-- --------------------------------------------------------

--
-- Table structure for table `pembeli`
--

CREATE TABLE `pembeli` (
  `ktp` varchar(255) NOT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `alamat_pembeli` varchar(255) NOT NULL,
  `telp_pembeli` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`ktp`, `nama_pembeli`, `alamat_pembeli`, `telp_pembeli`) VALUES
('45454544646', 'jonagay', 'taman balii', '083929329429'),
('5656565556565', 'sepno', 'baloi', '0833434343');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `level`, `id_user`) VALUES
('sales', 'sales123', 1, 1),
('manager', 'manager123', 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bayar_cicilan`
--
ALTER TABLE `bayar_cicilan`
  ADD PRIMARY KEY (`kode_cicilan`);

--
-- Indexes for table `beli_cash`
--
ALTER TABLE `beli_cash`
  ADD PRIMARY KEY (`kode_cash`);

--
-- Indexes for table `kredit`
--
ALTER TABLE `kredit`
  ADD PRIMARY KEY (`kode_kredit`);

--
-- Indexes for table `mobil`
--
ALTER TABLE `mobil`
  ADD PRIMARY KEY (`kode_mobil`);

--
-- Indexes for table `paket`
--
ALTER TABLE `paket`
  ADD PRIMARY KEY (`kode_paket`);

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`ktp`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
