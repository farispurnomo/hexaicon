-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.13-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.0.0.6530
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table ap2.app_settings
CREATE TABLE IF NOT EXISTS `app_settings` (
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.app_settings: ~0 rows (approximately)

-- Dumping structure for table ap2.core_menus
CREATE TABLE IF NOT EXISTS `core_menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) unsigned DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.core_menus: ~3 rows (approximately)
INSERT INTO `core_menus` (`id`, `url`, `title`, `icon`, `parent_id`, `order`, `description`, `created_at`, `updated_at`) VALUES
	(1, '/admin/dashboard', 'Dashboard', NULL, NULL, 0, NULL, NULL, NULL),
	(2, '/admin/master', 'Master', NULL, NULL, 1, NULL, NULL, NULL),
	(3, '/admin/master/icon', 'Icon', NULL, 2, 0, NULL, NULL, NULL);

-- Dumping structure for table ap2.core_menu_abilities
CREATE TABLE IF NOT EXISTS `core_menu_abilities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `menu_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.core_menu_abilities: ~2 rows (approximately)
INSERT INTO `core_menu_abilities` (`id`, `menu_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
	(1, 1, 'dashboard:read', NULL, NULL, NULL),
	(2, 3, 'icon:read', NULL, NULL, NULL);

-- Dumping structure for table ap2.core_privileges
CREATE TABLE IF NOT EXISTS `core_privileges` (
  `role_id` bigint(20) unsigned NOT NULL,
  `ability_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`role_id`,`ability_id`),
  KEY `core_privileges_ability_id_foreign` (`ability_id`),
  CONSTRAINT `core_privileges_ability_id_foreign` FOREIGN KEY (`ability_id`) REFERENCES `core_menu_abilities` (`id`) ON DELETE CASCADE,
  CONSTRAINT `core_privileges_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `core_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.core_privileges: ~2 rows (approximately)
INSERT INTO `core_privileges` (`role_id`, `ability_id`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, NULL),
	(1, 2, NULL, NULL);

-- Dumping structure for table ap2.core_roles
CREATE TABLE IF NOT EXISTS `core_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.core_roles: ~1 rows (approximately)
INSERT INTO `core_roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Superadmin', NULL, NULL);

-- Dumping structure for table ap2.core_users
CREATE TABLE IF NOT EXISTS `core_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `last_active` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `core_users_user_id_unique` (`user_id`),
  KEY `core_users_role_id_foreign` (`role_id`),
  CONSTRAINT `core_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `core_roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.core_users: ~0 rows (approximately)

-- Dumping structure for table ap2.log_subscriptions
CREATE TABLE IF NOT EXISTS `log_subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_id` bigint(20) unsigned NOT NULL,
  `subscription_plan_id` bigint(20) unsigned NOT NULL,
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `subscription_ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `log_subscriptions_subscription_plan_id_foreign` (`subscription_plan_id`),
  CONSTRAINT `log_subscriptions_subscription_plan_id_foreign` FOREIGN KEY (`subscription_plan_id`) REFERENCES `mst_subscription_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.log_subscriptions: ~0 rows (approximately)

-- Dumping structure for table ap2.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.migrations: ~18 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2022_09_09_070709_create_app_settings_table', 1),
	(6, '2022_09_09_071550_create_core_roles_table', 1),
	(7, '2022_09_09_071560_create_core_users_table', 1),
	(8, '2022_09_09_071614_create_core_menus_table', 1),
	(9, '2022_09_09_071625_create_core_menu_abilities_table', 1),
	(10, '2022_09_09_071644_create_core_privileges_table', 1),
	(11, '2022_09_30_113250_create_mst_subscription_plans_table', 1),
	(12, '2022_09_30_113313_create_mst_clients_table', 1),
	(13, '2022_09_30_113351_create_log_subscriptions_table', 1),
	(14, '2022_09_30_113956_create_mst_categories_table', 1),
	(15, '2022_09_30_113957_create_mst_sub_categories_table', 1),
	(16, '2022_09_30_114030_create_mst_icons_table', 1),
	(17, '2022_09_30_114101_create_mst_icon_resolutions_table', 1),
	(18, '2022_09_30_120123_create_mst_icon_resolution_subscriptions_table', 1);

-- Dumping structure for table ap2.mst_categories
CREATE TABLE IF NOT EXISTS `mst_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.mst_categories: ~0 rows (approximately)

-- Dumping structure for table ap2.mst_clients
CREATE TABLE IF NOT EXISTS `mst_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subscription_plan_id` bigint(20) unsigned NOT NULL,
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `subscription_ends_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mst_clients_email_unique` (`email`),
  KEY `mst_clients_subscription_plan_id_foreign` (`subscription_plan_id`),
  CONSTRAINT `mst_clients_subscription_plan_id_foreign` FOREIGN KEY (`subscription_plan_id`) REFERENCES `mst_subscription_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.mst_clients: ~0 rows (approximately)

-- Dumping structure for table ap2.mst_icons
CREATE TABLE IF NOT EXISTS `mst_icons` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sub_category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mst_icons_sub_category_id_foreign` (`sub_category_id`),
  CONSTRAINT `mst_icons_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `mst_sub_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.mst_icons: ~0 rows (approximately)

-- Dumping structure for table ap2.mst_icon_resolutions
CREATE TABLE IF NOT EXISTS `mst_icon_resolutions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `icon_id` bigint(20) unsigned NOT NULL,
  `width` int(11) NOT NULL DEFAULT 0 COMMENT 'in px',
  `height` int(11) NOT NULL DEFAULT 0 COMMENT 'in px',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.mst_icon_resolutions: ~0 rows (approximately)

-- Dumping structure for table ap2.mst_icon_resolution_subscriptions
CREATE TABLE IF NOT EXISTS `mst_icon_resolution_subscriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `icon_resolution_id` bigint(20) unsigned NOT NULL,
  `subscription_plan_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mst_icon_resolution_subscriptions_icon_resolution_id_foreign` (`icon_resolution_id`),
  KEY `mst_icon_resolution_subscriptions_subscription_plan_id_foreign` (`subscription_plan_id`),
  CONSTRAINT `mst_icon_resolution_subscriptions_icon_resolution_id_foreign` FOREIGN KEY (`icon_resolution_id`) REFERENCES `mst_icon_resolutions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mst_icon_resolution_subscriptions_subscription_plan_id_foreign` FOREIGN KEY (`subscription_plan_id`) REFERENCES `mst_subscription_plans` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.mst_icon_resolution_subscriptions: ~0 rows (approximately)

-- Dumping structure for table ap2.mst_subscription_plans
CREATE TABLE IF NOT EXISTS `mst_subscription_plans` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discont` int(11) NOT NULL DEFAULT 0 COMMENT 'in percent',
  `price` bigint(20) NOT NULL DEFAULT 0,
  `total_price` bigint(20) NOT NULL DEFAULT 0 COMMENT 'dicount(%) * price',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.mst_subscription_plans: ~0 rows (approximately)

-- Dumping structure for table ap2.mst_sub_categories
CREATE TABLE IF NOT EXISTS `mst_sub_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mst_sub_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `mst_sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `mst_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table ap2.mst_sub_categories: ~0 rows (approximately)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
