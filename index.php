<?php
require_once __DIR__ . "/api/coingecko.php";
$pageTitle = "Top 40 Market";
include "includes/header.php";
$coins = getMarketCoins(40);
?>
<div class="controls" style="padding: 20px 5% 0; display: flex; gap: 10px; align-items: center;">
    <input type="text" id="searchInput" placeholder="Cari koin..." onkeyup="searchCoin()" style="flex-grow: 1; padding: 10px; border-radius: 10px; border: 1px solid #ddd;">
    <button class="btn-view" onclick="setView('grid')">🔳</button>
    <button class="btn-view" onclick="setView('list')">≡</button>
</div>
<main>
    <div id="coinGrid" class="grid">
        <?php foreach ($coins as $key => $coin): ?>
        <a class="card" href="coin.php?id=<?= $coin['id'] ?>">
            <div class="star-icon" data-id="<?= $coin['id'] ?>" onclick="toggleWatchlist('<?= $coin['id'] ?>', event)">☆</div>
            <div class="coin-rank">#<?= $key + 1 ?></div>
            <div class="card-content">
                <img src="<?= $coin['image'] ?>">
                <h3><?= $coin['name'] ?></h3>
                <p>$<?= number_format($coin['current_price'], 2) ?></p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</main>
<script src="assets/js/main.js"></script>
<?php include "includes/footer.php"; ?>