<?php
include('koneksi.php');
 
if(isset($_GET['id_sekolah'])){
	$id_sekolah = $_GET['id_sekolah'];

	$cek = mysqli_query($coneksi, "SELECT * FROM sekolah WHERE id_sekolah='$id_sekolah'") or die(mysqli_error($coneksi));
	
	if(mysqli_num_rows($cek) > 0){
		$del = mysqli_query($coneksi, "DELETE FROM sekolah WHERE id_sekolah='$id_sekolah'") or die(mysqli_error($coneksi));
		if($del){
			echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "success",
				title: "Berhasil",
				text: "Data  Sekolah Berhasil Dihapus!",
				confirmButtonText: "Ok"
			}).then(() => {
				window.location.href = "index.php?page=sekolah";
			});
			</script>';
		} else {
			echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "error",
				title: "Gagal",
				text: "Data Sekolah Gagal dihapus!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=sekolah";
			});
			</script>';
		}
	} else {
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "question",
				title: "Warning",
				text: "Data Sekolah Tidak Ditemukan!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=sekolah";
			});
			</script>';
	}
}
?>