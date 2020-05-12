-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Bulan Mei 2020 pada 08.10
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_inventory`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_baik`
--

CREATE TABLE `barang_baik` (
  `id_baik` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_baik` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_exp`
--

CREATE TABLE `barang_exp` (
  `id_exp` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_exp` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_warning`
--

CREATE TABLE `barang_warning` (
  `id_warning` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_warning` int(11) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_barang`
--

CREATE TABLE `data_barang` (
  `id_barang` int(11) NOT NULL,
  `kode_barang` varchar(15) DEFAULT NULL,
  `nama_barang` varchar(20) DEFAULT NULL,
  `jenis_barang` varchar(20) DEFAULT NULL,
  `masa_simpan` int(11) DEFAULT NULL,
  `satuan` varchar(10) DEFAULT NULL,
  `jumlah_barang` int(11) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `role` varchar(10) DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `role`, `updated_at`, `created_at`) VALUES
(1, 'superstar', '0ad4dba8d2449d5e42081f9078641fd4', 'super', '2020-05-12 13:04:31', '2020-05-12 13:04:31'),
(2, 'capricorn', 'cikampek', 'user', '2020-05-12 13:07:40', '2020-05-12 13:07:40');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang_baik`
--
ALTER TABLE `barang_baik`
  ADD PRIMARY KEY (`id_baik`),
  ADD KEY `FK1` (`id_barang`);

--
-- Indeks untuk tabel `barang_exp`
--
ALTER TABLE `barang_exp`
  ADD PRIMARY KEY (`id_exp`),
  ADD KEY `FK3` (`id_barang`);

--
-- Indeks untuk tabel `barang_warning`
--
ALTER TABLE `barang_warning`
  ADD PRIMARY KEY (`id_warning`),
  ADD KEY `FK2` (`id_barang`);

--
-- Indeks untuk tabel `data_barang`
--
ALTER TABLE `data_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang_baik`
--
ALTER TABLE `barang_baik`
  MODIFY `id_baik` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `barang_exp`
--
ALTER TABLE `barang_exp`
  MODIFY `id_exp` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `barang_warning`
--
ALTER TABLE `barang_warning`
  MODIFY `id_warning` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `data_barang`
--
ALTER TABLE `data_barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang_baik`
--
ALTER TABLE `barang_baik`
  ADD CONSTRAINT `FK1` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id_barang`);

--
-- Ketidakleluasaan untuk tabel `barang_exp`
--
ALTER TABLE `barang_exp`
  ADD CONSTRAINT `FK3` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id_barang`);

--
-- Ketidakleluasaan untuk tabel `barang_warning`
--
ALTER TABLE `barang_warning`
  ADD CONSTRAINT `FK2` FOREIGN KEY (`id_barang`) REFERENCES `data_barang` (`id_barang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
