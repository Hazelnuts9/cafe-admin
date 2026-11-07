<?php
declare(strict_types=1);

if (PHP_SAPI === 'cli-server') {
    $file = __DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if (is_file($file)) {
        return false;
    }
}

session_start();

define('BASE_PATH', dirname(__DIR__));
define('BASE_URL', rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/'));

// Autoloader sederhana: Cafe\Core\Router => src/Core/Router.php
spl_autoload_register(function (string $class): void {
    $prefix = 'Cafe\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $file = BASE_PATH . '/src/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

require BASE_PATH . '/src/helpers.php';

use Cafe\Controllers\DashboardController;
use Cafe\Controllers\KategoriController;
use Cafe\Controllers\MenuController;
use Cafe\Core\Router;

$router = new Router();

// Tabel rute: METHOD + path => [Controller, method]
$router->get('/',                [DashboardController::class, 'index']);

$router->get('/menu',            [MenuController::class, 'index']);
$router->get('/menu/tambah',     [MenuController::class, 'tambah']);
$router->get('/menu/edit',       [MenuController::class, 'edit']);
$router->post('/menu/simpan',    [MenuController::class, 'simpan']);
$router->post('/menu/update',    [MenuController::class, 'update']);
$router->post('/menu/hapus',     [MenuController::class, 'hapus']);

$router->get('/kategori',            [KategoriController::class, 'index']);
$router->get('/kategori/tambah',     [KategoriController::class, 'tambah']);
$router->get('/kategori/edit',       [KategoriController::class, 'edit']);
$router->post('/kategori/simpan',    [KategoriController::class, 'simpan']);
$router->post('/kategori/update',    [KategoriController::class, 'update']);
$router->post('/kategori/hapus',     [KategoriController::class, 'hapus']);

// ---------- Ambil path bersih lalu dispatch ----------
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
if (BASE_URL !== '' && str_starts_with($uri, BASE_URL)) {
    $uri = substr($uri, strlen(BASE_URL));
}
$uri = '/' . trim($uri, '/');
if ($uri === '/index.php') {
    $uri = '/';
}

$router->dispatch($_SERVER['REQUEST_METHOD'], $uri);
