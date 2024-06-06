-- Restriction to add unique constraint on DailyReport table for userid and created_at columns
ALTER TABLE DailyReport ADD CONSTRAINT unique_user_daily_report UNIQUE (userid, created_at);

