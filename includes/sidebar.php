<div class="sidebar">
    <h2 style="text-align:center;">🅿️ SIM-PARKIR</h2>
    <p style="text-align:center; font-size: 11px; color: #888;">Administrator: <?= htmlspecialchars($_SESSION['user']); ?></p>
    <hr style="border:0.5px solid #333; margin:20px 0;">
    
    <a href="/parking_system/dashboard.php">Dashboard</a>
    
    <!-- Alur Admin Terpadu -->
    <a href="/parking_system/modules/admin/input_stnk.php">1. Input STNK Masuk</a>
    <a href="/parking_system/modules/admin/arahan_lokasi.php">2. Atur Lokasi Parkir</a>
    <a href="/parking_system/modules/admin/verifikasi_keluar.php">3. Verifikasi Keluar</a>
    
    <hr style="border:0.5px solid #333; margin:20px 0;">
    <a href="/parking_system/modules/admin/laporan_parkir.php">Laporan Harian</a>
    <a href="/parking_system/logout.php" style="color:#e74c3c;">Keluar Sistem</a>
</div>