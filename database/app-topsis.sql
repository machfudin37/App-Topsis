-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jun 2023 pada 03.42
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app-topsis`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` varchar(5) NOT NULL,
  `nm_alternatif` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nm_alternatif`) VALUES
('al001', 'Ahmad'),
('al002', 'Rio'),
('al003', 'Elsa'),
('al004', 'Fahri'),
('al005', 'Adam'),
('al006', 'Sinta'),
('al007', 'Setyawan'),
('al008', 'Adrian'),
('al009', 'Iman'),
('al010', 'Rossa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` varchar(5) NOT NULL,
  `nama_kriteria` varchar(45) NOT NULL,
  `bobot` double NOT NULL,
  `poin1` double NOT NULL,
  `poin2` double NOT NULL,
  `poin3` double NOT NULL,
  `poin4` double NOT NULL,
  `poin5` double NOT NULL,
  `sifat` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`, `bobot`, `poin1`, `poin2`, `poin3`, `poin4`, `poin5`, `sifat`) VALUES
('kr001', 'Tanggung Jawab', 30, 1, 2, 3, 4, 5, 'benefit'),
('kr002', 'Sikap', 30, 1, 2, 3, 4, 5, 'benefit'),
('kr003', 'Keterampilan', 25, 1, 2, 3, 4, 5, 'benefit'),
('kr004', 'Absensi', 15, 1, 2, 3, 4, 5, 'benefit');

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_matrik`
--

CREATE TABLE `nilai_matrik` (
  `id_matrik` int(7) NOT NULL,
  `id_alternatif` varchar(7) NOT NULL,
  `id_kriteria` varchar(7) NOT NULL,
  `nilai` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `nilai_matrik`
--

INSERT INTO `nilai_matrik` (`id_matrik`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(9, 'al002', 'kr001', 5),
(10, 'al002', 'kr002', 3),
(11, 'al002', 'kr003', 1),
(12, 'al002', 'kr004', 3),
(13, 'al003', 'kr001', 3),
(14, 'al003', 'kr002', 4),
(15, 'al003', 'kr003', 5),
(16, 'al003', 'kr004', 1),
(17, 'al004', 'kr001', 2),
(18, 'al004', 'kr002', 1),
(19, 'al004', 'kr003', 2),
(20, 'al004', 'kr004', 4),
(21, 'al005', 'kr001', 3),
(22, 'al005', 'kr002', 5),
(23, 'al005', 'kr003', 2),
(24, 'al005', 'kr004', 4),
(25, 'al006', 'kr001', 4),
(26, 'al006', 'kr002', 2),
(27, 'al006', 'kr003', 3),
(28, 'al006', 'kr004', 5),
(29, 'al007', 'kr001', 1),
(30, 'al007', 'kr002', 3),
(31, 'al007', 'kr003', 5),
(32, 'al007', 'kr004', 2),
(33, 'al008', 'kr001', 3),
(34, 'al008', 'kr002', 4),
(35, 'al008', 'kr003', 1),
(36, 'al008', 'kr004', 2),
(37, 'al009', 'kr001', 3),
(38, 'al009', 'kr002', 3),
(39, 'al009', 'kr003', 2),
(40, 'al009', 'kr004', 1),
(41, 'al010', 'kr001', 4),
(42, 'al010', 'kr002', 3),
(43, 'al010', 'kr003', 3),
(44, 'al010', 'kr004', 5),
(69, 'al001', 'kr001', 2),
(70, 'al001', 'kr002', 4),
(71, 'al001', 'kr003', 4),
(72, 'al001', 'kr004', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_preferensi`
--

CREATE TABLE `nilai_preferensi` (
  `nm_alternatif` varchar(35) NOT NULL,
  `nilai` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(70) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`) VALUES
(11, '', 'admin', 'admin@admin.com', '$2y$10$s5wmxw8R1i3n7TeGhYwi0OiRVClhAzio4kWHPLqi/ojbgVj1ORiba');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `nilai_matrik`
--
ALTER TABLE `nilai_matrik`
  ADD PRIMARY KEY (`id_matrik`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `nilai_matrik`
--
ALTER TABLE `nilai_matrik`
  MODIFY `id_matrik` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
