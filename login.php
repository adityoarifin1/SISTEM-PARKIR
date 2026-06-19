<?php
session_start();
include 'config/database.php';

if (isset($_POST['login'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = $_POST['password'];

    // Cek username admin dengan prepared statement
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $query = $stmt->get_result();
    
    if ($query->num_rows === 1) {
        $row = $query->fetch_assoc();
        // Verify password dengan password_verify
        if (password_verify($pass, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['user'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Akses Admin Ditolak! Periksa kembali.";
        }
    } else {
        $error = "Akses Admin Ditolak! Periksa kembali.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Parkir SMAN Bandar Lampung</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }

        .login-brand {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            color: white;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .login-brand h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .login-brand p {
            font-size: 1rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .school-info {
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 12px;
            font-size: 0.9rem;
        }

        .school-info strong {
            display: block;
            margin-bottom: 0.5rem;
        }

        .login-form-wrapper {
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-wrapper h2 {
            color: #1e40af;
            margin-bottom: 0.5rem;
            font-size: 1.75rem;
        }

        .login-form-wrapper .subtitle {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group input::placeholder {
            color: #94a3b8;
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .alert-error {
            background-color: #fef2f2;
            color: #7f1d1d;
            border-left: 4px solid #dc2626;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.95rem;
        }

        .login-footer {
            text-align: center;
            color: #64748b;
            font-size: 0.85rem;
            margin-top: 1.5rem;
        }

        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
            }

            .login-brand {
                padding: 2rem;
            }

            .login-brand h1 {
                font-size: 1.75rem;
            }

            .login-form-wrapper {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-brand">
            <h1>🅿️ SIM-PARKIR</h1>
            <p>Sistem Informasi Manajemen Parkir Kendaraan</p>
            <div class="school-info">
                <strong>SMAN BANDAR LAMPUNG</strong>
                <div>Rajabasa Jaya, Bandar Lampung 35144</div>
            </div>
        </div>
        
        <div class="login-form-wrapper">
            <h2>Admin Login</h2>
            <p class="subtitle">Masukkan kredensial Anda untuk akses sistem</p>
            
            <?php if(isset($error)) : ?>
                <div class="alert-error">
                    ⚠️ <?= htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Masukkan username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                </div>
                
                <button type="submit" name="login" class="login-btn">Login Sekarang</button>
                
                <div class="login-footer">
                    <p>© 2026 Sistem Parkir SMAN Bandar Lampung. All rights reserved.</p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>