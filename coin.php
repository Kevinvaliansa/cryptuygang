<?php
require_once __DIR__ . "/api/coingecko.php";
$id = $_GET['id'] ?? 'bitcoin';
$coin = getCoinDetail($id);
$pageTitle = $coin['name'] . " - Detail Koin";
include "includes/header.php";

$priceChange = $coin['market_data']['price_change_percentage_24h'];
$color = $priceChange >= 0 ? 'var(--up)' : 'var(--down)';

// Logika pemilihan bahasa deskripsi
$deskripsi = $coin['description']['id'] ?: $coin['description']['en'];
?>

<div style="max-width: 1200px; margin: auto; padding: 20px;">
    <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px;">
        <img src="<?= $coin['image']['large'] ?>" width="64">
        <div>
            <h1 style="margin: 0;"><?= $coin['name'] ?> <span style="opacity: 0.5; font-size: 1.2rem;"><?= strtoupper($coin['symbol']) ?></span></h1>
            <div style="display: flex; gap: 15px; align-items: center; margin-top: 5px;">
                <h2 style="margin: 0;">$<?= number_format($coin['market_data']['current_price']['usd'], 2) ?></h2>
                <span style="color: <?= $color ?>; font-weight: bold;">
                    <?= ($priceChange >= 0 ? '▲' : '▼') ?> <?= number_format(abs($priceChange), 2) ?>%
                </span>
            </div>
        </div>
    </div>

    <div class="coin-detail-layout" style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        
        <div>
            <div class="timeframe-selector" style="display: flex; gap: 10px; margin-bottom: 15px;">
                <button class="btn-view active" id="btn-1" onclick="updateChartTimeframe('1')">24 Jam</button>
                <button class="btn-view" id="btn-7" onclick="updateChartTimeframe('7')">7 Hari</button>
                <button class="btn-view" id="btn-30" onclick="updateChartTimeframe('30')">30 Hari</button>
            </div>
            
            <div style="height: 400px; background: var(--card-bg); padding: 20px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <canvas id="priceChart"></canvas>
            </div>

            <div style="margin-top: 30px;">
                <h3 style="border-left: 5px solid var(--accent); padding-left: 15px;">Tentang <?= $coin['name'] ?></h3>
                <div style="line-height: 1.8; opacity: 0.9; font-size: 1rem; text-align: justify;">
                    <?php if (!empty($deskripsi)): ?>
                        <?= strip_tags($deskripsi, '<p><a><br><b><strong>') ?>
                    <?php else: ?>
                        <p>Deskripsi dalam Bahasa Indonesia tidak tersedia untuk koin ini.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            <div style="background: var(--card-bg); padding: 25px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <h3 style="margin-top: 0; border-bottom: 1px solid rgba(0,0,0,0.05); padding-bottom: 10px;">Statistik Pasar</h3>
                
                <div style="margin-bottom: 20px;">
                    <small style="opacity: 0.5; font-weight: bold; letter-spacing: 1px;">KAPITALISASI PASAR</small>
                    <p style="margin: 5px 0; font-size: 1.1rem; font-weight: bold;">$<?= number_format($coin['market_data']['market_cap']['usd']) ?></p>
                </div>

                <div style="margin-bottom: 20px;">
                    <small style="opacity: 0.5; font-weight: bold; letter-spacing: 1px;">VOLUME (24 JAM)</small>
                    <p style="margin: 5px 0; font-size: 1.1rem; font-weight: bold;">$<?= number_format($coin['market_data']['total_volume']['usd']) ?></p>
                </div>

                <div style="margin-bottom: 20px;">
                    <small style="opacity: 0.5; font-weight: bold; letter-spacing: 1px;">SUPLAI BEREDAR</small>
                    <p style="margin: 5px 0; font-size: 1.1rem; font-weight: bold;"><?= number_format($coin['market_data']['circulating_supply']) ?> <?= strtoupper($coin['symbol']) ?></p>
                </div>

                <div style="margin-bottom: 10px;">
                    <small style="opacity: 0.5; font-weight: bold; letter-spacing: 1px;">HARGA TERTINGGI (ATH)</small>
                    <p style="margin: 5px 0; font-size: 1.1rem; font-weight: bold; color: var(--up);">$<?= number_format($coin['market_data']['ath']['usd'], 2) ?></p>
                </div>
            </div>

            <div style="background: var(--card-bg); padding: 25px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05);">
                <h4 style="margin-top: 0;">Tautan Eksternal</h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="<?= $coin['links']['homepage'][0] ?>" target="_blank" style="color: var(--accent); text-decoration: none; font-size: 0.9rem;">🌐 Situs Web Resmi</a>
                    <a href="https://twitter.com/<?= $coin['links']['twitter_screen_name'] ?>" target="_blank" style="color: var(--accent); text-decoration: none; font-size: 0.9rem;">🐦 Twitter / X</a>
                    <a href="<?= $coin['links']['blockchain_site'][0] ?>" target="_blank" style="color: var(--accent); text-decoration: none; font-size: 0.9rem;">🔍 Explorer</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const coinId = '<?= $id ?>';
    function updateChartTimeframe(days) {
        loadChart(coinId, days);
        document.querySelectorAll('.timeframe-selector .btn-view').forEach(btn => btn.classList.remove('active'));
        document.getElementById('btn-' + days).classList.add('active');
    }
    window.onload = () => updateChartTimeframe('1');
</script>

<?php include "includes/footer.php"; ?>