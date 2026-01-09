let cryptoChart;
function loadChart(id, days = 1) {
    const ctx = document.getElementById('priceChart').getContext('2d');
    fetch(`https://api.coingecko.com/api/v3/coins/${id}/market_chart?vs_currency=usd&days=${days}`)
    .then(res => res.json()).then(data => {
        if (cryptoChart) cryptoChart.destroy();
        
        const isShort = parseFloat(days) < 1;
        const labels = data.prices.map(p => {
            const d = new Date(p[0]);
            return isShort ? d.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : d.toLocaleDateString();
        });

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(52, 152, 219, 0.4)');
        gradient.addColorStop(1, 'rgba(52, 152, 219, 0)');

        cryptoChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{ 
                    data: data.prices.map(p => p[1]), 
                    borderColor: '#3498db', 
                    fill: true, 
                    backgroundColor: gradient, 
                    tension: 0.3, 
                    pointRadius: isShort ? 2 : 0 
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: { legend: { display: false } },
                scales: { x: { ticks: { maxTicksLimit: 8 } } }
            }
        });
    });
}