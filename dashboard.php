<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pembayaran Syahriah Bulanan</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    /* Ensure the cards take up the same width as the chart */
    .small-box {
        min-height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .small-box-footer {
        padding: 10px;
        color: white !important; /* Force the text color to white */
    }

    .row {
        display: flex;
        flex-wrap: wrap;  /* Allows the cards to wrap on smaller screens */
        gap: 10px;
        justify-content: space-between;
    }

    .col-lg-4, .col-md-4 {
        flex: 1;
        min-width: 30%; /* Each card takes up 1/3 of the width */
        max-width: 33%; /* Ensures 3 cards per row */
    }

    .col-lg-12 {
        flex: 1;
        width: 100%;
    }

    /* Specifically target the 'Laporan' card footer text to make it white */
    .small-box.bg-warning .small-box-footer {
        color: white !important; /* Ensure the footer text in Laporan card is white */
    }
</style>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
    </nav>
    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="image/alfalah.jpg" alt="Logo alfalah" class="brand-image img-circle elevation-3" style="opacity: .8;">
            <span class="brand-text font-weight-light">SYAHRIAH BULANAN</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link active">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="data_santri.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Santri</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pembayaran.php" class="nav-link">
                            <i class="nav-icon fas fa-credit-card"></i>
                            <p>Pembayaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="laporan.php" class="nav-link">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan</p>
                        </a>
                    </li>
                    <!-- Logout -->
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link" onclick="return confirmLogout();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content -->
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Dashboard Pembayaran Syahriah Bulanan</h1>
        </section>
        <section class="content">
            <!-- Cards -->
            <div class="row">
                <!-- Total Pembayaran -->
                <div class="col-lg-4 col-md-4">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>1200</h3>
                            <p>Data Santri</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="data_santri.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- Persentase Pembayaran -->
                <div class="col-lg-4 col-md-4">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>130</h3>
                            <p>Pembayaran</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <a href="pembayaran.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- Total Laporan -->
                <div class="col-lg-4 col-md-4">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 class="text-light">210</h3>
                            <p class="text-light">Laporan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <a href="laporan.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Grafik Statistik -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Statistik Pembayaran</h3>
                        </div>
                        <div class="card-body">
                            <canvas id="paymentChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Statistik Pembayaran
    const ctx = document.getElementById('paymentChart').getContext('2d');
    const paymentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni'],
            datasets: [{
                label: 'Pembayaran',
                data: [50, 60, 70, 80, 90, 100],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            }
        }
    });

    // Fungsi konfirmasi logout
    function confirmLogout() {
        // Menampilkan pesan konfirmasi logout
        return confirm("Apakah Anda yakin mau keluar dari halaman ini?");
    }
</script>
</body>
</html>