CREATE DATABASE IF NOT EXISTS db_parkir;
USE db_parkir;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'petugas') NOT NULL
);

CREATE TABLE pengaturan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    kapasitas_maksimal INT DEFAULT 50
);

CREATE TABLE parkir (
    id INT PRIMARY KEY AUTO_INCREMENT,
    no_plat VARCHAR(15) NOT NULL,
    jenis_kendaraan ENUM('Motor', 'Mobil') NOT NULL,
    lokasi_parkir VARCHAR(50) DEFAULT 'Menunggu Arahan',
    jam_masuk DATETIME DEFAULT CURRENT_TIMESTAMP,
    jam_keluar DATETIME NULL,
    biaya INT DEFAULT 0,
    status ENUM('Masuk', 'Keluar') DEFAULT 'Masuk'
);

-- User: KOYORRRR | Pass: 12345 | Role: Admin
INSERT INTO users (username, password, role) VALUES 
('KOYORRRR', '$2y$10$t0Ek7wut3qgs4AQTVBuuFeJGBwMaZORdZFE6BQLmsKKfG2So4USce', 'admin'),
('PETUGAS1', '$2y$10$mCUCW9E/n6tTOnVvHh97S.Isc4G3S7V.H0U6y5uE0Q7yZ2K/oU6uE', 'petugas');

INSERT INTO pengaturan (kapasitas_maksimal) VALUES (50);