-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 12, 2025 at 06:04 PM
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
-- Database: `air`
--

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `kota` varchar(50) NOT NULL,
  `telp` varchar(100) NOT NULL,
  `level` varchar(50) NOT NULL,
  `tipe` varchar(10) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `nama`, `alamat`, `kota`, `telp`, `level`, `tipe`, `status`) VALUES
('admin', '$2y$10$uPHHW50rU7HeATUGouystu7isDBWxhmvMzgwyQTXt1Kbt5IK0z/0C', 'Admin Web', 'Polines', 'Semarang', '024111', 'admin', '', 'TIDAK AKTIF'),
('admin2', '$2y$10$IGgg.rkt6LQF0Lo0lkUGXOL483fegNxvsOdE6OOPgwAhwJiPaGLfm', 'Admin Web', 'Polines', 'Semarang', '024111', 'admin', '-', '0'),
('alan', '$2y$10$amm7KgdOglAxGUqkdOExDuyp6dIdCtjFQlf9XQGnkBv5Lt6E3FKPC', 'Alan', 'Gondang', 'Icikiwir', '999', 'warga', 'Kost', 'AKTIF'),
('bendahara', '$2y$10$Fq/8fH.qvsSrsSR.6S6gGefci/D9QGw9rjBJaSTSH2PAPWYdHY5Qe', 'Bendahara Air', 'Polines', 'Semarang', '024111', 'bendahara', '-', '0'),
('petugas', '$2y$10$EqDOxb1vi5MbwM9RYoA4PeJB.1MSnPijJErT9MOOp6.KzvUixYwMm', 'Petugas Air', 'Polines', 'Semarang', '024111', 'petugas', '-', '0'),
('warga', '$2y$10$nMThkwJ9UA2f42oZdui15OSgeJ06CmV6W8Mk3VBqiqKXj14HGbtAq', 'Warga', 'Polines', 'Semarang', '024111', 'warga', '-', '0'),
('zaidan', '$2y$10$1.5BYlqw.lmRgzuNaKta2ekOj/xeXzN8rN2UEcLeu/Oy8jpZzeUkO', 'Zaidan', 'Pucang Gading', 'Semarang', '089', 'warga', 'Rumah', 'AKTIF');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
