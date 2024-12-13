<?php
include 'koneksi.php';

// Handle Pembayaran
if (isset($_POST['addPayment'])) {
    $nis = $_POST['nis'];
    $bulan = $_POST['bulan'];
    $status = $_POST['status'];
    $jumlah = $_POST['jumlah']; // Get the Jumlah from the form

    $jumlah = str_replace(["Rp", "."], "", $jumlah);

    $query = "INSERT INTO pembayaran (Nis, Bulan, Status, Jumlah) VALUES ('$nis', '$bulan', '$status', '$jumlah')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: pembayaran.php");
        exit;
    } else {
        die("Error query: " . mysqli_error($koneksi));
    }
}

// Update Pembayaran
if (isset($_POST['updatePayment'])) {
    $nis = $_POST['nis'];
    $bulan = $_POST['bulan'];
    $status = $_POST['status'];
    $jumlah = $_POST['jumlah']; // Get the Jumlah from the form

    $jumlah = str_replace(["Rp", "."], "", $jumlah);

    $updateQuery = "UPDATE pembayaran SET Bulan = '$bulan', Status = '$status', Jumlah = '$jumlah' WHERE Nis = '$nis'";

    if (mysqli_query($koneksi, $updateQuery)) {
        header("Location: pembayaran.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Delete Pembayaran
if (isset($_GET['deleteNis'])) {
    $nis = $_GET['deleteNis'];
    $deleteQuery = "DELETE FROM pembayaran WHERE Nis = '$nis'";
    if (mysqli_query($koneksi, $deleteQuery)) {
        header("Location: pembayaran.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Query to fetch data from 'santri' and 'pembayaran' tables
$query = "SELECT santri.Nama, santri.Nis, pembayaran.Bulan, pembayaran.Status, pembayaran.Jumlah 
          FROM santri 
          JOIN pembayaran ON santri.Nis = pembayaran.Nis";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    echo "Error: " . mysqli_error($koneksi);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
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
                        <a href="pembayaran.php" class="nav-link active">
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

    <div class="content-wrapper">
        <section class="content-header">
            <h1>Pembayaran</h1>
        </section>

        <section class="content">
            <div class="container mt-4">
                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">
                    <i class="fas fa-plus-circle"></i> Tambah Pembayaran
                </button>

                <!-- Modal Add -->
                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="pembayaran.php">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalLabel">Tambah Pembayaran</h5>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Nis</label>
                                        <input type="text" name="nis" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Bulan</label>
                                        <input type="text" name="bulan" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input type="text" name="status" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Jumlah</label>
                                        <input type="text" name="jumlah" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="addPayment" class="btn btn-primary">Tambah</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Nis</th>
                            <th>Bulan</th>
                            <th>Status</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['Nama']; ?></td>
                            <td><?php echo $row['Nis']; ?></td>
                            <td><?php echo $row['Bulan']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                            <td>Rp <?php echo number_format($row['Jumlah'], 0, ',', '.'); ?></td>
                            <td>
                                <button class='btn btn-success btn-sm' data-toggle='modal' data-target='#editModal<?php echo $row['Nis']; ?>'>
                                    <i class='fas fa-edit'></i> Edit
                                </button>
                                <button class='btn btn-danger btn-sm' onclick='

                            <td>Rp <?php echo number_format($row['Jumlah'], 0, ',', '.'); ?></td>
                            <td>
                                
                                <button class='btn btn-danger btn-sm' onclick='deletePayment("<?php echo $row['Nis']; ?>")'>
                                    <i class='fas fa-trash'></i> Hapus
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal<?php echo $row['Nis']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $row['Nis']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="pembayaran.php">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel<?php echo $row['Nis']; ?>">Edit Pembayaran</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nis</label>
                                                <input type="text" name="nis" class="form-control" value="<?php echo $row['Nis']; ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Bulan</label>
                                                <input type="text" name="bulan" class="form-control" value="<?php echo $row['Bulan']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <input type="text" name="status" class="form-control" value="<?php echo $row['Status']; ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Jumlah</label>
                                                <input type="text" name="jumlah" class="form-control" value="<?php echo number_format($row['Jumlah'], 0, ',', '.'); ?>" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="updatePayment" class="btn btn-primary">Simpan Perubahan</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script>
    // Function to confirm deletion
    function deletePayment(nis) {
        if (confirm("Apakah Anda yakin ingin menghapus pembayaran untuk NIS: " + nis + "?")) {
            window.location.href = "pembayaran.php?deleteNis=" + nis;
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
