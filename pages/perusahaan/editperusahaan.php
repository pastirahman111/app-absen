<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Perusahaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <!-- Tambahkan ini di atas script Swal.fire -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<div class="container" style="margin-top:20px">
    <h2>Edit Perusahaan</h2>
    <hr>

<?php
	if (isset($_GET['id_perusahaan'])) {
      	$id_perusahaan = $_GET['id_perusahaan'];
		$select = mysqli_query($coneksi, "SELECT * FROM perusahaan WHERE id_perusahaan='$id_perusahaan'") or die(mysqli_error($coneksi));

      	if (mysqli_num_rows($select) == 0) {
            echo'<script>
			Swal.fire({
				icon: "error",
				title: "Gagal",
				text: "Id Perusahaan tidak di temukan",
				confirmButtonText: "OK"
			}).then((result) => {
				if (result.isConfirmed) {
				window.location.href = "index.php?page=perusahaan";
				}
			});
			</script>';
        } else {
            $data = mysqli_fetch_assoc($select);
		}
	} else {
      	echo'<script>
			Swal.fire({
				icon: "error",
				title: "Gagal",
				text: "Id Perusahaan tidak di temukan",
				confirmButtonText: "OK"
			}).then((result) => {
				if (result.isConfirmed) {
				window.location.href = "index.php?page=perusahaan";
				}
			});
			</script>';
	    }

    // Proses Update
    if (isset($_POST['submit'])) {
        $id_perusahaan      = $_POST['id_perusahaan'];
        $nama_perusahaan    = $_POST['nama_perusahaan'];
        $alamat_perusahaan  = $_POST['alamat_perusahaan'];

        $sql = mysqli_query($coneksi, "UPDATE perusahaan SET nama_perusahaan='$nama_perusahaan', 
	    alamat_perusahaan='$alamat_perusahaan' 
	    WHERE id_perusahaan='$id_perusahaan'") or die(mysqli_error($coneksi));

        if ($sql) {
		echo'<script>
			Swal.fire({
				icon: "success",
				title: "Berhasil",
				text: "Berhasil Update Perusahaan   ",
				confirmButtonText: "OK"
			}).then((result) => {
				if (result.isConfirmed) {
				window.location.href = "index.php?page=perusahaan";
				}
			});
			</script>';
		} else {
			echo '<script>
			    Swal.fire({
                    icon: "error",
                    title: "Gagal mengupdate perusahaan",
                    text: "' . mysqli_error($coneksi) . '",
                    confirmButtonText: "OK"
                });
                </script>';
			}
		}

    ?>

    <form action="" method="post">
        <input type="hidden" name="id_perusahaan" value="<?php echo $data['id_perusahaan']; ?>">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nama Perusahaan</label>
            <div class="col-sm-10">
                <input type="text" name="nama_perusahaan" class="form-control" value="<?php echo $data['nama_perusahaan']; ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Alamat Perusahaan</label>
            <div class="col-sm-10">
                <input type="text" name="alamat_perusahaan" class="form-control" value="<?php echo $data['alamat_perusahaan']; ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">&nbsp;</label>
            <div class="col-sm-10">
                <input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
                <a href="index.php?page=perusahaan" class="btn btn-warning">KEMBALI</a>
            </div>
        </div>
    </form>
</div>
</body>
</html>
