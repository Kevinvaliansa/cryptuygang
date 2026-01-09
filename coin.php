<?php
require_once __DIR__ . "/api/coingecko.php";

// 1. Ambil ID dari URL
$id = $_GET['id'] ?? null;

// Jika tidak ada ID, kembalikan ke halaman utama
if (!$id) {
    header("Location: index.php");
    exit;
}

// 2. Ambil data koin dari API
$coin = getCoinDetail($id);

// 3. PENANGANAN ERROR: Cek apakah data berhasil dimuat
// Jika $coin kosong (null) atau market_data tidak ada, berarti API sedang limit
if (!$coin || !isset($coin['market_data'])) {
    $pageTitle = "API Limit - Error";
    include "includes/header.php";
    ?>
    <div style="max-width:800px; margin: 50px auto; text-align:center; padding:20px;">
        <div style="background: #fff3f3; padding: 30px; border-radius: 20px; border: 1px solid #ffcccc;">
            <h1 style="color: #ff3b30; font-size: 50px; margin-bottom: 10px;">⚠️</h1>
            <h2 style="color: #2c3e50;">Waduh, API sedang Limit!</h2>
            <p style="color: #666; line-height: 1.6;">
                CoinGecko sedang membatasi permintaan data saat ini. <br>
                Silakan tunggu sekitar 1-2 menit, lalu <b>Refresh</b> halaman ini.
            </p>
            <br>
            <a href="index.php" class="btn-view" style="text-decoration: none; display: inline-block; background: #3498db; color: white; padding: 10px 25px; border-radius: 10px;"> Kembali ke Market</a>
        </div>
    </div>
    <?php
    include "includes/footer.php";
    exit; // Berhenti di sini agar sisa kodingan di bawah tidak dijalankan
}

// 4. Jika data berhasil dimuat, tampilkan halaman normal
$pageTitle = htmlspecialchars($coin['name']);
include "includes/header.php";
?>

<div style="max-width:1000px; margin:auto; padding:30px 20px; text-align:center">
    <div style="text-align:left">
        <a href="index.php" class="btn-view" style="text-decoration: none; color: var(--text); background: var(--card-bg); padding: 8px 15px; border-radius: 8px; border: 1px solid #ddd;">← Kembali</a>
    </div>

    <img src="<?= $coin['image']['large'] ?>" style="width:80px; margin-top:20px">
    <h1 style="margin: 10px 0;"><?= htmlspecialchars($coin['name']) ?> <small style="opacity:0.5">(<?= strtoupper($coin['symbol']) ?>)</small></h1>
    <h2 style="color:var(--accent); font-size:2.8rem; margin:10px 0;">$<?= number_format($coin['market_data']['current_price']['usd'], 2) ?></h2>
    
    <div class="timeframe-selector" style="margin: 30px 0;">
        <button onclick="changeTF(this, '0.0104')">15m</button>
        <button onclick="changeTF(this, '0.0417')">1h</button>
        <button onclick="changeTF(this, '0.1667')">4h</button>
        <button onclick="changeTF(this, '1')" class="active">1D</button>
        <button onclick="changeTF(this, '7')">7D</button>
        <button onclick="changeTF(this, '30')">1M</button>
        <button onclick="changeTF(this, '365')">1Y</button>
    </div>

    <div id="chart-container">
        <canvas id="priceChart"></canvas>
    </div>
</div>

<script>
/**
 * Fungsi untuk mengganti Timeframe
 */
function changeTF(btn, d) {
    // 1. Hapus class active dari semua tombol
    document.querySelectorAll('.timeframe-selector button').forEach(b => b.classList.remove('active'));
    
    // 2. Tambah class active ke tombol yang diklik
    btn.classList.add('active'); 
    
    // 3. Panggil fungsi loadChart dari assets/js/chart.js
    loadChart("<?= htmlspecialchars($id) ?>", d);
}

// Load chart pertama kali saat halaman dibuka (Default 1 Hari)
window.onload = () => loadChart("<?= htmlspecialchars($id) ?>", '1');
</script>

<?php include "includes/footer.php"; ?>