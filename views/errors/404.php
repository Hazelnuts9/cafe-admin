<?php $title = 'Halaman tidak ditemukan'; $active = ''; require BASE_PATH . '/views/layout/header.php'; ?>

<div class="page-head">
    <h1>Halaman tidak ditemukan</h1>
</div>
<p class="muted">Alamat yang kamu buka tidak ada atau datanya sudah dihapus.</p>
<p><a class="btn" href="<?= url('/') ?>">Kembali ke dashboard</a></p>

<?php require BASE_PATH . '/views/layout/footer.php'; ?>
