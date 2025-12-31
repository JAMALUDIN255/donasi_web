<?php
// logout.php (Versi Paling Agresif untuk Menghancurkan Sesi)

// Wajib start session sebelum bisa destroy
session_start(); 

// Hancurkan semua data session yang terdaftar
session_unset();

// Hancurkan session yang terkait
session_destroy();

// PENGHANCURAN COOKIE SESI (Ini yang sering terlewat!)
// Ambil parameter cookie session PHP
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, // Set masa lalu (kedaluwarsa)
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Alihkan kembali ke halaman login
header("Location: login.php");
exit;
?>