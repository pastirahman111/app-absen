<?php
include('koneksi.php');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
        }
        .table thead th {
            background-color: #007bff;
            color: white;
            table-layout: auto;
            width: 100%;
        }
        .table tbody tr:hover {
            background-color: #e9ecef;
        }
        .btn-warning {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php?page=tambahsiswa" class="btn btn-primary" >Tambah Siswa</a>
    <h2 class="text-center">Data SISWA</h2>
    
    <hr>
    <div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nisn</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Sekolah</th>
                <th>Tempat Prakerin</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($coneksi, "
                SELECT siswa.*, 
                    sekolah.nama_sekolah, 
                    perusahaan.nama_perusahaan 
                FROM siswa 
                LEFT JOIN sekolah ON siswa.id_sekolah = sekolah.id_sekolah 
                LEFT JOIN perusahaan ON siswa.id_perusahaan = perusahaan.id_perusahaan 
                ORDER BY siswa.id_siswa ASC
            ") or die(mysqli_error($coneksi));

            if(mysqli_num_rows($sql) > 0){
                $no = 1;
                while($data = mysqli_fetch_assoc($sql)){
                    echo '
                    <tr style="text-align:center; cursor:pointer;" onclick="window.location=\'index.php?page=editsiswa1&id_siswa='.$data['id_siswa'].'\'">
                        <td>'.$no.'</td>
                        <td>'.$data['nisn'].'</td>
                        <td>'.$data['nama_siswa'].'</td>
                        <td>'.$data['kelas'].'</td>
                        <td>'.$data['nama_sekolah'].'</td>
                        <td>'.$data['nama_perusahaan'].'</td>
                        <td>'.$data['tanggal_mulai'].'</td>
                        <td>'.$data['tanggal_selesai'].'</td>
                    </tr>
                    ';
                    $no++;
                }
            }else{
                echo '
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data.</td>
                </tr>
                ';
            }
            ?>
        </tbody>
    </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
