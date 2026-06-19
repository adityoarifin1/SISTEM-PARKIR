<?php
include 'config/database.php';

// Ambil kapasitas maksimal dengan error handling
$q_pengaturan = mysqli_query($conn, "SELECT kapasitas_maksimal FROM pengaturan LIMIT 1");
if(!$q_pengaturan) {
    die(json_encode(['error' => 'Query error: ' . mysqli_error($conn)]));
}

$pengaturan_row = mysqli_fetch_assoc($q_pengaturan);
$max = $pengaturan_row ? intval($pengaturan_row['kapasitas_maksimal']) : 50;

// Hitung kendaraan yang masih di dalam
$q_aktif = mysqli_query($conn, "SELECT COUNT(*) as jml FROM parkir WHERE status='Masuk'");
if(!$q_aktif) {
    die(json_encode(['error' => 'Query error: ' . mysqli_error($conn)]));
}

$aktif_row = mysqli_fetch_assoc($q_aktif);
$aktif = $aktif_row ? intval($aktif_row['jml']) : 0;

$sisa = $max - $aktif;

// Kirim data ke JS
header('Content-Type: application/json');
echo json_encode([
    'sisa' => $sisa,
    'aktif' => $aktif,
    'max' => $max
]);
?>