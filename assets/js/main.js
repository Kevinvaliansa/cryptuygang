function toggleTheme() {
    const body = document.body;
    const currentTheme = body.classList.contains('dark') ? 'light' : 'dark';
    
    // 1. Ubah class di body secara instan
    body.classList.remove('light', 'dark');
    body.classList.add(currentTheme);
    
    // 2. Kirim permintaan ke PHP untuk simpan tema di Cookie
    fetch('toggle-theme.php?theme=' + currentTheme)
    .then(response => {
        console.log("Tema berhasil diubah ke: " + currentTheme);
    })
    .catch(err => console.error("Gagal menyimpan tema:", err));
}
function setView(mode) {
    const grid = document.getElementById('coinGrid');
    const buttons = document.querySelectorAll('.btn-view');
    
    if (!grid) return;

    // Menghapus class lama dan menambah yang baru berdasarkan mode
    if (mode === 'list') {
        grid.classList.add('list-view');
    } else {
        grid.classList.remove('list-view');
    }

    // Simpan pilihan agar tidak hilang saat refresh
    localStorage.setItem('pref-view', mode);

    // Update status tombol aktif secara spesifik
    buttons.forEach(btn => {
        btn.classList.remove('active');
        // Mencari tombol yang sesuai dengan mode yang diklik
        if (btn.getAttribute('onclick').includes(mode)) {
            btn.classList.add('active');
        }
    });
}