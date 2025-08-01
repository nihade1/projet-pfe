-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_projet_pfe
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `article_commandes`
--

DROP TABLE IF EXISTS `article_commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article_commandes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `commande_id` bigint(20) unsigned NOT NULL,
  `produit_id` bigint(20) unsigned NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` decimal(8,2) NOT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `article_commandes_commande_id_foreign` (`commande_id`),
  KEY `article_commandes_produit_id_foreign` (`produit_id`),
  CONSTRAINT `article_commandes_commande_id_foreign` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `article_commandes_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `article_commandes`
--

LOCK TABLES `article_commandes` WRITE;
/*!40000 ALTER TABLE `article_commandes` DISABLE KEYS */;
INSERT INTO `article_commandes` VALUES (1,5,1,1,200.00,'expediee','2025-07-29 15:03:26','2025-07-30 11:38:44');
/*!40000 ALTER TABLE `article_commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `artisans`
--

DROP TABLE IF EXISTS `artisans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `artisans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `artisans_user_id_foreign` (`user_id`),
  CONSTRAINT `artisans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artisans`
--

LOCK TABLES `artisans` WRITE;
/*!40000 ALTER TABLE `artisans` DISABLE KEYS */;
INSERT INTO `artisans` VALUES (1,8,NULL,NULL,'2025-07-23 11:18:50','2025-07-23 11:18:50'),(2,9,NULL,NULL,'2025-07-24 16:09:05','2025-07-24 16:09:05');
/*!40000 ALTER TABLE `artisans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avis`
--

DROP TABLE IF EXISTS `avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `produit_id` bigint(20) unsigned NOT NULL,
  `note` tinyint(4) NOT NULL,
  `commentaire` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `avis_user_id_foreign` (`user_id`),
  KEY `avis_produit_id_foreign` (`produit_id`),
  CONSTRAINT `avis_produit_id_foreign` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`) ON DELETE CASCADE,
  CONSTRAINT `avis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avis`
--

LOCK TABLES `avis` WRITE;
/*!40000 ALTER TABLE `avis` DISABLE KEYS */;
/*!40000 ALTER TABLE `avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boutiques`
--

DROP TABLE IF EXISTS `boutiques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boutiques` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `artisan_id` bigint(20) unsigned NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boutiques_artisan_id_foreign` (`artisan_id`),
  CONSTRAINT `boutiques_artisan_id_foreign` FOREIGN KEY (`artisan_id`) REFERENCES `artisans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boutiques`
--

LOCK TABLES `boutiques` WRITE;
/*!40000 ALTER TABLE `boutiques` DISABLE KEYS */;
INSERT INTO `boutiques` VALUES (1,'Tayri cuir','Bienvenue chez Tayri Cuir, votre boutique en ligne d├®di├®e ├á lÔÇÖ├®l├®gance et ├á lÔÇÖauthenticit├® du cuir artisanal. Inspir├®e par le mot amazigh \"Tayri\", signifiant amour, notre marque incarne la passion du travail bien fait, lÔÇÖh├®ritage du savoir-faire marocain et la noblesse des mati├¿res naturelles.\r\n\r\nNous vous proposons une s├®lection raffin├®e de sacs, portefeuilles, ceintures et accessoires en cuir v├®ritable, fa├ºonn├®s ├á la main par des artisans talentueux. Chaque pi├¿ce raconte une histoire, celle dÔÇÖune tradition intemporelle alli├®e ├á une touche contemporaine.\r\n\r\nChez Tayri Cuir, nous mettons lÔÇÖamour du d├®tail et la qualit├® au c┼ôur de notre d├®marche, pour vous offrir des cr├®ations durables, uniques et pleines de caract├¿re.\r\n\r\nÔ£¿ Tayri Cuir ÔÇô Le cuir qui a une ├óme.',2,'boutiques/jP4kh6Fk9KwTAPaQTglJ7QszpRHSIOAqgelRAwkY.png','2025-07-26 16:27:05','2025-07-26 16:27:05');
/*!40000 ALTER TABLE `boutiques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-minaidrissi@gmail.com|127.0.0.1','i:1;',1753271458),('laravel-cache-minaidrissi@gmail.com|127.0.0.1:timer','i:1753271458;',1753271458);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'D├®coration','2025-07-23 10:37:02','2025-07-23 10:37:02'),(2,'Bijoux faits main','2025-07-23 10:37:02','2025-07-23 10:37:02'),(3,'V├¬tements artisanaux','2025-07-23 10:37:02','2025-07-23 10:37:02'),(4,'Accessoires en cuir','2025-07-23 10:37:02','2025-07-23 10:37:02'),(5,'C├®ramiques','2025-07-23 10:37:02','2025-07-23 10:37:02'),(6,'Textiles tiss├®s','2025-07-23 10:37:02','2025-07-23 10:37:02'),(7,'Cosm├®tiques naturels','2025-07-23 10:37:02','2025-07-23 10:37:02'),(8,'Objets en bois','2025-07-23 10:37:02','2025-07-23 10:37:02'),(9,'Papeterie & Cartes','2025-07-23 10:37:02','2025-07-23 10:37:02'),(10,'Produits locaux (├®pices, miel, etc.)','2025-07-23 10:37:02','2025-07-23 10:37:02');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commandes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `statut` varchar(255) NOT NULL DEFAULT 'en_attente',
  `montant_total` decimal(10,2) NOT NULL,
  `adresse_livraison` varchar(255) NOT NULL,
  `code_postal_livraison` varchar(255) NOT NULL,
  `ville_livraison` varchar(255) NOT NULL,
  `pays_livraison` varchar(255) NOT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `methode_paiement` varchar(255) DEFAULT NULL,
  `statut_paiement` varchar(255) NOT NULL DEFAULT 'en_attente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commandes_user_id_foreign` (`user_id`),
  CONSTRAINT `commandes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commandes`
--

LOCK TABLES `commandes` WRITE;
/*!40000 ALTER TABLE `commandes` DISABLE KEYS */;
INSERT INTO `commandes` VALUES (1,10,'en_attente',400.00,'Lot Riad Sidi Moumen GH12 IMM2 NR 13','20400','casablanca','maroc','0607057469',NULL,'en_attente','2025-07-28 13:08:09','2025-07-28 13:08:09'),(2,10,'en_attente',400.00,'Lot Riad Sidi Moumen GH12 IMM2 NR 13','20400','casablanca','maroc','0607057469',NULL,'en_attente','2025-07-28 13:08:22','2025-07-28 13:08:22'),(3,10,'en_attente',400.00,'Lot Riad Sidi Moumen GH12 IMM2 NR 13','20400','casablanca','maroc','0607057469',NULL,'en_attente','2025-07-28 13:08:26','2025-07-28 13:08:26'),(4,10,'pay├®',200.00,'Douar Ait Sidi Ali O\'mhend, ouaouizeght, azilal','22402','Azilal','Maroc','0607057469',NULL,'en_attente','2025-07-29 15:01:29','2025-07-29 15:01:29'),(5,10,'pay├®',200.00,'Douar Ait Sidi Ali O\'mhend, ouaouizeght, azilal','22402','Azilal','Maroc','0607057469',NULL,'en_attente','2025-07-29 15:03:26','2025-07-29 15:03:26');
/*!40000 ALTER TABLE `commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (11,'0001_01_01_000000_create_users_table',1),(12,'0001_01_01_000001_create_cache_table',1),(13,'0001_01_01_000002_create_jobs_table',1),(14,'2025_07_13_000001_create_artisans_table',1),(15,'2025_07_13_000002_create_boutiques_table',1),(16,'2025_07_13_000003_create_categories_table',1),(17,'2025_07_13_000004_create_produits_table',1),(18,'2025_07_13_000005_create_commandes_table',1),(19,'2025_07_13_000006_create_article_commandes_table',1),(20,'2025_07_13_000007_create_avis_table',1),(21,'2025_07_30_123645_add_statut_to_article_commandes',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produits`
--

DROP TABLE IF EXISTS `produits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prix` decimal(8,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `boutique_id` bigint(20) unsigned NOT NULL,
  `categorie_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produits_boutique_id_foreign` (`boutique_id`),
  KEY `produits_categorie_id_foreign` (`categorie_id`),
  CONSTRAINT `produits_boutique_id_foreign` FOREIGN KEY (`boutique_id`) REFERENCES `boutiques` (`id`) ON DELETE CASCADE,
  CONSTRAINT `produits_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produits`
--

LOCK TABLES `produits` WRITE;
/*!40000 ALTER TABLE `produits` DISABLE KEYS */;
INSERT INTO `produits` VALUES (1,'Porte-monnaie',200.00,9,'produits/y6xwBVOT8hwSEOFNA6Lyi8B757Z6sFxneAhe4gPr.jpg','Alliez ├®l├®gance et praticit├® avec ce portefeuille compact en cuir v├®ritable, con├ºu pour vous accompagner au quotidien. Son design minimaliste et intemporel convient aussi bien aux femmes quÔÇÖaux hommes en qu├¬te de simplicit├® et de raffinement.\r\n\r\n­ƒö╣ Mati├¿re : Cuir v├®ritable de haute qualit├®\r\n­ƒö╣ Couleur : Marron taupe sobre et ├®l├®gant\r\n­ƒö╣ Dimensions : Format pratique pour sac ou poche\r\n­ƒö╣ Caract├®ristiques : Compartiment principal avec fermeture ├á rabat, id├®al pour cartes, billets et petite monnaie\r\n­ƒö╣ Fabrication artisanale : Chaque pi├¿ce est soigneusement fabriqu├®e ├á la main par nos artisans\r\n\r\nUn accessoire indispensable pour celles et ceux qui appr├®cient la beaut├® du cuir naturel et le savoir-faire traditionnel.\r\n\r\nSouhaitez-vous q',1,4,'2025-07-26 16:30:05','2025-07-29 15:03:26');
/*!40000 ALTER TABLE `produits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('NjLtpKbRXVfMUHxeHqTRPFdtcjdtDotDTP8AOaRw',9,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQzJOVTFrTmRCcktvM2d2TnF0RjlqeUFKTFVrS3A4VXhtbllBNDRuQiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcnRpc2FuL2NvbW1hbmRlcyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjk7fQ==',1753824454),('qgjIw8pIwUazUQig80cq1ppDd0IMXTcOLYL9yw4i',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUHZKT3ozQVU2cE1JcHFmcGFGTmVpbnE4bFNCeXhydFdKTGwxbUdLeSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fX0=',1753811068),('sd8Z9O5etzFAbxKs1O6DXsiZrJKsEwewXxxtgosg',9,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 OPR/120.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWGh6RjFEUUZ1anlnMXdaaDhTTFgzY1dmeGI5ZFVIYUM0ekpTV1c2SiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcnRpc2FuL2JvdXRpcXVlIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTt9',1753883522);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2025-07-23 10:37:01','$2y$12$CMgNn7xq0rMvZNbb7yDinOoupaa1QidEH.Mfbdr1qr2BeGS87xRn.','user','kZEwq0NPHk','2025-07-23 10:37:01','2025-07-23 10:37:01'),(3,'Elmo Tromp','gleichner.larissa@example.net','2025-07-23 10:52:59','$2y$12$s17yc8WlDw0KRG2784FaKemvfxN9eTq9.7C1sX7r6KIt2QeEjgLna','customer','uPkTRlNqtk','2025-07-23 10:52:59','2025-07-23 10:52:59'),(4,'Audra Towne','padberg.bernita@example.net','2025-07-23 10:52:59','$2y$12$s17yc8WlDw0KRG2784FaKemvfxN9eTq9.7C1sX7r6KIt2QeEjgLna','customer','g5d0HSsAOe','2025-07-23 10:52:59','2025-07-23 10:52:59'),(5,'Flavio Mayer Sr.','kconroy@example.net','2025-07-23 10:52:59','$2y$12$s17yc8WlDw0KRG2784FaKemvfxN9eTq9.7C1sX7r6KIt2QeEjgLna','customer','6MTzko2VHT','2025-07-23 10:52:59','2025-07-23 10:52:59'),(6,'Kelsie Schuppe','bryan@example.org','2025-07-23 10:52:59','$2y$12$s17yc8WlDw0KRG2784FaKemvfxN9eTq9.7C1sX7r6KIt2QeEjgLna','customer','aWegkWZAwA','2025-07-23 10:52:59','2025-07-23 10:52:59'),(7,'Mrs. Libby Grimes IV','ohara.alison@example.org','2025-07-23 10:52:59','$2y$12$s17yc8WlDw0KRG2784FaKemvfxN9eTq9.7C1sX7r6KIt2QeEjgLna','customer','YKzhSKHiMX','2025-07-23 10:52:59','2025-07-23 10:52:59'),(8,'Tayri Cuir','mohammedfadl@gmail.com',NULL,'$2y$12$Rgpvk.u9XXI/D.H2ccPqkOnfo4yvmULCEbn6PG1htw.cBQKsCKpV2','artisan',NULL,'2025-07-23 11:18:50','2025-07-23 11:18:50'),(9,'nihade ouassekssou','nihade.ouasse01@gmail.com',NULL,'$2y$12$hXAkVw.gg2qaY6cNDGoYTumUxyALKJz5wR5uI89/5nbsI3Uz/LEAS','artisan',NULL,'2025-07-24 16:09:05','2025-07-24 16:09:05'),(10,'nihade ouassekssou','nihade.ouasse@gmail.com',NULL,'$2y$12$Ha/EECSrIs2Zw6N2LU1LSecLcxwDfvuYSaM8dvXFWb/Jk88QHFTpu','customer',NULL,'2025-07-28 13:07:22','2025-07-28 13:07:22');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-30 14:53:17
