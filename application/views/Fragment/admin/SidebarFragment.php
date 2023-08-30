<div id="wrapper">

  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav metismenu" id="side-menu">
        <?= $this->load->view('Fragment/SidebarHeaderFragment', NULL, TRUE); ?>
        <li id="dashboard">
          <a href="<?= site_url('AdminController/') ?>"><i class="fa fa-home"></i> <span class="nav-label">Beranda</span></a>
        </li>
        <li id="kelolahuser">
          <a href="<?= site_url('AdminController/Kelolahuser') ?>"><i class="fa fa-user"></i><span class="nav-label">Kelolah Pegawai</span></a>
        </li>
        <li id="kelolahsiswa">
          <a href="<?= site_url('AdminController/Pendaftar') ?>"><i class="fa fa-user"></i><span class="nav-label">Kelolah Pendaftar</span></a>
        </li>

        <li id="bank_soal">
          <a href="<?= site_url('AdminController/BankSoal') ?>"><i class="fa fa-note-sticky"></i><span class="nav-label">Bank Soal</span></a>
        </li>
        <li id="open_session">
          <a href="<?= site_url('AdminController/jadwal_ujian') ?>"><i class="far fa-user-graduate"></i><span class="nav-label">Jadwal Ujian</span></a>
        </li>
        <li id="passing_grade">
          <a href="<?= site_url('AdminController/passing_grade') ?>"><i class="far fa-user-graduate"></i><span class="nav-label">Passing Grade</span></a>
        </li>
        <!-- </li> -->
        <!-- <li id="search">
        <a href="<?= base_url('search') ?>"><i class="fas fa-search"></i></i> <span class="nav-label">Search</span></a>
      </li> -->
        <li id="logout">
          <a href="<?= site_url('AdminController') ?>" class="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
        </li>
        </li>
      </ul>
    </div>
  </nav>
  <script>
    $(document).ready(function() {});
  </script>