-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 17, 2026 at 01:14 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.36

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `huit_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint UNSIGNED NOT NULL,
  `branch_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Cơ sở chính Tân Phú', '140 Lê Trọng Tấn, Tân Phú, TP.HCM', '2026-11-16 17:47:30', '2026-11-16 17:47:30'),
(2, 'Trung tâm Thí nghiệm Thực hành', '93 Tân Kỳ Tân Quý, Tân Phú, TP.HCM', '2026-11-16 17:47:30', '2026-11-16 17:47:30'),
(3, 'Cơ sở Chế Lan Viên', '70 Chế Lan Viên, Tân Phú, TP.HCM', '2026-11-16 17:47:30', '2026-11-16 17:47:30');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_11_17_004048_create_branches_table', 1),
(5, '2026_11_17_004055_create_teachers_table', 1),
(6, '2026_11_17_004101_create_schedules_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `teacher_id` bigint UNSIGNED NOT NULL,
  `branch_id` bigint UNSIGNED NOT NULL,
  `subject_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day_of_week` tinyint NOT NULL,
  `shift_or_periods` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `teacher_id`, `branch_id`, `subject_name`, `room`, `day_of_week`, `shift_or_periods`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 'Học phần ut nesciunt', 'P.201', 3, 'Chiều (Tiết 7-9)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(2, 5, 2, 'Học phần aut voluptatum', 'P.326', 7, 'Chiều (Tiết 10-12)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(3, 7, 2, 'Học phần maxime accusantium', 'P.158', 3, 'Sáng (Tiết 4-6)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(4, 7, 3, 'Học phần vel sint', 'P.443', 7, 'Chiều (Tiết 7-9)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(5, 2, 3, 'Học phần quasi officiis', 'P.238', 4, 'Chiều (Tiết 10-12)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(6, 6, 2, 'Học phần in architecto', 'P.387', 3, 'Sáng (Tiết 1-3)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(7, 5, 2, 'Học phần mollitia voluptas', 'P.166', 3, 'Chiều (Tiết 7-9)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(8, 4, 2, 'Học phần nam nobis', 'P.348', 3, 'Chiều (Tiết 10-12)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(9, 6, 2, 'Học phần aut impedit', 'P.119', 6, 'Sáng (Tiết 4-6)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(10, 5, 3, 'Học phần eveniet omnis', 'P.322', 7, 'Sáng (Tiết 4-6)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(11, 5, 2, 'Học phần iusto earum', 'P.362', 5, 'Sáng (Tiết 1-3)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(12, 4, 1, 'Học phần qui enim', 'P.381', 7, 'Sáng (Tiết 1-3)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(13, 3, 1, 'Học phần voluptatem reprehenderit', 'P.282', 2, 'Chiều (Tiết 7-9)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(14, 8, 1, 'Học phần nihil deleniti', 'P.245', 2, 'Chiều (Tiết 7-9)', '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(15, 8, 3, 'Học phần eligendi alias', 'P.358', 7, 'Chiều (Tiết 7-9)', '2026-11-16 17:47:32', '2026-11-16 17:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('j1XM47Wj3KqPlnLK1YtI9Gx3sGpxsNpN1ln2g1Vl', 9, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/157.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ0cEdBeHNYWEhWM3BuQmxhUmt2cmlySjVCcGFEWGgyWTVQVW03eUJtIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDgwXC9MZVRoaVllbk5oaV8yMDAxMjMwNjE0X0NDXC9odWl0LXNjaGVkdWxlXC9wdWJsaWNcL2FwaVwvc3VnZ2VzdC10ZWFjaGVycz9icmFuY2hfaWQ9MSZkYXlfb2Zfd2Vlaz0yJmV4cGVydGlzZT0mc2hpZnRfb3JfcGVyaW9kcz1TJUMzJUExbmclMjAlMjhUaSVFMSVCQSVCRnQlMjAxLTMlMjkiLCJyb3V0ZSI6ImFwaS5zdWdnZXN0In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjksInBhc3N3b3JkX2hhc2hfd2ViIjoiYzdlMDI0NWYyZmQ2MjlkZmYzNWZiMzBkMjI0ZDM4OWEyMDM1YjMwZTk0MzE2MTAwNzY0MWNiY2MxYjIxYjk2NyJ9', 1794877775);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` bigint UNSIGNED NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expertise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `full_name`, `email`, `phone`, `expertise`, `created_at`, `updated_at`) VALUES
(1, 'Trác Đình Lân', 'gv1@huit.edu.vn', '020 254 7386', 'Trí tuệ nhân tạo', '2026-11-16 17:47:30', '2026-11-16 17:47:30'),
(2, 'Bác. Chương Giang', 'gv2@huit.edu.vn', '0123-724-8194', 'Mạng máy tính', '2026-11-16 17:47:30', '2026-11-16 17:47:30'),
(3, 'Danh Trung', 'gv3@huit.edu.vn', '(076) 149 4727', 'Lập trình Mã nguồn mở', '2026-11-16 17:47:30', '2026-11-16 17:47:30'),
(4, 'Cái Thảo', 'gv4@huit.edu.vn', '(84)(241)751-9104', 'Trí tuệ nhân tạo', '2026-11-16 17:47:31', '2026-11-16 17:47:31'),
(5, 'Đàm Hà Thi', 'gv5@huit.edu.vn', '057 628 2593', 'Lập trình Mã nguồn mở', '2026-11-16 17:47:31', '2026-11-16 17:47:31'),
(6, 'Bà. Châu Mộng Hải', 'gv6@huit.edu.vn', '84-230-770-7350', 'Cơ sở dữ liệu', '2026-11-16 17:47:31', '2026-11-16 17:47:31'),
(7, 'Bác. Huỳnh Lộc Mai', 'gv7@huit.edu.vn', '84-126-488-3332', 'Cơ sở dữ liệu', '2026-11-16 17:47:31', '2026-11-16 17:47:31'),
(8, 'Cụ. Bình An', 'gv8@huit.edu.vn', '(0124)729-6233', 'Cơ sở dữ liệu', '2026-11-16 17:47:32', '2026-11-16 17:47:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'teacher',
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `teacher_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Trác Đình Lân', 'gv1@huit.edu.vn', NULL, '$2y$12$w0JPrONbWw8Vrt.fzpADn.wwUkUEVg8G9/q1oCvxrmfPBiAuuzXw6', 'teacher', 1, NULL, '2026-11-16 17:47:30', '2026-11-16 17:47:30'),
(2, 'Bác. Chương Giang', 'gv2@huit.edu.vn', NULL, '$2y$12$cQySQ2.qQ4fABHRFJZZkwu/3FRU.uyP6QiOfj8x7DMtb44UgdPzeS', 'teacher', 2, NULL, '2026-11-16 17:47:30', '2026-11-16 17:47:30'),
(3, 'Danh Trung', 'gv3@huit.edu.vn', NULL, '$2y$12$01kLVUe20VqAkA/niTM1iuqord6pFXuCsY6oxxmNGliv7eyqsqI1C', 'teacher', 3, NULL, '2026-11-16 17:47:31', '2026-11-16 17:47:31'),
(4, 'Cái Thảo', 'gv4@huit.edu.vn', NULL, '$2y$12$w/YEq2Xv4Ec3dy3hZr.wKuq8kAKKP8wyZERZeYSNvDXq3IgFOTx0O', 'teacher', 4, NULL, '2026-11-16 17:47:31', '2026-11-16 17:47:31'),
(5, 'Đàm Hà Thi', 'gv5@huit.edu.vn', NULL, '$2y$12$vfQUSHKvFGuADL/Yx8KWHubdD/Nb9K1Xdr4cfTq89Sl8IlMW4zr9a', 'teacher', 5, NULL, '2026-11-16 17:47:31', '2026-11-16 17:47:31'),
(6, 'Bà. Châu Mộng Hải', 'gv6@huit.edu.vn', NULL, '$2y$12$pIsExnhvWC7Z47ueyxlAK.bYl6O/jKPpjZ.bGp/SVawJLZd7T4Auq', 'teacher', 6, NULL, '2026-11-16 17:47:31', '2026-11-16 17:47:31'),
(7, 'Bác. Huỳnh Lộc Mai', 'gv7@huit.edu.vn', NULL, '$2y$12$6mGwMYkdH3sdMhfCHcFrleptBD4PNvUWCwxX6hld/0HBhN.2QN8eC', 'teacher', 7, NULL, '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(8, 'Cụ. Bình An', 'gv8@huit.edu.vn', NULL, '$2y$12$nyQ26DHKaweyPrkNi7aaFeF80OUQEDdAn5n3PbDiwYQ7TpkYCIinm', 'teacher', 8, NULL, '2026-11-16 17:47:32', '2026-11-16 17:47:32'),
(9, 'Phòng Đào Tạo HUIT', 'admin@huit.edu.vn', NULL, '$2y$12$GQumEDsjqi69wfR50snODOiDhwuanssNsL0/1Sei6n/D13MmQmz5G', 'admin', NULL, 'SyvtKrLiqrWt4geA2iNC5maCpf82h4haVdbPBDgWbnFS3vHla3DLdG5gIw4E', '2026-11-16 17:47:32', '2026-11-16 17:47:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `schedules_teacher_id_foreign` (`teacher_id`),
  ADD KEY `schedules_branch_id_foreign` (`branch_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `teachers_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `schedules_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
