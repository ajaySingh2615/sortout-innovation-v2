-- Enhanced Admin Alert Tracking System
-- This version includes proper foreign key relationships and detailed tracking

-- 1. Main Admin Alert Tracking Table (tracks last seen timestamp per admin)
CREATE TABLE `admin_alert_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(100) NOT NULL,
  `last_seen_timestamp` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_admin` (`admin_id`),
  KEY `idx_admin_timestamp` (`admin_id`,`last_seen_timestamp`),
  -- Foreign key to users table (assuming you have a users table)
  CONSTRAINT `fk_admin_alert_user` FOREIGN KEY (`admin_id`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Optional: Detailed Client View Tracking (tracks which specific clients each admin has seen)
CREATE TABLE `admin_client_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(100) NOT NULL,
  `client_id` int(11) NOT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `view_type` enum('dashboard','details','approval','rejection') DEFAULT 'dashboard',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_admin_client` (`admin_id`, `client_id`),
  KEY `idx_admin_viewed` (`admin_id`, `viewed_at`),
  KEY `idx_client_viewed` (`client_id`, `viewed_at`),
  -- Foreign keys
  CONSTRAINT `fk_admin_view_user` FOREIGN KEY (`admin_id`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_admin_view_client` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert initial tracking records for existing admins
INSERT IGNORE INTO `admin_alert_tracking` (`admin_id`, `last_seen_timestamp`)
SELECT DISTINCT `username`, NOW()
FROM `users` 
WHERE `role` IN ('admin', 'super_admin');

-- Optional: Mark all existing clients as "seen" by all admins (to avoid showing old alerts)
INSERT IGNORE INTO `admin_client_views` (`admin_id`, `client_id`, `viewed_at`, `view_type`)
SELECT u.username, c.id, NOW(), 'dashboard'
FROM `users` u
CROSS JOIN `clients` c
WHERE u.role IN ('admin', 'super_admin'); 