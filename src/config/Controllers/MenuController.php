<?php
declare(strict_types=1);

namespace Cafe\Controllers;

use Cafe\Core\Controller;
use Cafe\Core\Database;
use Cafe\Models\KategoriModel;
use Cafe\Models\MenuModel;

class MenuController extends Controller
{
    private MenuModel $menu;
    private KategoriModel $kategori;

    public function __construct()
    {
        $pdo            = Database::connection();
        $this->menu     = new MenuModel($pdo);
        $this->kategori = new KategoriModel($pdo);
    }

    // GET /menu?q=kopi — daftar + pencarian (Read)
    public function index(): void
    {
        $cari = trim((string) ($_GET['q'] ?? ''));

        $this->view('menu/index', [
            'title'  => 'Menu',
            'active' => 'menu',
            'cari'   => $cari,
            'daftar' => $this->menu->all($cari),
        ]);
    }

    // GET /menu/tambah — form kosong
    public function tambah(): void
    {
        $this->tampilForm('tambah', ['nama' => '', 'harga' => '', 'stok' => '0', 'kategori_id' => ''], []);
    }

    // POST /menu/simpan — Create
    public function simpan(): void
    {
        [$data, $errors] = $this->validasi($_POST);

        if ($errors) {
            $this->tampilForm('tambah', $data, $errors, 422);
            return;
        }

        $this->menu->create($data);
        $this->flash('success', 'Menu "' . $data['nama'] . '" berhasil ditambahkan.');
        $this->redirect('/menu');
    }

    // GET /menu/edit?id=1 — form berisi data lama
    public function edit(): void
    {
        $row = $this->menu->find((int) ($_GET['id'] ?? 0)) ?? $this->notFound();
        $this->tampilForm('edit', $row, []);
    }

    // POST /menu/update — Update
    public function update(): void
    {
        $id = (int) ($_POST['id'] ?? 0);
        $this->menu->find($id) ?? $this->notFound();

        [$data, $errors] = $this->validasi($_POST);

        if ($errors) {
            $this->tampilForm('edit', $data + ['id' => $id], $errors, 422);
            return;
        }

        $this->menu->update($id, $data);
        $this->flash('success', 'Menu "' . $data['nama'] . '" berhasil diperbarui.');
        $this->redirect('/menu');
    }

    // POST /menu/hapus — Delete
    public function hapus(): void
    {
        $id  = (int) ($_POST['id'] ?? 0);
        $row = $this->menu->find($id) ?? $this->notFound();

        $this->menu->delete($id);
        $this->flash('success', 'Menu "' . $row['nama'] . '" dihapus.');
        $this->redirect('/menu');
    }

    // ---------- helper privat ----------

    private function tampilForm(string $mode, array $data, array $errors, int $status = 200): void
    {
        $this->view('menu/form', [
            'title'    => $mode === 'edit' ? 'Edit Menu' : 'Tambah Menu',
            'active'   => 'menu',
            'mode'     => $mode,
            'data'     => $data,
            'errors'   => $errors,
            'kategori' => $this->kategori->all(),
        ], $status);
    }

    /** @return array{0: array<string,string>, 1: array<string,string>} [data bersih, daftar error] */
    private function validasi(array $in): array
    {
        $errors = [];

        $data = [
            'nama'        => trim((string) ($in['nama'] ?? '')),
            'harga'       => trim((string) ($in['harga'] ?? '')),
            'stok'        => trim((string) ($in['stok'] ?? '')),
            'kategori_id' => trim((string) ($in['kategori_id'] ?? '')),
        ];

        if ($data['nama'] === '') {
            $errors['nama'] = 'Nama menu wajib diisi.';
        } elseif (panjang($data['nama']) < 3 || panjang($data['nama']) > 100) {
            $errors['nama'] = 'Nama menu harus 3–100 karakter.';
        }

        if ($data['harga'] === '') {
            $errors['harga'] = 'Harga wajib diisi.';
        } elseif (!ctype_digit($data['harga']) || (int) $data['harga'] <= 0 || (int) $data['harga'] > 10000000) {
            $errors['harga'] = 'Harga harus angka bulat antara 1 dan 10.000.000.';
        }

        if ($data['stok'] === '') {
            $errors['stok'] = 'Stok wajib diisi.';
        } elseif (!ctype_digit($data['stok']) || (int) $data['stok'] > 100000) {
            $errors['stok'] = 'Stok harus angka bulat 0 atau lebih (maksimal 100.000).';
        }

        if ($data['kategori_id'] === '') {
            $errors['kategori_id'] = 'Pilih salah satu kategori.';
        } elseif (!ctype_digit($data['kategori_id']) || $this->kategori->find((int) $data['kategori_id']) === null) {
            $errors['kategori_id'] = 'Kategori tidak ditemukan.';
        }

        return [$data, $errors];
    }
}
