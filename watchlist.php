<?php
require_once __DIR__ . "/api/coingecko.php";
$pageTitle = "My Watchlist";
include "includes/header.php";
?>

<div style="padding: 20px 5%;">
    <h1>⭐ Watchlist</h1>
    <p id="emptyMsg" style="display:none; opacity: 0.6;">Belum ada koin yang ditambahkan ke watchlist.</p>
    
    <div id="watchlistGrid" class="grid">
        </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const watchlist = JSON.parse(localStorage.getItem('myWatchlist')) || [];
    const grid = document.getElementById('watchlistGrid');
    const msg = document.getElementById('emptyMsg');

    if (watchlist.length === 0) {
        msg.style.display = 'block';
        return;
    }

    // Mengambil data pasar terbaru untuk koin-koin di watchlist
    try {
        const response = await fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=' + watchlist.join(','));
        const coins = await response.json();

        grid.innerHTML = coins.map((coin, index) => `
            <a class="card" href="coin.php?id=${coin.id}">
                <div class="star-icon active" data-id="${coin.id}" onclick="toggleWatchlist('${coin.id}', event); location.reload();">⭐</div>
                <div class="coin-rank">#${coin.market_cap_rank}</div>
                <div class="card-content">
                    <img src="${coin.image}" alt="${coin.name}">
                    <h3>${coin.name} <span style="font-size: 0.7rem; opacity: 0.5;">${coin.symbol.toUpperCase()}</span></h3>
                    <div class="price-info" style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                        <p style="margin:0; font-weight: bold;">$${coin.current_price.toLocaleString()}</p>
                        <span class="${coin.price_change_percentage_24h >= 0 ? 'up' : 'down'}" style="font-size: 0.9rem; font-weight: bold;">
                            ${coin.price_change_percentage_24h.toFixed(2)}%
                        </span>
                    </div>
                </div>
            </a>
        `).join('');
    } catch (e) {
        console.error("Gagal memuat watchlist", e);
    }
});
</script>

<?php include "includes/footer.php"; ?>