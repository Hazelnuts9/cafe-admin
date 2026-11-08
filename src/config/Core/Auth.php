<?php
declare(strict_types=1);

namespace Cafe\Core;

/** AUTH — urusan "sudah login atau belum", disimpan di session. */
final class Auth
{
    public static function cek(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function masuk(array $user): void
    {
        session_regenerate_id(true); // ID session baru: cegah session fixation
        $_SESSION['user'] = [
            'id'       => (int) $user['id'],
            'nama'     => (string) $user['nama'],
            'username' => (string) $user['username'],
        ];
    }

    public static function keluar(): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);
    }
}
