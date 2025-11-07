-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.1.0 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ujian_ujikom_sistem_faktur_penjualan
CREATE DATABASE IF NOT EXISTS `ujian_ujikom_sistem_faktur_penjualan` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ujian_ujikom_sistem_faktur_penjualan`;

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.cache: ~0 rows (approximately)

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.cache_locks: ~0 rows (approximately)

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.customer
CREATE TABLE IF NOT EXISTS `customer` (
  `id_customer` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `perusahaan_cust` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_customer`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.customer: ~8 rows (approximately)
INSERT INTO `customer` (`id_customer`, `nama_customer`, `perusahaan_cust`, `alamat`) VALUES
	(1, 'Irpan', 'Choros', 'Bogor'),
	(2, 'Farhan', 'Levi\'s', 'Tangerang Selatan'),
	(3, 'Inoky', 'Louis Vitton', 'Bekasi'),
	(4, 'Eko', 'Gucci', 'Tangerang'),
	(5, 'Dimas', 'Choros', 'Depok');

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.detail_faktur
CREATE TABLE IF NOT EXISTS `detail_faktur` (
  `id_produk` bigint unsigned NOT NULL,
  `no_faktur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int NOT NULL,
  `price` int NOT NULL,
  KEY `detail_faktur_id_produk_foreign` (`id_produk`),
  CONSTRAINT `detail_faktur_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.detail_faktur: ~4 rows (approximately)
INSERT INTO `detail_faktur` (`id_produk`, `no_faktur`, `qty`, `price`) VALUES
	(1, 'PJ2511070001', 1, 7000000),
	(3, 'PJ2511070002', 50, 2500);

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.faktur
CREATE TABLE IF NOT EXISTS `faktur` (
  `no_faktur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_faktur` datetime NOT NULL,
  `due_date` datetime NOT NULL,
  `metode_bayar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ppn` int NOT NULL,
  `dp` int NOT NULL,
  `grand_total` int NOT NULL,
  `user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_customer` bigint unsigned NOT NULL,
  `id_perusahaan` bigint unsigned NOT NULL,
  PRIMARY KEY (`no_faktur`),
  KEY `faktur_id_customer_foreign` (`id_customer`),
  KEY `faktur_id_perusahaan_foreign` (`id_perusahaan`),
  CONSTRAINT `faktur_id_customer_foreign` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`),
  CONSTRAINT `faktur_id_perusahaan_foreign` FOREIGN KEY (`id_perusahaan`) REFERENCES `perusahaan` (`id_perusahaan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.faktur: ~3 rows (approximately)
INSERT INTO `faktur` (`no_faktur`, `tgl_faktur`, `due_date`, `metode_bayar`, `ppn`, `dp`, `grand_total`, `user`, `id_customer`, `id_perusahaan`) VALUES
	('PJ2511070001', '2025-11-07 02:37:05', '2025-11-08 00:00:00', 'TUNAI', 10, 0, 7700000, 'Farhan Jiratullah', 2, 3),
	('PJ2511070002', '2025-11-07 02:46:34', '2025-11-08 00:00:00', 'TUNAI', 10, 0, 137500, 'Farhan Jiratullah', 1, 4);

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.jobs: ~0 rows (approximately)

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.job_batches: ~0 rows (approximately)

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.migrations: ~1 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2025_11_06_014053_create_customer_table', 1),
	(5, '2025_11_06_014253_create_perusahaans_table', 1),
	(6, '2025_11_06_014448_create_produk_table', 1),
	(7, '2025_11_06_014625_create_faktur_table', 1),
	(8, '2025_11_06_015341_create_detail_faktur_table', 1);

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.perusahaan
CREATE TABLE IF NOT EXISTS `perusahaan` (
  `id_perusahaan` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_perusahaan`),
  UNIQUE KEY `perusahaan_nama_perusahaan_unique` (`nama_perusahaan`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.perusahaan: ~6 rows (approximately)
INSERT INTO `perusahaan` (`id_perusahaan`, `nama_perusahaan`, `alamat`, `no_telp`, `fax`) VALUES
	(1, 'Solaria', 'Ciomas Hill', '081236790123', '+1 (155) 584-9752'),
	(2, 'Gucci', 'New York', '081234567890', '+1 (821) 182-7556'),
	(3, 'Levi\'s', 'Phoenix', '081234567890', '+1 (331) 732-4059'),
	(4, 'Choros', 'Brooklyn', '081234567890', '+1 (199) 368-8748'),
	(5, 'Louis Vitton', 'New Jersey', '081234567890', '+1 (443) 153-1607');

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.produk
CREATE TABLE IF NOT EXISTS `produk` (
  `id_produk` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_produk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` int NOT NULL,
  PRIMARY KEY (`id_produk`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.produk: ~5 rows (approximately)
INSERT INTO `produk` (`id_produk`, `nama_produk`, `price`, `satuan`, `jenis`, `stock`) VALUES
	(1, 'Laptop HP', 7000000, 'pcs', 'Elektronik', 49),
	(2, 'Sofa', 10000000, 'pcs', 'Furniture', 30),
	(3, 'Vitamin C 50 MG KF 10 Tablet', 2500, 'strip', 'Suplemen', 50),
	(4, 'Chitato', 9000, 'pcs', 'Makanan', 200),
	(5, 'Erigo', 200000, 'pcs', 'Pakaian', 80);

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.sessions: ~1 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('ZP31U5ZdeKdVz5uyGGuuAVs2Wmj8ZHV0lwgeI4sw', 6, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiZkoyVHBhdmtVZlRja3pZaVRjWUVuZmdLQXZRaXhkOVJQREw0ZmtETiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUyOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvcGVuanVhbGFuL1BKMjUxMTA3MDAwMi9wcmV2aWV3Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Njt9', 1762484009);

-- Dumping structure for table ujian_ujikom_sistem_faktur_penjualan.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ujian_ujikom_sistem_faktur_penjualan.users: ~1 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(6, 'Farhan Jiratullah', 'farhanjiratullah794@gmail.com', NULL, '$2y$12$y7O6WQkkxdO7EZFMxs0DUeIfWCACz8JFIpmDCNH./fyk4LRp4dCMa', NULL, '2025-11-06 18:11:24', '2025-11-06 18:11:24');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
