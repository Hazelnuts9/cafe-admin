<?php
declare(strict_types=1);

namespace Cafe\Controllers;

use Cafe\Core\Controller;
use Cafe\Core\Database;
use Cafe\Models\KategoriModel;
use Cafe\Models\MenuModel;

class DashboardController extends Controller
{
    public function index(): void
    {
        $pdo      = Database::connection();
        $menu     = new MenuModel($pdo);
        $kategori = new KategoriModel($pdo);

        $this->view('dashboard/index', [
            'title'        => 'Dashboard',
            'active'       => 'dashboard',
            'totalMenu'    => $menu->count(),
            'totalKategori' => $kategori->count(),
            'totalStok'    => $menu->totalStok(),
            'menipis'      => $menu->stokMenipis(),
            'perKategori'  => $kategori->allWithCount(),
        ]);
    }
}
