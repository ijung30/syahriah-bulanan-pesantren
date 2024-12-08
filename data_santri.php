<?php
include 'koneksi.php';

// Handle Tambah Santri
if (isset($_POST['addStudent'])) {
    if (isset($_POST['nis'], $_POST['nama'], $_POST['kelas'], $_POST['alamat'])) {
        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $alamat = $_POST['alamat'];

        $query = "INSERT INTO santri (nis, nama, kelas, alamat) VALUES ('$nis', '$nama', '$kelas', '$alamat')";
        if (mysqli_query($koneksi, $query)) {
            header("Location: data_santri.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "Some required fields are missing.";
    }
}

// Handle Edit Santri
if (isset($_POST['editStudent'])) {
    if (isset($_POST['nis'], $_POST['nama'], $_POST['kelas'], $_POST['alamat'])) {
        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $alamat = $_POST['alamat'];

        $query = "UPDATE santri SET nama='$nama', kelas='$kelas', alamat='$alamat' WHERE nis='$nis'";
        if (mysqli_query($koneksi, $query)) {
            header("Location: data_santri.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "Some required fields are missing.";
    }
}

// Handle Hapus Santri
if (isset($_GET['deleteId'])) {
    $nis = $_GET['deleteId'];

    // Validasi nis
    if (is_numeric($nis)) {
        $query = "DELETE FROM santri WHERE nis='$nis'";
        if (mysqli_query($koneksi, $query)) {
            header("Location: data_santri.php");
            exit;
        } else {
            echo "Error deleting student: " . mysqli_error($koneksi);
        }
    } else {
        echo "Invalid NIS value!";
    }
}

// Ambil data santri dari database
$query = "SELECT * FROM santri";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Santri</title>
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
                        <a href="data_santri.php" class="nav-link active">
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
            <h1>Data Santri</h1>
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">Tambah Santri</button>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Nis</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $row['nis'] ?></td>
                        <td><?= $row['nama'] ?></td>
                        <td><?= $row['kelas'] ?></td>
                        <td><?= $row['alamat'] ?></td>
                        <td>
                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editModal"
                                    data-nis="<?= $row['nis'] ?>" data-nama="<?= $row['nama'] ?>"
                                    data-kelas="<?= $row['kelas'] ?>" data-alamat="<?= $row['alamat'] ?>">
                                Edit
                            </button>
                            <a href="data_santri.php?deleteId=<?= $row['nis'] ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Apakah Anda yakin ingin menghapus data santri ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Santri -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="data_santri.php">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Santri</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nis</label>
                        <input type="text" name="nis" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="addStudent" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Santri -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="data_santri.php">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Santri</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="nis" id="editNis">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" id="editNama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kelas</label>
                        <input type="text" name="kelas" id="editKelas" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" id="editAlamat" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="editStudent" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script>
    // Pass data to Edit Modal
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var nis = button.data('nis');
        var nama = button.data('nama');
        var kelas = button.data('kelas');
        var alamat = button.data('alamat');
        var modal = $(this);
        modal.find('#editNis').val(nis);
        modal.find('#editNama').val(nama);
        modal.find('#editKelas').val(kelas);
        modal.find('#editAlamat').val(alamat);
    });
</script>
</body>
</html>
