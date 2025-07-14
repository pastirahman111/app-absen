<?php
include('koneksi.php');

if(isset($_GET['id_guru'])){
			$id_guru = $_GET['id_guru'];
			
			$cek = mysqli_query($coneksi, "SELECT * FROM guru WHERE id_guru='$id_guru'") or die(mysqli_error($coneksi));
			
			if(mysqli_num_rows($cek) > 0){
				$del = mysqli_query($coneksi, "DELETE FROM guru WHERE id_guru='$id_guru'") or die(mysqli_error($coneksi));
				if($del){
					echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
					<script>
					Swal.fire({
						icon: "success",
						title: "Berhasil",
						text: "Data Catatan berhasil dihapus!",
						confirmButtonText: "Ok"
					}).then(() => {
						window.location.href = "index.php?page=guru";
					});
					</script>';
				} else {
				echo'<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
				<script>
				Swal.fire({
					icon: "error",
					title: "Gagal",
					text: "Data Siswa Gagal dihapus!",
					confirmButtonText: "Kembali"
				}).then(() => {
					window.location.href = "index.php?page=guru";
				});
				</script>';
			}
			} else {
				echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
				<script>
				Swal.fire({
					icon: "question",
					title: "Warning",
					text: "Data siswa tidak ditemukan di database!",
					confirmButtonText: "Kembali"
				}).then(() => {
					window.location.href = "index.php?page=guru";
				});
				</script>';
		}
	}
?>