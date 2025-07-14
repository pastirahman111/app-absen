<?php
session_start(); // WAJIB ADA!

include '../koneksi.php';

// Cek apakah form dikirim
if (!isset($_POST['nama']) || !isset($_POST['katakunci'])) {
    header("location:sign-in.php?pesan=akses_ditolak");
    exit();
}

$username = $_POST['nama'];
$password = $_POST['katakunci'];

// Validasi sederhana: jika kosong, kembalikan
if (empty($username) || empty($password)) {
    header("location:sign-in.php?pesan=kosong");
    exit();
}

// Cek admin
$stmt = $coneksi->prepare("SELECT * FROM users WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$login = $stmt->get_result();
$cek = $login->num_rows;

// Cek siswa
$stmt_siswa = $coneksi->prepare("SELECT * FROM siswa WHERE username=? AND password=?");
$stmt_siswa->bind_param("ss", $username, $password);
$stmt_siswa->execute();
$login_siswa = $stmt_siswa->get_result();
$cek_siswa = $login_siswa->num_rows;

// Cek guru
$stmt_guru = $coneksi->prepare("SELECT * FROM guru WHERE username=? AND password=?");
$stmt_guru->bind_param("ss", $username, $password);
$stmt_guru->execute();
$login_guru = $stmt_guru->get_result();
$cek_guru = $login_guru->num_rows;

// Cek pembimbing
$stmt_pembimbing = $coneksi->prepare("SELECT * FROM pembimbing WHERE username=? AND password=?");
$stmt_pembimbing->bind_param("ss", $username, $password);
$stmt_pembimbing->execute();
$login_pembimbing = $stmt_pembimbing->get_result();
$cek_pembimbing = $login_pembimbing->num_rows;

// Login sesuai level
if ($cek > 0) {
    $data = $login->fetch_assoc();
    if ($data['level'] == "admin") {
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "admin";
        $_SESSION['id_admin'] = $data['id_admin'];
        header("location:../index.php?page=dashboard&login=berhasil&username=$username");
        exit();
    } else {
        header("location:../index.php?pesan=level_tidak_diizinkan");
        exit();
    }
} elseif ($cek_siswa > 0) {
    $data = $login_siswa->fetch_assoc();
    $_SESSION['username'] = $username;
    $_SESSION['id_siswa'] = $data['id_siswa'];
    $_SESSION['level'] = "siswa";
    header("location:../index.php?page=dashboard_siswa&login=berhasil&username=$username");
    exit();
} elseif ($cek_guru > 0) {
    $data = $login_guru->fetch_assoc();
    $_SESSION['username'] = $username;
    $_SESSION['id_sekolah'] = $data['id_sekolah'];
    $_SESSION['id_guru'] = $data['id_guru'];
    $_SESSION['level'] = "guru";
    header("location:../index.php?page=dashboard_guru&login=berhasil&username=$username");
    exit();
} elseif ($cek_pembimbing > 0) {
    $data = $login_pembimbing->fetch_assoc();
    $_SESSION['username'] = $username;
    $_SESSION['id_perusahaan'] = $data['id_perusahaan'];
    $_SESSION['id_pembimbing'] = $data['id_pembimbing'];
    $_SESSION['level'] = "pembimbing";
    header("location:../index.php?page=dashboard_pembimbing&login=berhasil&username=$username");
    exit();
} else {
    // Jika tidak cocok semua
    header("location:sign-in.php?pesan=gagal");
    exit();
}

// Tutup statement
$stmt->close();
$stmt_siswa->close();
$stmt_guru->close();
$stmt_pembimbing->close();
$coneksi->close();
