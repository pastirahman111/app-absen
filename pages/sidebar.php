<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="index.php?page=dashboard">
      <img src="assets/img/LOGOSMK-removebg-preview.png" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold text-white">ABSENS</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-3">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">

      <!-- Dashboard -->
      <li class="nav-item">
        <a class="nav-link text-white" href="index.php?page=dashboard">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">home</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>

      <!-- Basis Data -->
      <li class="nav-item">
        <a class="nav-link text-white" data-bs-toggle="collapse" href="#basisDataMenu" role="button" aria-expanded="false" aria-controls="basisDataMenu">
          <i class="material-icons opacity-10">storage</i>
          <span class="nav-link-text ms-1">Basis Data</span>
        </a>
        <div class="collapse" id="basisDataMenu">
          <ul class="nav flex-column ms-4">
            <li class="nav-item"><a href="index.php?page=siswa" class="nav-link text-white">Data Siswa</a></li>
            <li class="nav-item"><a href="index.php?page=guru" class="nav-link text-white">Data Guru</a></li>
            <li class="nav-item"><a href="index.php?page=pembimbing" class="nav-link text-white">Data Pembimbing</a></li>
            <li class="nav-item"><a href="index.php?page=perusahaan" class="nav-link text-white">Data Perusahaan</a></li>
            <li class="nav-item"><a href="index.php?page=sekolah" class="nav-link text-white">Data Sekolah</a></li>
          </ul>
        </div>
      </li>

      <!-- Jurnal -->
      <li class="nav-item">
        <a class="nav-link text-white" data-bs-toggle="collapse" href="#jurnalMenu" role="button" aria-expanded="false" aria-controls="jurnalMenu">
          <i class="material-icons opacity-10">assignment</i>
          <span class="nav-link-text ms-1">Jurnal</span>
        </a>
        <div class="collapse" id="jurnalMenu">
          <ul class="nav flex-column ms-4">
            <li class="nav-item"><a href="index.php?page=jurnal" class="nav-link text-white">Data Jurnal</a></li>
            <li class="nav-item"><a href="index.php?page=tambahjurnal" class="nav-link text-white">Isi Jurnal</a></li>
          </ul>
        </div>
      </li>

      <!-- Catatan -->
      <li class="nav-item">
        <a class="nav-link text-white" data-bs-toggle="collapse" href="#catatanMenu" role="button" aria-expanded="false" aria-controls="catatanMenu">
          <i class="material-icons opacity-10">receipt_long</i>
          <span class="nav-link-text ms-1">Catatan</span>
        </a>
        <div class="collapse" id="catatanMenu">
          <ul class="nav flex-column ms-4">
            <li class="nav-item"><a href="index.php?page=catatan" class="nav-link text-white">Data Catatan</a></li>
            <li class="nav-item"><a href="index.php?page=tambahcatatan" class="nav-link text-white">Isi Catatan</a></li>
          </ul>
        </div>
        <li class="nav-item">
        <a class="nav-link text-white <?php echo ($_GET['page'] == 'rekap_absen') ? 'active' : ''; ?>" href="index.php?page=rekap_absen">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">table_view</i>
          </div>
          <span class="nav-link-text ms-1">Rekap Absen</span>
        </a>
      </li>
      </li>

      <!-- Laporan -->
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?php echo ($_GET['page'] == 'laporan') ? 'active' : ''; ?>" href="index.php?page=laporan3">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">table_view</i>
          </div>
          <span class="nav-link-text ms-1">Laporan</span>
        </a>
      </li>

      <!-- Sign Out -->
        <li class="nav-item">
          <div class="nav-link text-white" style="cursor:pointer;" onclick="konfirmasiLogout()">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">logout</i>
            </div>
            <span class="nav-link-text ms-1">Sign Out</span>
          </div>
        </li>
    </ul>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      function konfirmasiLogout() {
        Swal.fire({
          title: 'Yakin ingin logout?',
          text: "Anda akan keluar dari aplikasi!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya, logout!',
          cancelButtonText: 'Batal'
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.href ='pages/sign-in.php'; // path file logout kamu
          }
        });
      }
    </script>
  </div>
</aside>