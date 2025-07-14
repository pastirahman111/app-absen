<?php
include('koneksi.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Sekolah</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <a href="index.php?page=tambahsekolah" class="btn btn-primary" >Tambah Sekolah</a>
    <h2 class="text-center">Data Sekolah</h2>
    
    <hr>
    
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sekolah</th>
                <th>Alamat</th>
                <th>Kepala Sekolah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = mysqli_query($coneksi, "SELECT * FROM sekolah ORDER BY id_sekolah ASC") or die(mysqli_error($coneksi));
            if(mysqli_num_rows($sql) > 0){
                $no = 1;
                while($data = mysqli_fetch_assoc($sql)){
                    echo '
                    <tr style="text-align:center; cursor:pointer;">
                        <td>'.$no.'</td>
                        <td>'.$data['nama_sekolah'].'</td>
                        <td>'.$data['alamat_sekolah'].'</td>
                        <td>'.$data['kepala_sekolah'].'</td>
                        <td> 
                            <a href="index.php?page=editsekolah&id_sekolah='.$data['id_sekolah'].'" class="badge badge-warning">Edit</a>
                            <a href="" data-id="'.$data['id_sekolah'].'" class="badge badge-danger btn-hapus">Delete</a>
                        </td>
                    </tr>
                    ';
                    $no++;
                }
            } else {
                echo '
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data.</td>
                </tr>
                ';
            }
            ?>
        </tbody>
    </table>
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
                            window.location.href = 'index.php?page=hapussekolah&id_sekolah=' + id;
                        }
                    });
                });
            });
        });
    </script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
