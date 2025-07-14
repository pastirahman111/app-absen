<?php include('../../koneksi.php'); ?>
<?php
	if(isset($_POST['submit'])){
		$id_pembimbing  = $_POST['id_pembimbing'];
		$catatan        = $_POST['catatan'];
		$id_jurnal      = $_POST['id_jurnal'];

		// Cek apakah catatan untuk jurnal ini sudah ada
		$cek = mysqli_query($coneksi, "SELECT * FROM catatan WHERE id_jurnal='$id_jurnal'") or die(mysqli_error($coneksi));

		if(mysqli_num_rows($cek) == 0){
				// Insert baru
				$sql = mysqli_query($coneksi, "INSERT INTO catatan(id_pembimbing, catatan, id_jurnal) VALUES('$id_pembimbing', '$catatan','$id_jurnal')") or die(mysqli_error($coneksi));

				if($sql){
				echo' <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
					<script>
					Swal.fire({
						icon: "success",
						title: "Berhasil "Berhasil menmabah catatan",
						confirmButtonText: "OK"
					}).then((result) => {
						if (result.isConfirmed) {
						window.location.href = "index.php?page=catatan";
						}
					});
					</script>';
				} else {
					echo '
					<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
					<script>
					Swal.fire({
						icon: "error",
						title: "Gagal menambahkan catatan   ",
						text: "' . mysqli_error($coneksi) . '",
						confirmButtonText: "OK"
					});
					</script>';
					}
			} else {
				echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
				<script>
				Swal.fire({
					icon: "error",
					title: "Gagal menambahkan catatan   ",
					text: "' . mysqli_error($coneksi) . '",
					confirmButtonText: "OK"
				});
				</script>';
						}
			}
			?>