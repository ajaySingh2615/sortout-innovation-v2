-- Add new fields for Artist profiles only
-- Execute these queries one by one in your MySQL database

-- 1. Add Email field
ALTER TABLE clients ADD COLUMN email VARCHAR(255) NULL AFTER phone;

-- 2. Add Types of influencers based on category
ALTER TABLE clients ADD COLUMN influencer_category TEXT NULL AFTER category;

-- 3. Add Types of Influencers (by follower count)
ALTER TABLE clients ADD COLUMN influencer_type VARCHAR(255) NULL AFTER influencer_category;

-- 4. Add Instagram Profile Link
ALTER TABLE clients ADD COLUMN instagram_profile VARCHAR(500) NULL AFTER influencer_type;

-- 5. Add Expected payment for one video
ALTER TABLE clients ADD COLUMN expected_payment VARCHAR(255) NULL AFTER instagram_profile;

-- 6. Add What type of product would you like to work on
ALTER TABLE clients ADD COLUMN work_type_preference TEXT NULL AFTER expected_payment;

-- Optional: Add index on email for better performance
CREATE INDEX idx_clients_email ON clients(email);

-- Optional: Add index on influencer_type for filtering
CREATE INDEX idx_clients_influencer_type ON clients(influencer_type); 