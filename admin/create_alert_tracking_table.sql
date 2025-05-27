-- Create table to track admin alert viewing
CREATE TABLE IF NOT EXISTS admin_alert_tracking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_id VARCHAR(100) NOT NULL,
    last_seen_timestamp DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_admin (admin_id),
    INDEX idx_admin_timestamp (admin_id, last_seen_timestamp)
);

-- Insert default entries for existing admins (optional)
-- This will set their last seen timestamp to current time so they don't see old alerts
INSERT IGNORE INTO admin_alert_tracking (admin_id, last_seen_timestamp)
SELECT DISTINCT username, NOW()
FROM users 
WHERE role IN ('admin', 'super_admin'); 