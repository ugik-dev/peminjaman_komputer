<div id="wrapper">

  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav metismenu" id="side-menu">
        <?= $this->load->view('Fragment/SidebarHeaderFragmentMahasiswa', NULL, TRUE); ?>
        <li id="dashboard">
          <a href="<?= base_url('mahasiswa/') ?>"><i class="fa fa-home"></i> <span class="nav-label">Beranda</span></a>
        </li>
        <li id="chatbot">
          <a href="<?= base_url('mahasiswa/riwayat') ?>"><i class="fa fa-history"></i> <span class="nav-label">Riwayat</span></a>
        </li>
        <li id="logout">
          <a href="<?= base_url('AdminController') ?>" class="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
        </li>
        </li>
    </div>
  </nav>
  <script>
    $(document).ready(function() {});
  </script>