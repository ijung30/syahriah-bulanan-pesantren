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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
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
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['nis']}</td>";
            echo "<td>{$row['nama']}</td>";
            echo "<td>{$row['kelas']}</td>";
            echo "<td>{$row['alamat']}</td>";
            echo "<td>
                    <button class='btn btn-success btn-sm' data-toggle='modal' data-target='#editModal' 
                           data-nis='{$row['nis']}' data-nama='{$row['nama']}' data-kelas='{$row['kelas']}' data-alamat='{$row['alamat']}'>
                        Edit
                    </button>
                    <a href='data_santri.php?deleteId={$row['nis']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah kamu yakin ingin menghapus data siswa?\");'>Hapus</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modal Tambah Santri -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="data_santri.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Santri</h5>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Santri</h5>
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

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Pass data to Edit Modal
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var nis = button.data('nis'); // Get data from the data-nis attribute
        var nama = button.data('nama'); // Get data from the data-nama attribute
        var kelas = button.data('kelas'); // Get data from the data-kelas attribute
        var alamat = button.data('alamat'); // Get data from the data-alamat attribute

        // Populate modal fields with the retrieved data
        var modal = $(this);
        modal.find('#editNis').val(nis);
        modal.find('#editNama').val(nama);
        modal.find('#editKelas').val(kelas);
        modal.find('#editAlamat').val(alamat);
    });
</script>

</body>
</html>
