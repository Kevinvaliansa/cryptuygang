let priceChart;

async function loadChart(id, days) {
    const ctx = document.getElementById('priceChart').getContext('2d');
    
    try {
        const response = await fetch(`api/coingecko.php?action=get_chart&id=${id}&days=${days}`);
        const data = await response.json();

        if (!data.prices) return;

        const chartData = data.prices.map(p => ({ x: p[0], y: p[1] }));
        
        // Buat Gradient untuk Background
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

        if (priceChart) priceChart.destroy();

        priceChart = new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [{
                    data: chartData,
                    borderColor: '#3b82f6',
                    borderWidth: 3,
                    pointRadius: 0,
                    pointHoverRadius: 6,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: (context) => '$' + context.parsed.y.toLocaleString()
                        }
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        grid: { display: false },
                        ticks: { maxTicksLimit: 7 }
                    },
                    y: {
                        position: 'right',
                        grid: { color: 'rgba(0,0,0,0.05)' },
                        ticks: { callback: (val) => '$' + val.toLocaleString() }
                    }
                }
            }
        });
    } catch (error) {
        console.error("Chart Error:", error);
    }
}