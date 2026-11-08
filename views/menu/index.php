<?php require BASE_PATH . '/views/layout/header.php'; ?>

<div class="page-head">
    <h1>Menu</h1>
    <a class="btn" href="<?= url('/menu/tambah') ?>">Tambah menu</a>
</div>

<form class="search" method="get" action="<?= url('/menu') ?>">
    <label class="sr-only" for="q">Cari menu</label>
    <input type="search" id="q" name="q" value="<?= e($cari) ?>" placeholder="Cari nama menu">
    <button class="btn btn-ghost" type="submit">Cari</button>
    <?php if ($cari !== ''): ?><a class="link" href="<?= url('/menu') ?>">Reset</a><?php endif; ?>
</form>

<section class="panel">
    <?php if (!$daftar): ?>
        <p class="muted">
            <?= $cari !== '' ? 'Tidak ada menu dengan nama "' . e($cari) . '".' : 'Belum ada menu. Tambahkan menu pertama kafe kamu.' ?>
        </p>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Nama</th><th>Kategori</th><th class="num">Harga</th><th class="num">Stok</th><th class="aksi">Aksi</th></tr>
                </thead>
                <tbody>
                <?php foreach ($daftar as $m): ?>
                    <tr>
                        <td><?= e($m['nama']) ?></td>
                        <td><?= e($m['kategori']) ?></td>
                        <td class="num"><?= e(rupiah($m['harga'])) ?></td>
                        <td class="num">
                            <span class="badge <?= (int) $m['stok'] <= \Cafe\Models\MenuModel::BATAS_STOK_MENIPIS ? 'badge-warn' : '' ?>">
                                <?= e($m['stok']) ?>
                            </span>
                        </td>
                        <td class="aksi">
                            <a href="<?= url('/menu/edit?id=' . (int) $m['id']) ?>">Edit</a>
                            <form method="post" action="<?= url('/menu/hapus') ?>"
                                  data-konfirmasi="Hapus menu &quot;<?= e($m['nama']) ?>&quot;?">
                                <input type="hidden" name="id" value="<?= (int) $m['id'] ?>">
                                <button class="link link-danger" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>

<?php require BASE_PATH . '/views/layout/footer.php'; ?>
