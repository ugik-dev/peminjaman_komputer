<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ParameterController extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('ParameterModel'));
    $this->load->helper(array('DataStructure', 'Validation'));
  }


  public function getAllTahunAjaran()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->ParameterModel->getAllTahunAjaran($this->input->get());
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function getAllKelas()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->ParameterModel->getAllKelas($this->input->post());
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function getAllJurusan()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->ParameterModel->getAllJurusan($this->input->post());
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }


  public function getAllMapping()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $filter = $this->input->post();

      $data = $this->ParameterModel->getAllMapping($filter);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function getAllMapel()
  {
    try {
      // $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->ParameterModel->getAllMapel();
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }


  public function getAllV4Mapping()
  {
    try {

      $this->SecurityModel->userOnlyGuard(TRUE);
      $filter = $this->input->post();

      $data = $this->ParameterModel->getAllV4Mapping($filter);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }


  public function getAllV5Mapping()
  {
    try {

      $this->SecurityModel->userOnlyGuard(TRUE);
      $filter = $this->input->post();

      $data = $this->ParameterModel->getAllV5Mapping($filter);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function getAllV0Mapping()
  {
    try {

      $this->SecurityModel->userOnlyGuard(TRUE);
      $filter = $this->input->post();

      $data = $this->ParameterModel->getAllV0Mapping($filter);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function getAllSiswa()
  {
    try {

      $this->SecurityModel->userOnlyGuard(TRUE);
      $filter = $this->input->post();

      $data = $this->ParameterModel->getAllSiswa($filter);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }



  public function getAllMappingKelasChat()
  {
    try {

      $this->SecurityModel->userOnlyGuard(TRUE);
      $filter = $this->input->get();

      $data = $this->ParameterModel->getAllMappingKelasChat($filter);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function getAllSiswaMapping()
  {
    try {

      $this->SecurityModel->userOnlyGuard(TRUE);
      $filter = $this->input->post();

      $data = $this->ParameterModel->getAllSiswaMapping($filter);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }


  public function getAllAbsen()
  {
    try {

      $this->SecurityModel->userOnlyGuard(TRUE);
      $filter = $this->input->post();

      $data = $this->ParameterModel->getAllAbsen($filter);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function getAllMapelJurusan()
  {
    try {

      $this->SecurityModel->userOnlyGuard(TRUE);
      $filter = $this->input->post();

      $data = $this->ParameterModel->getAllMapelJurusan($filter);
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }



  public function addMapel()
  {
    try {
      $this->SecurityModel->roleOnlyGuard('admin');
      $data = $this->input->post();
      $idUsaha = $this->ParameterModel->addMapel($data);
      $data = $this->ParameterModel->getAllMapel(array('id_mapel' => $idUsaha));
      echo json_encode(array('data' => $data[$idUsaha]));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function editMapel()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->input->post();
      $idUsaha = $this->ParameterModel->editMapel($data);
      $data = $this->ParameterModel->getAllMapel(array('id_mapel' => $idUsaha));
      echo json_encode(array('data' => $data[$idUsaha]));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function deleteMapel()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->input->post();
      $this->ParameterModel->deleteMapel($data);
      echo json_encode(array());
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }


  public function addKelas()
  {
    try {
      $this->SecurityModel->roleOnlyGuard('admin');
      $data = $this->input->post();
      $idUsaha = $this->ParameterModel->addKelas($data);
      $data = $this->ParameterModel->getAllKelas(array('id_jenis_kelas' => $idUsaha));
      echo json_encode(array('data' => $data[$idUsaha]));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function editKelas()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->input->post();
      $idUsaha = $this->ParameterModel->editKelas($data);
      $data = $this->ParameterModel->getAllKelas(array('id_jenis_kelas' => $idUsaha));
      echo json_encode(array('data' => $data[$idUsaha]));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function deleteKelas()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->input->post();
      $this->ParameterModel->deleteKelas($data);
      echo json_encode(array());
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function addTA()
  {
    try {
      $this->SecurityModel->roleOnlyGuard('admin');
      $data = $this->input->post();
      $idUsaha = $this->ParameterModel->addTA($data);
      $data = $this->ParameterModel->getAllTahunAjaran(array('id_tahun_ajaran' => $idUsaha));
      echo json_encode(array('data' => $data[$idUsaha]));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function editTA()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->input->post();
      $idUsaha = $this->ParameterModel->editTA($data);
      $data = $this->ParameterModel->getAllTahunAjaran(array('id_tahun_ajaran' => $idUsaha));
      echo json_encode(array('data' => $data[$idUsaha]));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function set_current_ta()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->input->post();
      $this->ParameterModel->set_current_ta($data);
      // $data = $this->ParameterModel->getAllKelas(array('id_jenis_kelas' => $idUsaha));
      echo json_encode(array('data' => ""));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function deleteTA()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->input->post();
      $this->ParameterModel->deleteTA($data);
      echo json_encode(array());
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }
}
