<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru</title>
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
        <h2>Edit Guru</h2>
        <hr>

        <?php
        if (isset($_GET['id_guru'])) {
            $id_guru = $_GET['id_guru'];
            $select = mysqli_query($coneksi, "SELECT * FROM guru WHERE id_guru='$id_guru'") or die(mysqli_error($coneksi));
            
            if (mysqli_num_rows($select) == 0) {
                echo '<div class="alert alert-warning">ID guru tidak ada dalam database.</div>';
                exit();
            } else {
                $data = mysqli_fetch_assoc($select);
            }
        }

        if (isset($_POST['submit'])) {
            $nama_guru = $_POST['nama_guru'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = mysqli_query($coneksi, "UPDATE guru SET nama_guru='$nama_guru', username='$username', password='$password' WHERE id_guru='$id_guru'") or die(mysqli_error($coneksi));

            if ($sql) {
                                    echo '
                    <script>
                        document.addEventListener("DOMContentLoaded", function () {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: "success",
                                title: "Data berhasil diperbarui",
                                showConfirmButton: false,
                                timer: 2000
                            });
                            setTimeout(function() {
                                window.location.href = "index.php?page=guru";
                            }, 2000);
                        });
                    </script>';
            } else {
                echo'
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "gagal memperbarui data!",
                        });
                        setTimeout(function() {
                                window.location.href = "index.php?page=guru";
                            }, 2000);
                    });
                </script>';
            } 
        }
        ?>

        <form action="" method="post">
            <input type="hidden" name="id_guru" value="<?php echo $id_guru; ?>">

            <div class="form-group">
                <label>Nama Guru</label>
                <input type="text" name="nama_guru" class="form-control" value="<?php echo $data['nama_guru']; ?>" required>
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
                <div class="col text-center">
                    <a href=""  class="btn btn-danger btn-hapus" data-id="<?php echo $data['id_guru']; ?>">Hapus</a>
                </div>
                <div class="col text-right">
                    <a href="index.php?page=guru" class="btn btn-warning">KEMBALI</a>
                </div>
        </form>
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
                            window.location.href = 'index.php?page=hapusguru&id_guru=' + id;
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
