CREATE DATABASE IF NOT EXISTS todolist_db;
USE todolist_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    task TEXT NOT NULL,
    is_done BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Contoh user 'admin' dengan password terenkripsi
INSERT INTO users (username, password) VALUES (
    'admin',
    '$2y$10$WeNMkGMhm0027tGNpyJdPOc1hJmbMTScvak9z4Lc9FJ5DPhGjdPzW' -- hash dari '235314017'
);
