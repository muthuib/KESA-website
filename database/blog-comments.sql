CREATE TABLE `comments` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `blog_id` INT(11) NOT NULL,  -- Must match blog.id exactly
    `user_id` INT(11) NULL DEFAULT NULL,  -- Match users.id if it's INT
    `parent_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `content` TEXT NOT NULL,
    `likes` INT NOT NULL DEFAULT 0,
    `is_approved` TINYINT(1) NOT NULL DEFAULT 1,
    `guest_name` VARCHAR(255) NULL DEFAULT NULL,
    `guest_email` VARCHAR(255) NULL DEFAULT NULL,
    `ip_address` VARCHAR(45) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `comments_blog_id_index` (`blog_id`),
    INDEX `comments_user_id_index` (`user_id`),
    INDEX `comments_parent_id_index` (`parent_id`),
    INDEX `comments_is_approved_index` (`is_approved`),
    INDEX `comments_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add foreign keys separately
ALTER TABLE `comments` 
    ADD CONSTRAINT `comments_blog_id_foreign` 
    FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE;



    -- Create comment likes table for tracking likes
CREATE TABLE `comment_likes` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `comment_id` BIGINT UNSIGNED NOT NULL,
    `user_id` INT(11) NULL DEFAULT NULL,
    `guest_id` VARCHAR(64) NULL DEFAULT NULL,
    `ip_address` VARCHAR(45) NULL DEFAULT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `comment_likes_unique` (`comment_id`, `user_id`),
    INDEX `comment_likes_comment_id_index` (`comment_id`),
    INDEX `comment_likes_user_id_index` (`user_id`),
    CONSTRAINT `comment_likes_comment_id_foreign` 
        FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
    CONSTRAINT `comment_likes_user_id_foreign` 
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Create comment reports table for moderation
CREATE TABLE `comment_reports` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `comment_id` BIGINT UNSIGNED NOT NULL,
    `user_id` INT(11) NULL DEFAULT NULL,
    `reason` VARCHAR(255) NOT NULL,
    `details` TEXT NULL DEFAULT NULL,
    `status` ENUM('pending', 'reviewed', 'dismissed') NOT NULL DEFAULT 'pending',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    INDEX `comment_reports_comment_id_index` (`comment_id`),
    INDEX `comment_reports_status_index` (`status`),
    CONSTRAINT `comment_reports_comment_id_foreign` 
        FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE,
    CONSTRAINT `comment_reports_user_id_foreign` 
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Create comment subscriptions for email notifications
CREATE TABLE `comment_subscriptions` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `blog_id` INT(11) NOT NULL,
    `user_id` INT(11) NULL DEFAULT NULL,
    `email` VARCHAR(255) NULL DEFAULT NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `subscription_unique` (`blog_id`, `user_id`),
    INDEX `comment_subscriptions_blog_id_index` (`blog_id`),
    INDEX `comment_subscriptions_user_id_index` (`user_id`),
    CONSTRAINT `comment_subscriptions_blog_id_foreign` 
        FOREIGN KEY (`blog_id`) REFERENCES `blog` (`id`) ON DELETE CASCADE,
    CONSTRAINT `comment_subscriptions_user_id_foreign` 
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;