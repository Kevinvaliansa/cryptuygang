<?php
require_once __DIR__ . "/api/coingecko.php";
$id = $_GET['id'] ?? 'bitcoin';
$coin = getCoinDetail($id);
include "includes/header.php";
?>
<div style="max-width:1000px; margin:auto; padding:20px; text-align:center">
    <h1><?= $coin['name'] ?></h1>
    <div style="margin-bottom: 20px; display: flex; justify-content: center; gap: 10px;">
        <button class="btn-view" onclick="loadChart('<?= $id ?>', '1', 'line')">📈 Line</button>
        <button class="btn-view" onclick="loadChart('<?= $id ?>', '1', 'candlestick')">🕯️ Candle</button>
    </div>
    <div style="height: 400px; background: var(--card-bg); padding: 20px; border-radius: 20px;">
        <canvas id="priceChart"></canvas>
    </div>
</div>
<script src="assets/js/chart.js"></script>
<script>window.onload = () => loadChart('<?= $id ?>', '1');</script>
<?php include "includes/footer.php"; ?>