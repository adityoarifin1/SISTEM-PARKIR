<?php
include '../../includes/header.php';
include '../../config/database.php';

if (isset($_POST['submit'])) {
    $plat = mysqli_real_escape_string($conn, strtoupper($_POST['no_plat']));
    $jenis = mysqli_real_escape_string($conn, $_POST['jenis']);
    $jam_masuk = date("Y-m-d H:i:s");

    // Validate input
    if (empty($plat) || empty($jenis)) {
        $error = "No Plat dan Jenis Kendaraan harus diisi!";
    } else {
        // Use prepared statement
        $stmt = $conn->prepare("INSERT INTO parkir (no_plat, jenis_kendaraan, jam_masuk, lokasi_parkir, status) VALUES (?, ?, ?, 'Menunggu Arahan', 'Masuk')");
        $stmt->bind_param("sss", $plat, $jenis, $jam_masuk);
        
        if ($stmt->execute()) {
            echo "<script>alert('Data STNK Masuk! Silahkan arahkan lokasi parkir.'); window.location='arahan_lokasi.php';</script>";
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<div class="card">
    <h2>📝 Input Data STNK Masuk</h2>
    <p style="color: #64748b;">Terima STNK dari siswa/pengunjung dan input data kendaraan yang masuk ke area parkir.</p>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-error" style="margin-bottom: 1.5rem;">
            ⚠️ <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" style="max-width: 600px;">
        <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 2rem; border-radius: 12px; border-left: 4px solid #0369a1;">
            
            <div class="form-group">
                <label for="no_plat">📋 No Plat STNK <span style="color: #dc2626;">*</span></label>
                <input type="text" id="no_plat" name="no_plat" placeholder="Contoh: B 1234 XYZ" required maxlength="15">
                <small style="color: #64748b; display: block; margin-top: 0.5rem;">Pastikan nomor plat ditulis dengan benar</small>
            </div>
            
            <div class="form-group">
                <label for="jenis">🚗 Jenis Kendaraan <span style="color: #dc2626;">*</span></label>
                <select id="jenis" name="jenis" required>
                    <option value="">-- Pilih Jenis Kendaraan --</option>
                    <option value="Motor">🏍️ Motor</option>
                    <option value="Mobil">🚗 Mobil</option>
                </select>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 1.5rem;">
                <button type="submit" name="submit" class="btn btn-blue" style="width: 100%;">✅ Input STNK Masuk</button>
                <a href="/parking_system/dashboard.php" class="btn" style="background: #64748b; color: white; width: 100%; text-decoration: none;">🔙 Kembali ke Dashboard</a>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <h3>💡 Instruksi Penting</h3>
    <ul style="margin-top: 1rem; list-style: none; padding: 0;">
        <li style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0;">
            <strong style="color: var(--primary-color);">1. Verifikasi Data</strong>
            <p style="color: #64748b; margin-top: 0.25rem;">Pastikan nomor plat yang Anda input sesuai dengan STNK fisik</p>
        </li>
        <li style="padding: 0.75rem 0; border-bottom: 1px solid #e2e8f0;">
            <strong style="color: var(--primary-color);">2. Pilih Jenis</strong>
            <p style="color: #64748b; margin-top: 0.25rem;">Pilih jenis kendaraan sesuai dengan yang masuk (Motor atau Mobil)</p>
        </li>
        <li style="padding: 0.75rem 0;">
            <strong style="color: var(--primary-color);">3. Lanjut ke Lokasi</strong>
            <p style="color: #64748b; margin-top: 0.25rem;">Setelah input berhasil, arahkan ke menu "Atur Lokasi Parkir"</p>
        </li>
    </ul>
</div>

<?php include '../../includes/footer.php'; ?>