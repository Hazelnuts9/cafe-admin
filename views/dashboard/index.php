<?php require BASE_PATH . '/views/layout/header.php'; ?>

<div class="page-head">
    <h1>Dashboard</h1>
    <a class="btn" href="<?= url('/menu/tambah') ?>">Tambah menu</a>
</div>

<section class="stats">
    <div class="stat">
        <span class="stat-label">Total menu</span>
        <span class="stat-value"><?= e($totalMenu) ?></span>
    </div>
    <div class="stat">
        <span class="stat-label">Total kategori</span>
        <span class="stat-value"><?= e($totalKategori) ?></span>
    </div>
    <div class="stat">
        <span class="stat-label">Total stok</span>
        <span class="stat-value"><?= e($totalStok) ?></span>
    </div>
    <div class="stat <?= count($menipis) > 0 ? 'stat-warn' : '' ?>">
        <span class="stat-label">Stok menipis</span>
        <span class="stat-value"><?= count($menipis) ?></span>
    </div>
</section>

<div class="two-col">
    <section class="panel">
        <h2>Perlu diisi ulang</h2>
        <?php if (!$menipis): ?>
            <p class="muted">Semua stok aman.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Menu</th><th>Kategori</th><th class="num">Sisa</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($menipis as $m): ?>
                        <tr>
                            <td><?= e($m['nama']) ?></td>
                            <td><?= e($m['kategori']) ?></td>
                            <td class="num"><span class="badge badge-warn"><?= e($m['stok']) ?></span></td>
                            <td class="aksi"><a href="<?= url('/menu/edit?id=' . (int) $m['id']) ?>">Isi stok</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>

    <section class="panel">
        <h2>Menu per kategori</h2>
        <?php if (!$perKategori): ?>
            <p class="muted">Belum ada kategori.</p>
        <?php else: ?>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Kategori</th><th class="num">Jumlah menu</th></tr></thead>
                    <tbody>
                    <?php foreach ($perKategori as $k): ?>
                        <tr>
                            <td><?= e($k['nama']) ?></td>
                            <td class="num"><?= e($k['jumlah_menu']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php require BASE_PATH . '/views/layout/footer.php'; ?>
