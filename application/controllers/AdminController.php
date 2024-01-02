<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('AdminModel', 'ParameterModel',  'UserModel', 'MahasiswaModel', 'PeminjamanModel'));
    $this->db->debug = true;
  }



  public function index()
  {
    $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
    $pageData = array(
      'title' => '',
      'content' => 'Dashboard',
      'breadcrumb' => 'Dashboard',
    );
    $this->load->view('Page', $pageData);
  }


  public function getRekap()
  {
    try {

      $this->SecurityModel->userOnlyGuard(TRUE);
      $filter = $this->input->post();
      $data = $this->PeminjamanModel->getAllPeminjaman($filter);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function Kelolahuser()
  {
     $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
    $pageData = array(
      'title' => 'User',
      'content' => 'admin/Kelolahuser',
      'breadcrumb' => "Administrator",
    );
    $this->load->view('Page', $pageData);
  }

  public function DetailMahasiswa($id)
  {
     $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
    $user = $this->UserModel->getAllUser(['id_user' => $id])[$id];
    $ret_data = $user;
    $pageData = array(
      'title' => 'Mahasiswa / Detail',
      'content' => 'admin/DetailMahasiswa',
      'breadcrumb' => "Administrator",
      'contentData' => array(),
      'jurusan' => $this->ParameterModel->getAllJurusan(),

      'ret_data' => $ret_data
    );
    $this->load->view('Page', $pageData);
  }
  public function Mahasiswa()
  {
     $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
    $pageData = array(
      'title' => 'Mahasiswa',
      'content' => 'admin/Kelolahmahasiswa',

      'breadcrumb' => "Administrator",
    );
    $this->load->view('Page', $pageData);
  }


  public function edit_data_mahasiswa()
  {
    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $data =  $this->input->post();
      $user = $this->MahasiswaModel->cek_status(['id_user' => $data['id_user']])[0];
      if (!empty($_FILES['file_nim']['name'])) {
        $config['upload_path']          = './upload/nim';
        $config['allowed_types']        = 'jpeg|jpg|png';
        $config['encrypt_name']             = true;
        $config['max_size']             = 300;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file_nim')) {
          throw new UserException($this->upload->display_errors(), UPLOAD_FAILED_CODE);
        } else {
          $nim = $this->upload->data();
          $data['file_nim'] = $nim['file_name'];
        }
      }

      if (!empty($user['id_data'])) {
        $data['id_data'] = $user['id_data'];
        $this->MahasiswaModel->editData($data);
      } else {
        $this->MahasiswaModel->addData($data);
      }
      echo json_encode($user);
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function action()
  {

    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $this->load->model('PeminjamanModel');
      $data = $this->input->post();
      $cur_data = $this->PeminjamanModel->getAllPeminjaman(array('id_peminjaman' => $data['id_peminjaman']))[$data['id_peminjaman']];

      $data_post['id_peminjaman'] = $data['id_peminjaman'];
      if ($data['type'] == 'checkin' && $cur_data['status'] == 1) {
        $data_post['status'] = 2;
        $data_post['checkin_time'] = $data['time'];
        $data_post['checkin_petugas'] = $this->session->userdata('id_user');
      }
      if ($data['type'] == 'checkout' && $cur_data['status'] == 2) {
        $data_post['status'] = 3;
        $data_post['checkout_time'] = $data['time'];
        $data_post['checkout_petugas'] = $this->session->userdata('id_user');
      }
      $id = $this->PeminjamanModel->editPeminjaman($data_post);
      $cur_data = $this->PeminjamanModel->getAllPeminjaman(array('id_peminjaman' => $data['id_peminjaman']))[$data['id_peminjaman']];
      echo json_encode(array('data' => $cur_data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function rekap()
  {
     $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
    $pageData = array(
      'title' => 'Rekap Peminjaman',
      'content' => 'admin/rekap_peminjaman',
      'breadcrumb' => 'Aplikasi',
    );
    $this->load->view('Page', $pageData);
  }

  public function master_komputer()
  {
     $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
    $pageData = array(
      'title' => 'Master Komputer',
      'content' => 'admin/master_komputer',
      'breadcrumb' => "Master",
    );
    $this->load->view('Page', $pageData);
  }






  public function addKomputer()
  {

    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $this->load->model('KomputerModel');
      $data = $this->input->post();
      $id = $this->KomputerModel->addKomputer($data);
      $data = $this->KomputerModel->getAllKomputer(array('id_komputer' => $id))[$id];
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function editKomputer()
  {
    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $this->load->model('KomputerModel');
      $data = $this->input->post();
      $this->KomputerModel->editKomputer($data);
      $data = $this->KomputerModel->getAllKomputer(array('id_komputer' => $data['id_komputer']))[$data['id_komputer']];
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function master_labor()
  {
     $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
    $pageData = array(
      'title' => 'Master Laboratorim',
      'content' => 'admin/master_labor',
      'breadcrumb' => "Master",
    );
    $this->load->view('Page', $pageData);
  }
  public function addLabor()
  {

    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $this->load->model('LaborModel');
      $data = $this->input->post();
      $id = $this->LaborModel->addLabor($data);
      $data = $this->LaborModel->getAllLabor(array('id_labor' => $id))[$id];
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function editLabor()
  {
    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $this->load->model('LaborModel');
      $data = $this->input->post();
      $this->LaborModel->editLabor($data);
      $data = $this->LaborModel->getAllLabor(array('id_labor' => $data['id_labor']))[$data['id_labor']];
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function master_jurusan()
  {
     $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
    $pageData = array(
      'title' => 'Master Jurusan',
      'content' => 'admin/master_jurusan',
      'breadcrumb' => "Master",
    );
    $this->load->view('Page', $pageData);
  }

  public function addJurusan()
  {

    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $this->load->model('JurusanModel');
      $data = $this->input->post();
      $id = $this->JurusanModel->addJurusan($data);
      $data = $this->JurusanModel->getAllJurusan(array('id_jurusan' => $id))[$id];
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function editJurusan()
  {
    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $this->load->model('JurusanModel');
      $data = $this->input->post();
      $this->JurusanModel->editJurusan($data);
      $data = $this->JurusanModel->getAllJurusan(array('id_jurusan' => $data['id_jurusan']))[$data['id_jurusan']];
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function deleteKomputer()
  {
    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $this->load->model('KomputerModel');
      $data = $this->input->post();
      $this->KomputerModel->deleteKomputer($data);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function deleteJurusan()
  {
    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $this->load->model('JurusanModel');
      $data = $this->input->post();
      $this->JurusanModel->deleteJurusan($data);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function deleteLabor()
  {
    try {
       $this->SecurityModel->rolesOnlyGuard(['admin','ka_lab']);
      $this->load->model('LaborModel');
      $data = $this->input->post();
      $this->LaborModel->deleteLabor($data);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }
}
