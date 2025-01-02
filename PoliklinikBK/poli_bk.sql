  -- phpMyAdmin SQL Dump
  -- version 5.1.1
  -- https://www.phpmyadmin.net/
  --
  -- Host: 127.0.0.1
  -- Generation Time: Jan 07, 2024 at 02:50 PM
  -- Server version: 10.4.22-MariaDB
  -- PHP Version: 8.1.1

  SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
  START TRANSACTION;
  SET time_zone = "+00:00";


  /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
  /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
  /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
  /*!40101 SET NAMES utf8mb4 */;

  --
  -- Database: `bk_poli`
  --

  -- --------------------------------------------------------

  --
  -- Table structure for table `daftar_poli`
  --

  CREATE TABLE `daftar_poli` (
    `id` int(10) UNSIGNED NOT NULL,
    `id_pasien` int(10) UNSIGNED NOT NULL,
    `id_jadwal` int(10) UNSIGNED NOT NULL,
    `keluhan` text NOT NULL,
    `no_antrian` int(10) UNSIGNED NOT NULL,
    `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  --
  -- Dumping data for table `daftar_poli`
  --

  INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`, `tanggal`) VALUES
  (28, 1, 5, 'gigi sakit', 1, '2024-01-07 06:18:38'),
  (29, 1, 7, 'ulu hati sakit,nyeri sampai dada', 1, '2024-01-07 08:23:21'),
  (30, 2, 8, 'batuk', 1, '2024-01-07 08:35:26'),
  (31, 2, 8, 'batuk', 2, '2024-01-07 08:35:26'),
  (32, 2, 4, 'dada berdebar kencang', 1, '2024-01-07 08:37:02'),
  (33, 11, 7, 'perut sakit di ulu hati', 2, '2024-01-07 10:46:57'),
  (34, 1, 13, 'dada sesak, perut sakit', 1, '2024-01-07 10:51:10');

  -- --------------------------------------------------------

  --
  -- Table structure for table `detail_periksa`
  --

  CREATE TABLE `detail_periksa` (
    `id` int(10) UNSIGNED NOT NULL,
    `id_periksa` int(10) UNSIGNED NOT NULL,
    `id_obat` int(10) UNSIGNED NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  --
  -- Dumping data for table `detail_periksa`
  --

  INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`) VALUES
  (22, 101, 4),
  (23, 101, 5),
  (24, 102, 2),
  (25, 102, 1),
  (26, 103, 3),
  (27, 104, 6),
  (28, 105, 1),
  (29, 105, 2),
  (30, 106, 2);

  -- --------------------------------------------------------

  --
  -- Table structure for table `dokter`
  --

  CREATE TABLE `dokter` (
    `id` int(10) UNSIGNED NOT NULL,
    `nama` varchar(255) NOT NULL,
    `alamat` varchar(255) NOT NULL,
    `no_hp` varchar(50) NOT NULL,
    `id_poli` int(10) UNSIGNED NOT NULL,
    `nip` int(11) NOT NULL,
    `password` varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  --
  -- Dumping data for table `dokter`
  --

  INSERT INTO `dokter` (`id`, `nama`, `alamat`, `no_hp`, `id_poli`, `nip`, `password`) VALUES
  (1, 'dr.Eka', 'jalanin', '081667789123', 1, 16782230, '$2y$10$i3Cc5D0xF7PblGi/Isg2G.4CfKf.3Uba9Z7tzBWm/rtrBzmRdHu9O'),
  (2, 'dr. vitarara', 'ngaliyan', '081678876543', 2, 16782231, '$2y$10$9SRJUYaBxAYZbJG2r7y0QO6StBI9HGDf/cEvlvxpMuNLqdC4HK0rK'),
  (3, 'dr. vita', 'jalanin saja', '087927482648', 6, 16782232, '$2y$10$tGPWtzC9heUptMPwXmrdZ.bGuD0TzLxbGOAo/wTnadJyJxcGBUVOm'),
  (4, 'dr. rara', 'ngaliyan', '081917789176', 7, 16782233, '$2y$10$c58mVulnkLXwXmUe5vEmde7AG1/3qf8Q2kmAmwdU3x0ccevO.ulbu'),
  (7, 'dr. ekavita', 'ngaliyan', '081917789179', 7, 16782234, '$2y$10$JPMNr/8bzs/9i6l543U1z.0UcVJCCDZH3C.PJQqSM5UteULrCGuce');

  -- --------------------------------------------------------

  --
  -- Table structure for table `jadwal_periksa`
  --

  CREATE TABLE `jadwal_periksa` (
    `id` int(10) UNSIGNED NOT NULL,
    `id_dokter` int(10) UNSIGNED NOT NULL,
    `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') NOT NULL,
    `jam_mulai` time NOT NULL,
    `jam_selesai` time NOT NULL,
    `statues` tinyint(1) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  --
  -- Dumping data for table `jadwal_periksa`
  --

  INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`, `statues`) VALUES
  (1, 1, 'Senin', '13:00:00', '15:00:00', 0),
  (2, 2, 'Selasa', '10:00:00', '12:00:00', 0),
  (3, 3, 'Kamis', '20:16:00', '23:19:00', 0),
  (4, 2, 'Kamis', '10:50:00', '12:50:00', 1),
  (5, 1, 'Selasa', '07:00:00', '10:00:00', 1),
  (7, 4, 'Kamis', '16:00:00', '18:00:00', 0),
  (8, 3, 'Selasa', '06:00:00', '10:00:00', 1),
  (13, 7, 'Kamis', '17:30:00', '19:30:00', 1),
  (14, 4, 'Selasa', '18:00:00', '20:00:00', 1),
  (15, 7, 'Senin', '17:00:00', '20:00:00', 0);

  -- --------------------------------------------------------

  --
  -- Table structure for table `obat`
  --

  CREATE TABLE `obat` (
    `id` int(10) UNSIGNED NOT NULL,
    `nama_obat` varchar(50) NOT NULL,
    `kemasan` varchar(35) NOT NULL,
    `harga` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  --
  -- Dumping data for table `obat`
  --

  INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga`) VALUES
  (1, 'omeprazole', 'kapsul', 20000),
  (2, 'sirup episan', 'botol 100ml', 80000),
  (3, 'paratusin', 'kaplet', 25000),
  (4, 'paracetamol', 'kaplet', 10000),
  (5, 'asam mafenamat', 'kaplet', 20000),
  (6, 'concor', 'tablet', 30000);

  -- --------------------------------------------------------

  --
  -- Table structure for table `pasien`
  --

  CREATE TABLE `pasien` (
    `id` int(10) UNSIGNED NOT NULL,
    `nama` varchar(255) NOT NULL,
    `alamat` varchar(255) NOT NULL,
    `no_ktp` varchar(255) NOT NULL,
    `no_hp` varchar(50) NOT NULL,
    `no_rm` varchar(25) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  --
  -- Dumping data for table `pasien`
  --

  INSERT INTO `pasien` (`id`, `nama`, `alamat`, `no_ktp`, `no_hp`, `no_rm`) VALUES
  (1, 'ekavvv', 'jalanin dulu aja', '$2y$10$c0sQyRQ.eYl1Y6oTaQ1dZ.2X7nqdNvNEz38ua8R1SaA/SJrKTtdGS', '089667554332', '2024-01-05-1'),
  (2, 'rara', 'jalan mawar', '$2y$10$tSZOKtVn8EYEGEuj0QFw1OggWxr19kwYN0ouI8m0YZ8GziZ.DYEga', '089667557781', '2024-01-05-2'),
  (3, 'hendrik', 'jl. polke pol', '$2y$10$IlB5TmTgQzIrFc/qfbiRKOz7L.pd1UdKAcwnjVRTU9p6dhJyX4ZgW', '083479826732', '2024-01-05-3'),
  (5, 'vita', 'ngaliyan', '$2y$10$EWfYpxO.5N50H1MLGi4YAuX2aJA9z6Y3p.EiE7tHoYb6vSL4xFW16', '081617766500', '2024-01-05-4'),
  (6, 'vitaaa', 'semarang', '$2y$10$tD5.ciwtVENJ5j6zWPl4s.o/johPlPHSQ4XPWgubG6x4Si4rMxZOS', '081617789221', '2024-01-05-5'),
  (7, 'vitaekaa', 'ngaliyan', '$2y$10$97ii31aHppx1sbJI6YulI.dPeVmfGRq5dmwUP821rxPLUQSPChgZO', '081617789100', '2024-01-05-6'),
  (8, 'pita', 'semarang', '$2y$10$gIB6PCYwb0hjenPA7HeWwuWLX/i78WPaF89QEwECHLVttyUF9LGue', '081663433334', '2024-01-05-7'),
  (9, 'ekav', 'semarang', '$2y$10$IY6elCqN3hz2UiomN3OwG.GQqQXPkZCoPZy/5o14tOnYtw8oCeLEC', '0816177891881', '2024-01-06-8'),
  (10, 'henn', 'ngaliyan', '$2y$10$UyAV1wpzOCJ79kfenpdq..v7eUQuypbvE4WBjwz0dHqBv.L89bG56', '081917789177', '2024-01-07-9'),
  (11, 'henni', 'ngaliyan', '$2y$10$zHIQ0zlq1mpWM1O1heEHyOi/de9./r9lLmA4OLi2w/RLQuuZ7ydQq', '081917789177', '2024-01-07-10');

  -- --------------------------------------------------------

  --
  -- Table structure for table `periksa`
  --

  CREATE TABLE `periksa` (
    `id` int(10) UNSIGNED NOT NULL,
    `id_daftar_poli` int(10) UNSIGNED NOT NULL,
    `tgl_periksa` datetime NOT NULL,
    `catatan` text NOT NULL,
    `biaya_periksa` int(11) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  --
  -- Dumping data for table `periksa`
  --

  INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`) VALUES
  (101, 28, '2024-01-07 07:19:46', 'minum obat 3x1', 180000),
  (102, 29, '2024-01-07 09:32:34', 'asam lambung, minum obat sirup episan dihabiskan', 250000),
  (103, 30, '2024-01-07 09:36:03', 'minum obat 3x1', 175000),
  (104, 32, '2024-01-07 09:37:44', 'minum obat 3x1', 180000),
  (105, 33, '2024-01-07 11:47:51', 'minum obat 3x1', 250000),
  (106, 34, '2024-01-07 11:51:56', 'asam lambung, minum obat sirup episan dihabiskan', 230000);

  -- --------------------------------------------------------

  --
  -- Table structure for table `poli`
  --

  CREATE TABLE `poli` (
    `id` int(10) UNSIGNED NOT NULL,
    `nama_poli` varchar(25) NOT NULL,
    `keterangan` text NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  --
  -- Dumping data for table `poli`
  --

  INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`) VALUES
  (1, 'poli gigi', 'sakit gigi berlubang'),
  (2, 'poli jantung', 'sakit serangan jantung'),
  (6, 'poli anak', 'anak'),
  (7, 'spesialis penyakit dalam', 'penyakit dalam');

  -- --------------------------------------------------------

  --
  -- Table structure for table `user`
  --

  CREATE TABLE `user` (
    `id` int(11) NOT NULL,
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  --
  -- Dumping data for table `user`
  --

  INSERT INTO `user` (`id`, `username`, `password`) VALUES
  (3, 'vita', '$2y$10$2j99cstm6b0Ch.z1mLzje.NTLjYHWZvQKXFn7ebS0EzN3jZc.W6iC');

  --
  -- Indexes for dumped tables
  --

  --
  -- Indexes for table `daftar_poli`
  --
  ALTER TABLE `daftar_poli`
    ADD PRIMARY KEY (`id`),
    ADD KEY `id_pasien` (`id_pasien`),
    ADD KEY `id_jadwal` (`id_jadwal`);

  --
  -- Indexes for table `detail_periksa`
  --
  ALTER TABLE `detail_periksa`
    ADD PRIMARY KEY (`id`),
    ADD KEY `id_periksa` (`id_periksa`),
    ADD KEY `id_obat` (`id_obat`);

  --
  -- Indexes for table `dokter`
  --
  ALTER TABLE `dokter`
    ADD PRIMARY KEY (`id`),
    ADD KEY `id_poli` (`id_poli`);

  --
  -- Indexes for table `jadwal_periksa`
  --
  ALTER TABLE `jadwal_periksa`
    ADD PRIMARY KEY (`id`),
    ADD KEY `id_dokter` (`id_dokter`);

  --
  -- Indexes for table `obat`
  --
  ALTER TABLE `obat`
    ADD PRIMARY KEY (`id`);

  --
  -- Indexes for table `pasien`
  --
  ALTER TABLE `pasien`
    ADD PRIMARY KEY (`id`);

  --
  -- Indexes for table `periksa`
  --
  ALTER TABLE `periksa`
    ADD PRIMARY KEY (`id`),
    ADD KEY `periksa_ibfk_1` (`id_daftar_poli`);

  --
  -- Indexes for table `poli`
  --
  ALTER TABLE `poli`
    ADD PRIMARY KEY (`id`);

  --
  -- Indexes for table `user`
  --
  ALTER TABLE `user`
    ADD PRIMARY KEY (`id`);

  --
  -- AUTO_INCREMENT for dumped tables
  --

  --
  -- AUTO_INCREMENT for table `daftar_poli`
  --
  ALTER TABLE `daftar_poli`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

  --
  -- AUTO_INCREMENT for table `detail_periksa`
  --
  ALTER TABLE `detail_periksa`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

  --
  -- AUTO_INCREMENT for table `dokter`
  --
  ALTER TABLE `dokter`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

  --
  -- AUTO_INCREMENT for table `jadwal_periksa`
  --
  ALTER TABLE `jadwal_periksa`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

  --
  -- AUTO_INCREMENT for table `obat`
  --
  ALTER TABLE `obat`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

  --
  -- AUTO_INCREMENT for table `pasien`
  --
  ALTER TABLE `pasien`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

  --
  -- AUTO_INCREMENT for table `periksa`
  --
  ALTER TABLE `periksa`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

  --
  -- AUTO_INCREMENT for table `poli`
  --
  ALTER TABLE `poli`
    MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

  --
  -- AUTO_INCREMENT for table `user`
  --
  ALTER TABLE `user`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

  --
  -- Constraints for dumped tables
  --

  --
  -- Constraints for table `daftar_poli`
  --
  ALTER TABLE `daftar_poli`
    ADD CONSTRAINT `daftar_poli_ibfk_3` FOREIGN KEY (`id_pasien`) REFERENCES `pasien` (`id`),
    ADD CONSTRAINT `daftar_poli_ibfk_4` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`);

  --
  -- Constraints for table `detail_periksa`
  --
  ALTER TABLE `detail_periksa`
    ADD CONSTRAINT `detail_periksa_ibfk_1` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`),
    ADD CONSTRAINT `detail_periksa_ibfk_2` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`);

  --
  -- Constraints for table `dokter`
  --
  ALTER TABLE `dokter`
    ADD CONSTRAINT `dokter_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id`);

  --
  -- Constraints for table `jadwal_periksa`
  --
  ALTER TABLE `jadwal_periksa`
    ADD CONSTRAINT `jadwal_periksa_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id`);

  --
  -- Constraints for table `periksa`
  --
  ALTER TABLE `periksa`
    ADD CONSTRAINT `periksa_ibfk_1` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`);
  COMMIT;

  /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
  /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
  /*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
