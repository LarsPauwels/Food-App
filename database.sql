-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Gegenereerd op: 29 aug 2020 om 01:10
-- Serverversie: 10.2.27-MariaDB
-- PHP-versie: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myware_food_app`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `province` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `addresses`
--

INSERT INTO `addresses` (`id`, `street`, `number`, `city`, `province`, `country`, `created_at`, `updated_at`) VALUES
(1, 'Rath Mill', '662', 'Lubowitzstad', 'Oregon', 'Belgium', '2020-08-25 16:41:35', '2020-08-25 16:41:35'),
(2, 'Berneice Square', '12', 'Boyleport', 'Arkansas', 'Netherlands', '2020-08-25 16:43:58', '2020-08-25 16:43:58'),
(3, 'Kuhic Pine', '713', 'North Kallie', 'Maryland', 'Saint Lucia', '2020-08-25 18:58:08', '2020-08-25 18:58:08'),
(4, 'kerkstraat', '123A', 'Tervuren', 'Vlaams-brabant', 'Belgium', '2020-08-25 18:58:08', '2020-08-25 18:58:08');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-08-25 16:47:47', '2020-08-25 16:47:47');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `bases`
--

CREATE TABLE `bases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `isAvailable` tinyint(4) DEFAULT 0,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `currency_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `bases`
--

INSERT INTO `bases` (`id`, `name`, `description`, `price`, `isAvailable`, `supplier_id`, `currency_id`, `created_at`, `updated_at`) VALUES
(1, 'Taco', 'Si senor', 3.2, 1, 1, 1, '2020-08-25 16:44:57', '2020-08-25 16:44:57'),
(2, 'Milkshake', 'My milkshake brings all boys to the yard', 2.5, 1, 1, 1, '2020-08-25 16:39:25', '2020-08-25 16:44:57');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `base__orders`
--

CREATE TABLE `base__orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `base_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `base__orders`
--

INSERT INTO `base__orders` (`id`, `order_id`, `base_id`, `created_at`, `updated_at`) VALUES
(61, 18, 1, '2020-08-27 14:29:38', '2020-08-27 14:29:38'),
(62, 18, 1, '2020-08-27 14:29:38', '2020-08-27 14:29:38'),
(70, 20, 2, '2020-08-28 14:47:16', '2020-08-28 14:47:16'),
(71, 20, 1, '2020-08-28 14:47:16', '2020-08-28 14:47:16'),
(72, 21, 2, '2020-08-28 14:47:27', '2020-08-28 14:47:27'),
(73, 21, 1, '2020-08-28 14:47:27', '2020-08-28 14:47:27');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `base__order__toppings`
--

CREATE TABLE `base__order__toppings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `base_order_id` bigint(20) UNSIGNED NOT NULL,
  `topping_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `base__order__toppings`
--

INSERT INTO `base__order__toppings` (`id`, `base_order_id`, `topping_id`, `order_id`, `created_at`, `updated_at`) VALUES
(49, 71, 1, 20, '2020-08-28 14:47:16', '2020-08-28 14:47:16'),
(50, 71, 2, 20, '2020-08-28 14:47:16', '2020-08-28 14:47:16'),
(51, 73, 1, 21, '2020-08-28 14:47:27', '2020-08-28 14:47:27'),
(52, 73, 2, 21, '2020-08-28 14:47:27', '2020-08-28 14:47:27');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `detail_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `companies`
--

INSERT INTO `companies` (`id`, `detail_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-08-25 16:39:58', '2020-08-25 16:39:58'),
(2, 3, '2020-08-25 19:00:49', '2020-08-25 19:00:49');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `company_supplier`
--

CREATE TABLE `company_supplier` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `company_supplier`
--

INSERT INTO `company_supplier` (`id`, `company_id`, `supplier_id`, `status`, `created_at`, `updated_at`) VALUES
(12, 1, 1, 0, '2020-08-27 12:49:27', '2020-08-27 13:23:38'),
(13, 2, 1, 1, '2020-08-27 21:06:48', '2020-08-27 21:06:48');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Euro', '2020-08-25 16:47:23', '2020-08-25 16:47:23');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `details`
--

CREATE TABLE `details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `details`
--

INSERT INTO `details` (`id`, `phone`, `name`, `address_id`, `created_at`, `updated_at`) VALUES
(1, '+1 (614) 697-1162', 'Tesco', 1, '2020-08-18 16:40:22', '2020-08-25 16:40:22'),
(2, '1-634-744-6129', 'O\'Taco\'', 2, '2020-08-25 16:43:25', '2020-08-25 16:43:25'),
(3, '1-634-744-6129', 'Rippin PLC', 3, '2020-08-25 19:01:08', '2020-08-25 19:01:11'),
(4, '+1 (614) 697-1162', 'Panos', 4, '2020-08-25 19:01:14', '2020-08-25 19:01:17');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 4, 1, '2020-08-25 16:49:20', '2020-08-25 16:49:20');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(2, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(3, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(4, '2016_06_01_000004_create_oauth_clients_table', 1),
(5, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(6, '2020_05_09_133736_create_users_table', 1),
(7, '2020_05_09_134051_create_roles_table', 1),
(8, '2020_05_09_134423_create_admins_table', 1),
(9, '2020_05_09_134530_create_employees_table', 1),
(10, '2020_05_09_134934_create_companies_table', 1),
(11, '2020_05_09_135033_create_details_table', 1),
(12, '2020_05_09_135111_create_addresses_table', 1),
(13, '2020_05_09_135250_create_suppliers_table', 1),
(14, '2020_05_09_135349_create_timesheets_table', 1),
(15, '2020_05_09_135520_create_orders_table', 1),
(16, '2020_05_09_135646_create_base__orders_table', 1),
(17, '2020_05_09_135731_create_bases_table', 1),
(18, '2020_05_09_140021_create_currencies_table', 1),
(19, '2020_05_09_140103_create_toppings_table', 1),
(20, '2020_05_09_140224_create_base__order__toppings_table', 1),
(21, '2020_05_11_223849_create_timesheet__suppliers_table', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('03a2d1c017d886c4e428aaf851ac02f2fc8235608941cbd52d9c75aebe79658a489144a0bd840ded', 1, 1, 'Personal Access Token', '[]', 0, '2020-08-25 14:51:06', '2020-08-25 14:51:06', '2021-08-25 16:51:06'),
('03c77a89c4cacf042e7c8da1c047687109eb5fb9f2f092dce7f1b67f06da85a5d19aaae9045b963c', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-22 21:31:56', '2020-08-22 21:31:56', '2021-08-22 23:31:56'),
('12fe779ccf5f7251a07fa24577ca0e8dd6f352e988bffa6c6b88bd2ad567a04bff39ee9fc60de5e4', 3, 1, 'Personal Access Token', '[]', 0, '2020-08-23 15:14:05', '2020-08-23 15:14:05', '2021-08-23 17:14:05'),
('13791bf291c06e973360ceb2b23147fa65a6f53658ed9fa9950a0a6a7936ae9325229486866660e6', 7, 1, 'Personal Access Token', '[]', 0, '2020-08-27 21:55:20', '2020-08-27 21:55:20', '2021-08-27 23:55:20'),
('1efa6abe15e5227e03d086201ee41eb13fa5dc93fd41575b7dabaf6a91ff476f8d5af9d442781f07', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-27 14:28:46', '2020-08-27 14:28:46', '2021-08-27 16:28:46'),
('228e5882e9b68eeb379f900bd3b1371c35a641a97aa500e8892f22dcd79b47bdb00210f9ead54574', 2, 1, 'Personal Access Token', '[]', 0, '2020-08-27 14:36:04', '2020-08-27 14:36:04', '2021-08-27 16:36:04'),
('25351b7db57fc6deed475c82f7afced1468baa1152847ef7d9a4dc73773d69450e605f539f8d5b08', 2, 1, 'Personal Access Token', '[]', 0, '2020-08-27 14:28:27', '2020-08-27 14:28:27', '2021-08-27 16:28:27'),
('2b810930aa2ec6554a8c44068fda59dd2a3c71849617d37bc71484cf69bda9b6df1e276bf03807a1', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-27 14:26:47', '2020-08-27 14:26:47', '2021-08-27 16:26:47'),
('3194cc664db11906cb692434d903fb254c48438aef4105220aa813ffb48ca0f2aae8b95afe0e117a', 6, 1, 'Personal Access Token', '[]', 0, '2020-08-27 22:49:15', '2020-08-27 22:49:15', '2021-08-28 00:49:15'),
('39b22fac2651eb18890d376170d6f4a93151fa0811bd0fb2d8a4bd5a18ea453e4b088b1b7fd46dd7', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-26 14:43:37', '2020-08-26 14:43:37', '2021-08-26 16:43:37'),
('456bb9f7e8c6e3263134154478f65c7bd05d5db6e8236b5248763d605a442f239133a5b7319f987b', 4, 1, 'Personal Access Token', '[]', 0, '2020-08-27 14:29:12', '2020-08-27 14:29:12', '2021-08-27 16:29:12'),
('476c0a847bf1213f33910c78aba63da8533a1366bc15d692aa4858d10578b4a53d0597b03c4514a0', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-22 22:16:56', '2020-08-22 22:16:56', '2021-08-23 00:16:56'),
('509613dcf0cec06bca42286f8b061f2f828e4c03479d27840ec03b391b2b83a5e905a5abf603bb4e', 2, 1, 'Personal Access Token', '[]', 0, '2020-08-27 14:25:53', '2020-08-27 14:25:53', '2021-08-27 16:25:53'),
('556901d281688f255f9cf4fd9e8d47d002d50fa9d08fea0765719b127645427ad83ee3fe1feb8c2f', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-21 15:02:46', '2020-08-21 15:02:46', '2021-08-21 17:02:46'),
('5634dbd425d4bab6842499c916b7f5091cb45200737f270b14c5950e7d833292bdd4f19b0589742e', 1, 1, 'Personal Access Token', '[]', 0, '2020-08-25 13:24:01', '2020-08-25 13:24:01', '2021-08-25 15:24:01'),
('697f92a7a20cb3f9d1395828ce5a3faef6b9f039bb58b2beb1d8d1f855ee204bc300d9489ac1aa9b', 2, 1, 'Personal Access Token', '[]', 0, '2020-08-25 17:02:03', '2020-08-25 17:02:03', '2021-08-25 19:02:03'),
('779fbdb828c70b67bb44b369146f3ae9038f106c5942276d7fd3f3e87bbbb1f4ee7469216adf9fc0', 4, 1, 'Personal Access Token', '[]', 0, '2020-08-23 20:13:38', '2020-08-23 20:13:38', '2021-08-23 22:13:38'),
('7c2e345abeeff62e616c5db8f13696080632d13d586dab5aa35aef8616004e2949cd2c1fcc47a7a9', 1, 1, 'Personal Access Token', '[]', 0, '2020-08-23 19:14:28', '2020-08-23 19:14:28', '2021-08-23 21:14:28'),
('7f29920785215841b0ea4a7e38f23d02f79b890aa10686e908895e480c4b7c82ac13ff4cb8e5cce8', 1, 1, 'Personal Access Token', '[]', 0, '2020-08-23 20:28:48', '2020-08-23 20:28:48', '2021-08-23 22:28:48'),
('8679c220313de4b66bf82cf83ce2a6293cffab24d5e1efabb3f2abd539f0f13571596d625e67fac9', 3, 1, 'Personal Access Token', '[]', 0, '2020-08-23 19:42:52', '2020-08-23 19:42:52', '2021-08-23 21:42:52'),
('8702a11eb2fc76e9166364c7f249c794f0afed0d7d5b636679c89dfb49149ba4c8d40d0d69917de7', 4, 1, 'Personal Access Token', '[]', 0, '2020-08-23 19:57:40', '2020-08-23 19:57:40', '2021-08-23 21:57:40'),
('8ca73c9b424535c4dc5a055953743cc1f980a7217c4f388b73e7a4895765f7da1c4e5b6fb82bb2fa', 2, 1, 'Personal Access Token', '[]', 0, '2020-08-25 20:55:01', '2020-08-25 20:55:01', '2021-08-25 22:55:01'),
('91d431e0605ff40138a86d2af25e1913a74da2ea16d8afbe27e611dad6ef90e73a13670fbb2dd69c', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-25 18:36:38', '2020-08-25 18:36:38', '2021-08-25 20:36:38'),
('948e4500cf637f89c4b9309229b7a7eeccd30b99a2f8eb58c6f6342f79fc7563e270ab8d6c74f803', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-27 21:55:57', '2020-08-27 21:55:57', '2021-08-27 23:55:57'),
('96adf18b0c562745efb04069fdd81f1b5f36fe6f434e53c5389c471a4a8cc876b6fb543390269aee', 2, 1, 'Personal Access Token', '[]', 0, '2020-08-25 14:52:47', '2020-08-25 14:52:47', '2021-08-25 16:52:47'),
('9e17851174e2476626ba83ba644c10e33851c8a489523f80eb4574812cfae3065a9fb9c2651b1f2e', 20, 1, 'Personal Access Token', '[]', 0, '2020-08-25 14:22:26', '2020-08-25 14:22:26', '2021-08-25 16:22:26'),
('9fc93191ce738b2d72314cf530658ec3fb9da85549b8eb0b95a5e16b095c94eae1dd187062024dc5', 2, 1, 'Personal Access Token', '[]', 0, '2020-08-25 16:46:52', '2020-08-25 16:46:52', '2021-08-25 18:46:52'),
('a2ef6630049aab4017a9a678518760d60a688dc0139dc6af8329a88eaf811e1bdb7326b8f29b382c', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-23 13:47:09', '2020-08-23 13:47:09', '2021-08-23 15:47:09'),
('a5996fbbd5822b28a41276572cb5bf303161f6b1fcba698fc777f8c9cb101fb8bd128f8cb208a15c', 4, 1, 'Personal Access Token', '[]', 0, '2020-08-27 14:28:04', '2020-08-27 14:28:04', '2021-08-27 16:28:04'),
('b6925f005535370b4a7791404a2ee2ecef6771a42f22110823c910d11cd3c6105b8c22c85aed4cc2', 3, 1, 'Personal Access Token', '[]', 0, '2020-08-23 20:13:19', '2020-08-23 20:13:19', '2021-08-23 22:13:19'),
('bb43eea2b007b6ccb8849c3739b2cec4f6b641fe73c0d4bbfecc4d903373a2c870424a93005bbc5b', 3, 1, 'Personal Access Token', '[]', 0, '2020-08-23 19:57:24', '2020-08-23 19:57:24', '2021-08-23 21:57:24'),
('bb6aa97f096bdcb319f66cffdc6abf9a36bd009af9e285b49ade8e314ebb9b60a82285f686f19b99', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-25 16:20:51', '2020-08-25 16:20:51', '2021-08-25 18:20:51'),
('bd4a35e71ffde7d58f7ed8062987b504ada52833d4dab24bfe27e0feb6dc11ab52bf7977c49ed3a8', 4, 1, 'Personal Access Token', '[]', 0, '2020-08-27 14:09:04', '2020-08-27 14:09:04', '2021-08-27 16:09:04'),
('c16091315e909388a55fae2d3d240c88ebfb2f40f362e4e8484f9ed037aa5b7970cad819a426dba5', 4, 1, 'Personal Access Token', '[]', 0, '2020-08-27 14:26:32', '2020-08-27 14:26:32', '2021-08-27 16:26:32'),
('c7fad6e03bfddb75ea3c5d416466c254c2df9e0008981175834a7a3c0725274beddcf0f14184566c', 2, 1, 'Personal Access Token', '[]', 0, '2020-08-28 20:52:17', '2020-08-28 20:52:17', '2021-08-28 22:52:17'),
('d4cbc5ba692fab9b61c29e3dfd9a99a5571a1974d39be2b6e26d1c8e4141b85d413059760f3c3fd6', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-22 21:33:09', '2020-08-22 21:33:09', '2021-08-22 23:33:09'),
('d840706aba9f265fea7e6f782adea8dc985e5727c250dfc7b3d8275cc266cd9b82c1fb603a423330', 1, 1, 'Personal Access Token', '[]', 0, '2020-08-25 13:42:32', '2020-08-25 13:42:32', '2021-08-25 15:42:32'),
('e3f6a0850b5b8f2897f6b3d363cd45a4564d6be97b33af70fb0dbb1b9bff43f4dbdeeaf74655a347', 1, 1, 'Personal Access Token', '[]', 0, '2020-08-21 14:42:54', '2020-08-21 14:42:54', '2021-08-21 16:42:54'),
('e533c81f2e1dc21c5e644254a9aff59600092c47134c066f5a7ef043c7655e770aabaa9ad70b57d9', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-22 22:23:56', '2020-08-22 22:23:56', '2021-08-23 00:23:56'),
('f1cdff7429a89c89898de268f196868d08b28a37f8c9e046b1fa7b6bc6329c63810eb4326b9541a5', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-27 20:43:23', '2020-08-27 20:43:23', '2021-08-27 22:43:23'),
('f2ebf4bdc7c3fcbd134428ea3d6f24090bdcc4915c3daf1716847fb14830427f7cd9d698dcc34c58', 5, 1, 'Personal Access Token', '[]', 0, '2020-08-27 14:08:45', '2020-08-27 14:08:45', '2021-08-27 16:08:45'),
('f3c067cf9812dbd99d7e90d6ddb358df865a72fe57a2e5aab2d9d2a825420a33844cef08a87f0726', 2, 1, 'Personal Access Token', '[]', 0, '2020-08-27 13:21:19', '2020-08-27 13:21:19', '2021-08-27 15:21:19'),
('fdad0ede12cd5465804e0c64a714d7e96c29769e626d751d0f0841323cfa9b57c11f03eb15f9f583', 2, 1, 'Personal Access Token', '[]', 0, '2020-08-25 17:59:25', '2020-08-25 17:59:25', '2021-08-25 19:59:25');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'uenOsYmJrw8efxYqYYppnKz3t9ZGFGqXrvfxoa8e', NULL, 'http://localhost', 1, 0, 0, '2020-08-21 14:42:49', '2020-08-21 14:42:49');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-08-21 14:42:49', '2020-08-21 14:42:49');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) NOT NULL,
  `timesheet_id` bigint(20) UNSIGNED NOT NULL,
  `total_price` double NOT NULL DEFAULT 0,
  `delivery_date` date NOT NULL,
  `delivered` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `orders`
--

INSERT INTO `orders` (`id`, `company_id`, `employee_id`, `supplier_id`, `timesheet_id`, `total_price`, `delivery_date`, `delivered`, `created_at`, `updated_at`) VALUES
(18, 1, 1, 1, 4, 6.4, '2020-08-27', 0, '2020-08-27 14:29:38', '2020-08-27 14:29:38'),
(20, 1, 1, 1, 2, 6.6, '2020-08-25', 0, '2020-08-28 14:47:16', '2020-08-28 14:47:16'),
(21, 1, 1, 1, 2, 6.6, '2020-08-25', 0, '2020-08-28 14:47:27', '2020-08-28 14:47:27');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'The highest level of access to the website. This role can create, update or delete other role users.', '2020-08-25 16:29:31', '2020-08-25 16:29:31'),
(2, 'Company', 'Contains all Employees that can order food products. This role can create, update or delete Employee roles.', '2020-08-25 16:29:31', '2020-08-25 16:29:31'),
(3, 'Employee', 'Can only create orders and view these orders.', '2020-08-25 16:32:12', '2020-08-25 16:32:12'),
(4, 'Supplier', 'Contains all products of their Restaurant and can create, update and delete these.', '2020-08-25 16:32:12', '2020-08-25 16:32:12');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `detail_id` bigint(20) UNSIGNED NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `suppliers`
--

INSERT INTO `suppliers` (`id`, `detail_id`, `locked`, `created_at`, `updated_at`) VALUES
(1, 2, 0, '2020-08-25 16:43:00', '2020-08-25 16:43:00'),
(2, 4, 0, '2020-08-25 18:56:43', '2020-08-25 18:56:43');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `timesheets`
--

CREATE TABLE `timesheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `day` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from` time DEFAULT NULL,
  `until` time DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `timesheets`
--

INSERT INTO `timesheets` (`id`, `company_id`, `supplier_id`, `day`, `from`, `until`, `active`, `created_at`, `updated_at`) VALUES
(49, 1, 1, 'Monday', '11:30:00', '13:30:00', 1, '2020-08-27 12:49:27', '2020-08-27 12:49:27'),
(50, 1, 1, 'Tuesday', '11:30:00', '13:30:00', 1, '2020-08-27 12:49:27', '2020-08-27 12:49:27'),
(51, 1, 1, 'Wednesday', '11:30:00', '13:30:00', 1, '2020-08-27 12:49:27', '2020-08-27 12:49:27'),
(52, 1, 1, 'Thursday', '11:30:00', '13:30:00', 1, '2020-08-27 12:49:27', '2020-08-27 12:49:27'),
(53, 1, 1, 'Friday', '11:30:00', '13:30:00', 1, '2020-08-27 12:49:27', '2020-08-27 12:49:27'),
(54, 1, 1, 'Saturday', NULL, NULL, 0, '2020-08-27 12:49:27', '2020-08-27 12:49:27'),
(55, 1, 1, 'Sunday', NULL, NULL, 0, '2020-08-27 12:49:27', '2020-08-27 12:49:27'),
(56, 2, 1, 'Monday', NULL, NULL, 0, '2020-08-27 21:06:48', '2020-08-27 21:06:48'),
(57, 2, 1, 'Tuesday', NULL, NULL, 0, '2020-08-27 21:06:48', '2020-08-27 21:06:48'),
(58, 2, 1, 'Wednesday', NULL, NULL, 0, '2020-08-27 21:06:48', '2020-08-27 21:06:48'),
(59, 2, 1, 'Thursday', NULL, NULL, 0, '2020-08-27 21:06:48', '2020-08-27 21:06:48'),
(60, 2, 1, 'Friday', NULL, NULL, 0, '2020-08-27 21:06:48', '2020-08-27 21:06:48'),
(61, 2, 1, 'Saturday', NULL, NULL, 0, '2020-08-27 21:06:48', '2020-08-27 21:06:48'),
(62, 2, 1, 'Sunday', NULL, NULL, 0, '2020-08-27 21:06:48', '2020-08-27 21:06:48');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `toppings`
--

CREATE TABLE `toppings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isAvailable` tinyint(4) NOT NULL DEFAULT 0,
  `base_id` bigint(20) UNSIGNED NOT NULL,
  `currency_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `toppings`
--

INSERT INTO `toppings` (`id`, `name`, `price`, `isAvailable`, `base_id`, `currency_id`, `created_at`, `updated_at`) VALUES
(1, 'Tomatoes', '0.6', 1, 1, 1, '2020-08-25 16:46:29', '2020-08-25 16:46:29'),
(2, 'Lettuce', '0.3', 0, 1, 1, '2020-08-25 16:46:29', '2020-08-25 16:46:29');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `firstname`, `lastname`, `remember_token`, `role_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'admin@foodapp.com', '$2y$10$2hc482ldwEjMpZhKqQj/POSdfuWdQWTWwu7tZrDz9mRRCYQPoc6Q6', 'Jhon', 'Doe', 'jmkGVMlDHdy4rDZLu3D1bEPhID9nxz1sdspDn59LVGsH7p9ZWIFFhoRaFvs9', 1, NULL, '2020-08-25 16:27:07', '2020-08-25 16:27:07'),
(2, 'company@foodapp.com', '$2y$10$2hc482ldwEjMpZhKqQj/POSdfuWdQWTWwu7tZrDz9mRRCYQPoc6Q6', NULL, NULL, 'tphr1XcCgr6tEZP4EP8FnKvq32unh1GpXn6LuJhCecVwhDgdZV8DH9j82TjD', 2, NULL, '2020-08-25 16:34:27', '2020-08-25 16:34:27'),
(3, 'company2@foodapp.com', '$2y$10$2hc482ldwEjMpZhKqQj/POSdfuWdQWTWwu7tZrDz9mRRCYQPoc6Q6', 'Lars', 'Pauwels', NULL, 2, NULL, '2020-08-25 16:34:27', '2020-08-25 16:34:27'),
(4, 'employee@foodapp.com', '$2y$10$ck873iGt09kcE4QqGNhYFu/dmqcMulDSisAoVIklNTHSy2ZT.PGSq', 'Lynda', 'Green', 'uCZkSjwsOwF7vPErknkdcYGFNbjLGPcozkz4fhzfyU0AbcIfpJzURWDFQ4ZD', 3, NULL, '2020-08-25 16:36:50', '2020-08-28 21:03:31'),
(5, 'supplier@foodapp.com', '$2y$10$2hc482ldwEjMpZhKqQj/POSdfuWdQWTWwu7tZrDz9mRRCYQPoc6Q6', NULL, NULL, 'ZED82hzR0Nt48xfizmbbACEZIgV1KXyhb0DQhWN4uTb3VuK0cOE4CmawNAJ7', 4, NULL, '2020-08-25 16:36:50', '2020-08-25 16:36:50'),
(6, 'supplier2@foodapp.com', '$2y$10$2hc482ldwEjMpZhKqQj/POSdfuWdQWTWwu7tZrDz9mRRCYQPoc6Q6', 'Ivan', 'Barr', 'FPTl4WayVUj9KM0REUeyC6k5ROtDAoc7ZVqdJFiBGSK5DENDoerHDsuwi3V6', 4, NULL, '2020-08-25 16:38:25', '2020-08-25 16:38:25'),
(7, 'company3@foodapp.com', '$2y$10$2hc482ldwEjMpZhKqQj/POSdfuWdQWTWwu7tZrDz9mRRCYQPoc6Q6', 'Reiss', 'Kearney', '7iPPEENmzLZ3xf5A42Vcp8FNaeKTCrNxOsUXmRIoHeBowrEbtyDVjwdquLZw', 2, NULL, '2020-08-25 18:55:05', '2020-08-25 18:55:05'),
(8, 'supplier3@foodapp.com', '$2y$10$2hc482ldwEjMpZhKqQj/POSdfuWdQWTWwu7tZrDz9mR...', 'Esa', 'Macleod', NULL, 4, NULL, '2020-08-25 18:55:05', '2020-08-25 18:55:05');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_company`
--

CREATE TABLE `user_company` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user_company`
--

INSERT INTO `user_company` (`id`, `user_id`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2020-08-25 16:39:25', '2020-08-25 16:39:25'),
(2, 3, 1, '2020-08-25 16:39:25', '2020-08-25 16:39:25'),
(3, 7, 2, '2020-08-25 19:00:32', '2020-08-25 19:00:32');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_supplier`
--

CREATE TABLE `user_supplier` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Gegevens worden geëxporteerd voor tabel `user_supplier`
--

INSERT INTO `user_supplier` (`id`, `user_id`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2020-08-25 16:42:29', '2020-08-25 16:42:29'),
(2, 6, 1, '2020-08-25 16:42:29', '2020-08-25 16:42:29'),
(3, 8, 2, '2020-08-25 19:00:12', '2020-08-25 19:00:12');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `bases`
--
ALTER TABLE `bases`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `base__orders`
--
ALTER TABLE `base__orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `base__order__toppings`
--
ALTER TABLE `base__order__toppings`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `company_supplier`
--
ALTER TABLE `company_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexen voor tabel `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexen voor tabel `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexen voor tabel `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexen voor tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `toppings`
--
ALTER TABLE `toppings`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexen voor tabel `user_company`
--
ALTER TABLE `user_company`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `user_supplier`
--
ALTER TABLE `user_supplier`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `bases`
--
ALTER TABLE `bases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `base__orders`
--
ALTER TABLE `base__orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT voor een tabel `base__order__toppings`
--
ALTER TABLE `base__order__toppings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT voor een tabel `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `company_supplier`
--
ALTER TABLE `company_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT voor een tabel `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `details`
--
ALTER TABLE `details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT voor een tabel `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT voor een tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT voor een tabel `toppings`
--
ALTER TABLE `toppings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `user_company`
--
ALTER TABLE `user_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `user_supplier`
--
ALTER TABLE `user_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
