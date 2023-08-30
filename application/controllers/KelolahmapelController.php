<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelolahmapelController extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('KelolahmapelModel'));
    $this->load->helper(array('DataStructure', 'Validation'));
  }


  public function getAllRoleOption()
  {
    try {
      // $this->SecurityModel->userOnlyGuard('admin');
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->KelolahmapelModel->getAllRoleOption($this->input->get());
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }


  public function getAllKelolahuser()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->KelolahmapelModel->getAllKelolahuser();
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }




  public function addUser()
  {
    try {
      $this->SecurityModel->userOnlyGuard('admin');
      $data = $this->input->post();
      $idKelolahuser = $this->KelolahmapelModel->addKelolahuser($data);
      $data = $this->KelolahmapelModel->getKelolahuser($idKelolahuser);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }


  public function add_siswa()
  {
    try {
      $this->SecurityModel->rolesOnlyGuard(array('admin', 'guru'), true);
      $data = $this->input->post();
      $idKelolahuser = $this->KelolahmapelModel->add_siswa($data);
      // $data = $this->KelolahmapelModel->getKelolahuser($idKelolahuser);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }


  public function create_kelas()
  {
    try {
      $this->SecurityModel->rolesOnlyGuard(array('admin'), true);
      $data = $this->input->post();
      $this->KelolahmapelModel->create_kelas($data);
      // $this->KelolahmapelModel->getKelolahuser($idKelolahuser);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function nonactive_kelas()
  {
    try {
      $this->SecurityModel->rolesOnlyGuard(array('admin'), true);
      $data = $this->input->post();
      $this->KelolahmapelModel->nonactive_kelas($data);
      // $this->KelolahmapelModel->getKelolahuser($idKelolahuser);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function active_kelas()
  {
    try {
      $this->SecurityModel->rolesOnlyGuard(array('admin'), true);
      $data = $this->input->post();
      $this->KelolahmapelModel->active_kelas($data);
      // $this->KelolahmapelModel->getKelolahuser($idKelolahuser);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function saveMapping()
  {
    try {
      $this->SecurityModel->rolesOnlyGuard(array('admin'), true);
      $data = $this->input->post();
      // if(empty($data['id_wali_kelas'])){
      if (!empty($data['nama_wali_kelas'])) {
        $tmp = explode(" -- ", $data['nama_wali_kelas']);
        if (!empty($tmp[2])) {
          $data['id_wali_kelas'] = $tmp[2];
        }
      }
      // }
      $this->KelolahmapelModel->saveMapping($data);
      // $this->KelolahmapelModel->getKelolahuser($idKelolahuser);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function delete_mapping_siswa()
  {
    try {
      $this->SecurityModel->rolesOnlyGuard(array('admin', 'guru'), true);
      $data = $this->input->post();
      $this->KelolahmapelModel->delete_mapping_siswa($data);
      echo json_encode(array());
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }
}
