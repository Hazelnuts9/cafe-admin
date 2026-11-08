<?php
declare(strict_types=1);

namespace Cafe\Controllers;

use Cafe\Core\Auth;
use Cafe\Core\Controller;
use Cafe\Core\Database;
use Cafe\Models\UserModel;

class AuthController extends Controller
{
    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel(Database::connection());
    }

    // GET /login — tampilkan form
    public function form(): void
    {
        if (Auth::cek()) {
            $this->redirect('/');
        }
        $this->tampilForm('', []);
    }

    // POST /login — cek username + password
    public function proses(): void
    {
        if (Auth::cek()) {
            $this->redirect('/');
        }

        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $errors   = [];

        if ($username === '') {
            $errors['username'] = 'Username wajib diisi.';
        }
        if ($password === '') {
            $errors['password'] = 'Password wajib diisi.';
        }

        $user = null;
        if (!$errors) {
            $user = $this->model->findByUsername($username);

            // Tetap menghitung hash walau user tidak ada, supaya waktu responsnya sama
            $hash = $user['password_hash'] ?? password_hash('palsu', PASSWORD_DEFAULT);

            if (!password_verify($password, $hash) || $user === null) {
                // Pesan sengaja dibuat sama, agar orang luar tidak bisa menebak username
                $errors['umum'] = 'Username atau password salah.';
            }
        }

        if ($errors) {
            $this->tampilForm($username, $errors, 422);
            return;
        }

        Auth::masuk($user);
        $this->flash('success', 'Selamat datang, ' . $user['nama'] . '.');
        $this->redirect('/');
    }

    // POST /logout
    public function keluar(): void
    {
        Auth::keluar();
        $this->flash('success', 'Kamu sudah keluar.');
        $this->redirect('/login');
    }

    private function tampilForm(string $username, array $errors, int $status = 200): void
    {
        $this->view('auth/login', [
            'title'    => 'Masuk',
            'username' => $username,
            'errors'   => $errors,
        ], $status);
    }
}
