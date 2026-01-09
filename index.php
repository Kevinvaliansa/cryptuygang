<?php
require_once __DIR__ . "/api/coingecko.php";
$pageTitle = "Top 40 Market";
include "includes/header.php";

$coins = getMarketCoins(40);
$trendingData = getTrendingCoins();
$trendingCoins = $trendingData['coins'] ?? [];
?>

<div style="padding: 20px 5% 0; display: flex; flex-wrap: wrap; gap: 15px; align-items: center;">
    <button class="btn-view" onclick="openModal()" style="display: flex; align-items: center; gap: 8px; background: var(--card-bg); border: 1px solid rgba(0,0,0,0.1); padding: 10px 15px; border-radius: 12px; cursor: pointer;">
        📊 <span style="font-weight: bold; font-size: 0.85rem;">Market Sentiment</span>
    </button>

    <div style="flex: 1; display: flex; gap: 10px; align-items: center; min-width: 250px;">
        <input type="text" id="searchInput" placeholder="Cari koin..." onkeyup="searchCoin()" style="flex-grow: 1; padding: 12px; border-radius: 12px; border: 1px solid rgba(0,0,0,0.1); background: var(--card-bg); color: var(--text);">
        <button class="btn-view" onclick="setView('grid')">🔳 Grid</button>
        <button class="btn-view" onclick="setView('list')">≡ List</button>
    </div>
</div>

<div id="indexModal" class="modal-overlay">
    <div class="modal-content">
        <span onclick="closeModal()" style="position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer; opacity: 0.5;">&times;</span>
        <h3 style="margin-top: 0;">Crypto Fear & Greed Index</h3>
        <p style="font-size: 0.85rem; opacity: 0.7; margin-bottom: 20px;">Indikator psikologi pasar saat ini</p>
        <img src="https://alternative.me/crypto/fear-and-greed-index.png" alt="Fear and Greed Index" style="width: 100%; border-radius: 12px;">
        <button onclick="closeModal()" class="btn-view" style="margin-top: 20px; width: 100%; padding: 12px; background: var(--accent); color: white; border: none; cursor: pointer;">Tutup</button>
    </div>
</div>

<div class="trending-container" style="padding: 15px 5% 0;">
    <div style="background: var(--card-bg); padding: 10px 20px; border-radius: 15px; display: flex; align-items: center; gap: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); overflow: hidden;">
        <span style="font-weight: bold; font-size: 0.8rem; white-space: nowrap; color: var(--text);">🔥 Trending:</span>
        <div style="display: flex; gap: 12px; overflow-x: auto; scrollbar-width: none;">
            <?php foreach(array_slice($trendingCoins, 0, 5) as $t): ?>
                <a href="coin.php?id=<?= $t['item']['id'] ?>" style="text-decoration: none; color: var(--text); font-size: 0.75rem; background: rgba(0,0,0,0.05); padding: 5px 12px; border-radius: 20px; white-space: nowrap; display: flex; align-items: center; gap: 5px;">
                    <img src="<?= $t['item']['small'] ?>" width="14">
                    <?= $t['item']['symbol'] ?>
                </a>
            <?php endforeach; ?>
            <a href="trending.php" style="text-decoration: none; color: var(--accent); font-size: 0.75rem; font-weight: bold; white-space: nowrap; margin-left: 10px;">Lihat Semua →</a>
        </div>
    </div>
</div>

<main>
    <div id="coinGrid" class="grid">
        <?php foreach ($coins as $key => $coin): 
            $change = $coin['price_change_percentage_24h'];
            $colorClass = $change >= 0 ? 'up' : 'down';
        ?>
        <a class="card" href="coin.php?id=<?= $coin['id'] ?>">
            <div class="star-icon" data-id="<?= $coin['id'] ?>" onclick="toggleWatchlist('<?= $coin['id'] ?>', event)">☆</div>
            <div class="coin-rank">#<?= $key + 1 ?></div>
            <div class="card-content">
                <img src="<?= $coin['image'] ?>" alt="<?= $coin['name'] ?>">
                <h3><?= $coin['name'] ?> <span style="font-size: 0.7rem; opacity: 0.5;"><?= strtoupper($coin['symbol']) ?></span></h3>
                <div class="price-info" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                    <p style="margin:0; font-weight: bold;">$<?= number_format($coin['current_price'], 2) ?></p>
                    <span class="<?= $colorClass ?>" style="font-size: 0.9rem; font-weight: bold;">
                        <?= ($change >= 0 ? '+' : '') . number_format($change, 2) ?>%
                    </span>
                </div>
                <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid rgba(0,0,0,0.05); display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <small style="display:block; font-size: 0.6rem; opacity: 0.5; font-weight: bold;">MARKET CAP</small>
                        <p style="margin:0; font-size: 0.75rem; font-weight: 600;">$<?= number_format($coin['market_cap'] / 1000000, 0) ?>M</p>
                    </div>
                    <div style="text-align: right;">
                        <small style="display:block; font-size: 0.6rem; opacity: 0.5; font-weight: bold;">VOLUME (24H)</small>
                        <p style="margin:0; font-size: 0.75rem; font-weight: 600;">$<?= number_format($coin['total_volume'] / 1000000, 0) ?>M</p>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</main>

<script>
function openModal() {
    const modal = document.getElementById("indexModal");
    modal.style.display = "block";
}

function closeModal() {
    const modal = document.getElementById("indexModal");
    modal.style.display = "none";
}

window.onclick = function(event) {
    let modal = document.getElementById("indexModal");
    if (event.target == modal) {
        closeModal();
    }
}
</script>

<style>
@keyframes slideDown {
    from { transform: translateY(-50px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.modal-content {
    animation: slideDown 0.4s ease-out;
    background-color: var(--card-bg);
    margin: 5% auto;
    padding: 25px;
    border-radius: 20px;
    width: 90%;
    max-width: 400px;
    position: relative;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.modal-overlay {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.6);
    backdrop-filter: blur(5px);
    transition: opacity 0.3s ease;
}
</style>

<?php include "includes/footer.php"; ?>