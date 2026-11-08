<?php
declare(strict_types=1);

namespace Cafe\Core;

use PDO;
use PDOException;

/** Koneksi PDO — dibuat sekali, dipakai ulang. */
final class Database
{
    private static ?PDO $pdo = null;

    public static function connection(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        $c = (require BASE_PATH . '/src/config/config.php')['db'];
        $dsn = "mysql:host={$c['host']};port={$c['port']};dbname={$c['name']};charset={$c['charset']}";

        try {
            self::$pdo = new PDO($dsn, $c['user'], $c['pass'], [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException) {
            http_response_code(500);
            exit('Koneksi database gagal. Pastikan MySQL menyala, database cafe_admin sudah di-import, '
                . 'dan cek pengaturan di src/config/config.php.');
        }

        return self::$pdo;
    }
}
