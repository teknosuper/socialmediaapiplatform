CREATE TABLE IF NOT EXISTS `account_cookies` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `service` VARCHAR(50) NOT NULL COMMENT 'The service name, e.g., "instagram", "tiktok"',
  `username` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NULL,
  `cookie` TEXT NOT NULL COMMENT 'Stores the full cookie string from the browser.',
  `cookies_status` VARCHAR(50) NULL DEFAULT 'pending' COMMENT 'e.g., "valid", "expired", "requires_login"',
  `cookies_response` TEXT NULL COMMENT 'Stores the last API response using this cookie.',
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `service_username_unique` (`service`, `username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;