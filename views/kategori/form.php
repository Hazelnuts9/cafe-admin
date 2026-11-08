<?php require BASE_PATH . '/views/layout/header.php'; ?>

<div class="page-head">
    <h1><?= $mode === 'edit' ? 'Edit kategori' : 'Tambah kategori' ?></h1>
</div>

<section class="panel form-panel">
    <form method="post" action="<?= url($mode === 'edit' ? '/kategori/update' : '/kategori/simpan') ?>" novalidate>
        <?php if ($mode === 'edit'): ?>
            <input type="hidden" name="id" value="<?= (int) $data['id'] ?>">
        <?php endif; ?>

        <div class="field <?= isset($errors['nama']) ? 'has-error' : '' ?>">
            <label for="nama">Nama kategori</label>
            <input type="text" id="nama" name="nama" maxlength="50" value="<?= old($data, 'nama') ?>" required>
            <?php if (isset($errors['nama'])): ?><p class="error"><?= e($errors['nama']) ?></p><?php endif; ?>
        </div>

        <div class="form-actions">
            <button class="btn" type="submit"><?= $mode === 'edit' ? 'Simpan perubahan' : 'Simpan kategori' ?></button>
            <a class="link" href="<?= url('/kategori') ?>">Batal</a>
        </div>
    </form>
</section>

<?php require BASE_PATH . '/views/layout/footer.php'; ?>
