<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Edit Sekolah</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container" style="margin-top:20px">
	<h2>Edit Sekolah</h2>
	<hr>

	<?php
	if (isset($_GET['id_sekolah'])) {
		$id_sekolah = $_GET['id_sekolah'];
		$select = mysqli_query($coneksi, "SELECT * FROM sekolah WHERE id_sekolah='$id_sekolah'") or die(mysqli_error($coneksi));
		if (mysqli_num_rows($select) == 0) {
			echo '<div class="alert alert-warning">ID sekolah tidak ditemukan.</div>';
			exit();
		} else {
			$data = mysqli_fetch_assoc($select);
		}
	} else {
		echo '<div class="alert alert-warning">ID sekolah belum dipilih.</div>';
		exit();
	}

	if (isset($_POST['submit'])) {
		$id_sekolah      = $_POST['id_sekolah'];
		$nama_sekolah    = $_POST['nama_sekolah'];
		$alamat_sekolah  = $_POST['alamat_sekolah'];
		$kepala_sekolah  = $_POST['kepala_sekolah'];

		$sql = mysqli_query($coneksi, "UPDATE sekolah SET 
			nama_sekolah='$nama_sekolah',
			alamat_sekolah='$alamat_sekolah',
			kepala_sekolah='$kepala_sekolah' 
			WHERE id_sekolah='$id_sekolah'") or die(mysqli_error($coneksi));

		if ($sql) {
			echo '<script>
				Swal.fire({
					icon: "success",
					title: "Berhasil",
					text: "Data sekolah berhasil diupdate!",
					confirmButtonText: "OK"
				}).then(() => {
					window.location.href = "index.php?page=sekolah";
				});
			</script>';
		} else {
			echo '<script>
				Swal.fire({
					icon: "error",
					title: "Gagal",
					text: "Data sekolah gagal diupdate!",
					confirmButtonText: "OK"
				});
			</script>';
		}
	}
	?>

	<form action="" method="post">
		<input type="hidden" name="id_sekolah" value="<?php echo $data['id_sekolah']; ?>">
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Nama Sekolah</label>
			<div class="col-sm-10">
				<input type="text" name="nama_sekolah" class="form-control" value="<?php echo $data['nama_sekolah']; ?>" required>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Alamat Sekolah</label>
			<div class="col-sm-10">
				<input type="text" name="alamat_sekolah" class="form-control" value="<?php echo $data['alamat_sekolah']; ?>" required>
			</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label">Kepala Sekolah</label>
			<div class="col-sm-10">
				<input type="text" name="kepala_sekolah" class="form-control" value="<?php echo $data['kepala_sekolah']; ?>" required>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-10">
				<input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
				<a href="index.php?page=sekolah" class="btn btn-warning">KEMBALI</a>
			</div>
		</div>
	</form>
</div>
</body>
</html>
