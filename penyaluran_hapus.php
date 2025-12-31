<?php
// penyaluran_hapus.php
session_start();
require 'functions.php';
require 'koneksi.php';

// PENGAMANAN KRITIS: Hanya Admin yang boleh akses.
if (!is_logged() || !is_admin()) {
    header("Location: penyaluran.php"); 
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if (hapus_penyaluran($id)) {
        header("Location: penyaluran.php?status=deleted");
        exit;
    } else {
        // Debugging error database jika gagal
        header("Location: penyaluran.php?status=error_delete");
        exit;
    }
} else {
    header("Location: penyaluran.php");
    exit;
}
?>