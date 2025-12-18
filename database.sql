-- SQL dump to create database and tables for isave_db
CREATE DATABASE IF NOT EXISTS `isave_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `isave_db`;

-- users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `fullname` VARCHAR(255),
  `email` VARCHAR(255),
  `role` ENUM('user','admin','technician') NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- applications for admin/technician roles
CREATE TABLE IF NOT EXISTS `applications` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `desired_role` ENUM('admin','technician') NOT NULL,
  `status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- repair reports
CREATE TABLE IF NOT EXISTS `reports` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `asset_number` VARCHAR(100) NOT NULL,
  `image_path` VARCHAR(255),
  `room` VARCHAR(100),
  `reason` TEXT,
  `warranty` TINYINT(1) DEFAULT 0,
  `responsible_person` VARCHAR(255),
  `status` ENUM('pending','approved','assigned','in_progress','resolved','rejected') DEFAULT 'pending',
  `assigned_to` INT DEFAULT NULL,
  `tech_name` VARCHAR(255) DEFAULT NULL,
  `tech_note` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- insert a default admin (password: admin123)
INSERT INTO `users` (`username`,`password`,`fullname`,`email`,`role`) VALUES
('admin','{PASSWORD_PLACEHOLDER}','Administrator','admin@example.com','admin');

-- Note: replace {PASSWORD_PLACEHOLDER} with the result of PHP password_hash('admin123', PASSWORD_DEFAULT)
