function toggleTheme() {
    const body = document.body;
    const currentTheme = body.classList.contains('dark') ? 'light' : 'dark';
    body.classList.remove('light', 'dark');
    body.classList.add(currentTheme);
    fetch('toggle-theme.php?theme=' + currentTheme);
}

function setView(mode) {
    const grid = document.getElementById('coinGrid');
    if (grid) grid.classList.toggle('list-view', mode === 'list');
    localStorage.setItem('pref-view', mode);
}

function searchCoin() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('#coinGrid .card');
    cards.forEach(card => {
        const name = card.querySelector('h3').innerText.toLowerCase();
        card.style.display = name.includes(input) ? "" : "none";
    });
}

function toggleWatchlist(id, event) {
    event.preventDefault(); event.stopPropagation();
    let watchlist = JSON.parse(localStorage.getItem('myWatchlist')) || [];
    const index = watchlist.indexOf(id);
    if (index > -1) watchlist.splice(index, 1);
    else watchlist.push(id);
    localStorage.setItem('myWatchlist', JSON.stringify(watchlist));
    renderWatchlistIcons();
}

function renderWatchlistIcons() {
    const watchlist = JSON.parse(localStorage.getItem('myWatchlist')) || [];
    document.querySelectorAll('.star-icon').forEach(star => {
        const id = star.getAttribute('data-id');
        star.innerText = watchlist.includes(id) ? '⭐' : '☆';
        star.classList.toggle('active', watchlist.includes(id));
    });
}

document.addEventListener('DOMContentLoaded', () => {
    renderWatchlistIcons();
    if (localStorage.getItem('pref-view')) setView(localStorage.getItem('pref-view'));
});