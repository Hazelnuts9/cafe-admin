<?php
declare(strict_types=1);

namespace Cafe\Controllers;

use Cafe\Core\Controller;
use Cafe\Core\Database;
use Cafe\Models\KategoriModel;

class KategoriController extends Controller
{
    private KategoriModel $model;

    public function __construct()
    {
        $this->model = new KategoriModel(Database::connection());
    }

    // GET /kategori — daftar (Read)
    public function index(): void
    {
        $this->view('kategori/index', [
            'title'  => 'Kategori',
            'active' => 'kategori',
            'daftar' => $this->model->allWithCount(),
        ]);
    }

    // GET /kategori/tambah — form kosong
    public function tambah(): void
    {
        $this->tampilForm('tambah', ['nama' => ''], []);
    }

    // POST /kategori/simpan — Create
    public function simpan(): void
    {
        [$nama, $errors] = $this->validasi($_POST);

        if ($errors) {
            $this->tampilForm('tambah', ['nama' => $nama], $errors, 422);
            return;
        }

        $this->model->create($nama);
        $this->flash('success', 'Kategori "' . $nama . '" berhasil ditambahkan.');
        $this->redirect('/kategori');
    }

    // GET /kategori/edit?id=1 — form berisi data lama
    public function edit(): void
    {
        $row = $this->model->find((int) ($_GET['id'] ?? 0)) ?? $this->notFound();
        $this->tampilForm('edit', $row, []);
    }

    // POST /kategori/update — Update
    public function update(): void
    {
        $id  = (int) ($_POST['id'] ?? 0);
        $row = $this->model->find($id) ?? $this->notFound();

        [$nama, $errors] = $this->validasi($_POST, $id);

        if ($errors) {
            $this->tampilForm('edit', ['id' => $row['id'], 'nama' => $nama], $errors, 422);
            return;
        }

        $this->model->update($id, $nama);
        $this->flash('success', 'Kategori berhasil diperbarui.');
        $this->redirect('/kategori');
    }

    // POST /kategori/hapus — Delete
    public function hapus(): void
    {
        $id  = (int) ($_POST['id'] ?? 0);
        $row = $this->model->find($id) ?? $this->notFound();

        if ($this->model->jumlahMenu($id) > 0) {
            $this->flash('error', 'Kategori "' . $row['nama'] . '" masih dipakai menu. Pindahkan atau hapus menunya dulu.');
            $this->redirect('/kategori');
        }

        $this->model->delete($id);
        $this->flash('success', 'Kategori "' . $row['nama'] . '" dihapus.');
        $this->redirect('/kategori');
    }

    // ---------- helper privat ----------

    private function tampilForm(string $mode, array $data, array $errors, int $status = 200): void
    {
        $this->view('kategori/form', [
            'title'  => $mode === 'edit' ? 'Edit Kategori' : 'Tambah Kategori',
            'active' => 'kategori',
            'mode'   => $mode,
            'data'   => $data,
            'errors' => $errors,
        ], $status);
    }

    /** @return array{0: string, 1: array<string,string>} [nama bersih, daftar error] */
    private function validasi(array $in, int $kecualiId = 0): array
    {
        $errors = [];
        $nama   = trim((string) ($in['nama'] ?? ''));

        if ($nama === '') {
            $errors['nama'] = 'Nama kategori wajib diisi.';
        } elseif (panjang($nama) < 3 || panjang($nama) > 50) {
            $errors['nama'] = 'Nama kategori harus 3–50 karakter.';
        } elseif ($this->model->namaSudahAda($nama, $kecualiId)) {
            $errors['nama'] = 'Nama kategori sudah dipakai. Gunakan nama lain.';
        }

        return [$nama, $errors];
    }
}
