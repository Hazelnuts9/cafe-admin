<?php
declare(strict_types=1);

namespace Cafe\Models;

use PDO;

/** MODEL Menu — semua SQL tabel `menu` ada di sini (prepared statement). */
class MenuModel
{
    public const BATAS_STOK_MENIPIS = 5;

    public function __construct(private PDO $pdo)
    {
    }

    public function all(string $cari = ''): array
    {
        $sql = 'SELECT m.id, m.nama, m.harga, m.stok, k.nama AS kategori
                FROM menu m
                JOIN kategori k ON k.id = m.kategori_id';
        $params = [];

        if ($cari !== '') {
            $sql .= ' WHERE m.nama LIKE :cari';
            $params['cari'] = '%' . $cari . '%';
        }

        $sql .= ' ORDER BY m.id DESC';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, nama, harga, stok, kategori_id FROM menu WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function create(array $d): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO menu (nama, harga, stok, kategori_id) VALUES (:nama, :harga, :stok, :kategori_id)'
        );
        $stmt->execute([
            'nama'        => $d['nama'],
            'harga'       => $d['harga'],
            'stok'        => $d['stok'],
            'kategori_id' => $d['kategori_id'],
        ]);
    }

    public function update(int $id, array $d): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE menu SET nama = :nama, harga = :harga, stok = :stok, kategori_id = :kategori_id WHERE id = :id'
        );
        $stmt->execute([
            'nama'        => $d['nama'],
            'harga'       => $d['harga'],
            'stok'        => $d['stok'],
            'kategori_id' => $d['kategori_id'],
            'id'          => $id,
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM menu WHERE id = :id');
        $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM menu')->fetchColumn();
    }

    public function totalStok(): int
    {
        return (int) $this->pdo->query('SELECT COALESCE(SUM(stok), 0) FROM menu')->fetchColumn();
    }

    public function stokMenipis(): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT m.id, m.nama, m.stok, k.nama AS kategori
             FROM menu m
             JOIN kategori k ON k.id = m.kategori_id
             WHERE m.stok <= :batas
             ORDER BY m.stok ASC, m.nama ASC'
        );
        $stmt->execute(['batas' => self::BATAS_STOK_MENIPIS]);
        return $stmt->fetchAll();
    }
}
