<?php include('koneksi.php');
// Pastikan ID siswa ada dalam session
if (!isset($_SESSION['id_pembimbing'])) {
    header("Location: sign-in.php"); // Arahkan ke halaman login jika belum login
    exit();
} ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembimbing</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
            padding: 20px;
            border-radius: 8px;
            background-color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
            color: #007bff;
        }
        .form-control {
            border: none;
            border-bottom: 2px solid #007bff;
            border-radius: 0;
            box-shadow: none;
        }
        .form-control:focus {
            border-color: #0056b3;
            box-shadow: none;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-warning {
            background-color: #ffc107;
            border: none;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Pembimbing</h2>
        <hr>

        <?php
        if (isset($_GET['id_pembimbing'])) {
            $id_pembimbing = $_GET['id_pembimbing'];
            $select = mysqli_query($coneksi, "SELECT * FROM pembimbing WHERE id_pembimbing='$id_pembimbing'") or die(mysqli_error($coneksi));
            
            if (mysqli_num_rows($select) == 0) {
                echo '<div class="alert alert-warning">ID Pembimbing tidak ada dalam database.</div>';
                exit();
            } else {
                $data = mysqli_fetch_assoc($select);
            }
        }

        if (isset($_POST['submit'])) {
            $id_pembimbing = $_POST['id_pembimbing'];
            $nama_pembimbing = $_POST['nama_pembimbing'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = mysqli_query($coneksi, "UPDATE pembimbing SET nama_pembimbing='$nama_pembimbing', username='$username', password='$password' WHERE id_pembimbing='$id_pembimbing'") or die(mysqli_error($coneksi));

            if ($sql) {
                echo '<script>alert("Berhasil mengupdate data."); document.location="index.php?page=editpembimbing1&id_pembimbing=' . $_SESSION['id_pembimbing'] . '";</script>';
            } else {
                echo '<div class="alert alert-danger">Gagal melakukan proses update data.</div>';
            }
        }
        ?>

        <form action="" method="post">
            <input type="hidden" name="id_pembimbing" value="<?php echo $id_pembimbing; ?>">

            <div class="form-group">
                <label>Nama Pembimbing</label>
                <input type="text" name="nama_pembimbing" class="form-control" value="<?php echo $data['nama_pembimbing']; ?>" required>
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $data['username']; ?>" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $data['password']; ?>" required>
            </div>
            <div class="form-group row">
                <div class="col text-left">
                    <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
