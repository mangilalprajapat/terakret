-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2024 at 03:08 PM
-- Server version: 10.6.17-MariaDB-1:10.6.17+maria~ubu2004
-- PHP Version: 7.2.34-45+ubuntu20.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `terakret`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_settings`
--

CREATE TABLE `app_settings` (
  `app_settings_id` int(11) NOT NULL,
  `point_amount` int(11) NOT NULL DEFAULT 1,
  `app_version` float NOT NULL,
  `maintenance_mode` enum('0','1') NOT NULL DEFAULT '1',
  `maintenance_mode_message` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `app_settings`
--

INSERT INTO `app_settings` (`app_settings_id`, `point_amount`, `app_version`, `maintenance_mode`, `maintenance_mode_message`) VALUES
(1, 1, 1.1, '1', 'saasdsa');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `banner_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`banner_id`, `title`, `banner`, `description`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Home', '1721452033.png', NULL, 'A', '2024-07-20 05:07:13', '2024-07-20 05:07:13'),
(6, 'about', '1721452525.png', NULL, 'A', '2024-07-20 05:15:25', '2024-07-20 05:15:25');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `contact_us_id` int(11) NOT NULL,
  `phone_code` varchar(10) NOT NULL DEFAULT '+91',
  `phone_number` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `map_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`contact_us_id`, `phone_code`, `phone_number`, `email`, `address`, `map_address`) VALUES
(1, '+91', '96875142939', 'info.terakret@gmail.com', '13th Floor, Bdodra, Ahmedabad, 394309, Gujrat, India', 'https://www.google.com/search?q=map+address&oq=map+address&gs_lcrp=EgZjaHJvbWUyBggAEEUYOTIGCAEQRRhA0gEINTA2MGowajeoAgCwAgA&sourceid=chrome&ie=UTF-8');

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `coupon_id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `description` mediumtext DEFAULT NULL,
  `start_at` date NOT NULL,
  `expired_at` date NOT NULL,
  `maximum_usage` int(11) NOT NULL DEFAULT 1,
  `user_limit` int(11) NOT NULL DEFAULT 1,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `coupon`
--

INSERT INTO `coupon` (`coupon_id`, `code`, `points`, `description`, `start_at`, `expired_at`, `maximum_usage`, `user_limit`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'H3EU0BK3XSRQCY5', 400, NULL, '2024-07-20', '2024-08-20', 10, 10, 'A', 0, '2024-07-19 09:53:39', '2024-07-28 07:44:32'),
(2, '009G33P0OG9XFS0', 233, NULL, '2024-07-19', '2024-07-28', 1, 1, 'A', 0, '2024-07-19 09:54:05', '2024-07-28 07:39:27'),
(3, 'CHX2NXWO3JL1TXF', 800, NULL, '2024-07-19', '2024-08-19', 1, 1, 'A', 0, '2024-07-19 09:54:34', '2024-07-19 10:10:39'),
(4, '2RQ8PBVOV7PK0PY', 546, NULL, '2024-07-19', '2024-07-31', 1, 1, 'A', 0, '2024-07-19 09:54:54', '2024-07-19 09:54:54'),
(5, 'S5V6NC7697UR2QX', 432, NULL, '2024-07-19', '2024-07-31', 1, 1, 'A', 0, '2024-07-19 11:19:33', '2024-07-19 11:19:33'),
(6, 'BX10QHDPI0B00M0', 200, NULL, '2024-07-29', '2024-07-31', 300, 3, 'A', 0, '2024-07-28 06:35:34', '2024-07-28 07:44:21');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `username` varchar(255) DEFAULT NULL COMMENT 'Random string',
  `email` varchar(255) DEFAULT NULL,
  `phone_code` varchar(5) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `wallet_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `coupon_points` int(11) NOT NULL DEFAULT 0,
  `is_veryfied` tinyint(1) NOT NULL DEFAULT 0,
  `customer_type` int(11) NOT NULL,
  `language` enum('en','guj') NOT NULL DEFAULT 'en',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `gender` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `referal_code` varchar(30) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `status` enum('Active','Inactive','Rejected') NOT NULL DEFAULT 'Inactive',
  `is_blocked` tinyint(1) DEFAULT 0 COMMENT 'user blocked by admin',
  `device_type` varchar(255) DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `api_token` mediumtext DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `otp` int(11) DEFAULT NULL,
  `otp_expire_at` datetime DEFAULT NULL,
  `is_logging` tinyint(1) NOT NULL DEFAULT 0,
  `is_first_login` enum('pending','first_loggedin','done') DEFAULT 'pending',
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_login_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `username`, `email`, `phone_code`, `phone`, `wallet_amount`, `coupon_points`, `is_veryfied`, `customer_type`, `language`, `is_deleted`, `gender`, `dob`, `country`, `pincode`, `state`, `city`, `referal_code`, `profile_image`, `status`, `is_blocked`, `device_type`, `device_token`, `api_token`, `remember_token`, `otp`, `otp_expire_at`, `is_logging`, `is_first_login`, `password`, `created_at`, `update_at`, `last_login_at`) VALUES
(1, 'Mangi Lal', 'org.mlp@gmail.com', '+91', '9587142939', '101.00', 22, 0, 1, 'en', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Active', 0, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'pending', '$2y$10$w03DZ/fJAFtsMxwo55wPz.ntrNYdY1yv1JityQmlv68K9xwJE16XK', '2024-07-19 11:41:35', '2024-08-01 03:17:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_type`
--

CREATE TABLE `customer_type` (
  `customer_type_id` int(11) NOT NULL,
  `customer_type` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_type`
--

INSERT INTO `customer_type` (`customer_type_id`, `customer_type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Customer', 1, '2024-07-12 03:25:16', '2024-07-12 03:25:16'),
(2, 'Vender', 1, '2024-07-12 03:25:16', '2024-07-12 03:25:16'),
(3, 'Sales', 1, '2024-07-12 03:25:16', '2024-07-12 03:25:16');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_03_09_135529_create_permission_tables', 1),
(5, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(6, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(7, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(8, '2016_06_01_000004_create_oauth_clients_table', 2),
(9, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\User', 1),
(1, 'App\\User', 9),
(2, 'App\\User', 4),
(3, 'App\\User', 2),
(4, 'App\\User', 3);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('021ee2b812378899fed597d0f44f54657ca342cf1f0180da787fd07d6ff01be0edd18b985d5caef3', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:02:29', '2024-07-29 07:02:29', '2025-07-29 12:32:29'),
('0dc39ccfacf8a351c5ff374b11444ae41cfb0d3b77cc57410f1b80511a4b0b37b175c378df6b3889', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:16', '2024-07-29 07:03:16', '2025-07-29 12:33:16'),
('0ead131d0db9871e2700a7f5059942295e470637d1050624be2b794820f333f90b4702f5d6223d17', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:02:41', '2024-07-29 07:02:41', '2025-07-29 12:32:41'),
('1f92c4f7db4939eb31dc04e464010f9221215f1a09583c89ddf3a8658d6ea8a752bc9f15df0123d4', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:05', '2024-07-29 07:03:05', '2025-07-29 12:33:05'),
('24e46a80bae6462b13c0f727e80ad31f502d70a68249e7de505c2c3df611086c01ec22b80dadd364', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:02:43', '2024-07-29 07:02:43', '2025-07-29 12:32:43'),
('48cc4ee6f87a00e13a5b45acb7e0631a0786815d27834c2933c2ba8d760008bcfe2c529c5f0572ff', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:18', '2024-07-29 07:03:18', '2025-07-29 12:33:18'),
('65a40ed84052c25becc1de932f4bcc802cf7fca8109f0c4086afdd15769fef299a209dfd9cc2bbcc', 1, 1, 'authToken', '[]', 0, '2023-05-07 03:42:30', '2023-05-07 03:42:30', '2024-05-07 09:12:30'),
('70abc496e4b6506bc0b184232d07202cc1adaa5d5ac9cfb2e6cba072c7db72520c8ba9befcb917a6', 1, 1, 'authToken', '[]', 0, '2023-05-07 03:51:35', '2023-05-07 03:51:35', '2024-05-07 09:21:35'),
('720e65d2e19cf4471459fbefa2b7ecb5a61d367ab3bb56390ed75f7da8e92f9af13e8747f6f7ad03', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:19', '2024-07-29 07:03:19', '2025-07-29 12:33:19'),
('7505f1037b3feb055ed1416e0a55773d249b8a527b339475c1e5db0736c8458b69538b6228f60a67', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:02', '2024-07-29 07:03:02', '2025-07-29 12:33:02'),
('7aa44daa7c1cf354cd14d7d03b3d82cd5868743e1bec7fadc9d4b8fa1a2d6a456f43e3943340ffa2', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:02:38', '2024-07-29 07:02:38', '2025-07-29 12:32:38'),
('88d1c280ac784e22d9443dc7de1b992d4b78825aa0c2d4956229bd0001954d9eaa764811a04364e3', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:00', '2024-07-29 07:03:00', '2025-07-29 12:33:00'),
('8e646e4875f7249606b8e72eb90eca8b6fb1b9c08b79fa7df44d20a8fa80e13565c4ca03189e32e9', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:13', '2024-07-29 07:03:13', '2025-07-29 12:33:13'),
('a2ba6c4cdea6459a9e88b0e134f8801ed2be941c9c8edc4fa0d1347f1cf256156bf674fc5e8503b0', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:06', '2024-07-29 07:03:06', '2025-07-29 12:33:06'),
('a5ec0b1f6f0e9487f0ad56985d6595ca1fb6323ad909dad1ded9109f89919dd8546711bf3b2da622', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:02:55', '2024-07-29 07:02:55', '2025-07-29 12:32:55'),
('b5dfe3006c51055c815a05428d341b41cc7e16494e63071deed77196ae240b8157a7a8f57ee07c7f', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:03', '2024-07-29 07:03:03', '2025-07-29 12:33:03'),
('d1d488870c09c36f85abc3bf8d47bafa34cea25bac7b25e14bac8d56d7aa1f04aebe785aa634ae20', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:15', '2024-07-29 07:03:15', '2025-07-29 12:33:15'),
('da3e90e9b4f720c8952fd911f23f357151fc502599c22f221ef612e5555363b4f95e9ba8621665ec', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:02:47', '2024-07-29 07:02:47', '2025-07-29 12:32:47'),
('fc9433014ba64f56134ed89ce90557249fdf7bd054ca5fc14ae5c321e711488cbf3abd636652df8d', 1, 1, 'authToken', '[]', 0, '2024-07-29 07:03:08', '2024-07-29 07:03:08', '2025-07-29 12:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Themekit-Laravel-Admin-Panel Personal Access Client', 'UMWq3J9lINVBrWehpr7QJ9wOcoBp27o1PdJu5nN7', NULL, 'http://localhost', 1, 0, 0, '2020-05-09 15:21:41', '2020-05-09 15:21:41'),
(2, NULL, 'Themekit-Laravel-Admin-Panel Password Grant Client', 'A6CbTxyM5JHmF4Yk4BB2Bj23D4EnhEDac7TyuFCF', 'users', 'http://localhost', 0, 1, 0, '2020-05-09 15:21:41', '2020-05-09 15:21:41');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-05-09 15:21:41', '2020-05-09 15:21:41');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin@test.com', '$2y$10$Sv2mf6G2Bgg7BiFce64QIOjZF7EcTKxX4EqypfJV3M3gvrc52yBR.', '2023-05-07 04:05:05');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(3, 'admin', 'web', '2020-03-10 12:41:09', '2024-07-19 02:02:46'),
(4, 'customer', 'web', '2020-03-10 12:41:41', '2024-07-19 02:02:18'),
(5, 'sales', 'web', '2020-03-12 10:16:39', '2024-07-19 02:02:23'),
(6, 'marketer', 'web', '2020-03-12 10:16:54', '2024-07-19 02:02:04'),
(8, 'customer', 'web', '2024-07-19 02:01:55', '2024-07-19 02:01:55');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `sale_price` float(10,2) DEFAULT 0.00,
  `price` float(10,2) NOT NULL DEFAULT 0.00,
  `size` text NOT NULL,
  `product_code` text NOT NULL,
  `description` mediumtext DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `name`, `category_id`, `product_image`, `sale_price`, `price`, `size`, `product_code`, `description`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(7, 'Camilal', 2, '1722052065.png', NULL, 23.00, '20 KG', 'ADSDS34', NULL, 'A', 1, '2024-07-27 03:47:25', '2024-07-27 03:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`category_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Gray', 'A', '2024-07-20 05:59:22', '2024-07-20 05:59:22'),
(2, 'Red', 'A', '2024-07-20 05:59:22', '2024-07-20 05:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2020-03-10 12:10:47', '2020-03-10 12:10:47'),
(2, 'Admin', 'web', '2020-03-10 13:09:23', '2020-03-10 13:09:23'),
(3, 'Project Marketer', 'web', '2020-03-12 12:41:50', '2024-07-19 02:03:59'),
(4, 'Sales Manager', 'web', '2020-03-12 12:42:07', '2020-03-12 12:42:07'),
(10, 'Customer', 'web', '2024-07-19 02:05:06', '2024-07-19 02:05:06');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(3, 2),
(4, 2),
(5, 2),
(5, 4),
(6, 2),
(6, 3),
(8, 10);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'info@terakret.com', NULL, '$2a$04$nEp.F6oYBieIwjh9PXS6muL9J5W6/hr6KM41wKBlZQuGxrkrddJ3S', 'ZP39eW8cazNdYquXKN4WgJI2qnHURDhgBTMZcvu8c0F2J0VtbaHfDBzALt5O', NULL, '2023-05-07 04:54:54'),
(2, 'Project Manager', 'pm@test.com', NULL, '$2y$10$rm0yp.fuqPZevIkxlActtuBpMuTHLGwPRYFaNlA5TToZZqx.i7Tra', NULL, '2020-03-12 12:48:59', '2020-03-12 12:48:59'),
(3, 'Sales Manager', 'sm@test.com', NULL, '$2y$10$40lQm5lnWgtElBwnko7ASuUr.Obu2CI.hPecZ8ZciGsYKkXw2Kf3.', NULL, '2020-03-12 12:50:15', '2020-03-12 12:50:15'),
(4, 'HR', 'hr@test.com', NULL, '$2y$10$sFgFRrOZS4mzhRlAHbDIie.Kz.G3YSIYynnmcljjxVzyl0gkMQT6a', NULL, '2020-03-12 12:55:25', '2020-03-12 12:55:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_bank`
--

CREATE TABLE `user_bank` (
  `bank_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_method` enum('Bank Account','UPI','Google Pay','PhonePe','Paytm','Other') NOT NULL DEFAULT 'Other',
  `upi` varchar(50) DEFAULT NULL,
  `googlepay` varchar(50) DEFAULT NULL,
  `phonepe` varchar(50) DEFAULT NULL,
  `paytm` varchar(50) DEFAULT NULL,
  `account_holder_name` varchar(255) NOT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_type` enum('Saving','Current','Other') DEFAULT 'Other',
  `account_number` varchar(255) DEFAULT NULL,
  `ifsc_code` varchar(255) DEFAULT NULL,
  `document` varchar(100) DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_bank`
--

INSERT INTO `user_bank` (`bank_id`, `user_id`, `payment_method`, `upi`, `googlepay`, `phonepe`, `paytm`, `account_holder_name`, `bank_name`, `account_type`, `account_number`, `ifsc_code`, `document`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(2, 1, 'Paytm', '5678765432', 'gfhfd@acx', '4567543eds@sfds', '654324567@dgdfg', 'iouygh', 'dfcgh', 'Current', '43456789', 'ytre654', '', 'A', 1, '2024-07-27 09:27:20', '2024-07-31 18:22:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_coupons`
--

CREATE TABLE `user_coupons` (
  `user_coupon_id` int(11) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL,
  `start_at` date NOT NULL,
  `expired_at` date NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'I',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_coupons`
--

INSERT INTO `user_coupons` (`user_coupon_id`, `coupon_code`, `points`, `user_id`, `start_at`, `expired_at`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '2RQ8PBVOV7PK0PY', 23, 1, '2024-07-19', '2024-07-31', 'A', 0, '2024-07-19 11:42:38', '2024-07-27 03:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `wallet_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `withdrawal_id` int(11) NOT NULL,
  `amount` float(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`wallet_id`, `customer_id`, `withdrawal_id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 23.00, '2024-08-01 02:34:13', '2024-08-01 02:34:13'),
(2, 1, 3, 30.00, '2024-08-01 03:17:48', '2024-08-01 03:17:48');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawal`
--

CREATE TABLE `withdrawal` (
  `withdrawal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `redeem_points` int(11) NOT NULL DEFAULT 0,
  `reddeem_amounts` float(10,2) NOT NULL DEFAULT 0.00,
  `transaction_id` varchar(100) DEFAULT NULL,
  `document` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('P','S','F','R','C') NOT NULL DEFAULT 'P' COMMENT 'P=Pending, S=Success, F=Faild, R=Rejects,C=Cancelled',
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `withdrawal`
--

INSERT INTO `withdrawal` (`withdrawal_id`, `user_id`, `bank_id`, `redeem_points`, `reddeem_amounts`, `transaction_id`, `document`, `description`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 100, 25.00, '4535345', NULL, NULL, 'S', 0, '2024-07-27 11:01:18', '2024-07-27 05:01:18'),
(2, 1, 2, 23, 23.00, '98765432', NULL, 'test', 'S', 0, '2024-07-27 05:42:25', '2024-07-27 05:42:25'),
(3, 1, 2, 33, 30.00, '4567876', NULL, NULL, 'S', 0, '2024-07-27 05:42:25', '2024-07-27 05:42:25'),
(4, 1, 2, 22, 23.00, NULL, NULL, 'gsdfssfds', 'C', 0, '2024-07-27 05:42:56', '2024-07-27 05:42:56'),
(5, 1, 2, 22, 23.00, '56464564', NULL, NULL, 'S', 0, '2024-07-31 05:42:56', '2024-07-27 05:42:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_settings`
--
ALTER TABLE `app_settings`
  ADD PRIMARY KEY (`app_settings_id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`contact_us_id`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `email` (`email`,`phone`);

--
-- Indexes for table `customer_type`
--
ALTER TABLE `customer_type`
  ADD PRIMARY KEY (`customer_type_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_bank`
--
ALTER TABLE `user_bank`
  ADD PRIMARY KEY (`bank_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD PRIMARY KEY (`user_coupon_id`),
  ADD UNIQUE KEY `code` (`coupon_code`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`wallet_id`);

--
-- Indexes for table `withdrawal`
--
ALTER TABLE `withdrawal`
  ADD PRIMARY KEY (`withdrawal_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `bank_id` (`bank_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_settings`
--
ALTER TABLE `app_settings`
  MODIFY `app_settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `contact_us_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon`
--
ALTER TABLE `coupon`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_type`
--
ALTER TABLE `customer_type`
  MODIFY `customer_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_bank`
--
ALTER TABLE `user_bank`
  MODIFY `bank_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_coupons`
--
ALTER TABLE `user_coupons`
  MODIFY `user_coupon_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `wallet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `withdrawal`
--
ALTER TABLE `withdrawal`
  MODIFY `withdrawal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_bank`
--
ALTER TABLE `user_bank`
  ADD CONSTRAINT `user_bank_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `user_coupons`
--
ALTER TABLE `user_coupons`
  ADD CONSTRAINT `user_coupons_ibfk_1` FOREIGN KEY (`coupon_code`) REFERENCES `coupon` (`code`),
  ADD CONSTRAINT `user_coupons_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `withdrawal`
--
ALTER TABLE `withdrawal`
  ADD CONSTRAINT `withdrawal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `withdrawal_ibfk_2` FOREIGN KEY (`bank_id`) REFERENCES `user_bank` (`bank_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
