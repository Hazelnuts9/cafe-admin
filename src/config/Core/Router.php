<?php
declare(strict_types=1);

namespace Cafe\Core;

/** ROUTER — mencocokkan METHOD + path ke [Controller, method]. */
class Router
{
    /** Rute yang boleh dibuka tanpa login. */
    private const RUTE_PUBLIK = ['/login'];

    private array $rute = [];

    public function get(string $path, array $aksi): void
    {
        $this->rute['GET'][$path] = $aksi;
    }

    public function post(string $path, array $aksi): void
    {
        $this->rute['POST'][$path] = $aksi;
    }

    public function dispatch(string $method, string $path): void
    {
        // SATPAM: selain halaman login, semua rute wajib login
        if (!Auth::cek() && !in_array($path, self::RUTE_PUBLIK, true)) {
            header('Location: ' . url('/login'));
            exit;
        }

        $aksi = $this->rute[$method][$path] ?? null;

        if ($aksi === null) {
            http_response_code(404);
            require BASE_PATH . '/views/errors/404.php';
            return;
        }

        [$kelas, $namaMethod] = $aksi;
        (new $kelas())->$namaMethod();
    }
}
