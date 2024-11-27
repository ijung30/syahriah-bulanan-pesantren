<?php
// Setting parameter koneksi
$host = 'localhost';        // Host database
$username = 'root';         // Username MySQL
$password = '';             // Password MySQL (kosong jika tidak ada password)
$databasename = 'syahriah';         // Nama database yang digunakan (ubah sesuai dengan nama database Anda)

// Membuat koneksi ke database MySQL
$koneksi = new mysqli($host, $username, $password, $databasename);

// Cek apakah koneksi berhasil
if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);  // Menampilkan error jika koneksi gagal
}

// Menutup koneksi akan dilakukan setelah operasi selesai.
?>