-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Bulan Mei 2026 pada 08.48
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
(3, 3, '1779084722_IMG_0632- 3x4.png', '1779084722_Empathy Map.png', '1779084722_Foto praktikum 1.jpeg', '1779084722_beda1.jpg', '1779084722_donat-tiramisu.jpeg', '1779084722_beda.jpg', '2026-05-18 06:12:02'),
(4, 4, '1779086891_batik.jpeg', '1779086891_beda2.jpg', '1779086891_beda.jpg', '1779086891_Amanjiwo-Borobudur-Resort-02.jpg', '1779086891_jarakon.jpeg', '1779086891_ab5dd5_489876ed50244f36bb9ffbeb5211c72f~mv2.png', '2026-05-18 06:48:11');

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
(3, 4, 'PMB20260518142', '3209106103060005', '0064044978', 'Indramayu', '2026-05-06', 'P', 'Jl. Persil', 'Islam', 'SMAN 1 Haurgeulis', 2024, 'Hadi', 'Siti', '089276372632', 'Akuntansi', 'lulus', '2026-05-18 06:11:25'),
(4, 5, 'PMB20260518129', '3209106103060006', '0064044979', 'Indramayu', '2026-05-23', 'P', 'jkahkasjh', 'Hindu', 'SMAN 1 Haurgeulis', 2024, 'Hadi', 'jule', '089276372638', 'Sistem Informasi', 'tidak_lulus', '2026-05-18 06:47:42');

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
(2, 3, 'lulus', 'Selamat anda dinyatakan lulus', '2026-05-18 06:13:03'),
(4, 4, '', 'Mohon maaf anda belum lulus', '2026-05-18 06:48:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `seleksi_berkas`
--

CREATE TABLE `seleksi_berkas` (
  `id_seleksi` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `status_seleksi` enum('menunggu','lulus','tidak_lulus') DEFAULT 'menunggu',
  `catatan` text DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `tanggal_seleksi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `submit_pendaftaran`
--

CREATE TABLE `submit_pendaftaran` (
  `id_submit` int(11) NOT NULL,
  `id_pendaftaran` int(11) NOT NULL,
  `tanggal_submit` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_submit` enum('menunggu','diproses','diterima','ditolak') DEFAULT 'menunggu'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(4, 'Salwa Ayudia Putri', 'salwaayudiaputri2121@gmail.com', '081324212132', '31a55dbf049616691309fb7ada746a01', 'mahasiswa', '2026-05-18 06:10:45'),
(5, 'Nazwa Hummaimah', 'nazwa123@gmail.com', '0818728182', 'e014a5c8d17c98d26ec3a4a7324b091b', 'mahasiswa', '2026-05-18 06:47:00');

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
-- Indeks untuk tabel `seleksi_berkas`
--
ALTER TABLE `seleksi_berkas`
  ADD PRIMARY KEY (`id_seleksi`),
  ADD KEY `id_pendaftaran` (`id_pendaftaran`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Indeks untuk tabel `submit_pendaftaran`
--
ALTER TABLE `submit_pendaftaran`
  ADD PRIMARY KEY (`id_submit`),
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
  MODIFY `id_daftar_ulang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `dokumen`
--
ALTER TABLE `dokumen`
  MODIFY `id_dokumen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pendaftaran`
--
ALTER TABLE `pendaftaran`
  MODIFY `id_pendaftaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `seleksi_berkas`
--
ALTER TABLE `seleksi_berkas`
  MODIFY `id_seleksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `submit_pendaftaran`
--
ALTER TABLE `submit_pendaftaran`
  MODIFY `id_submit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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

--
-- Ketidakleluasaan untuk tabel `seleksi_berkas`
--
ALTER TABLE `seleksi_berkas`
  ADD CONSTRAINT `seleksi_berkas_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE,
  ADD CONSTRAINT `seleksi_berkas_ibfk_2` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `submit_pendaftaran`
--
ALTER TABLE `submit_pendaftaran`
  ADD CONSTRAINT `submit_pendaftaran_ibfk_1` FOREIGN KEY (`id_pendaftaran`) REFERENCES `pendaftaran` (`id_pendaftaran`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
