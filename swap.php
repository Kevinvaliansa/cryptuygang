<?php
require_once __DIR__ . "/api/coingecko.php";
$pageTitle = "Swap Crypto";
include "includes/header.php";
$coins = getMarketCoins(20);
?>

<div class="swap-container">
    <div class="swap-box">
        <h2 style="margin: 0 0 20px 0; text-align: center;">Tukar Koin</h2>
        
        <div class="input-group">
            <label style="font-size: 0.75rem; font-weight: bold; opacity: 0.5;">JUAL</label>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                <input type="number" id="fromAmount" placeholder="0.0" oninput="calculateSwap()">
                <select id="fromCoin" onchange="calculateSwap()" style="border: none; background: none; color: var(--text); font-weight: bold;">
                    <?php foreach($coins as $c): ?>
                        <option value="<?= $c['current_price'] ?>"><?= strtoupper($c['symbol']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div style="text-align: center; margin: -15px 0; position: relative; z-index: 1;">
            <button onclick="reverseSwap()" style="border-radius: 50%; width: 36px; height: 36px; border: 4px solid var(--card-bg); background: var(--accent); color: white; cursor: pointer;">⇅</button>
        </div>

        <div class="input-group">
            <label style="font-size: 0.75rem; font-weight: bold; opacity: 0.5;">TERIMA</label>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                <input type="number" id="toAmount" placeholder="0.0" readonly>
                <select id="toCoin" onchange="calculateSwap()" style="border: none; background: none; color: var(--text); font-weight: bold;">
                    <?php foreach($coins as $c): ?>
                        <option value="<?= $c['current_price'] ?>" <?= $c['symbol'] == 'usdt' ? 'selected' : '' ?>><?= strtoupper($c['symbol']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <button onclick="alert('Swap Berhasil!')" style="width: 100%; padding: 16px; border-radius: 12px; border: none; background: var(--accent); color: white; font-weight: bold; margin-top: 20px; cursor: pointer;">
            Tukar Sekarang
        </button>
    </div>
</div>

<script>
function calculateSwap() {
    const fromP = document.getElementById('fromCoin').value;
    const toP = document.getElementById('toCoin').value;
    const amt = document.getElementById('fromAmount').value;
    if(amt > 0) {
        document.getElementById('toAmount').value = ((amt * fromP) / toP).toFixed(6);
    } else {
        document.getElementById('toAmount').value = "";
    }
}

function reverseSwap() {
    const f = document.getElementById('fromCoin');
    const t = document.getElementById('toCoin');
    const temp = f.value;
    f.value = t.value;
    t.value = temp;
    calculateSwap();
}
</script>

<?php include "includes/footer.php"; ?>