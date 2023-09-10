<?php
$this->load->view('Fragment/HeaderFragment', ['title' => $title]);
$this->load->view('Fragment/NavbarFragment');
$this->load->view('Fragment/menu_' . strtolower($this->session->userdata('nama_role')));
?>
<div class="themebody-wrap">
    <div class="codex-breadcrumb">
        <div class="breadcrumb-contain">
            <div class="left-breadcrumb">
                <ul class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">
                            <h1><?= $breadcrumb ?></h1>
                        </a></li>
                    <li class="breadcrumb-item active"><a href="#"><?= $title ?></a></li>
                </ul>
            </div>
            <!-- <div class="right-breadcrumb">
                <ul>
                    <li>
                        <div class="bread-wrap"><i class="fa fa-clock-o"></i></div><span class="liveTime"></span>
                    </li>
                    <li>
                        <div class="bread-wrap"><i class="fa fa-calendar"></i></div><span class="getDate"></span>
                    </li>
                </ul>
            </div> -->
        </div>
    </div>
    <div class="theme-body">
        <div class="custom-container element-button">

            <?php
            $this->load->view('Fragment/SidebarHeaderModals');
            $this->load->view($content);
            echo "</div></div></div>";
            // $this->load->view("Fragment/content");
            // $this->load->view('Fragment/SidebarHeaderModals', NULL, FALSE);
            $this->load->view('Fragment/FooterFragment');
