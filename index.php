<?php
require_once __DIR__ . "/api/coingecko.php";
$pageTitle = "Top 40 Market";
include "includes/header.php";
$coins = getMarketCoins(40);
?>

<div class="controls" style="padding: 20px 5% 0; display: flex; gap: 10px; justify-content: flex-end;">
    <button class="btn-view" onclick="setView('grid')">🔳 Grid</button>
    <button class="btn-view" onclick="setView('list')">≡ List</button>
</div>

<main>
    <div id="coinGrid" class="grid"> <?php foreach ($coins as $key => $coin): 
            $change = $coin['price_change_percentage_24h'] ?? 0;
            $class = ($change >= 0) ? 'up' : 'down';
        ?>
        <a class="card" href="coin.php?id=<?= $coin['id'] ?>">
            <div class="coin-rank">#<?= $key + 1 ?></div>
            <div class="card-content">
                <img src="<?= $coin['image'] ?>" alt="<?= $coin['name'] ?>">
                <div class="coin-info">
                    <h3><?= $coin['name'] ?> <span class="symbol"><?= strtoupper($coin['symbol']) ?></span></h3>
                    <div class="price-info">
                        <span class="price">$<?= number_format($coin['current_price'], 2) ?></span>
                        <span class="<?= $class ?>"><?= number_format($change, 2) ?>%</span>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</main>

<?php include "includes/footer.php"; ?>