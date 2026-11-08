<?php
/**
 * @var string $title
 * @var string $username
 * @var array<string, string> $error
 */
$flash = pullFlash();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?> — Kopi Senja Admin</title>
    <link rel="stylesheet" href="<?= url('/css/style.css') ?>">
</head>
<body class="login-page">
<main class="login-card">
    <div class="login-brand">
        <span class="brand-name">Kopi Senja</span>
        <span class="brand-sub">Masuk ke panel admin</span>
    </div>

    <?php if ($flash): ?>
        <div class="alert alert-<?= e($flash['type']) ?>" role="status"><?= e($flash['msg']) ?></div>
    <?php endif; ?>
    <?php if (isset($errors['umum'])): ?>
        <div class="alert alert-error" role="alert"><?= e($errors['umum']) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= url('/login') ?>" novalidate>
        <div class="field <?= isset($errors['username']) ? 'has-error' : '' ?>">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= e($username) ?>"
                   autocomplete="username" autofocus required>
            <?php if (isset($errors['username'])): ?><p class="error"><?= e($errors['username']) ?></p><?php endif; ?>
        </div>

        <div class="field <?= isset($errors['password']) ? 'has-error' : '' ?>">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="current-password" required>
            <?php if (isset($errors['password'])): ?><p class="error"><?= e($errors['password']) ?></p><?php endif; ?>
        </div>

        <button class="btn btn-block" type="submit">Masuk</button>
    </form>
</main>
</body>
</html>
