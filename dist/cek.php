<!-- cek apakah sudah login -->
	<?php 
	session_start();
	if($_SESSION['role']!="dist"){
		header("location:../index.php?pesan=belum_login");
	}
	$user_id = $_SESSION['id'];
	?>