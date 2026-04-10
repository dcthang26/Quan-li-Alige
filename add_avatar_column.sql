-- Add avatar column to users table
ALTER TABLE `users` ADD COLUMN `avatar` varchar(255) DEFAULT NULL;
