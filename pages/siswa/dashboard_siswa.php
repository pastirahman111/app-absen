<?php include('koneksi.php'); 

$id_siswa = $_SESSION['id_siswa']?? '';
$tanggal_hari_ini = date('Y-m-d');

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Absensi Siswa</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #btnSimpan {
            padding: 20px 40px;
            font-size: 24px;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        #btnSimpan.masuk { background-color: #0056b3; }
        #btnSimpan.keluar { background-color: black; cursor: not-allowed; }
        #btnSimpan.mulai { background-color: red; }
        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh;
        }
    </style>
</head>
<body>
<?php if (isset($_GET['login']) && $_GET['login'] === 'berhasil' && isset($_GET['username'])): ?>
<script>
  Swal.fire({
    icon: 'success',
    title: 'Selamat datang <?= htmlspecialchars($_GET['username']) ?>!',
    text: 'Login berhasil.',
    ConfirmButtonText: "Ok"
  });
</script>
<?php endif; ?>


<?php
// Cek status absen hari ini untuk JS
$result = mysqli_query($coneksi, "SELECT * FROM absen WHERE id_siswa='$id_siswa' AND tanggal='$tanggal_hari_ini'");
$absen_hari_ini = mysqli_fetch_assoc($result);

$statusAbsen = 0;
if ($absen_hari_ini) {
    if (is_null($absen_hari_ini['jam_keluar']) || $absen_hari_ini['jam_keluar'] == '') {
        $statusAbsen = 1;
    } else {
        $statusAbsen = 2;
    }
}
?>

<div class="center">
    <button id="btnSimpan" onclick="simpan()">Hadir</button>
</div>

<script>
    const tombol = document.getElementById('btnSimpan');
    let statusAbsen = <?= $statusAbsen ?>;

    aturTampilan(statusAbsen);

    function aturTampilan(status) {
        tombol.classList.remove('mulai', 'masuk', 'keluar');
        tombol.disabled = false;

        if (status === 0) {
            tombol.textContent = 'Masuk';
            tombol.classList.add('mulai');
        } else if (status === 1) {
            tombol.textContent = 'Keluar';
            tombol.classList.add('masuk');
        } else {
            tombol.textContent = 'Sudah Absen';
            tombol.classList.add('keluar');
            tombol.disabled = true;
        }
    }

    function simpan() {
        let action = (statusAbsen === 0) ? 'simpan_masuk' : 'simpan_keluar';

        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            const response = this.responseText;

            Swal.fire({
                title: 'Informasi',
                text: response,
                icon: response.includes('tercatat') ? 'success' : 'warning',
                confirmButtonText: 'OK'
            });

            if (action === 'simpan_masuk' && response.includes('tercatat')) {
                statusAbsen = 1;
            } else if (action === 'simpan_keluar' && response.includes('tercatat')) {
                statusAbsen = 2;
            }

            aturTampilan(statusAbsen);
        };

        // Pastikan path ke proses_absen.php sesuai folder kamu
        xhttp.open("POST", "pages/siswa/proses_absen.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("action=" + encodeURIComponent(action) + "&keterangan=Hadir");
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
