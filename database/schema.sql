CREATE DATABASE IF NOT EXISTS cafe_admin
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cafe_admin;

DROP TABLE IF EXISTS menu;
DROP TABLE IF EXISTS kategori;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama          VARCHAR(100) NOT NULL,
  username      VARCHAR(50)  NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE kategori (
  id         INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama       VARCHAR(50)  NOT NULL UNIQUE,
  created_at TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE menu (
  id          INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama        VARCHAR(100) NOT NULL,
  harga       INT UNSIGNED NOT NULL,
  stok        INT UNSIGNED NOT NULL DEFAULT 0,
  kategori_id INT UNSIGNED NOT NULL,
  created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_menu_kategori
    FOREIGN KEY (kategori_id) REFERENCES kategori(id)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO users (nama, username, password_hash) VALUES
  ('Admin Kopi Senja', 'admin', '$2y$10$ldxfDXCWObYW0p3Q1ymWcuZcb2BbhnO52FkhhM9eRByTvPbPiQd0K');

INSERT INTO kategori (nama) VALUES
  ('Kopi'), ('Non-Kopi'), ('Makanan Berat'), ('Camilan');

INSERT INTO menu (nama, harga, stok, kategori_id) VALUES
  ('Espresso',            18000, 40, 1),
  ('Kopi Susu Gula Aren', 22000, 35, 1),
  ('V60 Manual Brew',     28000,  4, 1),
  ('Matcha Latte',        26000, 20, 2),
  ('Cokelat Panas',       24000,  3, 2),
  ('Nasi Ayam Sambal',    32000, 15, 3),
  ('Mie Goreng Spesial',  28000, 12, 3),
  ('Kentang Goreng',      20000, 25, 4);
