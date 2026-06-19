<?php
$host = "localhost";
$user = "root";
$pass = ""; // Kosongkan jika menggunakan XAMPP standar
$db   = "db_parkir"; // Pastikan nama ini sesuai di phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$conn) {
    die('Database connection error: ' . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>