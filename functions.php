<?php
// functions.php (Perbaikan Final Error Redeclare dengan function_exists)

// Pastikan session_start dipanggil hanya sekali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mengubah require ke require_once untuk menghindari loading berulang
require_once "koneksi.php";

// Gunakan if (!function_exists) untuk mencegah error fatal
if (!function_exists('esc')) {
    function esc($str) {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('is_logged')) {
    function is_logged() {
        return isset($_SESSION['user']);
    }
}

if (!function_exists('is_admin')) {
    function is_admin() {
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }
}

if (!function_exists('current_user')) {
    function current_user() {
        return $_SESSION['user'] ?? null;
    }
}

if (!function_exists('login')) {
    function login($email, $password) {
        global $koneksi;
        $email = mysqli_real_escape_string($koneksi, $email);
        $q = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' LIMIT 1");

        if ($q && mysqli_num_rows($q) === 1) {
            $user = mysqli_fetch_assoc($q);
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('register')) {
    function register($nama, $email, $password) {
        global $koneksi;
        $nama  = mysqli_real_escape_string($koneksi, $nama);
        $email = mysqli_real_escape_string($koneksi, $email);

        $check_q = mysqli_query($koneksi, "SELECT id FROM users WHERE email='$email' LIMIT 1");
        if (mysqli_num_rows($check_q) > 0) {
            return 'email_exist'; 
        }

        $hash  = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$hash', 'pendona')";
        $result = mysqli_query($koneksi, $sql);

        if ($result) {
            $q_user = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email' LIMIT 1");
            if ($q_user && mysqli_num_rows($q_user) === 1) {
                $user = mysqli_fetch_assoc($q_user);
                $_SESSION['user'] = $user;
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('logout')) {
    function logout() {
        session_destroy();
    }
}

// FUNGSI MANAJEMEN DONASI BARANG
if (!function_exists('get_all_donasi_barang')) {
    function get_all_donasi_barang() {
        global $koneksi;
        return mysqli_query($koneksi, "SELECT * FROM donasi ORDER BY id DESC");
    }
}

// di functions.php
if (!function_exists('tambah_donasi_barang')) {
    function tambah_donasi_barang($nama, $barang, $jumlah, $kontak) { // <<< TAMBAH $jumlah
        global $koneksi;
        $nama = mysqli_real_escape_string($koneksi, $nama);
        $barang = mysqli_real_escape_string($koneksi, $barang);
        $jumlah = (int)$jumlah;
        $kontak = mysqli_real_escape_string($koneksi, $kontak);
        $sql = "INSERT INTO donasi (nama, barang, jumlah, kontak, tanggal_donasi) 
                VALUES ('$nama', '$barang', '$jumlah', '$kontak', NOW())"; // <<< TAMBAH jumlah di query
        return mysqli_query($koneksi, $sql);
    }
}

if (!function_exists('update_donasi_barang')) {
    function update_donasi_barang($id, $nama, $barang, $jumlah, $kontak) { // <<< TAMBAH $jumlah
        global $koneksi;
        $id = (int)$id;
        $nama = mysqli_real_escape_string($koneksi, $nama);
        $barang = mysqli_real_escape_string($koneksi, $barang);
        $jumlah = (int)$jumlah;
        $kontak = mysqli_real_escape_string($koneksi, $kontak);
        $sql = "UPDATE donasi SET nama='$nama', barang='$barang', jumlah='$jumlah', kontak='$kontak' WHERE id=$id"; // <<< TAMBAH jumlah di query
        return mysqli_query($koneksi, $sql);
    }
}

if (!function_exists('get_donasi_by_id')) {
    function get_donasi_by_id($id) {
        global $koneksi;
        $id = (int)$id;
        // Pastikan SELECT * akan mengambil kolom jumlah yang baru
        $q = mysqli_query($koneksi, "SELECT * FROM donasi WHERE id = $id LIMIT 1");
        if ($q && mysqli_num_rows($q) == 1) {
            return mysqli_fetch_assoc($q);
        }
        return null;
    }
}

if (!function_exists('hapus_donasi_barang')) {
    function hapus_donasi_barang($id) {
        global $koneksi;
        $id = (int)$id;
        return mysqli_query($koneksi, "DELETE FROM donasi WHERE id = $id");
    }
}
// FUNGSI MANAJEMEN PENYALURAN
if (!function_exists('get_all_penyaluran')) {
    function get_all_penyaluran() {
        global $koneksi;
        return mysqli_query($koneksi, "SELECT * FROM penyaluran ORDER BY id DESC");
    }
}

if (!function_exists('tambah_penyaluran')) {
    function tambah_penyaluran($nama_barang, $jumlah, $penerima, $tanggal) { // MENGGANTI barang_id menjadi nama_barang
        global $koneksi;
        $nama_barang = mysqli_real_escape_string($koneksi, $nama_barang);
        $jumlah = (int)$jumlah;
        $penerima = mysqli_real_escape_string($koneksi, $penerima);
        $tanggal = mysqli_real_escape_string($koneksi, $tanggal);

        $sql = "
            INSERT INTO penyaluran (nama_barang, jumlah, penerima, tanggal)
            VALUES ('$nama_barang', '$jumlah', '$penerima', '$tanggal')
        "; // INSERT nama_barang
        return mysqli_query($koneksi, $sql);
    }
}

if (!function_exists('get_penyaluran_by_id')) {
    function get_penyaluran_by_id($id) {
        global $koneksi;
        $id = (int)$id;
        $q = mysqli_query($koneksi, "SELECT * FROM penyaluran WHERE id = $id LIMIT 1");
        if ($q && mysqli_num_rows($q) == 1) {
            return mysqli_fetch_assoc($q);
        }
        return null;
    }
}

if (!function_exists('update_penyaluran')) {
    function update_penyaluran($id, $nama_barang, $jumlah, $penerima, $tanggal) { // MENGGANTI barang_id menjadi nama_barang
        global $koneksi;
        $id = (int)$id;
        $nama_barang = mysqli_real_escape_string($koneksi, $nama_barang);
        $jumlah = (int)$jumlah;
        $penerima = mysqli_real_escape_string($koneksi, $penerima);
        $tanggal = mysqli_real_escape_string($koneksi, $tanggal);

        $sql = "
            UPDATE penyaluran SET nama_barang='$nama_barang', jumlah='$jumlah', penerima='$penerima', tanggal='$tanggal' 
            WHERE id=$id
        "; // UPDATE nama_barang
        return mysqli_query($koneksi, $sql);
    }
}

if (!function_exists('hapus_penyaluran')) {
    function hapus_penyaluran($id) {
        global $koneksi;
        $id = (int)$id;
        return mysqli_query($koneksi, "DELETE FROM penyaluran WHERE id = $id");
    }
}
// FUNGSI MANAJEMEN TRACKING
if (!function_exists('get_all_tracking')) {
    function get_all_tracking() {
        global $koneksi;
        return mysqli_query($koneksi, "SELECT * FROM tracking ORDER BY id DESC");
    }
}

if (!function_exists('tambah_tracking')) {
    // MENGGANTI barang_id menjadi nama_barang
    function tambah_tracking($nama_barang, $jenis, $jumlah, $keterangan, $tanggal) { 
        global $koneksi;
        $nama_barang = mysqli_real_escape_string($koneksi, $nama_barang);
        $jenis = mysqli_real_escape_string($koneksi, $jenis);
        $jumlah = (int)$jumlah;
        $keterangan = mysqli_real_escape_string($koneksi, $keterangan);
        $tanggal = mysqli_real_escape_string($koneksi, $tanggal);

        $sql = "
            INSERT INTO tracking (nama_barang, jenis, jumlah, keterangan, tanggal)
            VALUES ('$nama_barang', '$jenis', '$jumlah', '$keterangan', '$tanggal')
        "; // INSERT nama_barang
        return mysqli_query($koneksi, $sql);
    }
}

if (!function_exists('get_tracking_by_id')) {
    function get_tracking_by_id($id) {
        global $koneksi;
        $id = (int)$id;
        $q = mysqli_query($koneksi, "SELECT * FROM tracking WHERE id = $id LIMIT 1");
        if ($q && mysqli_num_rows($q) == 1) {
            return mysqli_fetch_assoc($q);
        }
        return null;
    }
}

if (!function_exists('update_tracking')) {
    // MENGGANTI barang_id menjadi nama_barang
    function update_tracking($id, $nama_barang, $jenis, $jumlah, $keterangan, $tanggal) { 
        global $koneksi;
        $id = (int)$id;
        $nama_barang = mysqli_real_escape_string($koneksi, $nama_barang);
        $jenis = mysqli_real_escape_string($koneksi, $jenis);
        $jumlah = (int)$jumlah;
        $keterangan = mysqli_real_escape_string($koneksi, $keterangan);
        $tanggal = mysqli_real_escape_string($koneksi, $tanggal);

        $sql = "
            UPDATE tracking SET nama_barang='$nama_barang', jenis='$jenis', jumlah='$jumlah', keterangan='$keterangan', tanggal='$tanggal' 
            WHERE id=$id
        "; // UPDATE nama_barang
        return mysqli_query($koneksi, $sql);
    }
}

// DI DALAM FILE functions.php

if (!function_exists('hapus_tracking')) {
    function hapus_tracking($id) {
        global $koneksi;
        $id = (int)$id;
        $sql = "DELETE FROM tracking WHERE id = $id LIMIT 1";
        return mysqli_query($koneksi, $sql);
    }
}
// DI DALAM FILE functions.php

if (!function_exists('kurangi_stok_donasi')) {
    function kurangi_stok_donasi($nama_barang, $jumlah_keluar) {
        global $koneksi;
        
        $nama_barang = mysqli_real_escape_string($koneksi, $nama_barang);
        $jumlah_keluar = (int)$jumlah_keluar;

        // 1. Update stok di item donasi yang memiliki stok cukup
        $sql_update = "
            UPDATE donasi 
            SET jumlah = jumlah - $jumlah_keluar
            WHERE barang = '$nama_barang' AND jumlah >= $jumlah_keluar
            LIMIT 1
        ";

        $result = mysqli_query($koneksi, $sql_update);

        if ($result && mysqli_affected_rows($koneksi) > 0) {
            
            // 2. !!! HAPUS LOGIKA PENGECEKAN DAN DELETE DI SINI !!!
            // Baris donasi tidak akan dihapus, hanya stoknya yang menjadi nol.

            return true;
        }
        return false; // Gagal mengurangi stok (stok tidak cukup atau nama barang tidak ditemukan)
    }
}
?>