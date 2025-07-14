<?php
include('../../koneksi.php'); 

$id_siswa = $_POST['id_siswa'] ?? null;
if (!$id_siswa) {
    echo "ID siswa tidak tersedia.";
    exit();
}


$query_siswa = "
    SELECT 
        s.nama_siswa, 
        s.id_siswa 
    FROM 
        siswa s 
    WHERE 
        s.id_siswa = ?
";

$stmt_siswa = $coneksi->prepare($query_siswa);
$stmt_siswa->bind_param("i", $id_siswa);
$stmt_siswa->execute();
$result_siswa = $stmt_siswa->get_result();

if ($result_siswa->num_rows > 0) {
    $data_siswa = $result_siswa->fetch_assoc();
    $nama_siswa = htmlspecialchars($data_siswa['nama_siswa']);
    $id_siswa = htmlspecialchars($data_siswa['id_siswa']);
} else {
    echo "Data siswa tidak ditemukan.";
    exit();
}

$query_absen = "
    SELECT 
        a.tanggal, 
        a.jam_masuk, 
        a.jam_keluar, 
        a.keterangan 
    FROM 
        absen a 
    WHERE 
        a.id_siswa = ? 
    ORDER BY a.tanggal
";

$stmt_absen = $coneksi->prepare($query_absen);
$stmt_absen->bind_param("i", $id_siswa);
$stmt_absen->execute();
$result_absen = $stmt_absen->get_result();

$kehadiran = [];
while ($row = $result_absen->fetch_assoc()) {
    $kehadiran[] = $row;
}

$stmt_siswa->close();
$stmt_absen->close();
$coneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hadir Praktik Kerja Lapangan</title>
    <style type="text/css">
        @page {
            size: A4;
            margin: 20mm;
        }
        .printable {
            margin: 20px;
        }
        @media print {
            .no-print {
                display: none; 
            }
        }
        .style6 { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 16px; }
        .style9 { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; }
        .style27 { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; font-weight: bold; }
        .top { border-top: 1px solid #000000; }
        .bottom { border-bottom: 1px solid #000000; }
        .left { border-left: 1px solid #000000; }
        .right { border-right: 1px solid #000000; }
        .all { border: 1px solid #000000; }
        .align-justify { text-align: justify; }
        .align-center { text-align: center; }
        .align-right { text-align: right; }
    </style>
    <script>
        function printReport() {
            window.print();
        }

        window.onload = function() {
            printReport();
        };
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="printable">
        <div class="text-center mb-8">
            <p class="font-bold style9">DAFTAR HADIR PESERTA DIDIK PRAKTIK KERJA LAPANGAN</p>
        </div>
        <table   cellspacing="2">
            <tr class="style9">
                <td>NAMA</td>
                <td>: <?php echo $nama_siswa; ?></td>
            </tr>
            <tr class="style9">
                <td>ID Siswa</td>
                <td>: <?php echo $id_siswa; ?></td>
            </tr>   
        </table>
        <table width="96%" border="1" align="center" cellpadding="3" cellspacing="0" class="style9">
            <thead>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr height="35">
                    <th class="left bottom top">No</th>
                    <th class="left bottom top">Hari/Tanggal</th>
                    <th class="left bottom top">MASUK</th>
                    <th class="left bottom top">PULANG</th>
                    <th class="left bottom top right">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                foreach ($kehadiran as $record) {
                    echo "<tr height='25' class='style27'>
                        <td class='top bottom left text-center'>{$no}</td>
                        <td class='top bottom left text-center'>" . htmlspecialchars($record['tanggal']) . "</td>
                        <td class='top bottom left text-center'>" . htmlspecialchars($record['jam_masuk']) . "</td>
                        <td class='top bottom left text-center'>" . htmlspecialchars($record['jam_keluar']) . "</td>
                        <td class='top bottom left right text-center'>" . htmlspecialchars($record['keterangan']) . "</td>
                    </tr>";
                    $no++;
                }
                ?>
                <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-end items-center mb-8">
            <div class="text-center">
                <div class="style9">.........................202...</div>
                <div class="style9">PEMBIMBING DUDI</div>
                <br><br><br>
                <div class="style9">(.............................................)</div>
            </div>
        </div>
    </div>
</body>
</html>
