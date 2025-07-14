<?php
include('koneksi.php');
 
if(isset($_GET['id_jurnal'])){
	$id_jurnal = $_GET['id_jurnal'];

	$cek = mysqli_query($coneksi, "SELECT * FROM jurnal WHERE id_jurnal='$id_jurnal'") or die(mysqli_error($coneksi));
	
	if(mysqli_num_rows($cek) > 0){
		$del = mysqli_query($coneksi, "DELETE FROM jurnal WHERE id_jurnal='$id_jurnal'") or die(mysqli_error($coneksi));
		if($del){
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "success",
				title: "Berhasil",
				text: "Data berhasil dihapus!",
				confirmButtonText: "Ok"
			}).then(() => {
				window.location.href = "index.php?page=jurnal";
			});
			</script>';
		}else{
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "error",
				title: "Gagal",
				text: "Data Gagal dihapus!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=jurnal";
			});
			</script>';
		}
	}else{
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "question",
				title: "Warning",
				text: "Data Tidak Ditemukan!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=jurnal";
			});
			</script>';
	}
}
 
?>
