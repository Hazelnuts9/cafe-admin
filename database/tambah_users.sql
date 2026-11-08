USE cafe_admin;

CREATE TABLE IF NOT EXISTS users (
  id            INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  nama          VARCHAR(100) NOT NULL,
  username      VARCHAR(50)  NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Akun awal: username "admin", password "admin123"
INSERT IGNORE INTO users (nama, username, password_hash) VALUES
  ('Admin Kopi Senja', 'admin', '$2y$10$ldxfDXCWObYW0p3Q1ymWcuZcb2BbhnO52FkhhM9eRByTvPbPiQd0K');