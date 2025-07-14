<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pembimbing</title>
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
                echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <script>
                    Swal.fire({
                        icon: "question",
                        title: "Warning",
                        text: "Data Tidak Ditemukan!",
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "index.php?page=editpembimbing";
                    });
                    </script>';
            } else {
                $data = mysqli_fetch_assoc($select);
            }

            if ($data) {
                $_SESSION['id_pembimbing'] = $data['id_pembimbing'];
            }
        }

        if (isset($_POST['submit'])) {
            $id_pembimbing = $_POST['id_pembimbing'];
            $nama_pembimbing = $_POST['nama_pembimbing'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sql = mysqli_query($coneksi, "UPDATE pembimbing SET 
            nama_pembimbing='$nama_pembimbing', 
            username='$username', 
            password='$password' 
            WHERE 
            id_pembimbing='$id_pembimbing'") or die(mysqli_error($coneksi));

            if ($sql) {
                echo '
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "success",
                            title: "Data Pembimbing berhasil diperbarui",
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = "index.php?page=editpembimbing&id_pembimbing=' . $id_pembimbing . '";
                        });
                    });
                </script>';
            } else {
                echo '
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire({
                            toast: true,
                            position: "top-end",
                            icon: "error",
                            title: "Data Pembimbing Gagal memperbarui data!",
                            text: "Terjadi kesalahan saat menyimpan data.",
                            showConfirmButton: true
                        }).then(() => {
                            window.location.href = "index.php?page=pembimbing";
                        });
                    });
                </script>';
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
                <div class="col text-center">
                    <?php if (!in_array($_SESSION['level'], ['pembimbing'])): ?>
                        <a href="" class="btn btn-danger btn-hapus" data-id="<?php echo $data['id_pembimbing']; ?>">Hapus</a>
                    <?php endif; ?>
                </div>
                <div class="col text-right">
                    <?php if (!in_array($_SESSION['level'], ['pembimbing'])): ?>
                        <a href="index.php?page=pembimbing" class="btn btn-warning">KEMBALI</a>
                    <?php endif; ?>
                </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hapusButtons = document.querySelectorAll('.btn-hapus');

            hapusButtons.forEach(function(button) {
                button.addEventListener('click', function(e) {
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
                            window.location.href = 'index.php?page=hapuspembimbing&id_pembimbing=' + id;
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