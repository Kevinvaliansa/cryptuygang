<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Crypto Market' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.4.4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.3.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-chart-financial@0.2.0"></script>
</head>
<body class="<?= $_COOKIE['theme'] ?? 'light' ?>">
<header>
    <div class="header-content">
        <div class="logo-nav">
            <h2>📈 Crypto Market</h2>
            <nav><a href="index.php">Pasar</a><a href="swap.php">Swap</a></nav>
        </div>
        <button onclick="toggleTheme()" class="theme-btn">🌓</button>
    </div>
</header>