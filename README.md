  Aplikasi Web Donasi Jamaludin

Aplikasi Web Donasi adalah sebuah sistem berbasis web yang digunakan untuk mengelola proses penggalangan dana (donasi) secara terstruktur. Aplikasi ini memungkinkan admin untuk mengelola data donasi, penyaluran, dan tracking, serta memungkinkan pengguna melihat informasi donasi secara transparan.

Aplikasi ini dibangun menggunakan PHP, MySQL, HTML, CSS, dan Bootstrap, serta dijalankan secara lokal menggunakan XAMPP.

Tujuan Aplikasi

- Mempermudah pengelolaan data donasi
- Menyediakan informasi donasi yang transparan
- Membantu admin dalam mencatat, mengedit, dan menghapus data donasi
- Menyediakan fitur tracking dan penyaluran donasi

Teknologi yang Digunakan

- Bahasa Pemrograman: PHP
- Database: MySQL
- Frontend: HTML, CSS, Bootstrap
- Web Server: Apache (XAMPP)
- Tools: Visual Studio Code, GitHub

Struktur Folder Project
```text
donasi_web/
├── assets/                 # File CSS & JS
├── dashboard.php           # Halaman dashboard admin
├── index.php               # Halaman utama
├── landing.php             # Halaman landing
├── login.php               # Halaman login
├── register.php            # Halaman registrasi
├── logout.php              # Proses logout
├── donasi.php              # Data donasi
├── donasi_tambah.php       # Tambah donasi
├── donasi_edit.php         # Edit donasi
├── donasi_hapus.php        # Hapus donasi
├── penyaluran.php          # Data penyaluran donasi
├── tracking.php            # Tracking donasi
├── koneksi.php             # Koneksi database
└── README.md               # Dokumentasi project
```

Fitur Aplikasi

- Autentikasi login & register
- Dashboard admin
- CRUD data donasi
- CRUD data penyaluran donasi
- Tracking donasi
- Tampilan responsif menggunakan Bootstrap

Preview Aplikasi & Penjelasan Screenshot

1. Halaman Landing Page

Halaman awal aplikasi yang menampilkan informasi umum mengenai aplikasi donasi. Halaman ini menjadi pintu masuk bagi pengguna sebelum melakukan login atau melihat detail donasi.

<img width="1440" height="730" alt="Screen Shot 2025-12-23 at 13 35 24" src="https://github.com/user-attachments/assets/acd3b1e5-b352-4f5f-999c-5803ea872a1a" />


2. Halaman Login

Digunakan oleh admin atau pengguna untuk masuk ke dalam sistem dengan username dan password yang valid.

<img width="1440" height="734" alt="Screen Shot 2025-12-23 at 13 35 36" src="https://github.com/user-attachments/assets/325a715f-2263-470c-85bb-0b7a9f88a6fd" />


3. Dashboard Admin

Menampilkan ringkasan data donasi, penyaluran, dan aktivitas sistem secara keseluruhan dalam satu tampilan.

<img width="1440" height="730" alt="Screen Shot 2025-12-23 at 13 35 52" src="https://github.com/user-attachments/assets/e8e2c48a-52f4-4b39-9190-467fa65c65c2" />


4. Halaman Data Donasi

Menampilkan daftar donasi yang masuk, lengkap dengan fitur tambah, edit, dan hapus data donasi.

<img width="1440" height="734" alt="Screen Shot 2025-12-23 at 13 36 13" src="https://github.com/user-attachments/assets/a553b413-3d7b-4160-af31-5436aa67aeaa" />


5. Halaman Penyaluran Donasi

Digunakan untuk mencatat dan mengelola data penyaluran donasi kepada pihak yang membutuhkan.

<img width="1440" height="731" alt="Screen Shot 2025-12-23 at 13 36 27" src="https://github.com/user-attachments/assets/beb3daa3-f0cd-42d6-b152-fde3bf7a7c6d" />


6. Halaman Tracking Donasi

Fitur ini memungkinkan admin maupun pengguna untuk memantau status dan riwayat donasi yang telah disalurkan.

<img width="1440" height="729" alt="Screen Shot 2025-12-23 at 13 36 34" src="https://github.com/user-attachments/assets/8a20f2d8-f77a-40b8-a55b-399bf8166b4f" />

CARA INSTALL / MENJALANKAN

1. Clone repository ini
2. Pindahkan folder ke `htdocs`
3. Import database ke phpMyAdmin
4. Atur koneksi database di `config/koneksi.php`
5. Jalankan melalui browser


Catatan untuk saya sendiri

Project ini dibuat sebagai tugas pembelajaran dan pengembangan
aplikasi web.
