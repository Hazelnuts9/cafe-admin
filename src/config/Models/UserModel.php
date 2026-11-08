<?php
declare(strict_types=1);

namespace Cafe\Models;

use PDO;

/** MODEL User — SQL tabel `users` (prepared statement). */
class UserModel
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, nama, username, password_hash FROM users WHERE username = :username'
        );
        $stmt->execute(['username' => $username]);
        return $stmt->fetch() ?: null;
    }
}
