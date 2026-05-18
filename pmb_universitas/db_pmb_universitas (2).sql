-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Bulan Mei 2026 pada 11.34
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pmb_universitas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `daftar_ulang`
--

CREATE TABLE `daftar_ulang` (
  `id_daftar_ulang` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `nominal` bigint(20) DEFAULT NULL,
  `status_verifikasi` enum('menunggu','valid','ditolak') DEFAULT 'menunggu',
  `catatan` text DEFAULT NULL,
  `verified_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `daftar_ulang`
--

INSERT INTO `daftar_ulang` (`id_daftar_ulang`, `id_pendaftaran`, `bukti_pembayaran`, `tanggal_bayar`, `nominal`, `status_verifikasi`, `catatan`, `verified_by`, `created_at`) VALUES
(3, 9, 'bukti_1779096719.png', '2026-05-18', 2500000, 'valid', NULL, 9, '2026-05-18 09:31:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen`
--

CREATE TABLE `dokumen` (
  `id_dokumen` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `ktp` varchar(255) DEFAULT NULL,
  `kartu_keluarga` varchar(255) DEFAULT NULL,
  `ijazah` varchar(255) DEFAULT NULL,
  `raport` varchar(255) DEFAULT NULL,
  `sertifikat` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `dokumen`
--

INSERT INTO `dokumen` (`id_dokumen`, `id_pendaftaran`, `foto`, `ktp`, `kartu_keluarga`, `ijazah`, `raport`, `sertifikat`, `created_at`) VALUES
(8, 8, '1779096258_Screenshot 2026-05-14 001810.png', '1779096258_Screenshot 2026-05-18 001207.png', '1779096258_Screenshot 2026-05-13 231833.png', '1779096258_donat-tiramisu.jpeg', '1779096258_hans_logo.png', '1779096258_Amanjiwo-Borobudur-Resort-02.jpg', '2026-05-18 09:24:18'),
(9, 9, '1779096509_Screenshot 2026-05-18 150750.png', '1779096509_Screenshot 2026-05-17 194327.png', '1779096509_Screenshot 2026-05-18 001135.png', '1779096509_Screenshot 2026-05-17 235304.png', '1779096509_Screenshot 2026-05-17 235433.png', '1779096509_Screenshot 2026-05-18 001756.png', '2026-05-18 09:28:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftaran`
--

CREATE TABLE `pendaftaran` (
  `id_pendaftaran` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nomor_pendaftaran` varchar(30) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `nisn` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `agama` varchar(30) DEFAULT NULL,
  `asal_sekolah` varchar(100) DEFAULT NULL,
  `tahun_lulus` year(4) DEFAULT NULL,
  `nama_ayah` varchar(100) DEFAULT NULL,
  `nama_ibu` varchar(100) DEFAULT NULL,
  `no_hp_ortu` varchar(20) DEFAULT NULL,
  `jurusan_pilihan` varchar(100) DEFAULT NULL,
  `status_pendaftaran` enum('draft','submitted','seleksi','lulus','tidak_lulus','daftar_ulang','selesai') DEFAULT 'draft',
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pendaftaran`
--

INSERT INTO `pendaftaran` (`id_pendaftaran`, `id_user`, `nomor_pendaftaran`, `nik`, `nisn`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `agama`, `asal_sekolah`, `tahun_lulus`, `nama_ayah`, `nama_ibu`, `no_hp_ortu`, `jurusan_pilihan`, `status_pendaftaran`, `tanggal_daftar`) VALUES
(8, 9, 'PMB20260518465', '3244042903060011', '1212755050', 'Cirebon', '2006-03-29', 'L', 'Jl. Kecapi', 'Kristen', 'SMKN 1 Persil', 2024, 'Yanto', 'Ana', '0835678954', 'Teknik Informatika', 'tidak_lulus', '2026-05-18 09:23:19'),
(9, 10, 'PMB20260518904', '3208175107040003', '00640789002', 'Edinburgh', '2026-05-12', 'P', 'Jl. Persil', 'Katolik', 'SMAN 1 Persil', 2024, 'Dudi', 'Asti', '08777695463256', 'Akuntansi', 'selesai', '2026-05-18 09:27:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `hasil` enum('lulus','tidak_lulus','cadangan') DEFAULT 'cadangan',
  `keterangan` text DEFAULT NULL,
  `tanggal_pengumuman` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id_pengumuman`, `id_pendaftaran`, `hasil`, `keterangan`, `tanggal_pengumuman`) VALUES
(7, 9, 'lulus', 'Selamat anda dinyatakan lulus', '2026-05-18 09:28:58'),
(8, 8, 'tidak_lulus', 'Mohon maaf anda belum lulus', '2026-05-18 09:30:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','mahasiswa') DEFAULT 'mahasiswa',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `email`, `no_hp`, `password`, `role`, `created_at`) VALUES
(1, 'Salwa Ayudia', 'salwaayudia@gmail.com', '08123456789', '0192023a7bbd73250516f069df18b500', 'admin', '2026-05-18 01:23:24'),
(9, 'Abdullah Fattah', 'tahfa979@gmail.com', '083176893435', '95554b27d822a619f2911f3ebeb5d490', 'mahasiswa', '2026-05-18 09:20:29'),
(10, 'Salwa Ayudia Putri', 'salwa123@gmail.com', '08145728965', '31a55dbf049616691309fb7ada746a01', 'mahasiswa', '2026-05-18 09:25:43');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `daftar_ulang`
--
ALTER TABLE `daftar_ulang`
  ADD PRIMARY KEY (`id_daftar_ulang`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `verified_by` (`verified_by`);

--
-- Indeks untuk tabel `dokumen`
--
ALTER TABLE `dokumen`
  ADD PRIMARY KEY (`id_dokumen`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indeks untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD PRIMARY KEY (`id_pendaftaran`),
  ADD UNIQUE KEY `nomor_pendaftaran` (`nomor_pendaftaran`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `daftar_ulang`
--
ALTER TABLE `daftar_ulang`
  MODIFY `id_daftar_ulang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id_dokumen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `daftar_ulang`
--
ALTER TABLE `daftar_ulang`
  ADD CONSTRAINT `daftar_ulang_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE,
  ADD CONSTRAINT `daftar_ulang_ibfk_2` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `dokumen`
--
ALTER TABLE `dokumen`
  ADD CONSTRAINT `dokumen_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  ADD CONSTRAINT `pendaftaran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
