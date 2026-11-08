<?php require BASE_PATH . '/views/layout/header.php'; ?>

<div class="page-head">
    <h1><?= $mode === 'edit' ? 'Edit menu' : 'Tambah menu' ?></h1>
</div>

<?php if (!$kategori): ?>
    <section class="panel">
        <p>Kategori masih kosong. Buat kategori dulu sebelum menambah menu.</p>
        <p><a class="btn" href="<?= url('/kategori/tambah') ?>">Tambah kategori</a></p>
    </section>
<?php else: ?>
    <section class="panel form-panel">
        <form method="post" action="<?= url($mode === 'edit' ? '/menu/update' : '/menu/simpan') ?>" novalidate>
            <?php if ($mode === 'edit'): ?>
                <input type="hidden" name="id" value="<?= (int) $data['id'] ?>">
            <?php endif; ?>

            <div class="field <?= isset($errors['nama']) ? 'has-error' : '' ?>">
                <label for="nama">Nama menu</label>
                <input type="text" id="nama" name="nama" maxlength="100" value="<?= old($data, 'nama') ?>" required>
                <?php if (isset($errors['nama'])): ?><p class="error"><?= e($errors['nama']) ?></p><?php endif; ?>
            </div>

            <div class="field <?= isset($errors['kategori_id']) ? 'has-error' : '' ?>">
                <label for="kategori_id">Kategori</label>
                <select id="kategori_id" name="kategori_id" required>
                    <option value="">Pilih kategori</option>
                    <?php foreach ($kategori as $k): ?>
                        <option value="<?= (int) $k['id'] ?>" <?= (string) ($data['kategori_id'] ?? '') === (string) $k['id'] ? 'selected' : '' ?>>
                            <?= e($k['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['kategori_id'])): ?><p class="error"><?= e($errors['kategori_id']) ?></p><?php endif; ?>
            </div>

            <div class="row">
                <div class="field <?= isset($errors['harga']) ? 'has-error' : '' ?>">
                    <label for="harga">Harga (Rp)</label>
                    <input type="text" inputmode="numeric" id="harga" name="harga" value="<?= old($data, 'harga') ?>" required>
                    <?php if (isset($errors['harga'])): ?><p class="error"><?= e($errors['harga']) ?></p><?php endif; ?>
                </div>
                <div class="field <?= isset($errors['stok']) ? 'has-error' : '' ?>">
                    <label for="stok">Stok</label>
                    <input type="text" inputmode="numeric" id="stok" name="stok" value="<?= old($data, 'stok') ?>" required>
                    <?php if (isset($errors['stok'])): ?><p class="error"><?= e($errors['stok']) ?></p><?php endif; ?>
                </div>
            </div>

            <div class="form-actions">
                <button class="btn" type="submit"><?= $mode === 'edit' ? 'Simpan perubahan' : 'Simpan menu' ?></button>
                <a class="link" href="<?= url('/menu') ?>">Batal</a>
            </div>
        </form>
    </section>
<?php endif; ?>

<?php require BASE_PATH . '/views/layout/footer.php'; ?>