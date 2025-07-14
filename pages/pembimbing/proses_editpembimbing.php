<?php include('../../koneksi.php'); ?>
<?php
	if(isset($_GET['id_pembimbing'])){
		$id_pembimbing = $_GET['id_pembimbing'];
		
		$select = mysqli_query($coneksi, "SELECT * FROM pembimbing WHERE id_pembimbing='$id_pembimbing'") or die(mysqli_error($coneksi));
		
		if(mysqli_num_rows($select) == 0){
			echo '            <script>
			Swal.fire({
				icon: "success",
				title: "Berhasil",
				text: "Data berhasil dihapus!",
				timer: 2000,
				showConfirmButton: false
			});
			</script>';
		}else{
			$data = mysqli_fetch_assoc($select);
		}
	}
?>
	
<?php
	if(isset($_POST['submit'])){
		$id_pembimbing		= $_POST['id_pembimbing'];
		$nama_pembimbing		= $_POST['nama_pembimbing'];
		$username			= $_POST['username'];
		$password			= $_POST['password'];
		
		
		$sql = mysqli_query($coneksi, "UPDATE pembimbing SET 
		nama_pembimbing='$nama_pembimbing',
		username='$username', 
		password='$password'
		WHERE 
		id_pembimbing='$id_pembimbing'") or die(mysqli_error($coneksi));

		
		if($sql){
			echo '<script>alert("Berhasil menambahkan data."); document.location="../../index.php?page=pembimbing";</script>';
		}else{
			echo '<div class="alert alert-warning">Gagal melakukan proses tambah data.</div>';
			}
		}
			
		else {
		echo 'You should select a file to upload !!';
		}
	
?>