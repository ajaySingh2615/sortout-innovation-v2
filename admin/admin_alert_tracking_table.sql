-- Admin Alert Tracking Table
-- This table tracks when each admin last viewed the registrations dashboard
-- to show personalized "new registration" alerts

CREATE TABLE `admin_alert_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(100) NOT NULL,
  `last_seen_timestamp` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_admin` (`admin_id`),
  KEY `idx_admin_timestamp` (`admin_id`,`last_seen_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert initial tracking records for existing admins
-- This sets their last seen timestamp to current time so they don't see old alerts
INSERT IGNORE INTO `admin_alert_tracking` (`admin_id`, `last_seen_timestamp`)
SELECT DISTINCT `username`, NOW()
FROM `users` 
WHERE `role` IN ('admin', 'super_admin'); 