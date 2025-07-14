<?php
include('koneksi.php');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembimbing dan Guru</title>
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
    <a href="index.php?page=tambahpembimbing" class="btn btn-primary" >Tambah Pembimbing</a>
    <h2 class="text-center">Data Pembimbing</h2>
    
    <hr>
    
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($coneksi, "SELECT * FROM pembimbing ORDER BY id_pembimbing ASC") or die(mysqli_error($coneksi));
            if(mysqli_num_rows($sql) > 0){
                $no = 1;
                while($data = mysqli_fetch_assoc($sql)){
                    echo '
                    <tr style="text-align:center; cursor:pointer;" onclick="window.location=\'index.php?page=editpembimbing&id_pembimbing='.$data['id_pembimbing'].'\'">
                        <td>'.$no.'</td>
                        <td>'.$data['nama_pembimbing'].'</td>
                        <td>'.$data['username'].'</td>
                        <td>'.$data['password'].'</td>
                    </tr>
                    ';
                    $no++;
                }
            } else {
                echo '
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data.</td>
                </tr>
                ';
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.2.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
