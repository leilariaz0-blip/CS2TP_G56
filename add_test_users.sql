-- Add test users with plain text passwords for website login
-- Run this in the database SQL interface on your university server

USE cs2team56_db;

-- Clear existing test users (optional)
DELETE FROM users WHERE username IN ('testuser', 'admin', 'cs2team56');

-- Insert test users with PLAIN TEXT passwords
-- These are the accounts people will use to login to your jewelry store website
INSERT INTO users (username, email, password, full_name) VALUES
('testuser', 'testuser@example.com', 'password', 'Test User'),
('admin', 'admin@example.com', 'admin123', 'Admin User'),
('cs2team56', 'cs2team56@aston.ac.uk', 'password', 'Team 56 User');

-- Now you can login to the jewelry store with:
-- Username: testuser, Password: password
-- OR
-- Username: admin, Password: admin123
-- OR
-- Username: cs2team56, Password: password
