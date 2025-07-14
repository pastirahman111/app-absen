<?php
session_start();
include('../../koneksi.php'); // sesuaikan path koneksi.php

if (!isset($_SESSION['id_siswa'])) {
    echo 'Session tidak aktif.';
    exit();
}

$id_siswa = $_SESSION['id_siswa'];
$tanggal_hari_ini = date('Y-m-d');
$jam_sekarang = date('H:i:s');

$action = $_POST['action'] ?? '';
$keterangan = $_POST['keterangan'] ?? '';

$result = mysqli_query($coneksi, "SELECT * FROM absen WHERE id_siswa='$id_siswa' AND tanggal='$tanggal_hari_ini'");
$absen_hari_ini = mysqli_fetch_assoc($result);

if ($action === 'simpan_masuk' && !$absen_hari_ini) {
    $sql = mysqli_query($coneksi, "INSERT INTO absen (id_siswa, jam_masuk, tanggal, keterangan) 
                                   VALUES ('$id_siswa', '$jam_sekarang', '$tanggal_hari_ini', '$keterangan')");
    echo $sql ? 'Jam masuk tercatat. Klik lagi untuk absen keluar.' : 'Gagal mencatat jam masuk.';
} elseif ($action === 'simpan_keluar' && $absen_hari_ini && !$absen_hari_ini['jam_keluar']) {
    $sql = mysqli_query($coneksi, "UPDATE absen SET jam_keluar='$jam_sekarang' 
                                   WHERE id_siswa='$id_siswa' AND tanggal='$tanggal_hari_ini'");
    echo $sql ? 'Jam keluar tercatat.' : 'Gagal mencatat jam keluar.';
} else {
    echo 'Sudah absen keluar atau data tidak valid.';
}
exit();
