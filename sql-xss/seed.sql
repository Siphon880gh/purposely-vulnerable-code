DROP DATABASE IF EXISTS security_comments_db;
CREATE DATABASE security_comments_db;
USE security_comments_db;

-- Create comments table
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample comments
INSERT INTO comments (name, comment) VALUES
('John Doe', 'This is a great website!'),
('Jane Smith', 'I love the design and functionality.'),
('Bob Johnson', 'Keep up the good work!'); 