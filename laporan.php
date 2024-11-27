<?php
include 'koneksi.php';

// Handle Filter
$filterKelas = '';  // Default filter value (empty)
if (isset($_POST['filterKelas'])) {
    $filterKelas = $_POST['kelas'];  // Get the filter value from the form
    $query = "SELECT santri.nis, santri.nama, santri.kelas, santri.alamat, pembayaran.status
              FROM santri  -- Ubah dari siswa ke santri jika memang nama tabelnya santri
              LEFT JOIN pembayaran ON santri.nis = pembayaran.nis
              WHERE santri.kelas LIKE '%$filterKelas%'";  // Query with filter
} else {
    $query = "SELECT santri.nis, santri.nama, santri.kelas, santri.alamat, pembayaran.status
              FROM santri  -- Ubah dari siswa ke santri jika memang nama tabelnya santri
              LEFT JOIN pembayaran ON santri.nis = pembayaran.nis";  // Default query with no filter
}

$result = mysqli_query($koneksi, $query);

if (!$result) {
    // If query failed, display the error
    die("Query failed: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Santri</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 20px;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Laporan Data Santri</h1>
    
    <!-- Filter Form -->
    <form method="POST" action="laporan.php" class="form-inline mb-3">
        <label for="kelas" class="mr-2">Filter Kelas:</label>
        <input type="text" name="kelas" id="kelas" class="form-control mr-2" placeholder="Masukkan Kelas" value="<?php echo htmlspecialchars($filterKelas); ?>">
        <button type="submit" name="filterKelas" class="btn btn-success">Filter</button> <!-- Tombol Filter jadi hijau -->
        <!-- Reset Button: Clear the filter -->
        <a href="laporan.php" class="btn btn-danger ml-2">Reset</a> <!-- Tombol Reset jadi merah -->
    </form>

    <!-- Data Siswa Table -->
    <table class="table table-bordered table-striped">
        <thead class="bg-primary">
            <tr>
                <th>No</th>
                <th>Nis</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status Pembayaran</th>  <!-- Column name changed to Status Pembayaran -->
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            // Check if payment status is "Lunas" or "Belum Lunas"
            $status = ($row['status'] == 'Lunas') ? 'Lunas' : 'Belum Lunas';
            
            echo "<tr>";
            echo "<td>$no</td>";
            echo "<td>{$row['nis']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['kelas']}</td>";
            echo "<td>$status</td>";  // Display payment status
            echo "</tr>";
            $no++;
        }
        ?>
        </tbody>
    </table>

    <!-- Button to Print Report -->
    <button class="btn btn-primary mt-3" onclick="window.print()">Cetak Laporan</button>
</div>

<!-- Include JS Libraries -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
