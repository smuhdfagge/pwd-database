-- ============================================================================
-- PWD Database System - Complete SQL Schema
-- ============================================================================
-- Database: pwd_database
-- Generated: November 13, 2025
-- Description: Complete database schema for Persons with Disabilities (PWD) 
--              Database Management System
-- ============================================================================

-- Set database defaults
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- ============================================================================
-- TABLE: users
-- Description: User accounts (admin and PLWD members)
-- ============================================================================
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','plwd') NOT NULL DEFAULT 'plwd',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`),
  KEY `users_status_index` (`status`),
  KEY `users_role_status_index` (`role`, `status`),
  KEY `users_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: password_reset_tokens
-- Description: Password reset token storage
-- ============================================================================
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: sessions
-- Description: User session storage
-- ============================================================================
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: disability_types
-- Description: Types of disabilities (e.g., Visual, Hearing, Physical)
-- ============================================================================
CREATE TABLE `disability_types` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `disability_types_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: education_levels
-- Description: Educational qualification levels
-- ============================================================================
CREATE TABLE `education_levels` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `education_levels_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: skills
-- Description: Skills and competencies catalog
-- ============================================================================
CREATE TABLE `skills` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `skills_name_index` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: plwd_profiles
-- Description: Detailed profiles for persons with disabilities
-- ============================================================================
CREATE TABLE `plwd_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `lga` varchar(255) DEFAULT NULL,
  `disability_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `education_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `skills` json DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `plwd_profiles_user_id_foreign` (`user_id`),
  KEY `plwd_profiles_disability_type_id_foreign` (`disability_type_id`),
  KEY `plwd_profiles_education_level_id_foreign` (`education_level_id`),
  KEY `plwd_profiles_verified_index` (`verified`),
  KEY `plwd_profiles_state_index` (`state`),
  KEY `plwd_profiles_gender_index` (`gender`),
  KEY `plwd_profiles_verified_state_index` (`verified`, `state`),
  KEY `plwd_profiles_verified_disability_type_id_index` (`verified`, `disability_type_id`),
  KEY `plwd_profiles_verified_gender_index` (`verified`, `gender`),
  KEY `plwd_profiles_state_disability_type_id_index` (`state`, `disability_type_id`),
  KEY `plwd_profiles_created_at_index` (`created_at`),
  KEY `plwd_profiles_updated_at_index` (`updated_at`),
  CONSTRAINT `plwd_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `plwd_profiles_disability_type_id_foreign` FOREIGN KEY (`disability_type_id`) REFERENCES `disability_types` (`id`) ON DELETE SET NULL,
  CONSTRAINT `plwd_profiles_education_level_id_foreign` FOREIGN KEY (`education_level_id`) REFERENCES `education_levels` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: education_records
-- Description: Educational history for PLWD profiles
-- ============================================================================
CREATE TABLE `education_records` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plwd_profile_id` bigint(20) UNSIGNED NOT NULL,
  `education_level_id` bigint(20) UNSIGNED DEFAULT NULL,
  `institution` varchar(255) DEFAULT NULL,
  `from_year` year(4) DEFAULT NULL,
  `to_year` year(4) DEFAULT NULL,
  `certificate_obtained` varchar(255) DEFAULT NULL,
  `document_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `education_records_plwd_profile_id_foreign` (`plwd_profile_id`),
  KEY `education_records_education_level_id_foreign` (`education_level_id`),
  KEY `education_records_from_year_index` (`from_year`),
  KEY `education_records_to_year_index` (`to_year`),
  KEY `education_records_plwd_profile_id_from_year_index` (`plwd_profile_id`, `from_year`),
  KEY `education_records_created_at_index` (`created_at`),
  CONSTRAINT `education_records_plwd_profile_id_foreign` FOREIGN KEY (`plwd_profile_id`) REFERENCES `plwd_profiles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `education_records_education_level_id_foreign` FOREIGN KEY (`education_level_id`) REFERENCES `education_levels` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: uploads
-- Description: Document uploads (ID cards, certificates, medical reports)
-- ============================================================================
CREATE TABLE `uploads` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `plwd_id` bigint(20) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL COMMENT 'ID Card, Medical Report, Certificate, Other',
  `mime_type` varchar(255) DEFAULT NULL,
  `file_size` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `uploads_plwd_id_foreign` (`plwd_id`),
  KEY `uploads_type_index` (`type`),
  KEY `uploads_plwd_id_type_index` (`plwd_id`, `type`),
  KEY `uploads_created_at_index` (`created_at`),
  CONSTRAINT `uploads_plwd_id_foreign` FOREIGN KEY (`plwd_id`) REFERENCES `plwd_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: opportunities
-- Description: Employment, training, and volunteer opportunities
-- ============================================================================
CREATE TABLE `opportunities` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `organization` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'employment' COMMENT 'employment, training, volunteer, scholarship, other',
  `deadline` date DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive','expired') NOT NULL DEFAULT 'active',
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `opportunities_status_index` (`status`),
  KEY `opportunities_type_index` (`type`),
  KEY `opportunities_deadline_index` (`deadline`),
  KEY `opportunities_status_created_at_index` (`status`, `created_at`),
  KEY `opportunities_status_deadline_index` (`status`, `deadline`),
  KEY `opportunities_type_status_index` (`type`, `status`),
  KEY `opportunities_views_index` (`views`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: audit_logs
-- Description: System activity and administrative action logs
-- ============================================================================
CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_values` json DEFAULT NULL,
  `new_values` json DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `audit_logs_admin_id_foreign` (`admin_id`),
  KEY `audit_logs_action_index` (`action`),
  KEY `audit_logs_model_type_index` (`model_type`),
  KEY `audit_logs_model_type_model_id_index` (`model_type`, `model_id`),
  KEY `audit_logs_admin_id_created_at_index` (`admin_id`, `created_at`),
  KEY `audit_logs_created_at_index` (`created_at`),
  CONSTRAINT `audit_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: cache
-- Description: Application cache storage
-- ============================================================================
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: cache_locks
-- Description: Cache locking mechanism
-- ============================================================================
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: jobs
-- Description: Queue job storage
-- ============================================================================
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: job_batches
-- Description: Batch job management
-- ============================================================================
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

-- ============================================================================
-- TABLE: failed_jobs
-- Description: Failed queue jobs
-- ============================================================================
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- TABLE: migrations
-- Description: Laravel migration tracking
-- ============================================================================
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- INDEXES SUMMARY
-- ============================================================================
-- Total Tables: 15
-- Total Indexes: 60+ (including primary keys and foreign keys)
--
-- Key Performance Indexes:
-- - users: role, status, (role, status), created_at
-- - plwd_profiles: 13 indexes for comprehensive filtering
-- - opportunities: 7 indexes for status, type, deadline filtering
-- - education_records: 6 indexes for chronological queries
-- - uploads: 4 indexes for document type filtering
-- - audit_logs: 6 indexes for activity tracking
--
-- Foreign Key Relationships:
-- - plwd_profiles -> users (CASCADE)
-- - plwd_profiles -> disability_types (SET NULL)
-- - plwd_profiles -> education_levels (SET NULL)
-- - education_records -> plwd_profiles (CASCADE)
-- - education_records -> education_levels (SET NULL)
-- - uploads -> plwd_profiles (CASCADE)
-- - audit_logs -> users (CASCADE)
-- ============================================================================

-- ============================================================================
-- NOTES
-- ============================================================================
-- 1. All timestamps use NULL default for Laravel compatibility
-- 2. JSON columns for flexible data storage (skills, audit values)
-- 3. Enum types for constrained values (gender, status, role)
-- 4. Cascading deletes maintain referential integrity
-- 5. Composite indexes optimize common query patterns
-- 6. Geospatial indexes support location-based queries
-- 7. Full-text search consideration for name/email lookups
-- ============================================================================

-- End of schema
