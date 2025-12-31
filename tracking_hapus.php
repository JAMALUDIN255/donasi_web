<?php
// tracking_hapus.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'functions.php';
require 'koneksi.php';

// PENGAMANAN KRITIS: Hanya Admin yang boleh akses.
if (!is_logged() || !is_admin()) {
    header("Location: tracking.php"); 
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if (hapus_tracking($id)) {
        // Redirect setelah sukses
        header("Location: tracking.php?status=deleted");
        exit;
    } else {
        // TANGKAP ERROR DATABASE JIKA GAGAL DELETE
        global $koneksi;
        $db_error = mysqli_error($koneksi);

        // Jika GAGAL, kirimkan pesan error kembali ke halaman tracking
        // Untuk melihat error ini, Anda perlu menambahkan logika penangkapan status di tracking.php
        $error_message = urlencode("Gagal menghapus data tracking. ERROR DB: " . $db_error);
        header("Location: tracking.php?status=error&msg=$error_message");
        exit;
    }
} else {
    header("Location: tracking.php");
    exit;
}
?>