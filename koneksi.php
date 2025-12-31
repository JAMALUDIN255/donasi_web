<?php
$host = 'localhost';
$user = 'root';
$pass = ''; // Ganti jika Anda punya password MySQL
$db   = 'donasi_web_db'; // Ganti dengan nama database Anda

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$koneksi = $conn;
$conn->set_charset('utf8mb4');
?>