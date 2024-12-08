<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi database sudah benar

$error_message = ''; // Variabel untuk pesan error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil input username dan password dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);
}

    // Query untuk memeriksa kombinasi username dan password
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['username'] = $username; // Simpan username dalam sesi
    header("Location: dashboard.php"); // Arahkan ke dashboard jika login berhasil
        exit();
    } else {
        $error_message = "Username atau password salah!"; // Pesan kesalahan login

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Web Pembayaran Syahriyah Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        /* Kontainer untuk gambar latar belakang */
        .background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('image/pondok.jpg'); /* Pastikan path gambar sesuai */
            background-size: cover;
            background-position: center;
            filter: blur(0px); /* Efek blur pada gambar latar belakang */
            z-index: -1; /* Menempatkan gambar di belakang konten */
        }
        .login-container {
            text-align: center;
            width: 300px;
            background: rgba(255, 255, 255, 0.8); /* Transparansi untuk teks tetap terbaca */
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .login-container img {
            width: 80px;
            margin-bottom: 1rem;
        }
        h2 {
            color: #555;
            margin-bottom: 1rem;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            width: 100%;
            padding: 0.5rem;
            background-color: #00a3a8;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #006269;
        }
        .error {
            color: red;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <!-- Gambar latar belakang yang blur -->
    <div class="background"></div>

    <div class="login-container">
        <img src="image/alfalah.jpg" alt="PEMBAYARAN SYAHRIAH BULANAN" style="width: 130px; margin-bottom: 1rem;">

        <h2>Silahkan Masuk</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <?php if (!empty($error_message)) { ?>
            <div class="error"><?= $error_message ?></div>
        <?php } ?>
    </div>
</body>
</html>
