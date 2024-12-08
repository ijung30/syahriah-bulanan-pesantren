<?php
include 'koneksi.php';

// Handle Tambah Pembayaran
if (isset($_POST['addPayment'])) {
    if (isset($_POST['nis'], $_POST['bulan'], $_POST['jumlah'], $_POST['status'])) {
        $nis = $_POST['nis'];
        $bulan = $_POST['bulan'];
        $jumlah = $_POST['jumlah'];
        $status = $_POST['status'];

        $query = "INSERT INTO pembayaran (nis, bulan, jumlah, status) VALUES ('$nis', '$bulan', '$jumlah', '$status')";
        if (mysqli_query($koneksi, $query)) {
            header("Location: pembayaran.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "Some required fields are missing.";
    }
}

// Handle Edit Pembayaran
if (isset($_POST['editPayment'])) {
    if (isset($_POST['nis'], $_POST['bulan'], $_POST['jumlah'], $_POST['status'])) {
        $nis = $_POST['nis'];
        $bulan = $_POST['bulan'];  // Memastikan bulan diterima
        $jumlah = $_POST['jumlah'];
        $status = $_POST['status'];

        $query = "UPDATE pembayaran SET jumlah='$jumlah', status='$status' WHERE nis='$nis' AND bulan='$bulan'";
        if (mysqli_query($koneksi, $query)) {
            header("Location: pembayaran.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    } else {
        echo "Some required fields are missing.";
    }
}

// Handle Hapus Pembayaran
if (isset($_GET['delete']) && isset($_GET['bulan'])) {
    $nis = $_GET['delete'];
    $bulan = $_GET['bulan'];

    $query = "DELETE FROM pembayaran WHERE nis='$nis' AND bulan='$bulan'";
    if (mysqli_query($koneksi, $query)) {
        header("Location: pembayaran.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

// Ambil Data Pembayaran
$query = "SELECT p.nis, s.nama, p.bulan, p.jumlah, p.status 
          FROM pembayaran p
          JOIN santri s ON p.nis = s.nis";
$result = mysqli_query($koneksi, $query);

// Cek jika query berhasil atau tidak
if (!$result) {
    die('Query Error: ' . mysqli_error($koneksi));
}
?>

<!-- AdminLTE CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    /* Center the table within the container */
    .table-wrapper {
        display: flex;
        justify-content: center; /* Center horizontally */
        margin-top: 20px; /* Optional, adjust as needed */
    }

    table {
        width: 80%; /* Adjust the width as needed */
        margin: 0 auto;
    }

    /* Ensure the cards take up the same width as the chart */
    .small-box {
        min-height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .small-box-footer {
        padding: 10px;
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
                        <a href="logout.php" class="nav-link" onclick="return confirmLogout();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <div class="content-wrapper">
        <div class="container mt-4">
            <h1>Data Pembayaran</h1>
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">Tambah Pembayaran</button>

            <!-- Table Wrapper -->
            <div class="table-wrapper">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Santri</th>
                        <th>NIS</th>
                        <th>Bulan</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['nis']}</td>
                            <td>{$row['bulan']}</td>
                            <td>Rp " . number_format($row['jumlah'], 0, ',', '.') . "</td>
                            <td>{$row['status']}</td>
                            <td>
                                <button class='btn btn-success btn-sm' data-toggle='modal' data-target='#editModal' 
                                        onclick='editPayment(\"{$row['nis']}\", \"{$row['bulan']}\", \"{$row['jumlah']}\", \"{$row['status']}\")'>Edit</button>
                                <a href='?delete={$row['nis']}&bulan={$row['bulan']}' class='btn btn-danger btn-sm' 
                                   onclick='return confirm(\"Yakin ingin menghapus data ini?\");'>Hapus</a>
                            </td>
                        </tr>";
                        $no++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tambah Modal -->
        <div class="modal fade" id="addModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Pembayaran</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group"><label for="nis">NIS</label><input type="text" id="nis" name="nis" class="form-control" required></div>
                            <div class="form-group">
                                <label for="bulan">Bulan</label>
                                <select id="bulan" name="bulan" class="form-control" required>
                                    <option value="Januari">Januari</option>
                                    <option value="Februari">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="April">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Juni">Juni</option>
                                    <option value="Juli">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="September">September</option>
                                    <option value="Oktober">Oktober</option>
                                    <option value="November">November</option>
                                    <option value="Desember">Desember</option>
                                </select>
                            </div>
                            <div class="form-group"><label for="jumlah">Jumlah</label><input type="text" id="jumlah" name="jumlah" class="form-control" required></div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="Lunas">Lunas</option>
                                    <option value="Belum Lunas">Belum Lunas</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="addPayment" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Pembayaran</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group"><label for="editNis">NIS</label><input type="text" id="editNis" name="nis" class="form-control" readonly></div>
                            <div class="form-group">
                                <label for="editBulan">Bulan</label>
                                <select id="editBulan" name="bulan" class="form-control" required>
                                    <option value="Januari">Januari</option>
                                    <option value="Februari">Februari</option>
                                    <option value="Maret">Maret</option>
                                    <option value="April">April</option>
                                    <option value="Mei">Mei</option>
                                    <option value="Juni">Juni</option>
                                    <option value="Juli">Juli</option>
                                    <option value="Agustus">Agustus</option>
                                    <option value="September">September</option>
                                    <option value="Oktober">Oktober</option>
                                    <option value="November">November</option>
                                    <option value="Desember">Desember</option>
                                </select>
                            </div>
                            <div class="form-group"><label for="editJumlah">Jumlah</label><input type="text" id="editJumlah" name="jumlah" class="form-control" required></div>
                            <div class="form-group">
                                <label for="editStatus">Status</label>
                                <select id="editStatus" name="status" class="form-control" required>
                                    <option value="Lunas">Lunas</option>
                                    <option value="Belum Lunas">Belum Lunas</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="editPayment" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- JavaScript to Populate Edit Modal -->
<script>
function editPayment(nis, bulan, jumlah, status) {
    document.getElementById('editNis').value = nis;
    document.getElementById('editJumlah').value = jumlah;
    document.getElementById('editStatus').value = status;

    // Set the selected bulan in the dropdown
    var bulanDropdown = document.getElementById('editBulan');
    bulanDropdown.value = bulan;  // Set the bulan value

    // Debugging: Print the selected month
    console.log("Bulan yang dipilih: " + bulan);

    // Periksa apakah bulan ada di dropdown
    var bulanOptions = Array.from(bulanDropdown.options).map(option => option.value);
    console.log("Option bulan yang tersedia: ", bulanOptions);
}
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
