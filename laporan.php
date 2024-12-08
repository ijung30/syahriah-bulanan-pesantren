<?php
include 'koneksi.php';

// Initialize the filter variable
$filterKelas = isset($_POST['kelas']) ? $_POST['kelas'] : '';

// Handle Tambah Pembayaran
if (isset($_POST['addPayment'])) {
    if (isset($_POST['nis'], $_POST['bulan'], $_POST['jumlah'], $_POST['status'])) {
        $nis = $_POST['nis'];
        $bulan = $_POST['bulan'];
        $jumlah = $_POST['jumlah'];
        $status = $_POST['status'];

        // Prepared statement untuk keamanan
        $query = "INSERT INTO pembayaran (nis, bulan, jumlah, status) VALUES (?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($koneksi, $query)) {
            mysqli_stmt_bind_param($stmt, "ssss", $nis, $bulan, $jumlah, $status);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: pembayaran.php");
                exit;
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
        }
    } else {
        echo "Some required fields are missing.";
    }
}

// Handle Edit Pembayaran
if (isset($_POST['editPayment'])) {
    if (isset($_POST['nis'], $_POST['bulan'], $_POST['jumlah'], $_POST['status'])) {
        $nis = $_POST['nis'];
        $bulan = $_POST['bulan'];
        $jumlah = $_POST['jumlah'];
        $status = $_POST['status'];

        // Prepared statement untuk keamanan
        $query = "UPDATE pembayaran SET jumlah=?, status=? WHERE nis=? AND bulan=?";
        if ($stmt = mysqli_prepare($koneksi, $query)) {
            mysqli_stmt_bind_param($stmt, "ssss", $jumlah, $status, $nis, $bulan);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: pembayaran.php");
                exit;
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
        }
    } else {
        echo "Some required fields are missing.";
    }
}

// Handle Hapus Pembayaran
if (isset($_GET['delete']) && isset($_GET['bulan'])) {
    $nis = $_GET['delete'];
    $bulan = $_GET['bulan'];

    // Prepared statement untuk menghapus data
    $query = "DELETE FROM pembayaran WHERE nis=? AND bulan=?";
    if ($stmt = mysqli_prepare($koneksi, $query)) {
        mysqli_stmt_bind_param($stmt, "ss", $nis, $bulan);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: pembayaran.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}

// Modify SQL Query Based on Filter
$query = "SELECT p.nis, s.nama, p.bulan, p.jumlah, p.status, s.kelas 
          FROM pembayaran p
          JOIN santri s ON p.nis = s.nis";
if ($filterKelas != '') {
    $query .= " WHERE s.kelas LIKE ?";
}

$stmt = mysqli_prepare($koneksi, $query);
if ($filterKelas != '') {
    mysqli_stmt_bind_param($stmt, "s", $filterKelas);
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Cek jika query berhasil atau tidak
if (!$result) {
    die('Query Error: ' . mysqli_error($koneksi));
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

<style>
    thead th {
        background-color: #f8f9fa; /* Light gray background */
        color: #000; /* Black text */
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
            <img src="image/alfalah.jpg" alt="Logo alfalah" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">SYAHRIAH BULANAN</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="dashboard.php" class="nav-link">
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
                        <a href="laporan.php" class="nav-link active">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>Laporan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link" onclick="return confirm('Apakah Anda yakin ingin logout?');">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="content-wrapper">
        <div class="container mt-4">
            <h1>Laporan Data Santri</h1>
            
            <!-- Filter Form -->
            <form method="POST" action="laporan.php" class="form-inline mb-3">
                <label for="kelas" class="mr-2">Filter Kelas:</label>
                <input type="text" name="kelas" id="kelas" class="form-control mr-2" placeholder="Masukkan Kelas" value="<?php echo htmlspecialchars($filterKelas); ?>">
                <button type="submit" name="filterKelas" class="btn btn-success">Filter</button>
                <a href="laporan.php" class="btn btn-danger ml-2">Reset</a>
            </form>

            <!-- Data Siswa Table -->
            <div class="table-container">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nis</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $status = ($row['status'] == 'Lunas') ? 'Lunas' : 'Belum Lunas';
                            
                            echo "<tr>";
                            echo "<td>$no</td>";
                            echo "<td>{$row['nis']}</td>";
                            echo "<td>{$row['nama']}</td>";
                            echo "<td>{$row['kelas']}</td>";
                            echo "<td>$status</td>";
                            echo "</tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Button to Print Report -->
            <button class="btn btn-primary mt-3" onclick="window.print()">Cetak Laporan</button>
        </div>
    </div>
</div>

<!-- Include JS Libraries -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
