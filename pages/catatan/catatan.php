<?php
include('koneksi.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa, Jurnal, dan Catatan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        .clickable-row { cursor: pointer; }
        .container {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        .table thead th { background-color: #007bff; color: white; }
        .table tbody tr:hover { background-color: #e9ecef; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center text-primary">Data Siswa, Jurnal, dan Catatan Terbaru</h2>
        <hr>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Catatan</th>
                    <th>Jurnal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "
                    SELECT
                        siswa.id_siswa,
                        siswa.nama_siswa,
                        jurnal.id_jurnal,
                        jurnal.keterangan AS keterangan_jurnal,
                        c.catatan
                    FROM siswa
                    LEFT JOIN (
                        SELECT * FROM jurnal
                        WHERE id_jurnal IN (
                            SELECT MAX(id_jurnal) FROM jurnal GROUP BY id_siswa
                        )
                    ) AS jurnal ON siswa.id_siswa = jurnal.id_siswa
                    LEFT JOIN (
                        SELECT id_jurnal, catatan
                        FROM catatan
                        WHERE id_catatan IN (
                            SELECT MAX(id_catatan) FROM catatan GROUP BY id_jurnal
                        )
                    ) AS c ON jurnal.id_jurnal = c.id_jurnal
                    ORDER BY siswa.nama_siswa ASC
                ";

                $result = mysqli_query($coneksi, $sql) or die(mysqli_error($coneksi));

                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id_jurnal = $row['id_jurnal'] ?? 0;
                        $catatan = !empty($row['catatan']) ? $row['catatan'] : '-';
                        $keterangan = !empty($row['keterangan_jurnal']) ? $row['keterangan_jurnal'] : 'Tidak ada jurnal';

                        echo '<tr class="clickable-row" data-href="index.php?page=tambahcatatan&id_jurnal='.$id_jurnal.'">';
                        echo '<td>'.$no.'</td>';
                        echo '<td>'.htmlspecialchars($row['nama_siswa']).'</td>';
                        echo '<td>'.htmlspecialchars($catatan).'</td>';
                        echo '<td>'.htmlspecialchars($keterangan).'</td>';
                        echo '</tr>';
                        $no++;
                    }
                } else {
                    echo '<tr><td colspan="4" class="text-center">Tidak ada data ditemukan.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>
</body>
</html>
