<div id="wrapper">

  <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
      <ul class="nav metismenu" id="side-menu">
        <?= $this->load->view('Fragment/SidebarHeaderFragmentPendaftar', NULL, TRUE); ?>
        <li id="dashboard">
          <a href="<?= base_url('pendaftar/') ?>"><i class="fa fa-home"></i> <span class="nav-label">Beranda</span></a>
        </li>
        <li id="chatbot">
          <a href="<?= base_url('pendaftar/jadwal') ?>"><i class="fa fa-comments"></i> <span class="nav-label">Jadwal</span></a>
        </li>
        <li id="chatbot">
          <a href="<?= base_url('pendaftar/chatbot') ?>"><i class="fa fa-comments"></i> <span class="nav-label">Chatbot</span></a>
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