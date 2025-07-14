<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Siswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" />
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
        <h2>Tambah Siswa</h2>
        <hr />
        <form action="" method="post"  enctype="multipart/form-data">
            <input type="hidden" name="id_siswa" value="<?php echo uniqid(); ?>" />

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>NISN</label>
                    <input type="text" name="nisn" class="form-control" required />
                </div>
                <div class="form-group col-md-3">
                    <label>Nama Siswa</label>
                    <input type="text" name="nama_siswa" class="form-control" required />
                </div>
                <div class="form-group col-md-3">
                    <label>Kelas</label>
                    <select name="kelas" class="form-control" required>
                        <option value="">Pilih Kelas</option>
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
                        <option value="">Pilih Program Keahlian</option>
                        <option value="Elektronika">Elektronika</option>
                        <option value="Perangkat Lunak">Perangkat Lunak</option>
                        <option value="Mekatronika">Mekatronika</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Tempat Tanggal Lahir</label>
                    <input type="text" name="ttl" class="form-control" required />
                </div>
                <div class="form-group col-md-3">
                    <label>Sekolah</label>
                    <select name="id_sekolah" class="form-control" required>
                        <?php
                        $data_sekolah = mysqli_query($coneksi, "SELECT * FROM sekolah");
                        while ($row = mysqli_fetch_array($data_sekolah)) {
                            echo '<option value="' . htmlspecialchars($row['id_sekolah']) . '">' . htmlspecialchars($row['nama_sekolah']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Perusahaan</label>
                    <select name="id_perusahaan" class="form-control" required>
                        <?php
                        $data_perusahaan = mysqli_query($coneksi, "SELECT * FROM perusahaan");
                        while ($row = mysqli_fetch_array($data_perusahaan)) {
                            echo '<option value="' . htmlspecialchars($row['id_perusahaan']) . '">' . htmlspecialchars($row['nama_perusahaan']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" class="form-control" required />
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-3">
                    <label>Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" class="form-control" required />
                </div>
                <div class="form-group col-md-3">
                    <label>Pembimbing</label>
                    <select name="id_pembimbing" class="form-control" required>
                        <?php
                        $data_pembimbing = mysqli_query($coneksi, "SELECT * FROM pembimbing");
                        while ($row = mysqli_fetch_array($data_pembimbing)) {
                            echo '<option value="' . htmlspecialchars($row['id_pembimbing']) . '">' . htmlspecialchars($row['nama_pembimbing']) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required />
                </div>
                <div class="form-group col-md-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required />
                </div>
                <div class="form-group col-md-3">
                    <label>No Wa</label>
                    <input type="text" name="no_wa" class="form-control" placeholder="62xxxx" required />
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-3">
                    <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN" />
                </div>
                <div class="col-md-3 offset-md-6 text-right">
                    <a href="index.php?page=siswa" class="btn btn-warning">KEMBALI</a>
                </div>
            </div>
        </form>

<?php
if (isset($_POST['submit'])) {
    $nisn           = $_POST['nisn'];
    $nama_siswa     = $_POST['nama_siswa'];
    $kelas          = $_POST['kelas'];
    $pro_keahlian   = $_POST['pro_keahlian'];
    $ttl            = $_POST['ttl'];
    $id_sekolah     = $_POST['id_sekolah'];
    $id_perusahaan  = $_POST['id_perusahaan'];
    $tanggal_mulai  = $_POST['tanggal_mulai'];
    $tanggal_selesai= $_POST['tanggal_selesai'];
    $id_pembimbing  = $_POST['id_pembimbing'];
    $username       = $_POST['username'];
    $password       = $_POST['password']; 
    $no_wa          = $_POST['no_wa']; 

    // Cek duplikat nisn
    $cek = mysqli_query($coneksi, "SELECT * FROM siswa WHERE nisn='$nisn'");

    if (mysqli_num_rows($cek) == 0) {
        $sql = mysqli_query($coneksi, "INSERT INTO siswa (
        nisn,
        nama_siswa,
        kelas,
        pro_keahlian,
        ttl, id_sekolah,
        id_perusahaan,
        tanggal_mulai, 
        tanggal_selesai, 
        id_pembimbing, 
        username, 
        password, 
        no_wa)

        VALUES (
        '$nisn',
        '$nama_siswa',
        '$kelas',
        '$pro_keahlian',
        '$ttl',
        '$id_sekolah',
        '$id_perusahaan',
        '$tanggal_mulai',
        '$tanggal_selesai', 
        '$id_pembimbing', 
        '$username', 
        '$password', 
        '$no_wa')");

            if($sql){
                echo'<script>
                    Swal.fire({
                        icon: "success",
                        title: "Berhasil",
                        text: "Berhasil Menambahkan Siswa",
                        confirmButtonText: "OK"
                    }).then((result) => {
                        if (result.isConfirmed) {
                        window.location.href = "index.php?page=siswa";
                        }
                    });
                    </script>';
                } else {
                    echo '<script>
                        Swal.fire({
                        icon: "error",
                        title: "Gagal Menambahkan Siswa",
                        text: "' . mysqli_error($coneksi) . '",
                        confirmButtonText: "OK"
                        }).then((result) => {
                        if (result.isConfirmed) {
                        window.location.href = "index.php?page=siswa";
                        }
                    });
                        </script>';
                        }
                    } else {
                        echo '<script>
                            Swal.fire({
                            icon: "error",
                            title: "Gagal Siswa Sudah Terdaftar",
                            text: "' . mysqli_error($coneksi) . '",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                            window.location.href = "index.php?page=siswa";
                            }
                        });
                            </script>';
                        }
                }
    ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</body>

</html>