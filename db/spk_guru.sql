-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table spk_guru.guru
CREATE TABLE IF NOT EXISTS `guru` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_guru` varchar(100) NOT NULL,
  `absensi` int(11) NOT NULL,
  `prestasi_kerja` int(11) NOT NULL,
  `prestasi_individual` int(11) NOT NULL,
  `skema_nasional` int(11) NOT NULL,
  `sertifikasi_guru` int(11) NOT NULL,
  `nilai_total` decimal(5,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table spk_guru.guru: ~2 rows (approximately)
/*!40000 ALTER TABLE `guru` DISABLE KEYS */;
INSERT INTO `guru` (`id`, `nama_guru`, `absensi`, `prestasi_kerja`, `prestasi_individual`, `skema_nasional`, `sertifikasi_guru`, `nilai_total`) VALUES
	(1, 'Sonasa Rinusantoro', 85, 1, 1, 1, 1, 1.40),
	(2, 'Rinusantoro', 60, 0, 2, 0, 0, 1.00);
/*!40000 ALTER TABLE `guru` ENABLE KEYS */;

-- Dumping structure for table spk_guru.kriteria
CREATE TABLE IF NOT EXISTS `kriteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kriteria` varchar(50) NOT NULL,
  `bobot` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table spk_guru.kriteria: ~5 rows (approximately)
/*!40000 ALTER TABLE `kriteria` DISABLE KEYS */;
INSERT INTO `kriteria` (`id`, `nama_kriteria`, `bobot`) VALUES
	(1, 'Absensi', 30),
	(2, 'Prestasi Kerja', 25),
	(3, 'Prestasi Individual', 25),
	(4, 'Skema Nasional', 10),
	(5, 'Sertifikasi Guru', 10);
/*!40000 ALTER TABLE `kriteria` ENABLE KEYS */;

-- Dumping structure for table spk_guru.nilai_kriteria
CREATE TABLE IF NOT EXISTS `nilai_kriteria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kriteria` int(11) NOT NULL,
  `range_interval` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `nilai` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kriteria` (`id_kriteria`),
  CONSTRAINT `nilai_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Dumping data for table spk_guru.nilai_kriteria: ~5 rows (approximately)
/*!40000 ALTER TABLE `nilai_kriteria` DISABLE KEYS */;
INSERT INTO `nilai_kriteria` (`id`, `id_kriteria`, `range_interval`, `keterangan`, `nilai`) VALUES
	(2, 1, '95-100', 'Sangat Baik', 3),
	(3, 2, '> 3', 'Sangat Baik', 3),
	(4, 3, '> 1', '-', 2),
	(5, 4, '> 1', '-', 2),
	(6, 5, '> 0', 'Punya', 2);
/*!40000 ALTER TABLE `nilai_kriteria` ENABLE KEYS */;

-- Dumping structure for table spk_guru.penilaian
CREATE TABLE IF NOT EXISTS `penilaian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guru_id` int(11) NOT NULL,
  `nilai_akhir` float NOT NULL,
  PRIMARY KEY (`id`),
  KEY `guru_id` (`guru_id`),
  CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table spk_guru.penilaian: ~2 rows (approximately)
/*!40000 ALTER TABLE `penilaian` DISABLE KEYS */;
INSERT INTO `penilaian` (`id`, `guru_id`, `nilai_akhir`) VALUES
	(1, 1, 1.4),
	(2, 2, 1);
/*!40000 ALTER TABLE `penilaian` ENABLE KEYS */;

-- Dumping structure for table spk_guru.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table spk_guru.users: ~1 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `username`, `password`) VALUES
	(1, 'admin', 'Admin@2024!');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
