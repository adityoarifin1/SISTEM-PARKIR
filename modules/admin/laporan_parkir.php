<?php 
include '../../includes/header.php'; 
include '../../config/database.php';

// Ambil data kendaraan yang sudah berstatus 'Keluar'
$query = "SELECT * FROM parkir WHERE status='Keluar' ORDER BY jam_keluar DESC";
$result = mysqli_query($conn, $query);

// Hitung total pendapatan dari biaya parkir
$total_pendapatan = mysqli_query($conn, "SELECT SUM(biaya) as total FROM parkir WHERE status='Keluar'");
$total = mysqli_fetch_assoc($total_pendapatan)['total'];
?>

<div class="card">
    <div style="text-align: center; border-bottom: 3px solid var(--primary-color); padding-bottom: 2rem; margin-bottom: 2rem;">
        <h2 style="margin: 0; color: var(--primary-color);">📊 LAPORAN PARKIR HARIAN</h2>
        <h3 style="margin: 0.5rem 0; color: var(--secondary-color);">SMAN BANDAR LAMPUNG</h3>
        <p style="margin: 0.5rem 0; font-size: 0.95rem; color: #64748b;">Rajabasa Jaya, Bandar Lampung 35144</p>
    </div>

    <div style="display: grid; grid-template-columns: 1fr auto; gap: 2rem; margin-bottom: 2rem; align-items: center;">
        <div>
            <h3 style="color: var(--primary-color); margin-bottom: 0.5rem;">📋 Data Kendaraan Selesai Parkir</h3>
            <p style="color: #64748b; font-size: 0.95rem;">Tanggal: <strong><?= date('d F Y'); ?></strong></p>
        </div>
        <button onclick="window.print()" class="btn btn-blue">🖨️ Print Laporan</button>
    </div>

    <?php if(mysqli_num_rows($result) > 0): ?>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th style="width: 8%;">No</th>
                    <th style="width: 15%;">🚗 No Plat</th>
                    <th style="width: 12%;">📋 Jenis</th>
                    <th style="width: 18%;">📍 Lokasi</th>
                    <th style="width: 15%;">🕐 Jam Masuk</th>
                    <th style="width: 15%;">🕐 Jam Keluar</th>
                    <th style="width: 17%;">💰 Biaya</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($result)): 
                ?>
                <tr>
                    <td style="text-align: center; font-weight: 600; color: var(--primary-color);"><?= $no++; ?></td>
                    <td><strong><?= htmlspecialchars($row['no_plat']); ?></strong></td>
                    <td><?= htmlspecialchars($row['jenis_kendaraan']); ?></td>
                    <td><?= htmlspecialchars($row['lokasi_parkir']); ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['jam_masuk'])); ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['jam_keluar'])); ?></td>
                    <td style="font-weight: 600; color: var(--success-color);">Rp <?= number_format($row['biaya'], 0, ',', '.'); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); font-weight: 700;">
                    <td colspan="6" style="text-align: right; padding: 1.25rem;">
                        TOTAL PENDAPATAN:
                    </td>
                    <td style="padding: 1.25rem; color: var(--success-color);">
                        Rp <?= number_format($total ?? 0, 0, ',', '.'); ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php else: ?>
    <div style="text-align: center; padding: 3rem 2rem; background: #f1f5f9; border-radius: 12px;">
        <div style="font-size: 2.5rem; margin-bottom: 1rem;">📭</div>
        <h3 style="color: var(--text-secondary); margin-bottom: 0.5rem;">Belum Ada Data Kendaraan Keluar</h3>
        <p style="color: #64748b;">Laporan akan ditampilkan setelah ada kendaraan yang keluar dari area parkir.</p>
    </div>
    <?php endif; ?>

    <div style="margin-top: 3rem; padding-top: 2rem; border-top: 2px solid #e2e8f0; display: grid; grid-template-columns: 1fr auto; gap: 2rem;">
        <div>
            <p style="color: #64748b; font-size: 0.9rem;">
                <strong>Dicetak pada:</strong> <?= date('d F Y \p\a\d\a H:i:s'); ?>
            </p>
        </div>
        <div style="text-align: center; min-width: 250px;">
            <p style="color: #64748b; margin-bottom: 2rem;">Bandar Lampung, <?= date('d F Y'); ?></p>
            <p style="color: #1e293b; font-weight: 600; margin-bottom: 3rem;">Admin Sistem Parkir</p>
            <p style="color: #1e293b; font-weight: 700;">Adityo Arifin</p>
            <p style="color: #64748b; font-size: 0.9rem;">NPM. 2453025006</p>
        </div>
    </div>
</div>

<style>
/* CSS khusus cetak agar sidebar tidak ikut terprint */
@media print {
    .sidebar, .btn {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
    }
    .card {
        box-shadow: none !important;
        border: none !important;
    }
}
</style>

<?php include '../../includes/footer.php'; ?>