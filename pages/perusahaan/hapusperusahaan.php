<?php
include('koneksi.php');

if (isset($_GET['id_perusahaan'])) {
	$id_perusahaan = $_GET['id_perusahaan'];

	$cek = mysqli_query($coneksi, "SELECT * FROM perusahaan WHERE id_perusahaan='$id_perusahaan'") or die(mysqli_error($coneksi));

	if (mysqli_num_rows($cek) > 0) {
		$del = mysqli_query($coneksi, "DELETE FROM perusahaan WHERE id_perusahaan='$id_perusahaan'") or die(mysqli_error($coneksi));
		if ($del) {
			echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "success",
				title: "Berhasil",
				text: "Data berhasil dihapus!",
				confirmButtonText: "Ok"
			}).then(() => {
				window.location.href = "index.php?page=perusahaan";
			});
			</script>';
		} else {
			echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "error",
				title: "Gagal",
				text: "Data Gagal dihapus!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=perusahaan";
			});
			</script>';
		}
	} else {
		echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
			Swal.fire({
				icon: "question",
				title: "Warning",
				text: "Data Tidak Ditemukan!",
				confirmButtonText: "Kembali"
			}).then(() => {
				window.location.href = "index.php?page=perusahaan";
			});
			</script>';
	}
}
