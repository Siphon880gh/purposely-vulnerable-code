DROP DATABASE IF EXISTS security_auth_db;
CREATE DATABASE security_auth_db;
USE security_auth_db;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample users with hashed passwords
-- Plaintext passwords for reference:
-- johndoe: password123
-- janesmith: password123
-- bobjohnson: password123
INSERT INTO users (username, email, password) VALUES
('johndoe', 'john@example.com', '$2y$10$N0f5JGzlz8XqRT2sEEHYmOh/WIMKOPI6mo1I09axQ5662Agum1/T2'),
('janesmith', 'jane@example.com', '$2y$10$WlhnFuHZ.H17e7vt61OET.mRd22CzHl8g6NqMC3w4Ytfj2hF5yawS'),
('bobjohnson', 'bob@example.com', '$2y$10$t2nipsjsxYhJAACZU7K.ZO5Wg9gmF48L2ZfooLOwuDmtPce9XGbWy');