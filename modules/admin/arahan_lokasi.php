<?php 
include '../../includes/header.php'; 
include '../../config/database.php';

if(isset($_POST['set_lokasi'])) {
    $id = intval($_POST['id']);
    $lok = mysqli_real_escape_string($conn, $_POST['lokasi']);
    
    // Use prepared statement
    $stmt = $conn->prepare("UPDATE parkir SET lokasi_parkir = ? WHERE id = ?");
    $stmt->bind_param("si", $lok, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Lokasi parkir berhasil diupdate!'); window.location='arahan_lokasi.php';</script>";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$res = mysqli_query($conn, "SELECT * FROM parkir WHERE status='Masuk' AND lokasi_parkir='Menunggu Arahan'");
?>

<div class="card">
    <h2>📍 Atur Posisi Kendaraan di Area Parkir</h2>
    <p style="color: #64748b;">Tentukan blok parkir untuk kendaraan yang telah input STNK dan menunggu arahan lokasi:</p>
</div>

<?php if(mysqli_num_rows($res) > 0): ?>
    <div class="card">
        <div style="overflow-x: auto;">
            <table>
                <thead>
                    <tr>
                        <th style="width: 20%;">🚗 No Plat</th>
                        <th style="width: 20%;">📋 Jenis</th>
                        <th style="width: 20%;">⏰ Jam Masuk</th>
                        <th style="width: 40%;">⚙️ Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($res)): ?>
                    <tr>
                        <td>
                            <span style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); color: white; padding: 0.5rem 1rem; border-radius: 8px; font-weight: 600; display: inline-block;">
                                <?= htmlspecialchars($row['no_plat']); ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($row['jenis_kendaraan']); ?></td>
                        <td style="font-size: 0.9rem; color: #64748b;">
                            <?= date('d/m/Y H:i', strtotime($row['jam_masuk'])); ?>
                        </td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="id" value="<?= intval($row['id']); ?>">
                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    <select name="lokasi" style="padding: 0.75rem; flex: 1; min-width: 200px;" required>
                                        <option value="">-- Pilih Blok Parkir --</option>
                                        <option value="Blok A (Halaman Utama)">🅰️ Blok A (Halaman Utama)</option>
                                        <option value="Blok B (Belakang Gedung)">🅱️ Blok B (Belakang Gedung)</option>
                                        <option value="Blok C (Area Kantin)">🅲 Blok C (Area Kantin)</option>
                                    </select>
                                    <button type="submit" name="set_lokasi" class="btn btn-green">✅ Set Lokasi</button>
                                </div>
                            </form>
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
            <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
            <h3 style="color: var(--success-color); margin-bottom: 0.5rem;">Tidak Ada Kendaraan Menunggu Arahan</h3>
            <p style="color: #64748b;">Semua kendaraan sudah mendapat arahan lokasi parkir.</p>
        </div>
    </div>
<?php endif; ?>

<div class="card">
    <h3>📌 Informasi Blok Parkir</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 1.5rem;">
        <div style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%); padding: 1.5rem; border-radius: 12px; border-left: 4px solid #0369a1;">
            <h4 style="color: #0369a1; margin-bottom: 0.5rem;">🅰️ Blok A</h4>
            <p style="color: #475569; font-size: 0.95rem;">Halaman Utama - Untuk Motor & Mobil</p>
        </div>
        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); padding: 1.5rem; border-radius: 12px; border-left: 4px solid #d97706;">
            <h4 style="color: #d97706; margin-bottom: 0.5rem;">🅱️ Blok B</h4>
            <p style="color: #475569; font-size: 0.95rem;">Belakang Gedung - Untuk Motor & Mobil</p>
        </div>
        <div style="background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%); padding: 1.5rem; border-radius: 12px; border-left: 4px solid #059669;">
            <h4 style="color: #059669; margin-bottom: 0.5rem;">🅲 Blok C</h4>
            <p style="color: #475569; font-size: 0.95rem;">Area Kantin - Prioritas Motor</p>
        </div>
    </div>
</div>
<?php include '../../includes/footer.php'; ?>