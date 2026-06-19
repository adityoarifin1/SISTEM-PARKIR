<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'config/database.php';

$max_result = mysqli_query($conn, "SELECT kapasitas_maksimal FROM pengaturan LIMIT 1");
$max = $max_result ? intval(mysqli_fetch_assoc($max_result)['kapasitas_maksimal']) : 0;

$aktif_result = mysqli_query($conn, "SELECT COUNT(*) as jml FROM parkir WHERE status='Masuk'");
$aktif = $aktif_result ? intval(mysqli_fetch_assoc($aktif_result)['jml']) : 0;

$sisa = max(0, $max - $aktif);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SIM Parkir</title>
    <link rel="stylesheet" href="http://localhost/parking_system/assets/css/style.css">
</head>
<body>
<?php include 'includes/sidebar.php'; ?>
<div class="main-content">
    <div class="card">
        <h1>🅿️ Dashboard Manajemen Parkir</h1>
        <p>Sistem Informasi Manajemen Parkir Kendaraan - SMAN Bandar Lampung</p>
    </div>

    <div class="stats-container">
        <div class="stat-box bg-blue">
            <p>Sisa Kapasitas</p>
            <h2><?= $sisa; ?></h2>
            <p class="stat-caption">Slot parkir tersedia</p>
        </div>
        <div class="stat-box bg-green">
            <p>Kendaraan Terisi</p>
            <h2><?= $aktif; ?></h2>
            <p class="stat-caption">Kendaraan sedang parkir</p>
        </div>
        <div class="stat-box bg-orange">
            <p>Total Kapasitas</p>
            <h2><?= $max; ?></h2>
            <p class="stat-caption">Batas maksimal slot</p>
        </div>
    </div>

    <div class="card">
        <h2>📋 Panduan Penggunaan Sistem</h2>
        <p>Ikuti langkah-langkah berikut untuk mengelola parkir kendaraan dengan efisien:</p>
        <div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
            <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 2rem; border-radius: 12px; border-left: 4px solid #0369a1;">
                <div style="font-size: 1.75rem; margin-bottom: 1rem;">📝</div>
                <h3 style="color: #0369a1; margin-bottom: 0.5rem;">Tahap 1: Input STNK Masuk</h3>
                <p style="color: #475569; font-size: 0.95rem;">Terima STNK dari siswa/pengunjung dan input data kendaraan pada menu "Input STNK Masuk".</p>
            </div>
            <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 2rem; border-radius: 12px; border-left: 4px solid #d97706;">
                <div style="font-size: 1.75rem; margin-bottom: 1rem;">📍</div>
                <h3 style="color: #d97706; margin-bottom: 0.5rem;">Tahap 2: Atur Lokasi Parkir</h3>
                <p style="color: #475569; font-size: 0.95rem;">Arahkan siswa/pengunjung ke blok parkir yang tersedia melalui menu "Atur Lokasi Parkir".</p>
            </div>
            <div style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); padding: 2rem; border-radius: 12px; border-left: 4px solid #059669;">
                <div style="font-size: 1.75rem; margin-bottom: 1rem;">✅</div>
                <h3 style="color: #059669; margin-bottom: 0.5rem;">Tahap 3: Verifikasi Keluar</h3>
                <p style="color: #475569; font-size: 0.95rem;">Saat siswa/pengunjung keluar, verifikasi kembali dan proses keluar melalui menu "Verifikasi Keluar".</p>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>⚙️ Informasi Sistem</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 1.5rem;">
            <div>
                <strong style="color: var(--primary-color);">Admin Login:</strong>
                <p style="color: #64748b; margin-top: 0.5rem;">Username: <code style="background: #f1f5f9; padding: 0.25rem 0.5rem; border-radius: 4px;"><?= htmlspecialchars($_SESSION['user']); ?></code></p>
            </div>
            <div>
                <strong style="color: var(--primary-color);">Kapasitas Parkir:</strong>
                <p style="color: #64748b; margin-top: 0.5rem;"><span style="font-size: 1.5rem; font-weight: 700; color: var(--primary-color);"><?= $max; ?></span> kendaraan</p>
            </div>
            <div>
                <strong style="color: var(--primary-color);">Status Sistem:</strong>
                <p style="color: #64748b; margin-top: 0.5rem;"><span style="display: inline-block; width: 10px; height: 10px; background: #10b981; border-radius: 50%; margin-right: 0.5rem;"></span> Online</p>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
