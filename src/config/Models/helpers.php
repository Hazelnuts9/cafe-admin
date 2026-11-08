<?php
declare(strict_types=1);

/** Escape output supaya aman dari XSS. Pakai di SEMUA data yang ditampilkan di View. */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

/** Bikin URL yang benar, baik di php -S maupun di XAMPP (subfolder). */
function url(string $path = '/'): string
{
    return BASE_URL . $path;
}

/** 25000 => "Rp 25.000" */
function rupiah(int|string $angka): string
{
    return 'Rp ' . number_format((int) $angka, 0, ',', '.');
}

/** Nilai lama form (setelah validasi gagal), sudah di-escape. */
function old(array $data, string $key): string
{
    return e($data[$key] ?? '');
}

/** Ambil pesan flash sekali pakai (hilang setelah dibaca). */
function pullFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

/** Panjang teks (aman untuk huruf non-ASCII; tetap jalan walau ekstensi mbstring mati). */
function panjang(string $teks): int
{
    return function_exists('mb_strlen') ? mb_strlen($teks) : strlen($teks);
}
