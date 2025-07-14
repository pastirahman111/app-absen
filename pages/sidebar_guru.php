<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand m-0" href="index.php?page=dashboard_guru">
      <img src="assets/img/LOGOSMK-removebg-preview.png" class="navbar-brand-img h-100" alt="main_logo">
      <span class="ms-1 font-weight-bold text-white">ABSENS</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white <?php echo (strpos($_GET['page'], 'dashboard_guru') !== false) ? 'active' : ''; ?>" href="index.php?page=dashboard_guru">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
           <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?php echo (strpos($_GET['page'], 'editguru') !== false) ? 'active' : ''; ?>" href="index.php?page=editguru1&id_guru=<?php echo $_SESSION['id_guru']?>">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
           <i class="material-icons opacity-10">person</i>
          </div>
          <span class="nav-link-text ms-1">Data Guru</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?php echo (strpos($_GET['page'], 'jurnal') !== false) ? 'active' : ''; ?>" href="index.php?page=jurnal">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
           <i class="material-icons opacity-10">assignment</i>
          </div>
          <span class="nav-link-text ms-1">Data Jurnal</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?php echo (strpos($_GET['page'], 'catatan') !== false) ? 'active' : ''; ?>" href="index.php?page=catatan">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
           <i class="material-icons opacity-10">receipt_long</i>
          </div>
          <span class="nav-link-text ms-1">Data Catatan</span>
        </a>
      </li>
      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?php echo ($_GET['page'] == 'laporan') ? 'active' : ''; ?>" href="index.php?page=laporan1">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">table_view</i>
          </div>
          <span class="nav-link-text ms-1">Laporan</span>
        </a>
      </li>
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