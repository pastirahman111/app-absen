<?php include('koneksi.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<title>tambahsekolah</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
	<div class="container" style="margin-top:20px">
		<h2>Tambah Sekolah</h2>	
		<hr>
		<form action="" method="post" class="tes" enctype="multipart/form-data">
			<div class="form-group row">
				<label class="col-sm-2 col-form-label"> ID Sekolah</label>
				<div class="col-sm-10">
					<input type="text" name="id_sekolah" class="form-control" size="4" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Nama Sekolah</label>
				<div class="col-sm-10">
					<input type="text" name="nama_sekolah" class="form-control" size="4" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Alamat Sekolah</label>
				<div class="col-sm-10">
					<input type="text" name="alamat_sekolah" class="form-control" size="4" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Kepala Sekolah</label>
				<div class="col-sm-10">
					<input type="text" name="kepala_sekolah" class="form-control" size="4" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Logo Sekolah</label>
				<div class="col-sm-10">
					<input type="file" name="logo_sekolah" class="form-control" accept="image/*" size="4" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">&nbsp;</label>
				<div class="col-sm-10">
					<br>
					<input type="submit" name="submit" class="btn btn-primary" value="SIMPAN">
					<a href="index.php?page=sekolah" class="btn btn-warning">KEMBALI</a>
				</div>
			</div>
		</form>

		<?php
		if(isset($_POST['submit'])){
			$id_sekolah	 = $_POST['id_sekolah'];
			$nama_sekolah = $_POST['nama_sekolah'];
			$alamat_sekolah		 = $_POST['alamat_sekolah'];
			$kepala_sekolah		 = $_POST['kepala_sekolah'];

			// Upload logo sekolah
			$logo_name = $_FILES['logo_sekolah']['name'];
			$tmp_name  = $_FILES['logo_sekolah']['tmp_name'];
			$upload_dir = "../../uploads/";

			// Buat folder jika belum ada
			if (!file_exists($upload_dir)) {
				mkdir($upload_dir, 0777, true);
			}

				$target_file = $upload_dir . basename($logo_name);
				move_uploaded_file($tmp_name, $target_file);
				
				$cek = mysqli_query($coneksi, "SELECT * FROM sekolah WHERE id_sekolah='id_sekolah'") or die(mysqli_error($coneksi));
				
				if(mysqli_num_rows($cek) == 0){
					$sql = mysqli_query($coneksi, "INSERT INTO sekolah
					(id_sekolah, 
					nama_sekolah, 
					alamat_sekolah, 
					kepala_sekolah, 
					logo_sekolah) 
					VALUES
					('$id_sekolah', 
					'$nama_sekolah', 
					'$alamat_sekolah',
					'$kepala_sekolah', 
					'$logo_name')") or die(mysqli_error($coneksi));
						
					if($sql){
                        echo'<script>
							Swal.fire({
								icon: "success",
								title: "Berhasil",
								text: "Berhasil Menambahkan Sekolah",
								confirmButtonText: "OK"
							}).then((result) => {
								if (result.isConfirmed) {
								window.location.href = "index.php?page=sekolah";
								}
							});
							</script>';
						} else {
							echo '<script>
								Swal.fire({
								icon: "error",
								title: "Gagal Menambahkan Sekolah",
								text: "' . mysqli_error($coneksi) . '",
								confirmButtonText: "OK"
							}).then((result) => {
								if (result.isConfirmed) {
								window.location.href = "index.php?page=sekolah";
								}
							});
								</script>';
						} 		
				}else{
					echo '<div class="alert alert-warning">Gagal, id_sekolah sudah terdaftar.</div>';
				}
		}
		?>

	</div>
		
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	
</body>
</html> 