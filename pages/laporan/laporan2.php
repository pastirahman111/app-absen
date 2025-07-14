<?php
include('koneksi.php');

// Pastikan ID sekolah ada dalam session
if (!isset($_SESSION['id_perusahaan'])) {
    header("Location: sign-in.php"); // Arahkan ke halaman login jika belum login
    exit();
}

$id_perusahaan = $_SESSION['id_perusahaan']; // Ambil ID sekolah dari session

// Query untuk mengambil daftar siswa berdasarkan ID sekolah
$query = "SELECT id_siswa, nama_siswa FROM siswa WHERE id_perusahaan = '$id_perusahaan'";
$result = mysqli_query($coneksi, $query);

// Cek jika query berhasil
if (!$result) {
    die('Query gagal: ' . mysqli_error($coneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buka Laporan Siswa</title>
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
        h1 {
            text-align: center;
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
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #777;
        }
        .btn-warning {
            background-color: #ffc107;
            border: none;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
    </style>
    <script>
        function openTab(event) {
            event.preventDefault(); // Mencegah pengiriman form default

            // Ambil data dari form
            const form = document.getElementById('myForm');
            const formData = new FormData(form);
            
            // Buat URL untuk pengiriman data
            const url = form.action;

            // Membuka tab baru
            const newTab = window.open(); // Membuka tab baru kosong

            // Kirim data POST menggunakan fetch
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text(); // Ambil respons sebagai teks
            })
            .then(data => {
                // Menuliskan respons ke tab baru
                newTab.document.write(data);
                newTab.document.close(); // Menutup dokumen untuk memproses konten
            })
            .catch(error => {
                console.error('Terjadi kesalahan saat mengirim data:', error);
                newTab.close(); // Tutup tab jika ada kesalahan
            });
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Buka Laporan Siswa</h1>
    <hr>

    <form id="myForm" action="pages/laporan/preview.php" method="POST" onsubmit="openTab(event)">
        <label for="id_siswa">ID Siswa:</label>
        <select id="id_siswa" name="id_siswa" class="form-control" required>
            <option value="">-- Pilih ID Siswa --</option>
            <?php
            // Menampilkan ID siswa yang diambil dari database
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['id_siswa'] . '">' . $row['id_siswa'] . ' - ' . $row['nama_siswa'] . '</option>';
            }
            ?>
        </select>

        <label for="reportSelect">Pilih Laporan:</label>
        <select id="reportSelect" name="page" class="form-control" required>
            <option value="">-- Pilih Laporan --</option>
            <option value="cover">Cover</option>
            <option value="df">Daftar Hadir</option>
            <option value="jr">Laporan Jurnal</option>
            <option value="catatan">Lembar Catatan Kegiatan</option>
            <option value="dn">Lembar Daftar Nilai</option>
            <option value="sk">Lembar Surat Keterangan</option>
            <option value="nkp">Lembar Nilai Kepuasan Pelanggan</option>
            <option value="lp">Lembar Pengesahan</option>
            <option value="bl">Lembar Bimbingan Laporan</option>
        </select>

        <button type="submit" class="btn btn-primary btn-block mt-4">Unduh Laporan</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>
</html>
