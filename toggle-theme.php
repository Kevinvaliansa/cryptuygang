<?php
// Mengambil data tema dari URL
$theme = $_GET['theme'] ?? 'light';

// Simpan pilihan di Cookie selama 30 hari
setcookie('theme', $theme, time() + (86400 * 30), "/");

echo "Success";
?>