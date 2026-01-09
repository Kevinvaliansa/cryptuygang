<?php
require_once __DIR__ . "/api/coingecko.php";
$pageTitle = "Koin Trending";
include "includes/header.php";

$trendingData = getTrendingCoins();
$trendingCoins = $trendingData['coins'] ?? [];
?>

<div style="padding: 20px 5%;">
    <div style="margin-bottom: 20px;">
        <h1 style="margin: 0;">🔥 Sedang Trending</h1>
        <p style="opacity: 0.6;">Koin yang paling banyak dicari oleh komunitas dalam 24 jam terakhir.</p>
    </div>

    <div id="coinGrid" class="grid">
        <?php foreach ($trendingCoins as $t): 
            $coin = $t['item'];
            // Mengambil data harga, market cap, dan volume dari data item trending
            // Catatan: API Trending menyediakan data ini dalam objek 'data'
            $price = $coin['data']['price'] ?? 0;
            $marketCap = $coin['data']['market_cap'] ?? 'N/A';
            $volume = $coin['data']['total_volume'] ?? 'N/A';
            $priceChange = $coin['data']['price_change_percentage_24h']['usd'] ?? 0;
            $colorClass = $priceChange >= 0 ? 'up' : 'down';
        ?>
        <a class="card" href="coin.php?id=<?= $coin['id'] ?>">
            <div class="star-icon" data-id="<?= $coin['id'] ?>" onclick="toggleWatchlist('<?= $coin['id'] ?>', event)">☆</div>
            
            <div class="coin-rank">#<?= $coin['market_cap_rank'] ?></div>
            
            <div class="card-content">
                <img src="<?= $coin['large'] ?>" alt="<?= $coin['name'] ?>">
                <h3><?= $coin['name'] ?> <span style="font-size: 0.7rem; opacity: 0.5;"><?= strtoupper($coin['symbol']) ?></span></h3>
                
                <div class="price-info" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                    <p style="margin:0; font-weight: bold;">
                        <?= is_numeric($price) ? '$' . number_format($price, 2) : $price ?>
                    </p>
                    <span class="<?= $colorClass ?>" style="font-size: 0.9rem; font-weight: bold;">
                        <?= ($priceChange >= 0 ? '+' : '') . number_format($priceChange, 2) ?>%
                    </span>
                </div>

                <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid rgba(0,0,0,0.05); display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <div>
                        <small style="display:block; font-size: 0.6rem; opacity: 0.5; font-weight: bold;">MARKET CAP</small>
                        <p style="margin:0; font-size: 0.75rem; font-weight: 600;"><?= $marketCap ?></p>
                    </div>
                    <div style="text-align: right;">
                        <small style="display:block; font-size: 0.6rem; opacity: 0.5; font-weight: bold;">VOLUME</small>
                        <p style="margin:0; font-size: 0.75rem; font-weight: 600;"><?= $volume ?></p>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<?php include "includes/footer.php"; ?>