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
}
