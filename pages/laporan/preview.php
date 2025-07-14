<?php
if (!isset($_POST['id_siswa']) || empty($_POST['id_siswa'])) {
    echo "ID siswa tidak ditemukan.";
    exit();
}

$id_siswa = $_POST['id_siswa'];
$page = $_POST['page'] ?? null;
?>
<div class="konten">
<?php
if (isset($_POST['page'])) {
    $page = $_POST['page'];
    switch ($page) {
        case 'cover':
            include $_SERVER['DOCUMENT_ROOT'] . '/app-absen/pages/laporan/cover.php';
            break;
        case 'df':
            include $_SERVER['DOCUMENT_ROOT'] . '/app-absen/pages/laporan/daftarhadir.php';
            break;
        case 'jr':
            include $_SERVER['DOCUMENT_ROOT'] . '/app-absen/pages/laporan/doc_jr.php';
            break;
        case 'catatan':
            include $_SERVER['DOCUMENT_ROOT'] . '/app-absen/pages/laporan/doc_catatan.php';
            break;
        case 'dn':
            include $_SERVER['DOCUMENT_ROOT'] . '/app-absen/pages/laporan/daftarnilai.php';
            break;
        case 'sk':
            include $_SERVER['DOCUMENT_ROOT'] . '/app-absen/pages/laporan/sk.php';
            break;
        case 'nkp':
            include $_SERVER['DOCUMENT_ROOT'] . '/app-absen/pages/laporan/nkp.php';
            break;
        case 'lp':
            include $_SERVER['DOCUMENT_ROOT'] . '/app-absen/pages/laporan/lp.php';
            break;
        case 'bl':
            include $_SERVER['DOCUMENT_ROOT'] . '/app-absen/pages/laporan/bl.php';
            break;
        default:
            echo "Maaf, halaman yang anda tuju tidak ada.";
            break;
    }
} else {
    echo "Halaman tidak ditemukan.";
}
?>