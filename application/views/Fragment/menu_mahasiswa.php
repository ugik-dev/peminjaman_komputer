<aside class="codex-sidebar">
    <div class="logo-gridwrap"><a class="codexbrand-logo" href="index.html"><img class="img-fluid" src="<?= base_url() ?>assets/images/logo/logo.png" alt="theeme-logo"></a><a class="codex-darklogo" href="index.html"><img class="img-fluid" src="<?= base_url() ?>assets/images/logo/dark-logo.png" alt="theeme-logo"></a>
        <div class="sidebar-action"><i data-feather="menu"></i></div>
    </div>
    <div class="icon-logo"><a href="<?=base_url()?>"><img class="img-fluid" src="<?= base_url() ?>assets/images/logo/logo1.png" alt="theeme-logo"></a></div>
    <div class="codex-menuwrapper">
        <ul class="codex-menu custom-scroll" data-simplebar>
            <li class="cdxmenu-title">
                <h5>Dashboards</h5>
            </li>
            <!-- <li class="menu-item" id="chatbot">
                <a href="<?= base_url('mahasiswa/riwayat') ?>"><i class="fa fa-history"></i> <span class="nav-label">Riwayat</span></a>
            </li>
            <li id="logout">
                <a href="<?= base_url('AdminController') ?>" class="logout"><i class="fa fa-sign-out"></i> <span class="nav-label">Logout</span></a>
            </li> -->

            <li class="menu-item"><a href="<?= base_url('mahasiswa/') ?>">
                    <div class="icon-item"><i data-feather="airplay"></i></div><span>Dashboard</span>
                </a></li>
            <li class="menu-item"><a href="<?= base_url('mahasiswa/profile') ?>">
                    <div class="icon-item"><i data-feather="user"></i></div><span>Profile</span>
                </a></li>
            <li class="cdxmenu-title">
                <h5>application</h5>
            </li>
            <li class="menu-item"><a href="<?= base_url('mahasiswa/riwayat') ?>">
                    <div class="icon-item"><i data-feather="calendar"></i></div><span>Riwayat Peminjaman</span>
                </a></li>
            <li class="menu-item"><a href="<?= base_url('logout') ?>">
                    <div class="icon-item"><i data-feather="log-out"></i></div><span>Logout</span>
                </a></li>
        </ul>
    </div>
</aside>