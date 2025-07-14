<?php
include('koneksi.php');

if(isset($_GET['id_pembimbing'])){
	$id_pembimbing = $_GET['id_pembimbing'];
	
	$cek = mysqli_query($coneksi, "SELECT * FROM pembimbing WHERE id_pembimbing='$id_pembimbing'") or die(mysqli_error($coneksi));
	
	if(mysqli_num_rows($cek) > 0){
		$del = mysqli_query($coneksi, "DELETE FROM pembimbing WHERE id_pembimbing='$id_pembimbing'") or die(mysqli_error($coneksi));
		if($del){
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "success",
				title: "Berhasil",
				text: "Data Pembimbing berhasil dihapus!",
				confirmButtonText: "Ok"
			}).then(() => {
				window.location.href = "index.php?page=pembimbing";
			});
			</script>';
		}else{
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "error",
				title: "Gagal",
				text: "Data embimbing Gagal dihapus!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=pembimbing";
			});
			</script>';
		}
	}else{
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "question",
				title: "Warning",
				text: "Data Pembimbing Tidak Ditemukan!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=pembimbing";
			});
			</script>';
	}
}

?>