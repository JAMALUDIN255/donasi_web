<?php
// register.php
require 'functions.php';
require 'koneksi.php'; 

if (is_logged()) {
    header("Location: dashboard.php");
    exit;
}

$error_msg = '';

if (isset($_POST['submit'])) {
    $nama     = $_POST['nama'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    if (empty($nama) || empty($email) || empty($password) || empty($confirm)) {
        $error_msg = "Semua kolom harus diisi.";
    } elseif ($password !== $confirm) {
        $error_msg = "Konfirmasi password tidak cocok.";
    } else {
        $registration_result = register($nama, $email, $password);

        if ($registration_result === true) {
            header("Location: dashboard.php");
            exit;
        } elseif ($registration_result === 'email_exist') {
            $error_msg = "Registrasi gagal. Email sudah digunakan.";
        } else {
            global $koneksi;
            $db_error = mysqli_error($koneksi);
            
            if (!empty($db_error)) {
                $error_msg = "Gagal registrasi. ERROR DB: " . htmlspecialchars($db_error);
            } else {
                $error_msg = "Registrasi gagal. Cek struktur kolom tabel users.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #36d1dc, #5b86e5);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .register-box {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }
    </style>
</head>
<body>

<div class="register-box">
    <h3 class="fw-bold text-center mb-4 text-primary">Buat Akun Baru</h3>

    <?php if ($error_msg): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error_msg); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" name="nama" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-4">
            <label for="confirm_password" class="form-label">Ulangi Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>

        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary btn-lg">Daftar Sekarang</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>