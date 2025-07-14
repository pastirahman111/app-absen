<?php 
include('koneksi.php');

$id = isset($_GET['id_jurnal']) ? mysqli_real_escape_string($coneksi, $_GET['id_jurnal']) : '';


// Ambil data jurnal dan catatan terbaru
$query = "
    SELECT j.*, s.nama_siswa, c.catatan 
    FROM jurnal j
    INNER JOIN siswa s ON j.id_siswa = s.id_siswa
    LEFT JOIN (
        SELECT id_jurnal, catatan
        FROM catatan
        WHERE id_catatan = (
            SELECT MAX(id_catatan) FROM catatan WHERE id_jurnal = '$id'
        )
    ) c ON j.id_jurnal = c.id_jurnal
    WHERE j.id_jurnal = '$id'
";

$result = mysqli_query($coneksi, $query);
$row = mysqli_fetch_assoc($result);

if ($row) {
    $_SESSION['id_siswa'] = $row['id_siswa'];
} else {
    echo "Data jurnal tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jurnal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        .form-container {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .small-date-input {
            width: 150px;
        }
    </style>
</head>
<body>
    <div class="container form-container text-primary">
        <h2 class="text-center">Detail Jurnal</h2>
        <hr>
        <div class="form-group">
            <label>Nama Siswa</label>
            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['nama_siswa']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Tanggal</label>
            <input type="text" class="form-control " value="<?php echo htmlspecialchars($row['tanggal']); ?>" readonly>
        </div>
        <div class="form-group">
            <label>Catatan</label>
            <textarea class="form-control" rows="4" readonly><?php echo htmlspecialchars($row['catatan'] ?? 'Belum ada catatan'); ?></textarea>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" rows="4" readonly><?php echo htmlspecialchars($row['keterangan']); ?></textarea>
        </div>
        <div class="row">
            <div class="col text-left">
               <?php if (!in_array($_SESSION['level'], ['siswa', 'guru'])): ?>
                <a href="#" class="btn btn-danger btn-hapus" data-id="<?= $row['id_jurnal']; ?>">Hapus</a>
                <?php endif; ?>
            </div>
            <div class="col text-right">
                <a href="index.php?page=jurnal" class="btn btn-warning">KEMBALI</a>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const hapusButtons = document.querySelectorAll('.btn-hapus');

    hapusButtons.forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const id = this.getAttribute('data-id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php?page=hapusjurnal&id_jurnal=' + id;
                }
            });
        });
    });
});
</script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
