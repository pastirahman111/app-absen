<?php 
if (session_status() == PHP_SESSION_NONE){
session_start();
}
 $hostname = 'localhost';
 $username  = 'root';
 $password  = '';
 $database  = 'app_absen';
$coneksi = mysqli_connect("localhost", "root", "", "app_absen");

if(!$coneksi){
	echo "Koneksi gagal";
}else{
	 echo "";
}
date_default_timezone_set('Asia/Jakarta');

 ?>