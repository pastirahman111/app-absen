<?php
include('koneksi.php');

if (isset($_GET['id_siswa'])) {
	$id_siswa = $_GET['id_siswa'];

	$cek = mysqli_query($coneksi, "SELECT * FROM siswa WHERE id_siswa='$id_siswa'") or die(mysqli_error($coneksi));

	if (mysqli_num_rows($cek) > 0) {
		$sql = mysqli_query($coneksi, "DELETE FROM siswa WHERE id_siswa='$id_siswa'") or die(mysqli_error($coneksi));
		if ($sql) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "success",
				title: "Berhasil",
				text: "Data Catatan berhasil dihapus!",
				confirmButtonText: "Ok"
			}).then(() => {
				window.location.href = "index.php?page=siswa";
			});
			</script>';
		}else{
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "error",
				title: "Gagal",
				text: "Data Siswa Gagal dihapus!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=siswa";
			});
			</script>';
		}
	}else{
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<>
			Swal.fire({
				icon: "question",
				title: "Warning",
				text: "Data siswa tidak ditemukan di database!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=siswa";
			});
			</script>';
	}
}