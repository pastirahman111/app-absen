<?php
include('koneksi.php');
 
if(isset($_GET['id_catatan'])){
	$id_catatan = $_GET['id_catatan'];

	$cek = mysqli_query($coneksi, "SELECT * FROM catatan WHERE id_catatan='$id_catatan'") or die(mysqli_error($coneksi));
	
	if(mysqli_num_rows($cek) > 0){
		$del = mysqli_query($coneksi, "DELETE FROM catatan WHERE id_catatan='$id_catatan'") or die(mysqli_error($coneksi));
		if($del){
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "success",
				title: "Berhasil",
				text: "Data Catatan berhasil dihapus!",
				confirmButtonText: "Ok"
			}).then(() => {
				window.location.href = "index.php?page=catatan";
			});
			</script>';
		}else{
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "error",
				title: "Gagal",
				text: "Data Catatan Gagal dihapus!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=catatan";
			});
			</script>';
		}
	}else{
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "question",
				title: "Warning",
				text: "Data Catatan Tidak Ditemukan!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=catatan";
			});
			</script>';
	}
}
 
?>
