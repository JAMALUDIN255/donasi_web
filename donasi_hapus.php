<?php
// donasi_hapus.php
session_start();
require 'functions.php';
require 'koneksi.php';

// CEK LOGIN DAN ROLE ADMIN (HARUS LOGIN DAN HARUS ADMIN)
if (!is_logged() || !is_admin()) {
    header("Location: donasi.php"); 
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if (hapus_donasi_barang($id)) {
        header("Location: donasi.php?status=deleted");
        exit;
    } else {
        header("Location: donasi.php?status=error_delete");
        exit;
    }
} else {
    header("Location: donasi.php");
    exit;
}
?>