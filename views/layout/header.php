<?php $flash = pullFlash(); $active = $active ?? ''; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Admin') ?> — Kopi Senja Admin</title>
    <link rel="stylesheet" href="<?= url('/css/style.css') ?>">
</head>
<body>
<div class="app">
    <aside class="sidebar">
        <a class="brand" href="<?= url('/') ?>">
            <span class="brand-name">Kopi Senja</span>
            <span class="brand-sub">Panel admin kafe</span>
        </a>
        <nav class="nav" aria-label="Menu utama">
            <a href="<?= url('/') ?>" class="<?= $active === 'dashboard' ? 'is-active' : '' ?>">Dashboard</a>
            <a href="<?= url('/menu') ?>" class="<?= $active === 'menu' ? 'is-active' : '' ?>">Menu</a>
            <a href="<?= url('/kategori') ?>" class="<?= $active === 'kategori' ? 'is-active' : '' ?>">Kategori</a>
        </nav>
        <div class="userbox">
            <span class="userbox-name"><?= e(\Cafe\Core\Auth::user()['nama'] ?? '') ?></span>
            <form method="post" action="<?= url('/logout') ?>">
                <button class="link" type="submit">Keluar</button>
            </form>
        </div>
    </aside>
    <main class="content">
        <?php if ($flash): ?>
            <div class="alert alert-<?= e($flash['type']) ?>" role="status"><?= e($flash['msg']) ?></div>
        <?php endif; ?>