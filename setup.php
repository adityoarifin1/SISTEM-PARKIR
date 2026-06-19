<?php
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika menggunakan XAMPP standar
$db   = "db_parkir";

// Koneksi tanpa database terlebih dahulu
$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

// Baca file SQL
$sql = file_get_contents('database/db-parkir.sql');

// Jalankan setiap query
$queries = array_filter(array_map('trim', explode(';', $sql)));

$success = true;
$messages = [];

foreach ($queries as $query) {
    if (!empty($query)) {
        if (!mysqli_multi_query($conn, $query . ';')) {
            $success = false;
            $messages[] = "Error: " . mysqli_error($conn);
        } else {
            // Buang hasil query yang tertunda
            while (mysqli_next_result($conn)) {
                if (!mysqli_more_results($conn)) break;
            }
            $messages[] = "✓ Query executed";
        }
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Setup</title>
    <style>
        body { font-family: Arial; margin: 50px; }
        .success { color: green; }
        .error { color: red; }
        .container { background: #f0f0f0; padding: 20px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Parking System Database Setup</h2>
        <?php if ($success): ?>
            <p class="success"><strong>✓ Database setup successful!</strong></p>
            <p>Tables created:</p>
            <ul>
                <li>users</li>
                <li>pengaturan</li>
                <li>parkir</li>
            </ul>
            <p><strong>Default Credentials:</strong></p>
            <ul>
                <li>Username: <strong>KOYORRRR</strong>, Password: <strong>12345</strong> (Admin)</li>
                <li>Username: <strong>PETUGAS1</strong>, Password: <strong>12345</strong> (Petugas)</li>
            </ul>
            <p><a href="login.php">Go to Login Page</a></p>
        <?php else: ?>
            <p class="error"><strong>✗ Setup failed!</strong></p>
            <p>Messages:</p>
            <ul>
                <?php foreach ($messages as $msg): ?>
                    <li><?php echo htmlspecialchars($msg); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</body>
</html>
