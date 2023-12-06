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
                    <a href="<?= site_url('AdminController/Mahasiswa') ?>"><i class="fa fa-user"></i><span class="nav-label">Kelolah Mahasiswa</span></a>
                </li>
                <li id="rekap">
                    <a href="<?= site_url('AdminController/rekap') ?>"><i class="far fa-user-graduate"></i><span class="nav-label">Rekap Peminjaman</span></a>
                </li>
                <li id="master">
                    <a href="#"><i class="fa fa-tasks"></i> <span class="nav-label">Master</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level" aria-expanded="true">
                        <li id="master_komputer">
                            <a href="<?= site_url('AdminController/master_komputer') ?>"><i class="fa fa-archive"></i><span class="nav-label">Master Komputer</span></a>
                        </li>
                        <li id="master_labor">
                            <a href="<?= site_url('AdminController/master_labor') ?>"><i class="fa fa-archive"></i> <span class="nav-label"> Labor</span></a>
                        </li>
                        <li id="kelola_email">
                            <a href="<?= site_url('AdminController/kelola_email') ?>"><i class="fa fa-link"></i> <span class="nav-label">Kelolah Email</span></a>
                        </li>
                    </ul>
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