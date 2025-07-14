  <?php include "koneksi.php";

  // Mendapatkan ID perusahaan yang sedang login
  $id_perusahaan = $_SESSION['id_perusahaan'] ?? null;

  // Jika tidak ada perusahaan yang login, arahkan ke halaman sign-in
  if (!$id_perusahaan) {
    header("Location: sign-in.php");
    exit();
  }

  // Query untuk mengambil perusahaan yang terkait dengan ID perusahaan yang sedang login
  $query_perusahaan = mysqli_query($coneksi, "SELECT * FROM perusahaan WHERE id_perusahaan = '$id_perusahaan'") or die(mysqli_error($coneksi));
  $perusahaan = mysqli_fetch_assoc($query_perusahaan);

  // Mengambil data siswa yang terkait dengan perusahaan yang sedang login
  $query_siswa = mysqli_query($coneksi, "SELECT * FROM siswa WHERE id_perusahaan = '$id_perusahaan' ORDER BY id_siswa ASC") or die(mysqli_error($coneksi));

  // Mengambil data sekolah
  $query_sekolah = mysqli_query($coneksi, "SELECT * FROM sekolah ORDER BY id_sekolah ASC") or die(mysqli_error($coneksi));

  // Menampilkan jumlah siswa dan sekolah yang terkait dengan perusahaan
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
    <style>
      .absent {
        color: red;
      }

      .present {
        color: green;
      }

      .readonly {
        background-color: #f8f9fa;
        /* Warna latar belakang read-only */
      }

      .container {
        margin-top: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                      <h4 class="mb-0"><?php echo $jumlah_siswa; ?></h4>
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
                      <h4 class="mb-0"><?php echo $jumlah_sekolah; ?></h4>
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
                      <h4 class="mb-0"><?php echo $jumlah_perusahaan; ?></h4>
                    </div>
                  </div>
                  <hr class="dark horizontal my-0">
                </div>
                <thead>
                  <h2>
                    <center>Absensi Siswa</center>
                  </h2>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Sakit</th>
                    <th>Izin</th>
                    <th>Alpa</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Mengambil data siswa dari database
                  $dataSiswa = mysqli_query($coneksi, "SELECT * FROM siswa WHERE id_perusahaan = '$id_perusahaan' ORDER BY id_siswa ASC") or die(mysqli_error($coneksi));
                  $index = 1; // Inisialisasi nomor urut
                  $today = date('Y-m-d'); // Tanggal hari ini

                  while ($siswa = mysqli_fetch_assoc($dataSiswa)) {
                    // Cek status kehadiran siswa hari ini
                    $attendanceQuery = mysqli_query($coneksi, "SELECT keterangan FROM absen WHERE id_siswa = {$siswa['id_siswa']} AND tanggal = '$today'") or die(mysqli_error($coneksi));
                    $attendance = mysqli_fetch_assoc($attendanceQuery);

                    $statusClass = '';
                    $keterangan = '-'; // Default jika tidak ada keterangan
                    $isReadOnly = false; // Flag untuk read-only
                    if ($attendance) {
                      // Siswa hadir
                      $statusClass = 'present';
                      $keterangan = $attendance['keterangan']; // Ambil keterangan dari absensi
                      $isReadOnly = true; // Set read-only true jika siswa hadir
                    } else {
                      // Siswa tidak hadir
                      $statusClass = 'absent';
                    }

                    echo '
                      <tr class="' . ($isReadOnly ? 'readonly' : '') . '">
                          <td>' . $index . '</td>
                          <td class="' . $statusClass . '">' . $siswa['nama_siswa'] . '</td>
                          
                          <td>
                              <input type="radio" id="Sakit_' . $siswa['id_siswa'] . '" name="absen_' . $siswa['id_siswa'] . '" value="sakit" ' . ($keterangan === 'sakit' ? 'checked' : '') . ($isReadOnly ? ' disabled' : '') . '>
                              <label for="sakit_' . $siswa['id_siswa'] . '">Sakit</label>
                          </td>
                          <td>
                              <input type="radio" id="Izin_' . $siswa['id_siswa'] . '" name="absen_' . $siswa['id_siswa'] . '" value="izin" ' . ($keterangan === 'izin' ? 'checked' : '') . ($isReadOnly ? ' disabled' : '') . '>
                              <label for="izin_' . $siswa['id_siswa'] . '">Izin</label>
                          </td>
                          <td>
                              <input type="radio" id="Alpa_' . $siswa['id_siswa'] . '" name="absen_' . $siswa['id_siswa'] . '" value="alpa" ' . ($keterangan === 'alpa' ? 'checked' : '') . ($isReadOnly ? ' disabled' : '') . '>
                              <label for="alpa_' . $siswa['id_siswa'] . '">Alpa</label>
                          </td>
                          <td>
                              <button type="submit" name="simpan_' . $siswa['id_siswa'] . '" class="btn btn-primary btn-sm" ' . ($isReadOnly ? 'disabled' : '') . '>Simpan</button>
                          </td>
                      </tr>
                      ';
                    $index++;
                  }
                  ?>
                </tbody>
        </table>
      </form>

      <?php
      // Proses penyimpanan data absensi
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($_POST as $key => $value) {
          if (strpos($key, 'simpan_') === 0) {
            $id_siswa = str_replace('simpan_', '', $key);
            $tanggal = date('Y-m-d');
            $jam_masuk = date('H:i:s');
            $radio_name = 'absen_' . $id_siswa;

            // Cek apakah radio button dipilih
            if (!isset($_POST[$radio_name])) {
              echo "
                    <script>
                      Swal.fire({
                        icon: 'warning',
                        title: 'Keterangan Belum Dipilih',
                        text: 'Silakan pilih keterangan untuk siswa ID: $id_siswa',
                        confirmButtonText: 'OK'
                      });
                    </script>
                    ";
                    continue;
                  }

            $keterangan = mysqli_real_escape_string($coneksi, $_POST[$radio_name]);

            // Cek jika data sudah ada di database
            $checkQuery = mysqli_query($coneksi, "SELECT * FROM absen WHERE id_siswa = '$id_siswa' AND tanggal = '$tanggal'");

            if (mysqli_num_rows($checkQuery) > 0) {
              // Jika ada, update data
              $updateQuery = mysqli_query($coneksi, "UPDATE absen SET 
              keterangan = '$keterangan', 
              jam_keluar = '$jamSekarang' 
              WHERE 
              id_siswa = '$id_siswa' 
              AND tanggal = '$tanggal'");

              if ($updateQuery) {
                echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil",
                            text: "Berhasil Memperbarui data",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                            window.location.href = "index.php?page=dashboard_pembimbing";
                            }
                        });
                        </script>';
              } echo "<script>
                      Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memperbarui',
                        text: 'Gagal memperbarui data untuk siswa ID: $id_siswa',
                        confirmButtonText: 'OK'
                      });
                    </script>";
            } else {
              $jam_keluar = date('H:i:s'); 
              $insertQueryStr = "INSERT INTO absen 
              (id_siswa, 
              jam_masuk, 
              jam_keluar, 
              tanggal, 
              keterangan) 
              VALUES 
              ('$id_siswa', 
              '$jam_masuk', 
              '$jam_keluar', 
              '$tanggal', 
              '$keterangan')";
              $insertQuery = mysqli_query($coneksi, $insertQueryStr);

              if ($insertQuery) {
              echo "<script>
                    Swal.fire({
                      icon: 'success',
                      title: 'Berhasil',
                      text: 'Absen Berhasil Disimpan!',
                      confirmButtonText: 'OK'
                    }).then(() => {
                      window.location.href = 'index.php?page=dashboard_pembimbing';
                    });
                  </script>
                  ";
                } else {
                  $error = mysqli_error($coneksi);
                  $query = htmlspecialchars($insertQueryStr); // supaya query tampil aman di HTML
                  echo "<script>
                    Swal.fire({
                      icon: 'error',
                      title: 'Gagal Menyimpan',
                      html: 'Gagal menyimpan data.<br>Error: <b>$error</b><br><small>Query: $query</small>',
                      confirmButtonText: 'OK'
                    });
                  </script>";
              }
            }
          }
        }
      }

      ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

  </body>

  </html>