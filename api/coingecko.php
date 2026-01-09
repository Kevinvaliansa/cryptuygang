<?php
// Di dalam file api/coingecko.php
if (!function_exists('fetchAPI')) {
    // ... fungsi fetchAPI yang sudah ada ...
    function fetchAPI($url) {
        $cacheDir = __DIR__ . '/cache/';
        if (!is_dir($cacheDir)) mkdir($cacheDir, 0777, true);
        $cacheFile = $cacheDir . md5($url) . '.json';

        if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < 60)) {
            return json_decode(file_get_contents($cacheFile), true);
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => ["User-Agent: CryptoApp/1.0"]
        ]);
        $response = curl_exec($ch);
        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) {
            file_put_contents($cacheFile, $response);
            return json_decode($response, true);
        }
        return file_exists($cacheFile) ? json_decode(file_get_contents($cacheFile), true) : null;
    }

    // Fungsi Baru untuk Trending
        function getTrendingCoins() {
        $url = "https://api.coingecko.com/api/v3/search/trending";
        return fetchAPI($url) ?: [];
    }

    function getMarketCoins($limit = 40) {
        $url = "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=$limit&page=1&sparkline=false&price_change_percentage=24h";
        return fetchAPI($url) ?: [];
    }

    function getCoinDetail($id) {
        return fetchAPI("https://api.coingecko.com/api/v3/coins/" . urlencode($id));
    }

    function getMarketChart($id, $days = 1) {
        $url = "https://api.coingecko.com/api/v3/coins/" . urlencode($id) . "/market_chart?vs_currency=usd&days=$days";
        return fetchAPI($url) ?: [];
    }
}

// Handler untuk AJAX tetap di bawah
if (isset($_GET['action']) && $_GET['action'] == 'get_chart') {
    header('Content-Type: application/json');
    $id = $_GET['id'] ?? 'bitcoin';
    $days = $_GET['days'] ?? 1;
    echo json_encode(getMarketChart($id, $days));
    exit;
}
?>