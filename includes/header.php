<?php 
session_start(); 
if(!isset($_SESSION['login'])) { header("Location: /parking_system/login.php"); exit; } 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Parkir SMAN Bandar Lampung</title>
    <link rel="stylesheet" href="http://localhost/parking_system/assets/css/style.css">
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main-content">