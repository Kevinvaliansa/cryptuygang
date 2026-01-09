<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Crypto Market' ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="<?= $_COOKIE['theme'] ?? 'light' ?>">

<header>
    <div class="header-content">
        <div class="logo-nav">
            <h2>📈 Crypto Market</h2>
            <nav>
                <a href="index.php">Pasar</a>
                <a href="swap.php">Swap</a>
            </nav>
        </div>
        <button onclick="toggleTheme()" class="theme-btn">🌓</button>
    </div>
</header>