-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2020 at 03:25 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alita`
--

-- --------------------------------------------------------

--
-- Table structure for table `akun`
--

CREATE TABLE `akun` (
  `kodeakun` varchar(12) NOT NULL,
  `namaakun` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akun`
--

INSERT INTO `akun` (`kodeakun`, `namaakun`) VALUES
('1900030', 'Pendapatan'),
('1800000', 'Biaya bank');

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `kodebank` varchar(12) NOT NULL,
  `namabank` varchar(25) NOT NULL,
  `cabang` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`kodebank`, `namabank`, `cabang`) VALUES
('1001', 'BCA', 'Roxy');

-- --------------------------------------------------------

--
-- Table structure for table `buktibayar`
--

CREATE TABLE `buktibayar` (
  `idtransaksi` varchar(12) NOT NULL,
  `username` varchar(15) NOT NULL,
  `buktibayar` longblob DEFAULT NULL,
  `totalharga` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `idcustomer` varchar(12) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `npwp` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`idcustomer`, `nama`, `email`, `alamat`, `telepon`, `npwp`) VALUES
('200708132125', 'PT maju mundur', 'atest7139@gmail.com', 'jalan', '123', '123123'),
('200716202620', 'BUDI', 'atest7139@gmail.com', 'jalan', '123123', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `jurnal`
--

CREATE TABLE `jurnal` (
  `idjurnal` varchar(14) NOT NULL,
  `debet` int(1) NOT NULL,
  `jurnal` text NOT NULL,
  `total` int(11) NOT NULL,
  `warkat` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurnal`
--

INSERT INTO `jurnal` (`idjurnal`, `debet`, `jurnal`, `total`, `warkat`) VALUES
('20200716165221', 0, '[[\"1900030\"],[\"1\"],[\"1\"]]', 1, 'GFK 887878'),
('20200716202730', 1, '[[\"2300001\"],[120000],[\"Transaksi 20200716202730 selesai\"]]', 120000, ''),
('20200716202923', 0, '[[\"1900030\",\"1800000\"],[\"5000\",\"30000\"],[\"pendapatan\",\"biaya bank\"]]', 35000, 'GFK 887879');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` varchar(12) NOT NULL,
  `namaproduk` varchar(40) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `namaproduk`, `stok`) VALUES
('200407125003', 'fila', 120),
('200407192729', 'kartu remi', 150),
('200412133557', 'tas', 150),
('200716202244', 'jam', 100);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `idtransaksi` varchar(14) NOT NULL,
  `idcustomer` varchar(12) NOT NULL,
  `jatuhtempo` varchar(14) NOT NULL,
  `nopo` varchar(12) NOT NULL,
  `pembayaran` varchar(6) NOT NULL,
  `produk` text NOT NULL,
  `subtotal` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`idtransaksi`, `idcustomer`, `jatuhtempo`, `nopo`, `pembayaran`, `produk`, `subtotal`, `diskon`, `status`) VALUES
('20200716215715', '200708132125', '20200728', '12A', 'Cash', '[[\"200412133557\"],[\"tas\"],[\"1\"],[\"1\"],[\"1\"]]', 1, 0, 1),
('20200716224735', '200708132125', '20200716', '12', 'Cash', '[[\"200412133557\"],[\"tas\"],[\"10\"],[\"1000\"],[\"10000\"]]', 10000, 0, 1),
('20200716224851', '200708132125', '20200802', '21', 'Cash', '[[\"200412133557\"],[\"tas\"],[\"10\"],[\"1000\"],[\"10000\"]]', 10000, 0, 1),
('20200716224906', '200708132125', '20200805', '200', 'Cash', '[[\"200412133557\"],[\"tas\"],[\"10\"],[\"200\"],[\"2000\"]]', 2000, 0, 1),
('20200716224945', '200708132125', '20200728', '10w', 'Cash', '[[\"200412133557\"],[\"tas\"],[\"10\"],[\"1000\"],[\"10000\"]]', 10000, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `nama`, `telepon`, `alamat`, `status`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin', '123', '123', 0),
('asd', '7815696ecbf1c96e6894b779456d330e', 'ASD', '123', '123asddsa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `warkat`
--

CREATE TABLE `warkat` (
  `kodewarkat` varchar(3) NOT NULL,
  `nowarkat` int(6) NOT NULL,
  `kodebank` varchar(12) NOT NULL,
  `aktif` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `warkat`
--

INSERT INTO `warkat` (`kodewarkat`, `nowarkat`, `kodebank`, `aktif`) VALUES
('GFK', 887876, '1001', 0),
('GFK', 887877, '1001', 0),
('GFK', 887878, '1001', 0),
('GFK', 887879, '1001', 0),
('GFK', 887880, '1001', 1),
('GFK', 887881, '1001', 1),
('GFK', 887882, '1001', 1),
('GFK', 887883, '1001', 1),
('GFK', 887884, '1001', 1),
('GFK', 887885, '1001', 1),
('GFK', 887886, '1001', 1),
('GFK', 887887, '1001', 1),
('GFK', 887888, '1001', 1),
('GFK', 887889, '1001', 1),
('GFK', 887890, '1001', 1),
('GFK', 887891, '1001', 1),
('GFK', 887892, '1001', 1),
('GFK', 887893, '1001', 1),
('GFK', 887894, '1001', 1),
('GFK', 887895, '1001', 1),
('GFK', 887896, '1001', 1),
('GFK', 887897, '1001', 1),
('GFK', 887898, '1001', 1),
('GFK', 887899, '1001', 1),
('GFK', 887900, '1001', 1),
('co', 127126, '1001', 1),
('co', 127127, '1001', 1),
('co', 127128, '1001', 1),
('co', 127129, '1001', 1),
('co', 127130, '1001', 1),
('co', 127131, '1001', 1),
('co', 127132, '1001', 1),
('co', 127133, '1001', 1),
('co', 127134, '1001', 1),
('co', 127135, '1001', 1),
('co', 127136, '1001', 1),
('co', 127137, '1001', 1),
('co', 127138, '1001', 1),
('co', 127139, '1001', 1),
('co', 127140, '1001', 1),
('co', 127141, '1001', 1),
('co', 127142, '1001', 1),
('co', 127143, '1001', 1),
('co', 127144, '1001', 1),
('co', 127145, '1001', 1),
('co', 127146, '1001', 1),
('co', 127147, '1001', 1),
('co', 127148, '1001', 1),
('co', 127149, '1001', 1),
('co', 127150, '1001', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buktibayar`
--
ALTER TABLE `buktibayar`
  ADD PRIMARY KEY (`idtransaksi`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`idcustomer`);

--
-- Indexes for table `jurnal`
--
ALTER TABLE `jurnal`
  ADD PRIMARY KEY (`idjurnal`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`idtransaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
