<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
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
        .form-row {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Siswa</h2>
        <hr>

        <?php
        if (isset($_GET['id_siswa'])) {
            $id_siswa = $_GET['id_siswa'];
            $select = mysqli_query($coneksi, "SELECT * FROM siswa WHERE id_siswa='$id_siswa'") or die(mysqli_error($coneksi));
            
            if (mysqli_num_rows($select) == 0) {
                    echo '
                        <scrip>
                            Swal.fire({
                                icon: "error",
                                title: "id siswa tidak ada di database!",
                                timer: 1500,
                                showConfirmButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "index.php?page=siswa";
                                }
                            });
                        </script>';
            } else {
                $data = mysqli_fetch_assoc($select);
            }
        }

        if (isset($_POST['submit'])) {
            $nisn = $_POST['nisn'];
            $nama_siswa = $_POST['nama_siswa'];
            $kelas = $_POST['kelas'];
            $pro_keahlian = $_POST['pro_keahlian'];
            $ttl = $_POST['ttl'];
            $id_sekolah = $_POST['id_sekolah'];
            $id_perusahaan = $_POST['id_perusahaan'];
            $tanggal_mulai = $_POST['tanggal_mulai'];
            $tanggal_selesai = $_POST['tanggal_selesai'];
            $id_pembimbing = $_POST['id_pembimbing'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $no_wa = $_POST['no_wa'];

            $sql = mysqli_query($coneksi, "UPDATE siswa SET 
            nisn='$nisn', 
            nama_siswa='$nama_siswa', 
            kelas='$kelas', 
            pro_keahlian='$pro_keahlian', 
            ttl='$ttl', 
            id_sekolah='$id_sekolah', 
            id_perusahaan='$id_perusahaan', 
            tanggal_mulai='$tanggal_mulai', 
            tanggal_selesai='$tanggal_selesai', 
            id_pembimbing='$id_pembimbing', 
            username='$username', 
            password='$password', 
            no_wa='$no_wa' 
            WHERE 
            id_siswa='$id_siswa'") or die(mysqli_error($coneksi));

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
                                window.location.href = "index.php?page=siswa";
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
                </script>';
            } 
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_siswa" value="<?php echo $id_siswa; ?>">
            
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>NISN</label>
                    <input type="text" name="nisn" class="form-control" value="<?php echo htmlspecialchars($data['nisn']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama_siswa" class="form-control" value="<?php echo htmlspecialchars($data['nama_siswa']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Kelas</label>
                    <select name="kelas" class="form-control" required>
                        <option value="<?php echo htmlspecialchars($data['kelas']); ?>"><?php echo htmlspecialchars($data['kelas']); ?></option>
                        <option value="12 RPL A">12 RPL A</option>
                        <option value="12 RPL B">12 RPL B</option>
                        <option value="12 RPL C">12 RPL C</option>
                        <option value="12 ELIND A">12 ELIND A</option>
                        <option value="12 ELIND B">12 ELIND B</option>
                        <option value="12 ELIND C">12 ELIND C</option>
                        <option value="12 MEKA A">12 MEKA A</option>
                        <option value="12 MEKA B">12 MEKA B</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Program Keahlian</label>
                    <select name="pro_keahlian" class="form-control" required>
                        <option value="<?php echo htmlspecialchars($data['pro_keahlian']); ?>"><?php echo htmlspecialchars($data['pro_keahlian']); ?></option>
                        <option value="Elektronika">Elektronika</option>
                        <option value="Perangkat Lunak">Perangkat Lunak</option>
                        <option value="Mekatronika">Mekatronika</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Tempat Tanggal Lahir</label>
                    <input type="text" name="ttl" class="form-control" value="<?php echo htmlspecialchars($data['ttl']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Sekolah</label>
                    <select name="id_sekolah" class="form-control" required>
                        <?php
                        $data_sekolah = mysqli_query($coneksi, "SELECT * FROM sekolah");
                        while ($row = mysqli_fetch_array($data_sekolah)) {
                        ?>
                            <option value="<?php echo htmlspecialchars($row['id_sekolah']); ?>" <?php echo ($row['id_sekolah'] == $data['id_sekolah']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['nama_sekolah']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Perusahaan</label>
                    <select name="id_perusahaan" class="form-control" required>
                        <?php
                        $data_perusahaan = mysqli_query($coneksi, "SELECT * FROM perusahaan");
                        while ($row = mysqli_fetch_array($data_perusahaan)) {
                        ?>
                            <option value="<?php echo htmlspecialchars($row['id_perusahaan']); ?>" <?php echo ($row['id_perusahaan'] == $data['id_perusahaan']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['nama_perusahaan']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="<?php echo htmlspecialchars($data['tanggal_mulai']); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="<?php echo htmlspecialchars($data['tanggal_selesai']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Pembimbing</label>
                    <select name="id_pembimbing" class="form-control" required>
                        <?php
                        $data_pembimbing = mysqli_query($coneksi, "SELECT * FROM pembimbing");
                        while ($row = mysqli_fetch_array($data_pembimbing)) {
                        ?>
                            <option value="<?php echo htmlspecialchars($row['id_pembimbing']); ?>" <?php echo ($row['id_pembimbing'] == $data['id_pembimbing']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($row['nama_pembimbing']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($data['username']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo htmlspecialchars($data['password']); ?>" required>
                </div>
                <div class="form-group col-md-3">
                    <label>No Wa</label>
                    <input type="text" name="no_wa" class="form-control" value="<?php echo htmlspecialchars($data['no_wa']); ?>" placeholder="62xxxx" required>
                </div>
            </div>
            
            <div class="form-group row">
                <div class="col text-left">
                    <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                </div>
                <div class="col text-center">
                    <a href="" class="btn btn-danger btn-hapus" data-id="<?php echo $data['id_siswa']; ?>" >Hapus</a>
                </div>
                <div class="col text-right">
                    <a href="index.php?page=siswa" class="btn btn-warning">KEMBALI</a>
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
                            window.location.href = 'index.php?page=hapussiswa&id_siswa=' + id;
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
