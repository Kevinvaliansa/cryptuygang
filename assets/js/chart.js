let myChart;
let currentType = localStorage.getItem('chart-type') || 'line';

async function loadChart(coinId, days = '1', type = currentType) {
    currentType = type;
    localStorage.setItem('chart-type', type);
    
    const ctx = document.getElementById('priceChart').getContext('2d');
    const url = type === 'candlestick' 
        ? `https://api.coingecko.com/api/v3/coins/${coinId}/ohlc?vs_currency=usd&days=${days}`
        : `https://api.coingecko.com/api/v3/coins/${coinId}/market_chart?vs_currency=usd&days=${days}`;

    try {
        const res = await fetch(url);
        const data = await res.json();
        if (myChart) myChart.destroy();

        let config;
        if (type === 'candlestick') {
            const formatted = data.map(d => ({ x: d[0], o: d[1], h: d[2], l: d[3], c: d[4] }));
            config = {
                type: 'candlestick',
                data: { datasets: [{ data: formatted, color: { up: '#10b981', down: '#ef4444' } }] }
            };
        } else {
            const formatted = data.prices.map(p => ({ x: p[0], y: p[1] }));
            config = {
                type: 'line',
                data: { datasets: [{ data: formatted, borderColor: '#3b82f6', fill: true, backgroundColor: 'rgba(59, 130, 246, 0.1)', pointRadius: 0 }] }
            };
        }

        myChart = new Chart(ctx, {
            ...config,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { x: { type: 'time' }, y: { position: 'right' } },
                plugins: { legend: { display: false } }
            }
        });
    } catch (e) { console.error("Error:", e); }
}