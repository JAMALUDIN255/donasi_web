<?php
session_start();
require 'functions.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    if (login($email, $password)) {
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Donasi Web</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

   <style>
    /* Styling untuk Body (Latar Belakang Gambar) */
    body { 
        font-family: 'Inter', sans-serif; 
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        
        /* Background Gambar dengan Overlay Gelap */
        background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url('bg1_donasi.jpg'); 
        /* Pastikan 'bg1_donasi.jpg' berada di lokasi yang benar */
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: #fff;
    }

    /* Styling untuk Card Login */
    .card {
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        background: rgba(255, 255, 255, 0.95); /* Semi-transparan agar elegan */
        color: #333;
        max-width: 400px;
        width: 90%;
        padding: 25px;
    }
    
    .card-title {
        font-weight: 700;
        color: #5b86e5; /* Warna sesuai tema Donasi */
    }

    .form-label {
        font-weight: 600;
    }

    /* Styling untuk Footer */
    .login-footer {
        margin-top: 20px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.8rem;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        position: fixed;
        bottom: 10px;
        width: 100%;
        text-align: center;
    }
</style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4 login-card">

        <h3 class="text-center mb-3 fw-bold">LOGIN ADMIN</h3>
        <p class="text-center text-muted mb-3">Masuk untuk melanjutkan</p>

        <?php if($error): ?>
            <div class="alert alert-danger text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">

            <div class="mb-3">
                <label class="fw-bold">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email..." required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
            </div>

            <button class="btn btn-primary w-100 mt-2">Login</button>

            <p class="text-center mt-3">
                <a href="index.php">Kembali ke Beranda</a>
            </p>

        </form>

    </div>
</div>

</body>
</html>