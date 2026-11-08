<?php require BASE_PATH . '/views/layout/header.php'; ?>

<div class="page-head">
    <h1>Kategori</h1>
    <a class="btn" href="<?= url('/kategori/tambah') ?>">Tambah kategori</a>
</div>

<section class="panel">
    <?php if (!$daftar): ?>
        <p class="muted">Belum ada kategori. Tambahkan kategori pertama, misalnya Kopi atau Camilan.</p>
    <?php else: ?>
        <div class="table-wrap">
            <table>
                <thead><tr><th>Nama kategori</th><th class="num">Jumlah menu</th><th class="aksi">Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($daftar as $k): ?>
                    <tr>
                        <td><?= e($k['nama']) ?></td>
                        <td class="num"><?= e($k['jumlah_menu']) ?></td>
                        <td class="aksi">
                            <a href="<?= url('/kategori/edit?id=' . (int) $k['id']) ?>">Edit</a>
                            <form method="post" action="<?= url('/kategori/hapus') ?>"
                                  data-konfirmasi="Hapus kategori &quot;<?= e($k['nama']) ?>&quot;?">
                                <input type="hidden" name="id" value="<?= (int) $k['id'] ?>">
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
