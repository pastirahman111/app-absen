<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Guru dan Siswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <h2>Tambah Guru</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>ID Guru</label>
                    <input type="text" name="id_guru" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Nama Guru</label>
                    <input type="text" name="nama_guru" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md">
                    <label>Sekolah</label>
                    <select name="id_sekolah" class="form-control" required>
                        <option value="">-- Pilih Sekolah --</option>
                        <?php
                        $sekolah = mysqli_query($coneksi, "SELECT * FROM sekolah");
                        while ($row = mysqli_fetch_assoc($sekolah)) {
                            echo "<option value='{$row['id_sekolah']}'>{$row['nama_sekolah']}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4">
                    <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                </div>
                <div class="col-md-8 text-right">
                    <a href="index.php?page=guru" class="btn btn-warning">KEMBALI</a>
                </div>
            </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $id_guru   = $_POST['id_guru'];
            $nama_guru = $_POST['nama_guru'];
            $username  = $_POST['username'];
            $password  = $_POST['password'];
            $id_sekolah = $_POST['id_sekolah'];

            // Validasi input dasar
            if (empty($id_guru) || empty($nama_guru) || empty($username) || empty($password)) {
                echo '<script>alert("Semua kolom wajib diisi."); window.history.back();</script>';
                exit;
            }
            // Cek apakah ID guru atau username sudah digunakan
            $cek = mysqli_query($coneksi, "SELECT * FROM guru WHERE id_guru='$id_guru' OR username='$username'");

            if (mysqli_num_rows($cek) > 0) {
                echo '<script>
                    Swal.fire({
                            icon: "warning",
                            title: "Warning",
                            text: "Id guru sudah di gunakan",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                            window.location.href = "index.php?page=guru";
                            }
                        });
                </script>';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $query = mysqli_query($coneksi, "INSERT INTO guru 
                    (id_guru, 
                    nama_guru, 
                    username, 
                    password, 
                    id_sekolah)
                    VALUES 
                    ('$id_guru', 
                    '$nama_guru', 
                    '$username', 
                    '$password', 
                    '$id_sekolah')");

                if ($query) {
                    echo'<script>
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: "Berhasil Menambahkan Guru",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                            window.location.href = "index.php?page=guru";
                            }
                        });
                        </script>';
                    } else {
                        echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Gagal Menambahkan Guru",
                            text: "' . mysqli_error($coneksi) . '",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                            window.location.href = "index.php?page=guru";
                            }
                        });
                            </script>';
                    } 
            }
        }
        ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>