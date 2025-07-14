<?php include('../../koneksi.php'); ?>
<?php
	if(isset($_GET['id_siswa'])){
		$id_siswa = $_GET['id_siswa'];
		
		$select = mysqli_query($coneksi, "SELECT * FROM siswa WHERE id_siswa='$id_siswa'") or die(mysqli_error($coneksi));
		
		if(mysqli_num_rows($select) == 0){
			echo '<div class="alert alert-warning">id_siswa tidak ada dalam database.</div>';
			exit();
		}else{
			$data = mysqli_fetch_assoc($select);
		}
	}
?>
		
<?php
	if(isset($_POST['submit'])){
		$id_siswa			= $_POST['id_siswa'];
		$nisn				= $_POST['nisn'];
		$nama_siswa			= $_POST['nama_siswa'];
		$kelas			    = $_POST['kelas'];
		$pro_keahlian		= $_POST['pro_keahlian'];
		$ttl		    	= $_POST['ttl'];
		$id_sekolah			= $_POST['id_sekolah'];
		$id_perusahaan		= $_POST['id_perusahaan'];
		$tanggal_mulai		= $_POST['tanggal_mulai'];
		$tanggal_selesai	= $_POST['tanggal_selesai'];
		$id_pembimbing		= $_POST['id_pembimbing'];
		$username			= $_POST['username'];
		$password			= $_POST['password'];
		$no_wa			= $_POST['no_wa'];
		
		$sql = mysqli_query($coneksi, "UPDATE siswa SET 
		nisn='$nisn', 
		nama_siswa='$nama_siswa', 
		kelas='$kelas', 
		pro_keahlian='$pro_keahlian', 
		ttl='$ttl', 
		id_sekolah='$id_sekolah',
		id_perusahaan='$id_perusahaan', 
		tanggal_mulai='$tanggal_mulai', 
		tanggal_selesai='$tanggal_selesai', 
		id_pembimbing='$id_pembimbing',
		username='$username', 
		password='$password', 
		no_wa='$no_wa' 
		WHERE id_siswa='$id_siswa'") or die(mysqli_error($coneksi));

		if ($sql) {
			echo '<script>
			Swal.fire({
			position: "top-end",
			icon: "success",
			title: "Berhasil menambahkan data",
			showConfirmButton: false,
			timer: 1500
		}).then(function() {
			window.location.href = "../../index.php?page=siswa";
		});
			</script>';
		} else {
			echo '<script>
			Swal.fire({
			icon: "error",
			title: "Gagal!",
			text: "Gagal melakukan tambah data.",
			confirmButtonText: "OK"
		});
			</script>';
		}
		} else {
    			echo '<script>
			Swal.fire({
				icon: "warning",
				title: "Peringatan!",
				text: "Anda harus memilih file untuk diupload!",
				confirmButtonText: "OK"
			});
    			</script>';
	}
?>