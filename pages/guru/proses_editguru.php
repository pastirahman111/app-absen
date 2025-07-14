<?php include('../../koneksi.php'); ?>
<?php
		if(isset($_GET['id_guru'])){
			$id_guru = $_GET['id_guru'];
			
			$select = mysqli_query($coneksi, "SELECT * FROM guru WHERE id_guru='$id_guru'") or die(mysqli_error($coneksi));
			
			if(mysqli_num_rows($select) == 0){
				echo '<div class="alert alert-warning">id_guru tidak ada dalam database.</div>';
				exit();
			}else{
				$data = mysqli_fetch_assoc($select);
			}
		}
		?>
		
		<?php
		if(isset($_POST['submit'])){
			$id_guru			= $_POST['id_guru'];
			$nama_guru			= $_POST['nama_guru'];
			$username			= $_POST['username'];
            	$password			= $_POST['password'];
			
			$sql = mysqli_query($coneksi, "UPDATE guru SET 
			nama_guru='$nama_guru',
			username='$username', 
			password='$password'
		      WHERE id_guru='$id_guru'") or die(mysqli_error($coneksi));

			if($sql){
			      echo '
				<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
				<script>
					Swal.fire({
						icon: "success",
						title: "Berhasil menambahkan data baru!",
						showConfirmButton: true
					}).then((result) => {
						if (result.isConfirmed) {
						window.location.href = "index.php?page=guru";
						}
					});
				</script>';
				} else {
				echo '
				<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
				<script>
					Swal.fire({
						icon: "error",
						title: "Gagal menambahkan jurnal",
						text: "' . mysqli_error($coneksi) . '",
						showConfirmButton: true
					}).then((result) => {
						if (result.isConfirmed) {
						window.location.href = "index.php?page=guru";
						}
					});
				</script>';
				}
		
	      } else {
	            echo 'You should select a file to upload !!';
	        }
		?>