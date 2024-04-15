-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Nov 2023 pada 07.31
-- Versi server: 10.1.32-MariaDB
-- Versi PHP: 5.6.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- Tabel User
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id`)
);

-- Tabel Album
CREATE TABLE `tbl_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_album` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `tanggal_buat` date NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_album_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`)
);

-- Tabel Foto
CREATE TABLE `tbl_foto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul_foto` varchar(255) NOT NULL,
  `deskripsi_foto` text NOT NULL,
  `tanggal_unggah` date NOT NULL,
  `lokasi_file` varchar(255) NOT NULL,
  `album_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_foto_album` FOREIGN KEY (`album_id`) REFERENCES `tbl_album` (`id`),
  CONSTRAINT `fk_foto_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`)
);

-- Tabel Komentar
CREATE TABLE `tbl_komentar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `isi_komentar` text NOT NULL,
  `tanggal_komentar` date NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_komentar_foto` FOREIGN KEY (`foto_id`) REFERENCES `tbl_foto` (`id`),
  CONSTRAINT `fk_komentar_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`)
);

-- Tabel Like Foto
CREATE TABLE `tbl_likefoto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `foto_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tanggal_like` date NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_likefoto_foto` FOREIGN KEY (`foto_id`) REFERENCES `tbl_foto` (`id`),
  CONSTRAINT `fk_likefoto_user` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`)
);

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(25) NOT NULL,
  PRIMARY KEY (`category_id`)
);

-- -- Insert data into tbl_user
-- INSERT INTO `tbl_user` (`id`, `username`, `password`, `email`, `nama_lengkap`, `alamat`) VALUES
-- (2, 'irawan', 'adminirawan', 'irawan@gmail.com', 'Irawan', 'Jl. Raya Kadu Seungit'),
-- (3, 'diana', '1234', 'Diana@gmail.com', 'Diana', 'Suka Seneng Cikeusik'),
-- (4, 'hazwan', '123', 'hazwan@gmail.com', 'Hazwan', 'Cikeusik Pandeglang');

-- -- Insert data into tbl_category
-- INSERT INTO `tbl_category` (`category_id`, `category_name`) VALUES
-- (14, 'Perjalanan'),
-- (15, 'Bawah Air'),
-- (16, 'Hewan Peliharaan'),
-- (17, 'Satwa Liar'),
-- (18, 'Makanan'),
-- (19, 'Olahraga'),
-- (20, 'Fashion'),
-- (21, 'Seni Rupa'),
-- (22, 'Dokumenter'),
-- (23, 'Arsitektur');

-- -- Insert data into tbl_image (assuming tb_image is tbl_image)
-- INSERT INTO `tbl_foto` (`id`, `judul_foto`, `deskripsi_foto`, `tanggal_unggah`, `lokasi_file`, `album_id`, `user_id`) VALUES
-- (34, 'Merancang Kota Modern', '<p>Foto ini menggambarkan kegiatan desain perencanaan membuat kota yang modern berdasarkan ramah lingkungan</p>\r\n', '2023-11-28', 'foto1701141777.jpg', 1, 2),
-- (35, 'Merancang Perumahan Elit', '<p>Foto ini menggambarkan kegiatan desain perencanaan membuat Rumah yang modern, nyaman untuk keluarga</p>\r\n', '2023-11-28', 'foto1701144257.jpg', 1, 2),
-- (36, 'Harimau Sumatra', 'Harimau sumatera (Panthera tigris sumatrae) adalah subspesies harimau yang habitat aslinya di pulau Sumatera. Hidup di hutan hujan tropis Sumatera, harimau ini adalah pemakan daging yang ulung. Dengan kecepatan lari hampir 40 mil per jam, mereka adalah predator yang tangguh di alam liar. Kemampuannya berburu, terutama di malam hari, memungkinkan mereka untuk mengintai mangsa dengan diam-diam sebelum menerkam dengan cepat.', '2023-11-28', 'foto1701147078.jpg', 1, 3),
-- (37, 'Badak Jawa', 'Badak Jawa (Rhinoceros sondaicus) adalah jenis satwa langka yang masuk kedalam 25 spesies prioritas utama konservasi Pemerintah Indonesia. Badak Jawa dapat hidup hingga 30-45 tahun di habitat aslinya. Mereka biasa tinggal di hutan hujan dataran rendah, padang rumput basah, dan dataran banjir yang luas. Badak ini merupakan makhluk yang suka menyendiri, kecuali saat pacaran dan saat membesarkan anak.', '2023-11-28', 'foto1701147926.jpg', 1, 3),
-- (38, 'Kucing Angora', 'Anggora adalah kucing dengan ciri khas berbulu panjang yang indah. Anggora memiliki tubuh yang sedang dengan badan berotot yang panjang, ramping, langsing dan elegan. Anggora memiliki hidung yang panjang, kepala yang berbentuk segitiga, serta telinga yang panjang, lebar, dan berbentuk segitiga.', '2023-11-28', 'foto1701148582.jpg', 1, 3),
-- (39, 'Ayam Kampung', 'Ayam kampung adalah kualitas daging nya yang memang lebih unggul di bandingkan dengan daging ayam lain nya, sehingga tidak heran jika rasa nya juga jauh lebih enak di bandingkan ayam lain.', '2023-11-28', 'foto1701148797.jpg', 1, 3),
-- (40, 'Pantai Carita', 'Pantai Carita merupakan objek wisata yang terletak di Kabupaten Pandeglang. Fasilitas di Pantai Carita cukup lengkap yaitu Banana boat, snorkling, papan seluncur, diving, dan fasilitas lainnya. Banyak juga penginapan-penginapan sepanjang pesisir pantai dan atau rumah-rumah warga yang difungsikan untuk penginapan.', '2023-11-28', 'foto1701150076.jpg', 1, 4),
-- (41, 'Curug Putri', 'Curug Putri Carita Pandeglang ini unik banget karena terbentuk dari lava yang membeku dan kemudian menjadi aliran sungai dengan batuan cantik.', '2023-11-28', 'foto1701150304.jpg', 1, 4),
-- (42, 'Singa Afrika', 'Singa adalah binatang yang menakutkan , tubuhnya besar, gesit dan garang, buas dan menyeramkan. Singa memiliki taring yang gampang melumatkan mangsanya, punya kuku yang kuat yang mampu menerkam mangsa hingga tak berdaya, dan mencabik- cabiknya. Singa sering digunakan untuk mewakili kekuatan, kegarangan dan kebuasan.', '2023-11-28', 'foto1701150517.jpg', 1, 3);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;