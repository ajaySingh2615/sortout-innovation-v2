-- Admin Actions Log Table (Optional)
-- This table tracks bulk operations performed by admins for audit purposes

CREATE TABLE `admin_actions_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(100) NOT NULL,
  `action_type` enum('bulk_approve','bulk_reject','bulk_delete','bulk_visibility') NOT NULL,
  `client_ids` text NOT NULL COMMENT 'JSON array of affected client IDs',
  `action_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `additional_data` text DEFAULT NULL COMMENT 'Additional action details in JSON format',
  PRIMARY KEY (`id`),
  KEY `idx_admin_action` (`admin_id`, `action_timestamp`),
  KEY `idx_action_type` (`action_type`, `action_timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Note: This table is optional and used for audit logging
-- If you don't want to track bulk operations, you can skip creating this table
-- The bulk_actions.php will work without it (just remove the logging code) 