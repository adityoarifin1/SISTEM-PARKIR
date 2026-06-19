<?php 
include '../../includes/header.php'; 
include '../../config/database.php';

if(isset($_GET['out'])) {
    $id = intval($_GET['out']);
    
    // Use prepared statement
    $stmt = $conn->prepare("UPDATE parkir SET jam_keluar=NOW(), status='Keluar' WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Verifikasi STNK Keluar Berhasil. Slot Parkir telah KOSONG.'); window.location='verifikasi_keluar.php';</script>";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$result = mysqli_query($conn, "SELECT * FROM parkir WHERE status='Masuk'");
?>

<div class="card">
    <h2>✅ Verifikasi STNK & Proses Keluar</h2>
    <p style="color: #64748b;">Verifikasi STNK dari siswa/pengunjung yang akan keluar dari area parkir:</p>
</div>

<?php if(mysqli_num_rows($result) > 0): ?>
    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 18%;">🚗 No Plat</th>
                        <th style="width: 15%;">📋 Jenis</th>
                        <th style="width: 20%;">📍 Lokasi</th>
                        <th style="width: 18%;">⏰ Jam Masuk</th>
                        <th style="width: 29%;">⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <span style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; display: inline-block;">
                                <?= htmlspecialchars($row['no_plat']); ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['jenis_kendaraan']); ?></td>
                        <td>
                            <span style="background: #fef3c7; color: #d97706; padding: 0.4rem 0.8rem; border-radius: 6px; font-size: 0.9rem;">
                                <?= htmlspecialchars($row['lokasi_parkir']); ?>
                            </span>
                        </td>
                        <td style="font-size: 0.9rem; color: #64748b;">
                            <?= date('d/m/Y H:i', strtotime($row['jam_masuk'])); ?>
                        </td>
                        <td>
                            <a href="?out=<?= intval($row['id']); ?>" class="btn btn-red" onclick="return confirm('⚠️ Pastikan siswa sudah menyerahkan STNK!\n\nLanjutkan proses keluar?')">
                                ✅ Verifikasi Keluar
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <div class="card">
        <div style="text-align: center; padding: 3rem 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🎉</div>
            <h3 style="color: var(--success-color); margin-bottom: 0.5rem;">Semua Kendaraan Telah Keluar</h3>
            <p style="color: #64748b;">Tidak ada kendaraan yang sedang parkir saat ini.</p>
        </div>
    </div>
<?php endif; ?>

<div class="card">
    <h3>📋 Informasi Proses Keluar</h3>
    <div style="background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%); padding: 2rem; border-radius: 12px; border-left: 4px solid #dc2626;">
        <h4 style="color: #dc2626; margin-bottom: 1rem;">⚠️ Poin Penting:</h4>
        <ul style="list-style: none; padding: 0;">
            <li style="padding: 0.5rem 0; color: #7f1d1d;">
                ✓ Verifikasi STNK fisik sebelum mengklik tombol "Verifikasi Keluar"
            </li>
            <li style="padding: 0.5rem 0; color: #7f1d1d;">
                ✓ Pastikan data no plat sesuai dengan STNK yang diserahkan
            </li>
            <li style="padding: 0.5rem 0; color: #7f1d1d;">
                ✓ Setelah diklik, slot parkir akan otomatis terbebas
            </li>
            <li style="padding: 0.5rem 0; color: #7f1d1d;">
                ✓ Proses tidak bisa dibatalkan setelah verifikasi
            </li>
        </ul>
    </div>
</div>
<?php include '../../includes/footer.php'; ?>