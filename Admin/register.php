<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name        = trim($_POST['full_name'] ?? '');
    $username         = trim($_POST['username'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $password         = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role             = ($_POST['role'] === 'Super Admin') ? 'Super Admin' : 'Staff';

    if (empty($full_name) || empty($username) || empty($email) || empty($password)) {
        $error_msg = 'Semua kolom wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = 'Format email tidak valid.';
    } elseif (strlen($password) < 6) {
        $error_msg = 'Password minimal harus terdiri dari 6 karakter.';
    } elseif ($password !== $confirm_password) {
        $error_msg = 'Konfirmasi password tidak cocok.';
    } else {
        $esc_name  = mysqli_real_escape_string($conn, $full_name);
        $esc_user  = mysqli_real_escape_string($conn, $username);
        $esc_email = mysqli_real_escape_string($conn, $email);

        // Cek apakah username atau email sudah terdaftar
        $cek = mysqli_query($conn, "SELECT admin_id FROM admins WHERE username = '$esc_user' OR email = '$esc_email' LIMIT 1");
        if ($cek && mysqli_num_rows($cek) > 0) {
            $error_msg = 'Username atau Email sudah terdaftar. Gunakan yang lain.';
        } else {
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $esc_pass    = mysqli_real_escape_string($conn, $hashed_pass);

            $sql_insert = "INSERT INTO admins (full_name, username, email, password, role) 
                           VALUES ('$esc_name', '$esc_user', '$esc_email', '$esc_pass', '$role')";
            if (mysqli_query($conn, $sql_insert)) {
                header('Location: login.php?registered=1');
                exit;
            } else {
                $error_msg = 'Gagal mendaftarkan akun: ' . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - CORTIS Admin Panel</title>
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
            max-width: 460px;
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
        .form-control:focus, .form-select:focus {
            border-color: var(--cortis-accent);
            box-shadow: 0 0 0 0.25rem rgba(0, 186, 198, 0.25);
        }
    </style>
</head>
<body>

<div class="card auth-card p-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold text-accent mb-1">REGISTER ADMIN</h3>
        <p class="text-secondary small mb-0">Buat Akun Pengelola CORTIS Management System</p>
    </div>

    <?php if ($error_msg !== '') : ?>
        <div class="alert alert-danger py-2 small"><?= htmlspecialchars($error_msg) ?></div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="full_name" class="form-control" placeholder="Contoh: Rifdah Ramadhani" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Username unik" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Role / Hak Akses</label>
                <select name="role" class="form-select">
                    <option value="Staff">Staff</option>
                    <option value="Super Admin">Super Admin</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
            </div>
            <div class="col-md-6 mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
            <i class="fas fa-user-plus me-1"></i> Daftar Akun Admin
        </button>
    </form>

    <div class="text-center small text-secondary">
        Sudah memiliki akun? <a href="login.php" class="text-accent text-decoration-none fw-bold">Login di sini</a>
    </div>
</div>

</body>
</html>