-- QuizVerse Database Dump for Hostinger (MySQL / MariaDB Compatible)
-- Generated on: 2026-10-22 09:11:20 UTC
-- Platform: Laravel 11 / QuizVerse Production
-- Ready for Hostinger phpMyAdmin or MySQL CLI import

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Table Structure Definitions
-- --------------------------------------------------------

DROP TABLE IF EXISTS `users`;
create table `users` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `email` varchar(255) not null, `email_verified_at` timestamp null, `password` varchar(255) not null, `role` varchar(255) not null default 'player', `xp` int not null default '0', `level` int not null default '1', `streak` int not null default '0', `coins` int not null default '100', `avatar` varchar(255) null, `bio` text null, `is_banned` tinyint(1) not null default '0', `last_active_at` timestamp null, `remember_token` varchar(100) null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `password_reset_tokens`;
create table `password_reset_tokens` (`email` varchar(255) not null, `token` varchar(255) not null, `created_at` timestamp null, primary key (`email`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `sessions`;
create table `sessions` (`id` varchar(255) not null, `user_id` bigint unsigned null, `ip_address` varchar(45) null, `user_agent` text null, `payload` longtext not null, `last_activity` int not null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `cache`;
create table `cache` (`key` varchar(255) not null, `value` mediumtext not null, `expiration` int not null, primary key (`key`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `cache_locks`;
create table `cache_locks` (`key` varchar(255) not null, `owner` varchar(255) not null, `expiration` int not null, primary key (`key`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `jobs`;
create table `jobs` (`id` bigint unsigned not null auto_increment primary key, `queue` varchar(255) not null, `payload` longtext not null, `attempts` tinyint unsigned not null, `reserved_at` int unsigned null, `available_at` int unsigned not null, `created_at` int unsigned not null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `job_batches`;
create table `job_batches` (`id` varchar(255) not null, `name` varchar(255) not null, `total_jobs` int not null, `pending_jobs` int not null, `failed_jobs` int not null, `failed_job_ids` longtext not null, `options` mediumtext null, `cancelled_at` int null, `created_at` int not null, `finished_at` int null, primary key (`id`)) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `failed_jobs`;
create table `failed_jobs` (`id` bigint unsigned not null auto_increment primary key, `uuid` varchar(255) not null, `connection` text not null, `queue` text not null, `payload` longtext not null, `exception` longtext not null, `failed_at` timestamp not null default CURRENT_TIMESTAMP) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `categories`;
create table `categories` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `slug` varchar(255) not null, `description` text null, `icon` varchar(255) not null, `color_theme` varchar(255) not null default 'violet', `bg_gradient` varchar(255) null, `is_active` tinyint(1) not null default '1', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `quizzes`;
create table `quizzes` (`id` bigint unsigned not null auto_increment primary key, `title` varchar(255) not null, `slug` varchar(255) not null, `description` text null, `category_id` bigint unsigned not null, `user_id` bigint unsigned not null, `difficulty` varchar(255) not null default 'medium', `time_limit_per_question` int not null default '20', `xp_reward` int not null default '150', `is_published` tinyint(1) not null default '1', `is_featured` tinyint(1) not null default '0', `plays_count` int not null default '0', `rating` decimal(3, 2) not null default '4.85', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `questions`;
create table `questions` (`id` bigint unsigned not null auto_increment primary key, `category_id` bigint unsigned not null, `user_id` bigint unsigned not null, `quiz_id` bigint unsigned null, `question_text` text not null, `question_type` varchar(255) not null default 'multiple_choice', `explanation` text null, `points` int not null default '20', `difficulty` varchar(255) not null default 'medium', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `question_options`;
create table `question_options` (`id` bigint unsigned not null auto_increment primary key, `question_id` bigint unsigned not null, `option_text` text not null, `is_correct` tinyint(1) not null default '0', `order` int not null default '0', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `quiz_attempts`;
create table `quiz_attempts` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned not null, `quiz_id` bigint unsigned null, `mode` varchar(255) not null default 'standard', `score` int not null default '0', `total_questions` int not null default '0', `correct_answers` int not null default '0', `xp_earned` int not null default '0', `accuracy_percentage` decimal(5, 2) not null default '0', `time_taken_seconds` int not null default '0', `streak_count` int not null default '0', `answers_summary` json null, `completed_at` timestamp null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `platform_settings`;
create table `platform_settings` (`id` bigint unsigned not null auto_increment primary key, `key` varchar(255) not null, `value` text null, `type` varchar(255) not null default 'string', `group` varchar(255) not null default 'general', `label` varchar(255) not null, `description` text null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `audit_logs`;
create table `audit_logs` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned null, `action` varchar(255) not null, `severity` varchar(255) not null default 'info', `entity_type` varchar(255) null, `entity_id` bigint unsigned null, `details` json null, `ip_address` varchar(255) null, `user_agent` text null, `created_at` timestamp not null default CURRENT_TIMESTAMP) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `campaigns`;
create table `campaigns` (`id` bigint unsigned not null auto_increment primary key, `title` varchar(255) not null, `type` varchar(255) not null default 'banner', `status` varchar(255) not null default 'active', `badge_text` varchar(255) null, `cta_text` varchar(255) not null default 'Learn More', `target_url` varchar(255) not null default '#', `content` text null, `impressions` int not null default '0', `clicks` int not null default '0', `start_date` date null, `end_date` date null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `roles`;
create table `roles` (`id` bigint unsigned not null auto_increment primary key, `name` varchar(255) not null, `slug` varchar(255) not null, `description` text null, `permissions` json null, `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

DROP TABLE IF EXISTS `staff_members`;
create table `staff_members` (`id` bigint unsigned not null auto_increment primary key, `user_id` bigint unsigned not null, `role_id` bigint unsigned not null, `department` varchar(255) not null default 'Operations', `is_active` tinyint(1) not null default '1', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';

-- --------------------------------------------------------
-- Column Modifications & Indexes
-- --------------------------------------------------------

alter table `users` add unique `users_email_unique`(`email`);
alter table `sessions` add index `sessions_user_id_index`(`user_id`);
alter table `sessions` add index `sessions_last_activity_index`(`last_activity`);
alter table `cache` add index `cache_expiration_index`(`expiration`);
alter table `cache_locks` add index `cache_locks_expiration_index`(`expiration`);
alter table `jobs` add index `jobs_queue_index`(`queue`);
alter table `failed_jobs` add unique `failed_jobs_uuid_unique`(`uuid`);
alter table `categories` add unique `categories_slug_unique`(`slug`);
alter table `quizzes` add unique `quizzes_slug_unique`(`slug`);
alter table `platform_settings` add unique `platform_settings_key_unique`(`key`);
alter table `roles` add unique `roles_slug_unique`(`slug`);
alter table `quizzes` add `question` text null;
alter table `quizzes` add `options` json null;
alter table `quizzes` add `correct_answer` varchar(255) null;
alter table `quizzes` add `image` varchar(255) null;
alter table `categories` add `image` varchar(255) null;

-- --------------------------------------------------------
-- Dumping Data for Tables
-- --------------------------------------------------------

-- Dumping data for table `users` (18 rows)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `xp`, `level`, `streak`, `coins`, `avatar`, `bio`, `is_banned`, `last_active_at`, `remember_token`, `created_at`, `updated_at`) VALUES
  (1, 'Alexandre Vance', 'admin@quizverse.com', NULL, '$2y$12$MDYFsynPcPg1L4g1BVp7/ucswA7YYvLZVqRoi4kGwiC6YY.G8IsFm', 'admin', 14850, 13, 14, 2800, 'uploads/w0LhcptdrPLTpXEGaVECtDeKxrrAs9khndLUNDKu.jpg', 'Lead Systems Architect & Founder at QuizVerse. Building next-gen competitive knowledge engines.', 0, '2026-10-22 04:55:50', NULL, '2026-10-22 04:21:31', '2026-10-22 06:47:45'),
  (2, 'Dr. Elena Rostova', 'creator@quizverse.com', NULL, '$2y$12$TbhspazOgody4xJMa.RdCOfQPoI9quejfob3qeg7AlL/RJWkiiFCO', 'creator', 9980, 10, 9, 1958, NULL, 'Astrophysicist & educator. Author of Science & Cosmos deep-dive challenges.', 0, '2026-10-22 09:07:55', NULL, '2026-10-22 04:21:32', '2026-10-22 09:07:55'),
  (3, 'Marcus Chen', 'player@quizverse.com', NULL, '$2y$12$msL7ZN2D2QeVT5fP5dI4/.K4OsjnUwNW78VjOwyZbQnzhPHDFtAG2', 'player', 5050, 8, 6, 860, 'uploads/dx8bQP0y7kveADtjVC90quNa9cXLUHXUQVnoXrYS.jpg', 'Full-stack explorer and daily challenge competitor. Aiming for Top 10 Global Leaderboard.', 0, '2026-10-22 08:20:09', 'XbJucfd8HaLJKU7Vyu6eLv3jbRUWcgQadwk2K7dLSLWO9RWkrbX3r0B4yia1', '2026-10-22 04:21:32', '2026-10-22 08:20:09'),
  (4, 'Sophia Lin', 'sophia.lin@dev.net', NULL, '$2y$12$DQjeDDqysok48lZjopcUneTEmFmXZ8ZhRNjXTdcbp82EWzwRspBRi', 'player', 23400, 16, 28, 5400, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 18:21:33', NULL, '2026-10-22 04:21:33', '2026-10-22 04:21:33'),
  (5, 'David Kim', 'david.kim@quantum.org', NULL, '$2y$12$0LkhWj9M6/NBjdcpqf6HcuF97X.TFJXIPgm3EvmwNRKmt6ZcYvOZ2', 'player', 21850, 15, 21, 4950, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 09:21:33', NULL, '2026-10-22 04:21:33', '2026-10-22 04:21:33'),
  (6, 'Aria Thorne', 'aria.t@cyber.io', NULL, '$2y$12$IJ8InR2Ra0HjfPhA1nHadeuJJV8l3daGUC/kjBdAg565LvolLGKh6', 'player', 19200, 14, 18, 4100, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-20 17:21:34', NULL, '2026-10-22 04:21:34', '2026-10-22 04:21:34'),
  (7, 'Kaelen Voss', 'voss@neural.net', NULL, '$2y$12$xTDKQ8r6msl7pD0W1GzzzeD44wcMCH0CzJsQJ7UbQxwL7wwvEdfPO', 'player', 17650, 13, 15, 3800, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 15:21:35', NULL, '2026-10-22 04:21:35', '2026-10-22 04:21:35'),
  (8, 'Zoe Gallagher', 'zoe.g@vector.dev', NULL, '$2y$12$S4DkVCaLx35AeaIBF7wLGOuDA4uyw.dpLs.CM.b8Ea4yix.2opzOu', 'player', 15400, 12, 11, 3200, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-20 13:21:35', NULL, '2026-10-22 04:21:35', '2026-10-22 04:21:35'),
  (9, 'Liam O''Connor', 'liam.oc@matrix.io', NULL, '$2y$12$F/lb5Udd5oL5sLmsmMFsweqKFtPXiWryPE3fv6JUKJVhIOCOSMnKO', 'player', 13900, 11, 14, 2900, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 22:21:36', NULL, '2026-10-22 04:21:36', '2026-10-22 04:21:36'),
  (10, 'Maya Patel', 'maya.patel@horizon.edu', NULL, '$2y$12$3/s/9y1T6QSvVzibyHmb9.QI4.jNSrqxMmpyBVvDxtf8Z661x4Fke', 'player', 12100, 11, 8, 2600, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 23:21:36', NULL, '2026-10-22 04:21:36', '2026-10-22 04:21:36'),
  (11, 'Nikolai Volkov', 'n.volkov@kernel.org', NULL, '$2y$12$cKskTCisZyiNG9fr7pSGU.BiBNMFVNIX8irhOcQsImpGBPx0xaEuW', 'player', 10800, 10, 12, 2300, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 08:21:37', NULL, '2026-10-22 04:21:37', '2026-10-22 04:21:37'),
  (12, 'Chloe Bennett', 'chloe.b@frontend.co', NULL, '$2y$12$Sf1dAxnb3VxJGcoLaxjVJenxPYEvzrwlwqoHnpp.0f.vWIKIHeT/2', 'player', 8950, 9, 5, 1800, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 06:21:37', NULL, '2026-10-22 04:21:37', '2026-10-22 04:21:37'),
  (13, 'Tariq Al-Mansoor', 'tariq@cloudpulse.io', NULL, '$2y$12$xEsoF0Bol0iecjt2jO8pCOQADALpNzeWu/uGebaPPiHemR33NS7E.', 'player', 7800, 8, 7, 1600, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 06:21:38', NULL, '2026-10-22 04:21:38', '2026-10-22 04:21:38'),
  (14, 'Isabella Santos', 'isa.santos@syntax.br', NULL, '$2y$12$0jpRa/SUsnAMVkRysmyTC.kVSld6J.hXBnib8kSn4TMi2xzpAGA/a', 'player', 6400, 8, 4, 1300, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 05:21:38', NULL, '2026-10-22 04:21:38', '2026-10-22 04:21:38'),
  (15, 'Felix Becker', 'felix@berlin-tech.de', NULL, '$2y$12$/2Gd.S4I3p8CE.rCMbx1puvyN1LKwVyleYI/IT7tKUE20tc38QiCq', 'player', 5200, 7, 3, 1100, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 04:21:39', NULL, '2026-10-22 04:21:39', '2026-10-22 04:21:39'),
  (16, 'Nia Adebayo', 'nia.a@lagos-dev.ng', NULL, '$2y$12$Zz2MimF8yo0Du/rSnF9UR.RC1BGJkXKfEEiTIJzQ0FMt7hG4n4aji', 'player', 3900, 6, 5, 850, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-20 04:21:39', NULL, '2026-10-22 04:21:39', '2026-10-22 04:21:39'),
  (17, 'Vikram Seth', 'vikram@algo-nexus.in', NULL, '$2y$12$XBBegFT22j0Mq3kH5Ih7C.4mANDY6d9pucYnAHtKPLPtQ1qU6qtbO', 'player', 2600, 5, 2, 600, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 07:21:40', NULL, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (18, 'Emma Watson-Lee', 'emma.wl@oxford-ai.uk', NULL, '$2y$12$JwblEZervj8EUIxSjTjPpOOKPmV1Mk8RwBEaVTVdpuiviD9Mh/aJe', 'player', 1400, 3, 1, 350, NULL, 'Competitive QuizVerse challenger.', 0, '2026-10-21 09:21:40', NULL, '2026-10-22 04:21:40', '2026-10-22 04:21:40');

-- Dumping data for table `categories` (8 rows)
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `color_theme`, `bg_gradient`, `is_active`, `created_at`, `updated_at`, `image`) VALUES
  (1, 'Science & Cosmos', 'science-cosmos', 'Astrophysics, orbital mechanics, quantum phenomena, and cosmic evolution.', 'fa-solid fa-flask', 'violet', 'from-violet-600/20 via-purple-600/10 to-indigo-600/20', 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40', NULL),
  (2, 'Modern Web & React', 'modern-web-react', 'React 19, Next.js architecture, state topologies, and browser rendering engines.', 'devicon-react-original colored', 'cyan', 'from-cyan-600/20 via-sky-600/10 to-blue-600/20', 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40', NULL),
  (3, 'Python & Machine Learning', 'python-ai-ml', 'PyTorch primitives, transformers, neural optimizations, and data paradigms.', 'devicon-python-plain colored', 'emerald', 'from-emerald-600/20 via-teal-600/10 to-green-600/20', 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40', NULL),
  (4, 'Cloud & Distributed Systems', 'cloud-distributed-systems', 'Kubernetes, consensus protocols, Kafka event pipelines, and edge compute.', 'devicon-docker-plain colored', 'blue', 'from-blue-600/20 via-indigo-600/10 to-violet-600/20', 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40', NULL),
  (5, 'Cybersecurity & Cryptography', 'cybersecurity-cryptography', 'Zero-trust architecture, TLS 1.3, buffer mitigations, and post-quantum keys.', 'fa-solid fa-shield-halved', 'rose', 'from-rose-600/20 via-pink-600/10 to-red-600/20', 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40', NULL),
  (6, 'Backend Architecture & Node', 'backend-architecture-node', 'Node event loops, ACID guarantees, Redis cache layers, and DB indexing.', 'devicon-nodejs-plain colored', 'amber', 'from-amber-600/20 via-yellow-600/10 to-orange-600/20', 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40', NULL),
  (7, 'Civilizations & Ancient History', 'civilizations-history', 'Mesopotamia, Bronze Age collapses, Hellenistic strategy, and Silk Road trade.', 'fa-solid fa-landmark', 'amber', 'from-amber-700/20 via-yellow-700/10 to-stone-600/20', 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40', NULL),
  (8, 'Cyberculture & Video Games', 'cyberculture-gaming', 'Game mechanics, engine pipelines, demo-scene lore, and competitive esports history.', 'fa-solid fa-gamepad', 'violet', 'from-purple-600/20 via-fuchsia-600/10 to-pink-600/20', 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40', NULL);

-- Dumping data for table `quizzes` (6 rows)
INSERT INTO `quizzes` (`id`, `title`, `slug`, `description`, `category_id`, `user_id`, `difficulty`, `time_limit_per_question`, `xp_reward`, `is_published`, `is_featured`, `plays_count`, `rating`, `created_at`, `updated_at`, `question`, `options`, `correct_answer`, `image`) VALUES
  (1, 'Quantum Frontiers & Cosmic Horizons', 'quantum-frontiers-cosmic-horizons', 'Test your grasp on black hole event horizons, quantum entanglement, and cosmological expansion.', 1, 2, 'hard', 25, 280, 1, 1, 313, 4.8, '2026-10-22 04:21:40', '2026-10-22 09:07:55', NULL, NULL, NULL, NULL),
  (2, 'React 19 & Next.js Architecture Deep Dive', 'react-19-nextjs-architecture', 'Master React Server Components, Actions, useActionState, Suspense boundaries, and selective hydration.', 2, 2, 'hard', 20, 240, 1, 1, 230, 4.87, '2026-10-22 04:21:40', '2026-10-22 04:21:40', NULL, NULL, NULL, NULL),
  (3, 'Python Neural Systems & PyTorch Fundamentals', 'python-neural-systems-pytorch', 'Autograd mechanics, tensor memory layouts, gradient accumulation, and transformer attention heads.', 3, 2, 'medium', 20, 200, 1, 1, 52, 4.83, '2026-10-22 04:21:41', '2026-10-22 04:21:41', NULL, NULL, NULL, NULL),
  (4, 'Kubernetes & Distributed Consensus Protocols', 'kubernetes-distributed-consensus', 'Raft elections, etcd leases, ingress controllers, CNI network topologies, and split-brain resolution.', 4, 2, 'hard', 25, 250, 1, 0, 41, 4.95, '2026-10-22 04:21:41', '2026-10-22 04:21:41', NULL, NULL, NULL, NULL),
  (5, 'Post-Quantum Cryptography & Zero-Trust Defense', 'post-quantum-zero-trust', 'NIST post-quantum standards (ML-KEM/Kyber), mTLS authorization, memory safety, and side-channel defenses.', 5, 2, 'hard', 25, 275, 1, 1, 237, 4.89, '2026-10-22 04:21:41', '2026-10-22 08:20:09', NULL, NULL, NULL, NULL),
  (6, 'High-Performance Node.js & Distributed Caches', 'high-performance-nodejs-caches', 'Libuv thread pools, microtask queues, Redis cluster replication, and database connection pooling.', 6, 2, 'medium', 20, 210, 1, 0, 91, 4.97, '2026-10-22 04:21:41', '2026-10-22 08:51:06', NULL, NULL, NULL, NULL);

-- Dumping data for table `questions` (17 rows)
INSERT INTO `questions` (`id`, `category_id`, `user_id`, `quiz_id`, `question_text`, `question_type`, `explanation`, `points`, `difficulty`, `created_at`, `updated_at`) VALUES
  (1, 1, 2, 1, 'What physical phenomenon occurs at the Schwarzschild radius of a non-rotating black hole?', 'multiple_choice', 'The Schwarzschild radius defines the spherical event horizon where the escape velocity equals the speed of light in vacuum (c).', 30, 'medium', '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (2, 1, 2, 1, 'Which particle is postulated to mediate the gravitational interaction in quantum field theory?', 'multiple_choice', 'The graviton is the hypothetical massless spin-2 boson mediating gravitation.', 30, 'medium', '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (3, 1, 2, 1, 'Cosmic microwave background (CMB) radiation possesses a black-body temperature of approximately:', 'multiple_choice', 'The CMB has a thermal black body spectrum at 2.72548 ± 0.00057 Kelvin.', 40, 'hard', '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (4, 1, 2, 1, 'Quantum entanglement allows information to travel faster than the speed of light (superluminal signaling).', 'true_false', 'The No-Communication Theorem states that entanglement cannot be used to transmit classical information faster than light.', 20, 'medium', '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (5, 2, 2, 2, 'In React 19, what hook replaces the conventional manual status handling pattern with form transitions?', 'multiple_choice', 'useActionState allows updating state based on the result of a form action, managing pending states automatically.', 30, 'medium', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (6, 2, 2, 2, 'Which of the following is true regarding React Server Components (RSC)?', 'multiple_choice', 'RSCs execute strictly on the server and their code dependencies are never shipped to the client JavaScript bundle.', 35, 'hard', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (7, 2, 2, 2, 'React 19 eliminates the need for manual memoization with useMemo and useCallback via the React Compiler.', 'true_false', 'The React Compiler automatically memoizes component outputs and values at build time.', 20, 'easy', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (8, 2, 2, 2, 'What is the primary function of the directive \"use client\" in Next.js App Router?', 'multiple_choice', '\"use client\" marks the boundary between server components and client-side interactive subtrees.', 25, 'medium', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (9, 3, 2, 3, 'In PyTorch, what operation must be invoked before backward() in a training loop to avoid accumulating stale gradients?', 'multiple_choice', 'optimizer.zero_grad() flushes the gradients of all optimized torch.Tensors before the next backward pass.', 25, 'easy', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (10, 3, 2, 3, 'What is the computational complexity of standard Scaled Dot-Product Attention with respect to sequence length N?', 'multiple_choice', 'Full pairwise attention between all tokens in a sequence of length N results in quadratic O(N^2) complexity.', 35, 'hard', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (11, 3, 2, 3, 'In Python 3.12+, the Global Interpreter Lock (GIL) can be optionally disabled in experimental free-threaded builds.', 'true_false', 'PEP 703 introduced the free-threaded build option in Python 3.13 (experimental preview in 3.12).', 20, 'medium', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (12, 4, 2, 4, 'What consensus algorithm is leveraged by etcd in Kubernetes to maintain distributed cluster state?', 'multiple_choice', 'etcd uses the Raft consensus algorithm for distributed leader election and replicated log consistency.', 30, 'medium', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (13, 4, 2, 4, 'Which Kubernetes resource guarantees that exactly one Pod replica runs on every matching node in a cluster?', 'multiple_choice', 'DaemonSets ensure that all (or some) Nodes run a copy of a Pod, ideal for logging or monitoring agents.', 25, 'easy', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (14, 5, 2, 5, 'Which lattice-based key encapsulation mechanism was standardized by NIST as FIPS 203 for general encryption?', 'multiple_choice', 'ML-KEM (originally CRYSTALS-Kyber) was selected and standardized as FIPS 203.', 35, 'hard', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (15, 5, 2, 5, 'Zero-Trust Architecture principles assume the internal perimeter network is inherently secure once authenticated.', 'true_false', 'Zero-Trust operates under \"Never Trust, Always Verify\", assuming hostile breach inside the network.', 20, 'easy', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (16, 6, 2, 6, 'In the Node.js event loop, which queue has highest execution priority immediately following the current operation?', 'multiple_choice', 'process.nextTick() queue executes immediately after the current operation finishes, before any other event loop phase.', 30, 'medium', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (17, 6, 2, 6, 'What caching anomaly occurs when multiple concurrent requests simultaneously calculate an expired key?', 'multiple_choice', 'Cache stampede (thundering herd) occurs when key expiration causes a massive spike of concurrent database recalculations.', 25, 'medium', '2026-10-22 04:21:41', '2026-10-22 04:21:41');

-- Dumping data for table `question_options` (60 rows)
INSERT INTO `question_options` (`id`, `question_id`, `option_text`, `is_correct`, `order`, `created_at`, `updated_at`) VALUES
  (1, 1, 'The escape velocity equals the speed of light in vacuum', 1, 0, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (2, 1, 'Hawking radiation completely ceases emitted particles', 0, 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (3, 1, 'Matter immediately converts into high-energy dark photons', 0, 2, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (4, 1, 'Time accelerates towards positive infinity for outside observers', 0, 3, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (5, 2, 'Graviton (spin-2 massless boson)', 1, 0, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (6, 2, 'Higgs Boson (spin-0 scalar boson)', 0, 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (7, 2, 'Gluon (spin-1 color charge carrier)', 0, 2, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (8, 2, 'Axion (spin-0 pseudo-Nambu-Goldstone boson)', 0, 3, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (9, 3, '2.73 Kelvin', 1, 0, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (10, 3, '0.55 Kelvin', 0, 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (11, 3, '4.20 Kelvin', 0, 2, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (12, 3, '7.85 Kelvin', 0, 3, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (13, 4, 'False - The No-Communication Theorem forbids superluminal signaling', 1, 0, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (14, 4, 'True - Entangled states enable immediate information broadcast', 0, 1, '2026-10-22 04:21:40', '2026-10-22 04:21:40'),
  (15, 5, 'useActionState', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (16, 5, 'useFormTransition', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (17, 5, 'useServerCallback', 0, 2, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (18, 5, 'useMutationSync', 0, 3, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (19, 6, 'Zero impact on client bundle size as their dependencies remain on server', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (20, 6, 'They require useState and useEffect for lifecycle management', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (21, 6, 'They re-render on the browser whenever client state changes', 0, 2, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (22, 6, 'They cannot fetch data directly from databases via async/await', 0, 3, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (23, 7, 'True - React Compiler automatically handles fine-grained memoization', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (24, 7, 'False - Manual useMemo hooks remain strictly mandatory', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (25, 8, 'Declares a boundary where the module and its child imports run in browser runtime', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (26, 8, 'Instructs Vite to build a Web Worker instance', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (27, 8, 'Disables server-side prerendering completely for that route', 0, 2, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (28, 8, 'Enables Electron desktop compatibility mode', 0, 3, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (29, 9, 'optimizer.zero_grad()', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (30, 9, 'model.reset_weights()', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (31, 9, 'torch.cuda.empty_cache()', 0, 2, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (32, 9, 'loss.detach()', 0, 3, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (33, 10, 'O(N^2)', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (34, 10, 'O(N log N)', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (35, 10, 'O(N)', 0, 2, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (36, 10, 'O(1)', 0, 3, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (37, 11, 'True - Free-threaded Python allows true multi-core thread concurrency', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (38, 11, 'False - The GIL cannot be disabled under any configuration', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (39, 12, 'Raft', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (40, 12, 'Multi-Paxos', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (41, 12, 'Zab (ZooKeeper Atomic Broadcast)', 0, 2, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (42, 12, 'Proof of Authority', 0, 3, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (43, 13, 'DaemonSet', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (44, 13, 'StatefulSet', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (45, 13, 'ReplicaSet', 0, 2, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (46, 13, 'CronJob', 0, 3, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (47, 14, 'ML-KEM (CRYSTALS-Kyber)', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (48, 14, 'RSA-4096 OAEP', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (49, 14, 'ECDH Curve25519', 0, 2, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (50, 14, 'Classic McEliece', 0, 3, '2026-10-22 04:21:41', '2026-10-22 04:21:41');
INSERT INTO `question_options` (`id`, `question_id`, `option_text`, `is_correct`, `order`, `created_at`, `updated_at`) VALUES
  (51, 15, 'False - Zero-Trust assumes breach and verifies every request continuously', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (52, 15, 'True - Internal networks are considered trusted zones', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (53, 16, 'process.nextTick queue (microtask)', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (54, 16, 'setImmediate callback queue (check phase)', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (55, 16, 'setTimeout timers queue (timers phase)', 0, 2, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (56, 16, 'I/O poll events queue', 0, 3, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (57, 17, 'Cache Stampede / Thundering Herd', 1, 0, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (58, 17, 'Dirty Read Anomaly', 0, 1, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (59, 17, 'Phantom Read Spike', 0, 2, '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (60, 17, 'Write-Through Staleness', 0, 3, '2026-10-22 04:21:41', '2026-10-22 04:21:41');

-- Dumping data for table `quiz_attempts` (26 rows)
INSERT INTO `quiz_attempts` (`id`, `user_id`, `quiz_id`, `mode`, `score`, `total_questions`, `correct_answers`, `xp_earned`, `accuracy_percentage`, `time_taken_seconds`, `streak_count`, `answers_summary`, `completed_at`, `created_at`, `updated_at`) VALUES
  (1, 3, 1, 'standard', 211, 4, 3, 213, 75, 78, 3, '[]', '2026-10-16 03:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (2, 4, 1, 'standard', 339, 4, 3, 226, 75, 47, 3, '[]', '2026-10-18 03:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (3, 5, 1, 'standard', 167, 4, 3, 173, 75, 68, 5, '[]', '2026-10-19 16:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (4, 6, 1, 'standard', 231, 4, 4, 251, 100, 60, 2, '[]', '2026-10-17 11:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (5, 7, 1, 'standard', 318, 4, 3, 195, 75, 80, 2, '[]', '2026-10-20 10:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (6, 8, 1, 'standard', 342, 4, 4, 156, 100, 62, 4, '[]', '2026-10-21 15:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (7, 9, 1, 'standard', 356, 4, 4, 234, 100, 51, 4, '[]', '2026-10-18 06:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (8, 10, 1, 'standard', 245, 4, 4, 272, 100, 66, 2, '[]', '2026-10-19 12:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (9, 11, 1, 'standard', 238, 4, 3, 280, 75, 46, 6, '[]', '2026-10-17 11:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (10, 12, 1, 'standard', 253, 4, 4, 209, 100, 69, 3, '[]', '2026-10-20 10:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (11, 13, 1, 'standard', 262, 4, 4, 311, 100, 57, 5, '[]', '2026-10-20 03:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (12, 14, 1, 'standard', 148, 4, 4, 173, 100, 60, 3, '[]', '2026-10-21 09:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (13, 15, 1, 'standard', 220, 4, 4, 281, 100, 76, 6, '[]', '2026-10-16 06:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (14, 16, 1, 'standard', 255, 4, 3, 285, 75, 40, 2, '[]', '2026-10-18 22:21:41', '2026-10-22 04:21:41', '2026-10-22 04:21:41'),
  (15, 17, 1, 'standard', 166, 4, 3, 205, 75, 50, 6, '[]', '2026-10-19 02:21:42', '2026-10-22 04:21:42', '2026-10-22 04:21:42'),
  (16, 18, 1, 'standard', 281, 4, 4, 311, 100, 52, 2, '[]', '2026-10-18 18:21:42', '2026-10-22 04:21:42', '2026-10-22 04:21:42'),
  (17, 1, 1, 'standard', 0, 4, 0, 0, 0, 19, 0, '[{\"question_id\":1,\"question_text\":\"What physical phenomenon occurs at the Schwarzschild radius of a non-rotating black hole?\",\"selected_option_id\":\"2\",\"correct_option_id\":1,\"is_correct\":false,\"points_earned\":0,\"time_taken\":8,\"explanation\":\"The Schwarzschild radius defines the spherical event horizon where the escape velocity equals the speed of light in vacuum (c).\"},{\"question_id\":2,\"question_text\":\"Which particle is postulated to mediate the gravitational interaction in quantum field theory?\",\"selected_option_id\":\"6\",\"correct_option_id\":5,\"is_correct\":false,\"points_earned\":0,\"time_taken\":2,\"explanation\":\"The graviton is the hypothetical massless spin-2 boson mediating gravitation.\"},{\"question_id\":3,\"question_text\":\"Cosmic microwave background (CMB) radiation possesses a black-body temperature of approximately:\",\"selected_option_id\":\"12\",\"correct_option_id\":9,\"is_correct\":false,\"points_earned\":0,\"time_taken\":4,\"explanation\":\"The CMB has a thermal black body spectrum at 2.72548 \\u00b1 0.00057 Kelvin.\"},{\"question_id\":4,\"question_text\":\"Quantum entanglement allows information to travel faster than the speed of light (superluminal signaling).\",\"selected_option_id\":null,\"correct_option_id\":13,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The No-Communication Theorem states that entanglement cannot be used to transmit classical information faster than light.\"}]', '2026-10-22 04:39:31', '2026-10-22 04:39:31', '2026-10-22 04:39:31'),
  (18, 1, 1, 'daily', 0, 4, 0, 0, 0, 20, 0, '[{\"question_id\":1,\"question_text\":\"What physical phenomenon occurs at the Schwarzschild radius of a non-rotating black hole?\",\"selected_option_id\":null,\"correct_option_id\":1,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The Schwarzschild radius defines the spherical event horizon where the escape velocity equals the speed of light in vacuum (c).\"},{\"question_id\":2,\"question_text\":\"Which particle is postulated to mediate the gravitational interaction in quantum field theory?\",\"selected_option_id\":null,\"correct_option_id\":5,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The graviton is the hypothetical massless spin-2 boson mediating gravitation.\"},{\"question_id\":3,\"question_text\":\"Cosmic microwave background (CMB) radiation possesses a black-body temperature of approximately:\",\"selected_option_id\":null,\"correct_option_id\":9,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The CMB has a thermal black body spectrum at 2.72548 \\u00b1 0.00057 Kelvin.\"},{\"question_id\":4,\"question_text\":\"Quantum entanglement allows information to travel faster than the speed of light (superluminal signaling).\",\"selected_option_id\":null,\"correct_option_id\":13,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The No-Communication Theorem states that entanglement cannot be used to transmit classical information faster than light.\"}]', '2026-10-22 04:55:50', '2026-10-22 04:55:50', '2026-10-22 04:55:50'),
  (19, 3, 1, 'daily', 97, 4, 2, 150, 50, 17, 1, '[{\"question_id\":1,\"question_text\":\"What physical phenomenon occurs at the Schwarzschild radius of a non-rotating black hole?\",\"selected_option_id\":\"1\",\"correct_option_id\":1,\"is_correct\":true,\"points_earned\":38,\"time_taken\":11,\"explanation\":\"The Schwarzschild radius defines the spherical event horizon where the escape velocity equals the speed of light in vacuum (c).\"},{\"question_id\":2,\"question_text\":\"Which particle is postulated to mediate the gravitational interaction in quantum field theory?\",\"selected_option_id\":\"8\",\"correct_option_id\":5,\"is_correct\":false,\"points_earned\":0,\"time_taken\":2,\"explanation\":\"The graviton is the hypothetical massless spin-2 boson mediating gravitation.\"},{\"question_id\":3,\"question_text\":\"Cosmic microwave background (CMB) radiation possesses a black-body temperature of approximately:\",\"selected_option_id\":\"9\",\"correct_option_id\":9,\"is_correct\":true,\"points_earned\":59,\"time_taken\":1,\"explanation\":\"The CMB has a thermal black body spectrum at 2.72548 \\u00b1 0.00057 Kelvin.\"},{\"question_id\":4,\"question_text\":\"Quantum entanglement allows information to travel faster than the speed of light (superluminal signaling).\",\"selected_option_id\":\"14\",\"correct_option_id\":13,\"is_correct\":false,\"points_earned\":0,\"time_taken\":3,\"explanation\":\"The No-Communication Theorem states that entanglement cannot be used to transmit classical information faster than light.\"}]', '2026-10-22 07:04:22', '2026-10-22 07:04:22', '2026-10-22 07:04:22'),
  (20, 3, 1, 'daily', 97, 4, 2, 150, 50, 33, 1, '[{\"question_id\":1,\"question_text\":\"What physical phenomenon occurs at the Schwarzschild radius of a non-rotating black hole?\",\"selected_option_id\":\"1\",\"correct_option_id\":1,\"is_correct\":true,\"points_earned\":38,\"time_taken\":11,\"explanation\":\"The Schwarzschild radius defines the spherical event horizon where the escape velocity equals the speed of light in vacuum (c).\"},{\"question_id\":2,\"question_text\":\"Which particle is postulated to mediate the gravitational interaction in quantum field theory?\",\"selected_option_id\":\"8\",\"correct_option_id\":5,\"is_correct\":false,\"points_earned\":0,\"time_taken\":2,\"explanation\":\"The graviton is the hypothetical massless spin-2 boson mediating gravitation.\"},{\"question_id\":3,\"question_text\":\"Cosmic microwave background (CMB) radiation possesses a black-body temperature of approximately:\",\"selected_option_id\":\"9\",\"correct_option_id\":9,\"is_correct\":true,\"points_earned\":59,\"time_taken\":1,\"explanation\":\"The CMB has a thermal black body spectrum at 2.72548 \\u00b1 0.00057 Kelvin.\"},{\"question_id\":4,\"question_text\":\"Quantum entanglement allows information to travel faster than the speed of light (superluminal signaling).\",\"selected_option_id\":\"14\",\"correct_option_id\":13,\"is_correct\":false,\"points_earned\":0,\"time_taken\":19,\"explanation\":\"The No-Communication Theorem states that entanglement cannot be used to transmit classical information faster than light.\"}]', '2026-10-22 07:04:44', '2026-10-22 07:04:44', '2026-10-22 07:04:44'),
  (21, 3, 1, 'quick', 0, 4, 0, 0, 0, 20, 0, '[{\"question_id\":1,\"question_text\":\"What physical phenomenon occurs at the Schwarzschild radius of a non-rotating black hole?\",\"selected_option_id\":null,\"correct_option_id\":1,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The Schwarzschild radius defines the spherical event horizon where the escape velocity equals the speed of light in vacuum (c).\"},{\"question_id\":2,\"question_text\":\"Which particle is postulated to mediate the gravitational interaction in quantum field theory?\",\"selected_option_id\":null,\"correct_option_id\":5,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The graviton is the hypothetical massless spin-2 boson mediating gravitation.\"},{\"question_id\":3,\"question_text\":\"Cosmic microwave background (CMB) radiation possesses a black-body temperature of approximately:\",\"selected_option_id\":null,\"correct_option_id\":9,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The CMB has a thermal black body spectrum at 2.72548 \\u00b1 0.00057 Kelvin.\"},{\"question_id\":4,\"question_text\":\"Quantum entanglement allows information to travel faster than the speed of light (superluminal signaling).\",\"selected_option_id\":null,\"correct_option_id\":13,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The No-Communication Theorem states that entanglement cannot be used to transmit classical information faster than light.\"}]', '2026-10-22 07:45:09', '2026-10-22 07:45:09', '2026-10-22 07:45:09'),
  (22, 3, 1, 'quick', 0, 4, 0, 0, 0, 13, 0, '[{\"question_id\":1,\"question_text\":\"What physical phenomenon occurs at the Schwarzschild radius of a non-rotating black hole?\",\"selected_option_id\":\"2\",\"correct_option_id\":1,\"is_correct\":false,\"points_earned\":0,\"time_taken\":7,\"explanation\":\"The Schwarzschild radius defines the spherical event horizon where the escape velocity equals the speed of light in vacuum (c).\"},{\"question_id\":2,\"question_text\":\"Which particle is postulated to mediate the gravitational interaction in quantum field theory?\",\"selected_option_id\":\"6\",\"correct_option_id\":5,\"is_correct\":false,\"points_earned\":0,\"time_taken\":2,\"explanation\":\"The graviton is the hypothetical massless spin-2 boson mediating gravitation.\"},{\"question_id\":3,\"question_text\":\"Cosmic microwave background (CMB) radiation possesses a black-body temperature of approximately:\",\"selected_option_id\":\"11\",\"correct_option_id\":9,\"is_correct\":false,\"points_earned\":0,\"time_taken\":2,\"explanation\":\"The CMB has a thermal black body spectrum at 2.72548 \\u00b1 0.00057 Kelvin.\"},{\"question_id\":4,\"question_text\":\"Quantum entanglement allows information to travel faster than the speed of light (superluminal signaling).\",\"selected_option_id\":\"14\",\"correct_option_id\":13,\"is_correct\":false,\"points_earned\":0,\"time_taken\":2,\"explanation\":\"The No-Communication Theorem states that entanglement cannot be used to transmit classical information faster than light.\"}]', '2026-10-22 08:04:02', '2026-10-22 08:04:02', '2026-10-22 08:04:02'),
  (23, 3, 5, 'quick', 0, 2, 0, 0, 0, 10, 0, '[{\"question_id\":14,\"question_text\":\"Which lattice-based key encapsulation mechanism was standardized by NIST as FIPS 203 for general encryption?\",\"selected_option_id\":null,\"correct_option_id\":47,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"ML-KEM (originally CRYSTALS-Kyber) was selected and standardized as FIPS 203.\"},{\"question_id\":15,\"question_text\":\"Zero-Trust Architecture principles assume the internal perimeter network is inherently secure once authenticated.\",\"selected_option_id\":null,\"correct_option_id\":51,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"Zero-Trust operates under \\\"Never Trust, Always Verify\\\", assuming hostile breach inside the network.\"}]', '2026-10-22 08:20:09', '2026-10-22 08:20:09', '2026-10-22 08:20:09'),
  (24, 2, 6, 'quick', 0, 2, 0, 0, 0, 10, 0, '[{\"question_id\":16,\"question_text\":\"In the Node.js event loop, which queue has highest execution priority immediately following the current operation?\",\"selected_option_id\":null,\"correct_option_id\":53,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"process.nextTick() queue executes immediately after the current operation finishes, before any other event loop phase.\"},{\"question_id\":17,\"question_text\":\"What caching anomaly occurs when multiple concurrent requests simultaneously calculate an expired key?\",\"selected_option_id\":null,\"correct_option_id\":57,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"Cache stampede (thundering herd) occurs when key expiration causes a massive spike of concurrent database recalculations.\"}]', '2026-10-22 08:51:06', '2026-10-22 08:51:06', '2026-10-22 08:51:06'),
  (25, 2, 1, 'standard', 41, 4, 1, 80, 25, 15, 1, '[{\"question_id\":1,\"question_text\":\"What physical phenomenon occurs at the Schwarzschild radius of a non-rotating black hole?\",\"selected_option_id\":\"1\",\"correct_option_id\":1,\"is_correct\":true,\"points_earned\":41,\"time_taken\":6,\"explanation\":\"The Schwarzschild radius defines the spherical event horizon where the escape velocity equals the speed of light in vacuum (c).\"},{\"question_id\":2,\"question_text\":\"Which particle is postulated to mediate the gravitational interaction in quantum field theory?\",\"selected_option_id\":\"6\",\"correct_option_id\":5,\"is_correct\":false,\"points_earned\":0,\"time_taken\":2,\"explanation\":\"The graviton is the hypothetical massless spin-2 boson mediating gravitation.\"},{\"question_id\":3,\"question_text\":\"Cosmic microwave background (CMB) radiation possesses a black-body temperature of approximately:\",\"selected_option_id\":\"12\",\"correct_option_id\":9,\"is_correct\":false,\"points_earned\":0,\"time_taken\":2,\"explanation\":\"The CMB has a thermal black body spectrum at 2.72548 \\u00b1 0.00057 Kelvin.\"},{\"question_id\":4,\"question_text\":\"Quantum entanglement allows information to travel faster than the speed of light (superluminal signaling).\",\"selected_option_id\":null,\"correct_option_id\":13,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The No-Communication Theorem states that entanglement cannot be used to transmit classical information faster than light.\"}]', '2026-10-22 09:07:45', '2026-10-22 09:07:45', '2026-10-22 09:07:45'),
  (26, 2, 1, 'standard', 41, 4, 1, 80, 25, 15, 1, '[{\"question_id\":1,\"question_text\":\"What physical phenomenon occurs at the Schwarzschild radius of a non-rotating black hole?\",\"selected_option_id\":\"1\",\"correct_option_id\":1,\"is_correct\":true,\"points_earned\":41,\"time_taken\":6,\"explanation\":\"The Schwarzschild radius defines the spherical event horizon where the escape velocity equals the speed of light in vacuum (c).\"},{\"question_id\":2,\"question_text\":\"Which particle is postulated to mediate the gravitational interaction in quantum field theory?\",\"selected_option_id\":\"6\",\"correct_option_id\":5,\"is_correct\":false,\"points_earned\":0,\"time_taken\":2,\"explanation\":\"The graviton is the hypothetical massless spin-2 boson mediating gravitation.\"},{\"question_id\":3,\"question_text\":\"Cosmic microwave background (CMB) radiation possesses a black-body temperature of approximately:\",\"selected_option_id\":\"12\",\"correct_option_id\":9,\"is_correct\":false,\"points_earned\":0,\"time_taken\":2,\"explanation\":\"The CMB has a thermal black body spectrum at 2.72548 \\u00b1 0.00057 Kelvin.\"},{\"question_id\":4,\"question_text\":\"Quantum entanglement allows information to travel faster than the speed of light (superluminal signaling).\",\"selected_option_id\":null,\"correct_option_id\":13,\"is_correct\":false,\"points_earned\":0,\"time_taken\":5,\"explanation\":\"The No-Communication Theorem states that entanglement cannot be used to transmit classical information faster than light.\"}]', '2026-10-22 09:07:55', '2026-10-22 09:07:55', '2026-10-22 09:07:55');

-- Dumping data for table `platform_settings` (7 rows)
INSERT INTO `platform_settings` (`id`, `key`, `value`, `type`, `group`, `label`, `description`, `created_at`, `updated_at`) VALUES
  (1, 'site_name', 'QuizVerse', 'string', 'general', 'Application Name', 'The brand identifier displayed across all interfaces and emails.', '2026-10-22 04:21:42', '2026-10-22 04:21:42'),
  (2, 'registration_enabled', 'true', 'boolean', 'general', 'Public Registration', 'Allow new players to sign up for public competitive accounts.', '2026-10-22 04:21:42', '2026-10-22 04:21:42'),
  (3, 'daily_xp_cap', '3000', 'integer', 'gameplay', 'Daily XP Earning Cap', 'Maximum XP a player can acquire per UTC day to prevent botting.', '2026-10-22 04:21:42', '2026-10-22 04:21:42'),
  (4, 'quick_play_timer', '15', 'integer', 'gameplay', 'Quick Play Timer (seconds)', 'Countdown duration for rapid blitz matchmaking.', '2026-10-22 04:21:42', '2026-10-22 04:21:42'),
  (5, 'streak_protection_coins', '250', 'integer', 'gameplay', 'Streak Shield Coin Cost', 'In-game currency required to freeze a broken streak.', '2026-10-22 04:21:42', '2026-10-22 04:21:42'),
  (6, 'maintenance_mode', 'false', 'boolean', 'security', 'Maintenance Guard', 'Restrict site access to administrators during database migrations.', '2026-10-22 04:21:42', '2026-10-22 04:21:42'),
  (7, 'ad_banner_active', 'true', 'boolean', 'monetization', 'Global Ad Banners', 'Display verified sponsor banners on player dashboard.', '2026-10-22 04:21:42', '2026-10-22 04:21:42');

-- Dumping data for table `audit_logs` (25 rows)
INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `severity`, `entity_type`, `entity_id`, `details`, `ip_address`, `user_agent`, `created_at`) VALUES
  (1, 1, 'system_boot', 'info', 'System', 1, '{\"version\":\"2026.4.1\",\"environment\":\"production\",\"status\":\"operational\"}', '127.0.0.1', 'QuizVerse Engine Automated Kernel', '2026-10-21 14:21:42'),
  (2, 1, 'role_assigned', 'warning', 'User', 1, '{\"assigned_by\":\"Root Initializer\",\"role\":\"Super Administrator\"}', '127.0.0.1', 'QuizVerse Engine Automated Kernel', '2026-10-19 22:21:42'),
  (3, 1, 'quiz_published', 'info', 'Quiz', 1, '{\"slug\":\"quantum-frontiers-cosmic-horizons\",\"author\":\"Dr. Elena Rostova\"}', '127.0.0.1', 'QuizVerse Engine Automated Kernel', '2026-10-19 13:21:42'),
  (4, 1, 'security_audit', 'security', 'Firewall', NULL, '{\"scanned_ips\":1420,\"anomalies_detected\":0,\"status\":\"clean\"}', '127.0.0.1', 'QuizVerse Engine Automated Kernel', '2026-10-19 06:21:42'),
  (5, 1, 'settings_updated', 'info', 'PlatformSetting', 3, '{\"key\":\"daily_xp_cap\",\"old_value\":\"2500\",\"new_value\":\"3000\"}', '127.0.0.1', 'QuizVerse Engine Automated Kernel', '2026-10-20 07:21:42'),
  (6, 1, 'quiz_completed', 'info', 'QuizAttempt', 17, '{\"quiz\":\"Quantum Frontiers & Cosmic Horizons\",\"score\":0,\"accuracy\":0,\"xp_earned\":0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 04:39:31'),
  (7, 1, 'quiz_completed', 'info', 'QuizAttempt', 18, '{\"quiz\":\"Quantum Frontiers & Cosmic Horizons\",\"score\":0,\"accuracy\":0,\"xp_earned\":0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 04:55:50'),
  (8, 3, 'profile_updated', 'info', 'User', 3, '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 06:39:12'),
  (9, 1, 'profile_updated', 'info', 'User', 1, '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 06:47:45'),
  (10, 1, 'user_logout', 'info', 'User', 1, '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 06:50:27'),
  (11, 2, 'user_logout', 'info', 'User', 2, '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 06:51:34'),
  (12, 1, 'user_logout', 'info', 'User', 1, '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 06:51:57'),
  (13, 3, 'user_logout', 'info', 'User', 3, '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 06:53:23'),
  (14, 3, 'user_login', 'info', 'User', 3, '{\"email\":\"player@quizverse.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 06:54:39'),
  (15, 3, 'user_logout', 'info', 'User', 3, '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 06:56:10'),
  (16, 3, 'user_login', 'info', 'User', 3, '{\"email\":\"player@quizverse.com\"}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 06:59:24'),
  (17, 3, 'quiz_completed', 'info', 'QuizAttempt', 19, '{\"quiz\":\"Quantum Frontiers & Cosmic Horizons\",\"score\":97,\"accuracy\":50,\"xp_earned\":150}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 07:04:23'),
  (18, 3, 'quiz_completed', 'info', 'QuizAttempt', 20, '{\"quiz\":\"Quantum Frontiers & Cosmic Horizons\",\"score\":97,\"accuracy\":50,\"xp_earned\":150}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 07:04:44'),
  (19, 3, 'quiz_completed', 'info', 'QuizAttempt', 21, '{\"quiz\":\"Quantum Frontiers & Cosmic Horizons\",\"score\":0,\"accuracy\":0,\"xp_earned\":0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 07:45:09'),
  (20, 3, 'quiz_completed', 'info', 'QuizAttempt', 22, '{\"quiz\":\"Quantum Frontiers & Cosmic Horizons\",\"score\":0,\"accuracy\":0,\"xp_earned\":0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 08:04:02'),
  (21, 3, 'quiz_completed', 'info', 'QuizAttempt', 23, '{\"quiz\":\"Post-Quantum Cryptography & Zero-Trust Defense\",\"score\":0,\"accuracy\":0,\"xp_earned\":0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 08:20:09'),
  (22, 3, 'user_logout', 'info', 'User', 3, '[]', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 08:37:24'),
  (23, 2, 'quiz_completed', 'info', 'QuizAttempt', 24, '{\"quiz\":\"High-Performance Node.js & Distributed Caches\",\"score\":0,\"accuracy\":0,\"xp_earned\":0}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 08:51:06'),
  (24, 2, 'quiz_completed', 'info', 'QuizAttempt', 25, '{\"quiz\":\"Quantum Frontiers & Cosmic Horizons\",\"score\":41,\"accuracy\":25,\"xp_earned\":80}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 09:07:45'),
  (25, 2, 'quiz_completed', 'info', 'QuizAttempt', 26, '{\"quiz\":\"Quantum Frontiers & Cosmic Horizons\",\"score\":41,\"accuracy\":25,\"xp_earned\":80}', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', '2026-10-22 09:07:55');

-- Dumping data for table `campaigns` (2 rows)
INSERT INTO `campaigns` (`id`, `title`, `type`, `status`, `badge_text`, `cta_text`, `target_url`, `content`, `impressions`, `clicks`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
  (1, 'DevPulse 2026 Global AI & Cloud Summit', 'banner', 'active', 'SPONSORED', 'Claim Free Pass', 'https://devpulse.io/summit-2026', 'Join 45,000+ engineers discussing frontier models, distributed rust systems, and quantum compilation.', 14280, 842, '2026-10-17 04:21:42', '2026-11-16 04:21:42', '2026-10-22 04:21:42', '2026-10-22 04:21:42'),
  (2, 'Quantum Cloud Workstations - 30 Days Free', 'sponsored', 'active', 'PARTNER OFFER', 'Deploy Now', 'https://quantumcloud.dev/free-tier', 'Spin up 8x H100 clusters with instantaneous cold boot latency. Zero credit card needed.', 9650, 512, '2026-10-20 04:21:42', '2026-11-09 04:21:42', '2026-10-22 04:21:42', '2026-10-22 04:21:42');

-- Dumping data for table `roles` (3 rows)
INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `permissions`, `created_at`, `updated_at`) VALUES
  (1, 'Super Administrator', 'super-admin', 'Full unconstrained platform control and governance privileges.', '[\"all\",\"manage_users\",\"manage_quizzes\",\"manage_settings\",\"view_analytics\",\"view_audit_logs\",\"manage_campaigns\"]', '2026-10-22 04:21:30', '2026-10-22 04:21:30'),
  (2, 'Content Director', 'content-director', 'Curates categories, inspects questions, and approves sponsored quizzes.', '[\"manage_quizzes\",\"manage_categories\",\"view_analytics\"]', '2026-10-22 04:21:30', '2026-10-22 04:21:30'),
  (3, 'Trust & Safety Lead', 'safety-lead', 'Moderates user directory, investigates flagged content, and handles account sanctions.', '[\"manage_users\",\"view_audit_logs\"]', '2026-10-22 04:21:31', '2026-10-22 04:21:31');

-- Dumping data for table `staff_members` (1 rows)
INSERT INTO `staff_members` (`id`, `user_id`, `role_id`, `department`, `is_active`, `created_at`, `updated_at`) VALUES
  (1, 1, 1, 'Executive Engineering', 1, '2026-10-22 04:21:31', '2026-10-22 04:21:31');

-- Dumping data for table `sessions` (2 rows)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
  ('qFA8gKT4IGvNFZ7ZocgaFARNaaQx67slSXFrE834', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.19041.6456', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWGsxV0U3VkxJTDIyUVkzR0lEQWtmNlk4dWpOdWMydmw5WTJybXRBaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792648626),
  ('6BSk8feqJRrDyFqJpyJRjd3IA6Pxo5Sycz7a2Hvb', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoidWtBak5zUEFnaXZuaXlwOGlUNWdYcWQwaHFuMFB4S1N4amgyUVlSciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9wbGF5L3Jlc3VsdHMvMjYiO3M6NToicm91dGUiO3M6MTI6InBsYXkucmVzdWx0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImZjN2Y2OWY3NWI3ZjRlMDI0YzE0ODFjODRjMWJhZDBhOWIyODJjYTliYmI1NDUzYTM0N2FhODI2NjAwZTdjYjMiO30=', 1792660084);

-- Dumping data for table `migrations` (12 rows)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
  (1, '0001_01_01_000000_create_users_table', 1),
  (2, '0001_01_01_000001_create_cache_table', 1),
  (3, '0001_01_01_000002_create_jobs_table', 1),
  (4, '2026_10_22_000001_create_categories_table', 1),
  (5, '2026_10_22_000002_create_quizzes_table', 1),
  (6, '2026_10_22_000003_create_questions_and_options_tables', 1),
  (7, '2026_10_22_000004_create_quiz_attempts_table', 1),
  (8, '2026_10_22_000005_create_platform_settings_table', 1),
  (9, '2026_10_22_000006_create_audit_logs_table', 1),
  (10, '2026_10_22_000007_create_campaigns_table', 1),
  (11, '2026_10_22_000008_create_staff_and_roles_table', 1),
  (12, '2026_10_22_000009_add_fields_to_quizzes_table', 2);

-- --------------------------------------------------------
-- Foreign Key Constraints
-- --------------------------------------------------------

alter table `quizzes` add constraint `quizzes_category_id_foreign` foreign key (`category_id`) references `categories` (`id`) on delete cascade;
alter table `quizzes` add constraint `quizzes_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade;
alter table `questions` add constraint `questions_category_id_foreign` foreign key (`category_id`) references `categories` (`id`) on delete cascade;
alter table `questions` add constraint `questions_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade;
alter table `questions` add constraint `questions_quiz_id_foreign` foreign key (`quiz_id`) references `quizzes` (`id`) on delete set null;
alter table `question_options` add constraint `question_options_question_id_foreign` foreign key (`question_id`) references `questions` (`id`) on delete cascade;
alter table `quiz_attempts` add constraint `quiz_attempts_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade;
alter table `quiz_attempts` add constraint `quiz_attempts_quiz_id_foreign` foreign key (`quiz_id`) references `quizzes` (`id`) on delete set null;
alter table `audit_logs` add constraint `audit_logs_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete set null;
alter table `staff_members` add constraint `staff_members_user_id_foreign` foreign key (`user_id`) references `users` (`id`) on delete cascade;
alter table `staff_members` add constraint `staff_members_role_id_foreign` foreign key (`role_id`) references `roles` (`id`) on delete cascade;

COMMIT;
SET FOREIGN_KEY_CHECKS = 1;
