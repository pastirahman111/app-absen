<?php include 'koneksi.php'; 

$id_sekolah = $_SESSION['id_sekolah'] ?? null;

if (!isset($_SESSION['id_sekolah'])) {
    $id_sekolah = $_SESSION['id_sekolah'];
} 

// Query untuk mendapatkan data siswa berdasarkan id_sekolah
$query_siswa = mysqli_query($coneksi, "SELECT * FROM siswa WHERE id_sekolah = '$id_sekolah' ORDER BY id_siswa ASC") or die(mysqli_error($coneksi));

// Query untuk data sekolah
$query_sekolah = mysqli_query($coneksi, "SELECT * FROM sekolah WHERE id_sekolah = '$id_sekolah' LIMIT 1") or die(mysqli_error($coneksi));

// Query untuk perusahaan (selalu ditampilkan semua)
$query_perusahaan = mysqli_query($coneksi, "SELECT * FROM perusahaan ORDER BY id_perusahaan ASC") or die(mysqli_error($coneksi));

// Hitung jumlah data
$jumlah_siswa = mysqli_num_rows($query_siswa);
$jumlah_sekolah = mysqli_num_rows($query_sekolah);
$jumlah_perusahaan = mysqli_num_rows($query_perusahaan);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .absent {
            color: red;
        }
        .present {
            color: green;
        }
        .readonly {
            background-color: #f8f9fa; /* Warna latar belakang read-only */
        }
        .container {
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<?php if (isset($_GET['login']) && $_GET['login'] === 'berhasil' && isset($_GET['username'])): ?>
<script>
  Swal.fire({
    icon: 'success',
    title: 'Selamat datang,<?= htmlspecialchars($_GET['username']) ?>!',
    text: 'Login berhasil.',
    confirmButtonText: 'OK',
  });
</script>
<?php endif; ?>

<div class="container" style="margin-top: 20px">
    <hr>
    <form method="POST" action="">
        <table class="table table-bordered">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">group</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Siswa</p>
                <h4 class="mb-0"><?php echo $jumlah_siswa;?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
          </div>
        </div>
        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">school</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Sekolah</p>
                <h4 class="mb-0"><?php echo $jumlah_sekolah;?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
          </div>
        </div>
        <div class="col-xl-4 col-sm-6">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">location_city</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Perusahaan</p>
                <h4 class="mb-0"><?php echo $jumlah_perusahaan;?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
          </div>
        </div>
            <thead>
            <h2><center>Absensi Siswa</center></h2>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Sakit</th>
                    <th>Izin</th>
                    <th>Alpa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mengambil data siswa dari database berdasarkan id_sekolah
                $dataSiswa = mysqli_query($coneksi, "SELECT * FROM siswa WHERE id_sekolah = '$id_sekolah' ORDER BY id_siswa ASC") or die(mysqli_error($coneksi));
                $index = 1; // Inisialisasi nomor urut
                $today = date('Y-m-d'); // Tanggal hari ini

                while ($siswa = mysqli_fetch_assoc($dataSiswa)) {
                    // Cek status kehadiran siswa hari ini
                    $attendanceQuery = mysqli_query($coneksi, "SELECT keterangan FROM absen WHERE id_siswa = {$siswa['id_siswa']} AND tanggal = '$today'") or die(mysqli_error($coneksi));
                    $attendance = mysqli_fetch_assoc($attendanceQuery);
                    
                    $statusClass = '';
                    $keterangan = '-'; // Default jika tidak ada keterangan
                    if ($attendance) {
                        // Siswa hadir
                        $statusClass = 'present';
                        $keterangan = $attendance['keterangan']; // Ambil keterangan dari absensi
                    } else {
                        // Siswa tidak hadir
                        $statusClass = 'absent';
                    }

                    echo '
                    <tr class="'.($attendance ? 'readonly' : '').'">
                        <td>'.$index.'</td>
                        <td class="'.$statusClass.'">'.$siswa['nama_siswa'].'</td>
                        
                        <td>
                            <input type="radio" id="Sakit_'.$siswa['id_siswa'].'" name="absen_'.$siswa['id_siswa'].'" value="sakit" '.($keterangan === 'sakit' ? 'checked' : '').' disabled>
                            <label for="sakit_'.$siswa['id_siswa'].'">Sakit</label>
                        </td>
                        <td>
                            <input type="radio" id="Izin_'.$siswa['id_siswa'].'" name="absen_'.$siswa['id_siswa'].'" value="izin" '.($keterangan === 'izin' ? 'checked' : '').' disabled>
                            <label for="izin_'.$siswa['id_siswa'].'">Izin</label>
                        </td>
                        <td>
                            <input type="radio" id="Alpa_'.$siswa['id_siswa'].'" name="absen_'.$siswa['id_siswa'].'" value="alpa" '.($keterangan === 'alpa' ? 'checked' : '').' disabled>
                            <label for="alpa_'.$siswa['id_siswa'].'">Alpa</label>
                        </td>
                    </tr>
                    ';
                    $index++;
                }
                ?>
            </tbody>
        </table>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</body>
</html>
