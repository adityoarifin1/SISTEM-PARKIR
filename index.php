<?php
include 'config/database.php';

$max_result = mysqli_query($conn, "SELECT kapasitas_maksimal FROM pengaturan LIMIT 1");
$max = $max_result ? intval(mysqli_fetch_assoc($max_result)['kapasitas_maksimal']) : 0;

$aktif_result = mysqli_query($conn, "SELECT COUNT(*) as jml FROM parkir WHERE status='Masuk'");
$aktif = $aktif_result ? intval(mysqli_fetch_assoc($aktif_result)['jml']) : 0;

$sisa = max(0, $max - $aktif);
$persentase = $max > 0 ? round(($aktif / $max) * 100) : 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM Parkir - SMAN Bandar Lampung</title>
    <link rel="stylesheet" href="assets/css/style.css?v=20260620">
</head>
<body class="landing-body">
    <header class="landing-navbar">
        <div class="nav-brand">
            <span>🅿️</span>
            <div>
                <strong>SIM Parkir</strong>
                <small>SMAN Bandar Lampung</small>
            </div>
        </div>
        <nav>
            <a href="#fitur">Fitur</a>
            <a href="#keunggulan">Keunggulan</a>
            <a href="#kontak">Kontak</a>
        </nav>
        <a href="login.php" class="btn btn-blue">Login Admin</a>
    </header>

    <main class="landing-page">
        <section class="landing-hero">
            <div class="hero-content">
                <span class="hero-badge">🚗 Sistem Parkir Digital</span>
                <h1>Kelola parkir sekolah dengan lebih cepat, aman, dan tertib.</h1>
                <p>Monitor kapasitas kendaraan, distribusi area parkir, dan proses masuk-keluar secara real time melalui sistem yang sederhana namun modern.</p>
                <div class="hero-actions">
                    <a href="login.php" class="btn btn-blue">Masuk ke Sistem</a>
                    <a href="#fitur" class="btn btn-outline">Lihat Fitur</a>
                </div>
                <div class="hero-highlights">
                    <span>Real Time</span>
                    <span>Keamanan</span>
                    <span>Efisien</span>
                </div>
            </div>

            <div class="hero-panel">
                <div class="hero-panel-card">
                    <p class="panel-label">Status Parkir Saat Ini</p>
                    <h2><?= $aktif; ?> / <?= $max; ?></h2>
                    <div class="progress-bar">
                        <span style="width: <?= min($persentase, 100); ?>%"></span>
                    </div>
                    <div class="panel-meta">
                        <div>
                            <small>Sisa Slot</small>
                            <strong><?= $sisa; ?></strong>
                        </div>
                        <div>
                            <small>Terisi</small>
                            <strong><?= $persentase; ?>%</strong>
                        </div>
                    </div>
                    <div class="hero-panel-footer">
                        <span>📍 Area parkir sekolah</span>
                        <span>✅ Aktif hari ini</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="landing-trust">
            <div>
                <span>🛡️ Aman</span>
                <strong>Data kendaraan terorganisir</strong>
            </div>
            <div>
                <span>⚡ Cepat</span>
                <strong>Proses masuk & keluar lebih singkat</strong>
            </div>
            <div>
                <span>📈 Real Time</span>
                <strong>Update status parkir langsung</strong>
            </div>
        </section>

        <section class="landing-section" id="fitur">
            <div class="section-heading">
                <span class="section-tag">Fitur Utama</span>
                <h2>Kenapa sistem ini sangat membantu?</h2>
            </div>
            <div class="feature-grid">
                <div class="feature-card feature-blue">
                    <div class="feature-icon">📝</div>
                    <h3>Input STNK Masuk</h3>
                    <p>Catat kendaraan baru dengan cepat dan rapi saat siswa atau tamu datang.</p>
                </div>
                <div class="feature-card feature-yellow">
                    <div class="feature-icon">📍</div>
                    <h3>Atur Lokasi Parkir</h3>
                    <p>Kelola penempatan kendaraan agar area parkir lebih tertib dan efisien.</p>
                </div>
                <div class="feature-card feature-green">
                    <div class="feature-icon">✅</div>
                    <h3>Verifikasi Keluar</h3>
                    <p>Proses pengecekan saat kendaraan keluar menjadi lebih akurat dan cepat.</p>
                </div>
            </div>
        </section>

        <section class="landing-section feature-extended-section" id="keunggulan">
            <div class="section-heading">
                <span class="section-tag">Keunggulan</span>
                <h2>Solusi yang cocok untuk sekolah modern</h2>
            </div>
            <div class="feature-extended-grid">
                <div class="feature-extended-card">
                    <h3>📋 Catatan yang rapi</h3>
                    <p>Semua data kendaraan tercatat dengan jelas dan mudah dilacak.</p>
                </div>
                <div class="feature-extended-card">
                    <h3>🧭 Tata letak yang jelas</h3>
                    <p>Memudahkan staf dalam mengarahkan kendaraan ke area yang tepat.</p>
                </div>
                <div class="feature-extended-card">
                    <h3>📱 Mudah digunakan</h3>
                    <p>Antarmuka sederhana sehingga tidak membingungkan untuk admin.</p>
                </div>
                <div class="feature-extended-card">
                    <h3>📊 Laporan cepat</h3>
                    <p>Memudahkan pemantauan aktivitas parkir setiap hari.</p>
                </div>
            </div>
        </section>

        <section class="landing-section process-section" id="proses">
            <div class="section-heading">
                <span class="section-tag">Cara Kerja</span>
                <h2>Proses yang simpel dan teratur</h2>
            </div>
            <div class="process-grid">
                <div class="process-card">
                    <span>01</span>
                    <h3>Input Data</h3>
                    <p>Masukkan data kendaraan saat tiba di area parkir.</p>
                </div>
                <div class="process-card">
                    <span>02</span>
                    <h3>Atur Lokasi</h3>
                    <p>Kelola penempatan agar tidak terjadi kekacauan.</p>
                </div>
                <div class="process-card">
                    <span>03</span>
                    <h3>Verifikasi Keluar</h3>
                    <p>Proses selesai dengan pencatatan yang lebih akurat.</p>
                </div>
            </div>
        </section>

        <section class="landing-section">
            <div class="cta-banner">
                <div>
                    <span class="section-tag">Siap Menggunakan?</span>
                    <h2>Mulai kelola parkir sekolah Anda sekarang.</h2>
                </div>
                <a href="login.php" class="btn btn-blue">Login Admin</a>
            </div>
        </section>

        <section class="landing-section" id="kontak">
            <div class="section-heading">
                <span class="section-tag">Kontak</span>
                <h2>Informasi penting</h2>
            </div>
            <div class="info-grid">
                <div>
                    <strong>🏫 Sekolah</strong>
                    <p>SMAN Bandar Lampung</p>
                </div>
                <div>
                    <strong>📍 Lokasi</strong>
                    <p>Area parkir utama sekolah</p>
                </div>
                <div>
                    <strong>🕒 Layanan</strong>
                    <p><span class="status-dot"></span> Sistem aktif untuk operasional harian</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="landing-footer">
        <p>© 2026 SIM Parkir SMAN Bandar Lampung</p>
    </footer>

    <script src="assets/js/script.js"></script>
</body>
</html>