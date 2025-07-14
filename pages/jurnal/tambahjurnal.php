<?php
include('koneksi.php');
if (!isset($_SESSION['level']) || $_SESSION['level'] !== 'siswa') {
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: "error",
            title: "Akses ditolak anda bukan siswa!",
            showConfirmButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?page=jurnal";
            }
        });
    </script>';
}

$tanggal_hari_ini = date('Y-m-d');
$id_siswa = $_SESSION['id_siswa'] ?? "";

if (isset($_POST['submit'])) {
    $keterangan = mysqli_real_escape_string($coneksi, $_POST['keterangan']);

    // Tambahkan jurnal baru (tanpa cek apakah sudah ada di tanggal ini)
    $sql = mysqli_query($coneksi, "INSERT INTO jurnal (tanggal, keterangan, id_siswa) VALUES ('$tanggal_hari_ini', '$keterangan', '$id_siswa')");

    if ($sql){
    $last_id = mysqli_insert_id($coneksi);
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: "success",
            title: "Berhasil menambahkan jurnal baru!",
            showConfirmButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?page=jurnal";
            }
        });
    </script>';
} else {
    echo '
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: "error",
            title: "Gagal menambahkan jurnal",
            text: "' . mysqli_error($coneksi) . '",
            showConfirmButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?page=jurnal";
            }
        });
    </script>';
}

    }

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Jurnal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
            padding: 20px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center text-primary">Tambah Jurnal</h2>
        <form action="" method="post">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" class="form-control" value="<?= $tanggal_hari_ini ?>" readonly>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
            </div>
        </form>
    </div>
</body>
</html>
