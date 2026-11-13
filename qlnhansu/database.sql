CREATE DATABASE IF NOT EXISTS QLNhanSu CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE QLNhanSu;

CREATE TABLE IF NOT EXISTS Users (
  admin_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  admin_email VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  admin_password VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  images VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (admin_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Câu 1: thêm dữ liệu vào bảng Users
INSERT INTO Users (admin_email, admin_password, images) VALUES
('nguyenvana@gmail.com', '123456', ''),
('tranthib@gmail.com',   '123456', ''),
('lequangc@gmail.com',   '123456', ''),
('phamthid@gmail.com',   '123456', '');
