<?php
include('koneksi.php');

$tanggal_hari_ini = date('Y-m-d');

// Cek role login
$id_pembimbing = $_SESSION['id_pembimbing'] ?? null;
$id_guru = $_SESSION['id_guru'] ?? null;
$id_admin = $_SESSION['id_admin'] ?? null;
$level = $_SESSION['level'] ?? null;

if (!isset($level) || !in_array($level, ['pembimbing', 'guru', 'admin'])) {
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: "error",
            title: "Akses di tolak!",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?page=catatan";
            }
        });
        </script>';
}

// Ambil ID jurnal
$id_jurnal = $_GET['id_jurnal'] ?? null;
    if (!$id_jurnal) {
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: "question",
            title: "Id jurnal tidak di temukan!",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?page=catatan";
            }
        });
        </script>';
}

$id_jurnal = mysqli_real_escape_string($coneksi, $id_jurnal);
$jurnal_result = mysqli_query($coneksi, "SELECT * FROM jurnal WHERE id_jurnal = '$id_jurnal'");
$jurnal_data = mysqli_fetch_assoc($jurnal_result);

if (!$jurnal_data) {
    echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: "question",
            title: "Id jurnal tidak di temukan!",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?page=catatan";
            }
        });
        </script>'; 
}

// Ambil catatan
if ($id_pembimbing) {
    $catatan_result = mysqli_query($coneksi, "SELECT * FROM catatan WHERE id_jurnal = '$id_jurnal' AND id_pembimbing = '$id_pembimbing'");
} else {
    $catatan_result = mysqli_query($coneksi, "SELECT * FROM catatan WHERE id_jurnal = '$id_jurnal' ORDER BY id_catatan DESC LIMIT 1");
}
$catatan_data = mysqli_fetch_assoc($catatan_result);
$catatan = $catatan_data['catatan'] ?? '';

// Proses simpan catatan
if (isset($_POST['submit']) && $id_pembimbing) {
    $catatan = mysqli_real_escape_string($coneksi, $_POST['catatan']);
    $id_catatan = $_POST['id_catatan'] ?? null;

    if ($id_catatan) {
        $cek = mysqli_query($coneksi, "SELECT * FROM catatan WHERE id_catatan='$id_catatan' AND id_pembimbing='$id_pembimbing'");
        if (mysqli_num_rows($cek) > 0) {
            $sql = mysqli_query($coneksi, "UPDATE catatan SET catatan='$catatan' WHERE id_catatan='$id_catatan'");
            $aksi = 'update';
        } else {
            $sql = mysqli_query($coneksi, "INSERT INTO catatan (id_jurnal, tanggal, catatan, id_pembimbing) VALUES ('$id_jurnal', '$tanggal_hari_ini', '$catatan', '$id_pembimbing')");
        }
    } else {
        $sql = mysqli_query($coneksi, "INSERT INTO catatan (id_jurnal, tanggal, catatan, id_pembimbing) VALUES ('$id_jurnal', '$tanggal_hari_ini', '$catatan', '$id_pembimbing')");
    }

    if ($sql) {
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: "success",
            title: "Berhasil '.($aksi == 'update' ? 'mengubah' : 'menambah') .' catatan!",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "index.php?page=catatan";
            }
        });
        </script>';
    } else {
        echo '
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        Swal.fire({
            icon: "error",
            title: "Gagal menambahkan catatan   ",
            text: "' . mysqli_error($coneksi) . '",
            confirmButtonText: "OK"
        });
        </script>';
    }
}

// Data tampilan
$keterangan = $jurnal_data['keterangan'] ?? 'Tidak ada jurnal';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Catatan Jurnal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 30px;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        textarea {
            resize: vertical;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-primary text-center">Detail Jurnal</h2>
        <hr>
        <form action="" method="post">
            <?php if ($catatan_data && $id_pembimbing && $catatan_data['id_pembimbing'] == $id_pembimbing): ?>
                <input type="hidden" name="id_catatan" value="<?= $catatan_data['id_catatan'] ?>">
            <?php endif; ?>
            <input type="hidden" name="id_jurnal" value="<?= htmlspecialchars($id_jurnal) ?>">

            <div class="form-group">
                <label>Tanggal</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($tanggal_hari_ini) ?>" readonly>
            </div>

            <div class="form-group">
                <label>Jurnal</label>
                <textarea class="form-control" rows="4" readonly><?= htmlspecialchars($keterangan) ?></textarea>
            </div>

            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="4" <?= in_array($level, ['guru', 'admin']) ? 'readonly' : '' ?>><?= htmlspecialchars($catatan) ?></textarea>
            </div>
            <div class="row mt-3">
                <div class="col text-left">
                    <?php if ($id_pembimbing && !in_array($level, ['guru', 'admin'])): ?>
                        <input type="submit" name="submit" class="btn btn-primary" value="Simpan">
                    <?php endif; ?>
                </div>
                <div class="col text-right">
                    <a href="index.php?page=catatan" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>