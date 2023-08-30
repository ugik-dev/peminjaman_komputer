<?php
$this->load->view('Fragment/HeaderFragment', ['title' => $title]);
// $this->load->view('Fragment/guest/SidebarFragment');
$this->load->view('Fragment/NavbarFragment');
$this->load->view($content);
$this->load->view('Fragment/SidebarHeaderModals', NULL, FALSE);
$this->load->view('Fragment/FooterFragment');
