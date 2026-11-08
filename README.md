# Kopi Senja Admin — Admin Panel Kafe (PHP MVC + MySQL)

Proyek kelompok Pemrograman Web (pengganti UTS/UAS). Aplikasi admin panel untuk mengelola menu kafe.

## Fitur
- Dashboard: total menu, total kategori, total stok, daftar stok menipis
- CRUD Menu (+ pencarian nama)
- CRUD Kategori (kategori yang masih dipakai menu tidak bisa dihapus)
- Validasi input di controller, prepared statement PDO, output di-escape (`htmlspecialchars`)

## Syarat
PHP 8.1+ (ekstensi `pdo_mysql`) dan MySQL/MariaDB. Cara termudah: XAMPP.

## Cara menjalankan

1. Import database: buka phpMyAdmin → tab **Import** → pilih `database/schema.sql` → Go.
   (atau CLI: `mysql -u root -p < database/schema.sql`)
2. Cek `src/config/config.php` (default XAMPP: user `root`, password kosong).
3. Jalankan server:
   ```bash
   php -S localhost:8000 -t public public/index.php
   ```
   Buka http://localhost:8000
   
   Kalau pakai XAMPP Apache: taruh folder ini di `htdocs/`, lalu buka
   `http://localhost/cafe-admin/public/`

## Tabel rute

| Method | Path | Controller@method | Fungsi |
|---|---|---|---|
| GET | `/` | DashboardController@index | Dashboard |
| GET | `/menu` | MenuController@index | Daftar menu (Read) |
| GET | `/menu/tambah` | MenuController@tambah | Form tambah |
| GET | `/menu/edit?id=` | MenuController@edit | Form edit |
| POST | `/menu/simpan` | MenuController@simpan | Create |
| POST | `/menu/update` | MenuController@update | Update |
| POST | `/menu/hapus` | MenuController@hapus | Delete |
| GET | `/kategori` | KategoriController@index | Daftar kategori |
| GET | `/kategori/tambah` | KategoriController@tambah | Form tambah |
| GET | `/kategori/edit?id=` | KategoriController@edit | Form edit |
| POST | `/kategori/simpan` | KategoriController@simpan | Create |
| POST | `/kategori/update` | KategoriController@update | Update |
| POST | `/kategori/hapus` | KategoriController@hapus | Delete |

## Struktur folder

```
cafe-admin/
├─ public/                 # SATU-satunya folder yang diakses web
│  ├─ index.php            # front controller + tabel rute
│  ├─ .htaccess            # semua request → index.php
│  └─ css/style.css
├─ src/
│  ├─ Core/                # Router, Controller dasar, Database (PDO)
│  ├─ Controllers/         # Dashboard, Menu, Kategori
│  ├─ Models/              # MenuModel, KategoriModel (semua SQL di sini)
│  ├─ config/config.php    # pengaturan database
│  └─ helpers.php          # e(), url(), rupiah(), old(), pullFlash()
├─ views/                  # tampilan saja (tanpa SQL)
│  ├─ layout/ dashboard/ menu/ kategori/ errors/
└─ database/schema.sql     # struktur tabel + data contoh
```