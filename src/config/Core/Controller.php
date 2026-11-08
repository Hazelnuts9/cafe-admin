<?php
declare(strict_types=1);

namespace Cafe\Core;

/** Controller dasar: alat bantu untuk menampilkan View, redirect, dan pesan flash. */
abstract class Controller
{
    protected function view(string $__view, array $__vars = [], int $__status = 200): void
    {
        http_response_code($__status);
        extract($__vars); // tiap key array jadi variabel di View: ['title' => 'X'] => $title
        require BASE_PATH . '/views/' . $__view . '.php';
    }

    protected function redirect(string $path): never
    {
        header('Location: ' . url($path));
        exit;
    }

    protected function flash(string $tipe, string $pesan): void
    {
        $_SESSION['flash'] = ['type' => $tipe, 'msg' => $pesan];
    }

    protected function notFound(): never
    {
        http_response_code(404);
        require BASE_PATH . '/views/errors/404.php';
        exit;
    }
}
