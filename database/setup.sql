CREATE DATABASE vulnerable_app;
USE vulnerable_app;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100)
);

INSERT INTO users (username, password, email) VALUES 
('admin', 'admin123', 'admin@example.com'),
('user1', 'password1', 'user1@example.com'),
('test', 'test123', 'test@example.com');

CREATE USER 'webapp'@'localhost' IDENTIFIED BY 'secure_password_123';
GRANT SELECT ON vulnerable_app.* TO 'webapp'@'localhost';
FLUSH PRIVILEGES;