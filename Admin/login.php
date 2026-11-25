<?php
session_start();
require_once 'connection.php';

// Jika sudah login, langsung arahkan ke Dashboard Admin
if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error_msg = '';
$success_msg = '';

if (isset($_GET['registered'])) {
    $success_msg = 'Registrasi berhasil! Silakan login menggunakan akun Anda.';
} elseif (isset($_GET['logged_out'])) {
    $success_msg = 'Anda telah berhasil keluar dari sesi Admin.';
} elseif (isset($_GET['auth_required'])) {
    $error_msg = 'Akses ditolak! Silakan login terlebih dahulu untuk membuka panel Admin.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = trim($_POST['username'] ?? '');
    $password          = $_POST['password'] ?? '';

    if (empty($username_or_email) || empty($password)) {
        $error_msg = 'Username/Email dan Password wajib diisi.';
    } else {
        $esc_user = mysqli_real_escape_string($conn, $username_or_email);
        $q_admin  = mysqli_query($conn, "SELECT * FROM admins WHERE username = '$esc_user' OR email = '$esc_user' LIMIT 1");

        if ($q_admin && mysqli_num_rows($q_admin) === 1) {
            $admin = mysqli_fetch_assoc($q_admin);
            if (password_verify($password, $admin['password'])) {
                session_regenerate_id(true);
                $_SESSION['admin_id']   = $admin['admin_id'];
                $_SESSION['full_name']  = $admin['full_name'];
                $_SESSION['username']   = $admin['username'];
                $_SESSION['admin_role'] = $admin['role'];

                header('Location: index.php');
                exit;
            } else {
                $error_msg = 'Password yang Anda masukkan salah.';
            }
        } else {
            $error_msg = 'Akun admin tidak ditemukan.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CORTIS Admin Panel</title>
    <link rel="stylesheet" href="adminlte/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --cortis-accent: #00bac6;
            --cortis-accent-hover: #009aa3;
        }
        body {
            background-color: #0e1015;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            width: 100%;
            max-width: 420px;
            background-color: #161922;
            border: 1px solid rgba(0, 186, 198, 0.35);
            border-radius: 14px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.55);
        }
        .text-accent { color: var(--cortis-accent) !important; }
        .btn-primary {
            background-color: var(--cortis-accent);
            border-color: var(--cortis-accent);
            color: #111;
            font-weight: 700;
        }
        .btn-primary:hover {
            background-color: var(--cortis-accent-hover);
            border-color: var(--cortis-accent-hover);
            color: #111;
        }
        .form-control:focus {
            border-color: var(--cortis-accent);
            box-shadow: 0 0 0 0.25rem rgba(0, 186, 198, 0.25);
        }
    </style>
</head>
<body>

<div class="card auth-card p-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-accent mb-1">CORTIS ADMIN</h3>
        <p class="text-secondary small mb-0">Masuk ke Panel Manajemen COERZONE</p>
    </div>

    <?php if ($error_msg !== '') : ?>
        <div class="alert alert-danger py-2 small"><?= htmlspecialchars($error_msg) ?></div>
    <?php endif; ?>

    <?php if ($success_msg !== '') : ?>
        <div class="alert alert-info py-2 small"><?= htmlspecialchars($success_msg) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="mb-3">
            <label class="form-label">Username atau Email</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username atau email" required autofocus>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
            <i class="fas fa-sign-in-alt me-1"></i> Login Admin
        </button>
    </form>

    <div class="text-center small text-secondary">
        Belum punya akun pengelola? <a href="register.php" class="text-accent text-decoration-none fw-bold">Daftar di sini</a>
        <div class="mt-2">
            <a href="../index.php" class="text-secondary text-decoration-none"><i class="fas fa-arrow-left me-1"></i> Kembali ke Website Utama</a>
        </div>
    </div>
</div>

</body>
</html>