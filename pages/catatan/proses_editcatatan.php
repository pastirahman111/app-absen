<?php include('../../koneksi.php'); ?>
<?php
		if(isset($_GET['id_catatan'])){
			$id_catatan = $_GET['id_catatan'];

			$select = mysqli_query($coneksi, "SELECT * FROM catatan WHERE id_catatan='$id_catatan'") or die(mysqli_error($coneksi));
			
			if(mysqli_num_rows($select) == 0){
				echo '<div class="alert alert-warning">id_sekolah tidak ada dalam database.</div>';
				exit();
			}else{
				$data = mysqli_fetch_assoc($select);
			}
		}
		?>
		
		<?php
		if(isset($_POST['submit'])){
			$id_catatan	     = $_POST['id_catatan'];
			$id_pembimbing   = $_POST['id_pembimbing'];
			$catatan	     = $_POST['catatan'];
                  $id_jurnal       = $_POST['id_jurnal'];
			
			
			$sql = mysqli_query($coneksi, "UPDATE catatan SET id_pembimbing='$id_pembimbing',catatan='$catatan', id_jurnal='$id_jurnal' WHERE id_catatan='$id_catatan'") or die(mysqli_error($coneksi));
			if($sql){
                        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
				<script>
				Swal.fire({
					icon: "success",
					title: "Berhasil",
					text: "Data Catatan berhasil Update!",
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
					text: "Data Catatan Gagal Di Update!",
					confirmButtonText: "Kembali"
				});
				</script>';
			}
		}
 
	         else {
	            echo 'You should select a file to upload !!';
	        }
		
		?>