<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembimbing</title>
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
        <h2>Tambah Pembimbing</h2>
        <hr>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>ID Pembimbing</label>
                    <input type="text" name="id_pembimbing" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Nama Pembimbing</label>
                    <input type="text" name="nama_pembimbing" class="form-control" required>
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
                <label for="id_perusahaan">Perusahaan</label>
                <select name="id_perusahaan" required class="form-control">
                    <option value="">--Pilih Perusahaan--</option>
                    <?php
                    $query = mysqli_query($coneksi, "SELECT * FROM perusahaan");
                    while ($data = mysqli_fetch_assoc($query)) {
                        echo '<option value="'.$data['id_perusahaan'].'">'.$data['nama_perusahaan'].'</option>';
                    }
                    ?>
                </select>
            </div>
            <br>
            <div class="form-group row">
                <div class="col text-left">
                    <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                </div>
                <div class="col text-right">
                    <a href="index.php?page=pembimbing" class="btn btn-warning">KEMBALI</a>
                </div>
        </form>

        <?php
        if (isset($_POST['submit'])) {
            $id_pembimbing	 = $_POST['id_pembimbing'];
            $nama_pembimbing = $_POST['nama_pembimbing'];
            $username		 = $_POST['username'];
            $password		 = $_POST['password'];
            $id_perusahaan   = $_POST['id_perusahaan'];

            $cek = mysqli_query($coneksi, "SELECT * FROM pembimbing WHERE id_pembimbing='id_pembimbing'") or die(mysqli_error($coneksi));

            if (mysqli_num_rows($cek) == 0) {
                $sql = mysqli_query($coneksi, "INSERT INTO pembimbing
                (id_pembimbing, 
                nama_pembimbing, 
                username, 
                password, 
                id_perusahaan) 
                VALUES
                ('$id_pembimbing', 
                '$nama_pembimbing', 
                '$username',
                '$password', 
                '$id_perusahaan')") or die(mysqli_error($coneksi));

                if ($sql) {
                    echo'<script>
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: "Berhasil Menambahkan Pembimbing",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                            window.location.href = "index.php?page=pembimbing";
                            }
                        });
                        </script>';
                    } else {
                        echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Gagal Menambahkan Pembimbing",
                            text: "' . mysqli_error($coneksi) . '",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                            window.location.href = "index.php?page=pembimbing";
                            }
                        });
                            </script>';
                    } 
            } else {
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "ID Pembimbing sudah ada",
                        text: "' . mysqli_error($coneksi) . '",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "index.php?page=pembimbing";
                        }
                    });
                </script>';
            }
        }        
                
?>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>
</html>
