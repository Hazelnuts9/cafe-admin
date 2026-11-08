<?php
declare(strict_types=1);

namespace Cafe\Models;

use PDO;

/** MODEL Kategori — semua SQL tabel `kategori` ada di sini (prepared statement). */
class KategoriModel
{
    public function __construct(private PDO $pdo)
    {
    }

    public function all(): array
    {
        return $this->pdo->query('SELECT id, nama FROM kategori ORDER BY nama')->fetchAll();
    }

    public function allWithCount(): array
    {
        $sql = 'SELECT k.id, k.nama, COUNT(m.id) AS jumlah_menu
                FROM kategori k
                LEFT JOIN menu m ON m.kategori_id = k.id
                GROUP BY k.id, k.nama
                ORDER BY k.nama';
        return $this->pdo->query($sql)->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, nama FROM kategori WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function namaSudahAda(string $nama, int $kecualiId = 0): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM kategori WHERE nama = :nama AND id <> :id');
        $stmt->execute(['nama' => $nama, 'id' => $kecualiId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function create(string $nama): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO kategori (nama) VALUES (:nama)');
        $stmt->execute(['nama' => $nama]);
    }

    public function update(int $id, string $nama): void
    {
        $stmt = $this->pdo->prepare('UPDATE kategori SET nama = :nama WHERE id = :id');
        $stmt->execute(['nama' => $nama, 'id' => $id]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM kategori WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function jumlahMenu(int $id): int
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM menu WHERE kategori_id = :id');
        $stmt->execute(['id' => $id]);
        return (int) $stmt->fetchColumn();
    }

    public function count(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM kategori')->fetchColumn();
    }
}
