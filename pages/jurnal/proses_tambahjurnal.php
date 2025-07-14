    <?php
    session_start();
    include('../../koneksi.php');

    // Pastikan ID siswa ada dalam session
    if (!isset($_SESSION['level']) || !in_array($_SESSION['level'], ['admin', 'pembimbing', 'siswa'])) {
        echo '<script>alert("Akses ditolak! Silakan login terlebih dahulu."); window.location.href = "../../sign-in.php";</script>';
        exit();
    }
    $id_jurnal = $_SESSION['id_jurnal'] ?? null;
    $id_siswa = $_SESSION['id_siswa'] ?? null;

    // Ambil tanggal hari ini
    $tanggal_hari_ini = date('Y-m-d');

    // Cek apakah sudah ada jurnal untuk hari ini
    $result = mysqli_query($coneksi, "SELECT * FROM jurnal WHERE id_siswa='$id_siswa' AND tanggal='$tanggal_hari_ini'");
    $jurnal_hari_ini = mysqli_fetch_assoc($result);

    if (isset($_POST['submit'])) {
        $keterangan = $_POST['keterangan'];

        if ($jurnal_hari_ini) {
            // Jika sudah ada jurnal untuk hari ini, update keterangan
            $id_jurnal = $jurnal_hari_ini['id_jurnal'];
            $sql = mysqli_query($coneksi, "UPDATE jurnal SET 
            keterangan='$keterangan' 
            WHERE id_jurnal='$id_jurnal'");

            if ($sql) {
                echo '
                <script>
                Swal.fire({
                    title: "Berhasil menambah jurnal.",
                    icon: "success",
                    draggable: true
                }).then(() => {
                    window.location.href = "../../index.php?page=jurnal";
                });
                </script>';
            } else {
                echo '<div class="alert alert-warning">Gagal memperbarui data.</div>';
            }
            } else {
                // Jika belum ada jurnal untuk hari ini, insert entri baru
                $sql = mysqli_query($coneksi, "INSERT INTO jurnal (tanggal,
                keterangan, 
                id_siswa) 
                
                VALUES (
                '$tanggal_hari_ini', 
                '$keterangan', 
                '$id_siswa')");

                if ($sql) {
                    echo'
                    <script>
                        Swal.fire({
                        title: "Gagal memperbarui data.",
                        icon: "error",
                        draggable: true
                        }).then(() => {
                        window.location.href = "../../index.php?page=jurnal";
                        });
                    </script>';
                } else {
                    echo '<div class="alert alert-warning">Gagal menambahkan data:'  . mysqli_error($coneksi) . '</div>';
                }
            }
    }
    ?>
