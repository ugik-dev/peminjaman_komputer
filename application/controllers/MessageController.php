<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MessageController extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('MessageModel', 'ParameterModel'));
    $this->load->helper(array('DataStructure', 'Validation'));
  }

  public function sent_mapping_kelas()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      if (!empty($this->input->post()['text_message'])) $this->MessageModel->sent_mapping_kelas($this->input->post());
      echo json_encode(array('data' => 'ok'));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }


  public function getLoadMoreMappingKelasChat()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->ParameterModel->getLoadMoreMappingKelasChat($this->input->get());
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function getReloadMappingKelasChat()
  {
    try {
      $this->SecurityModel->userOnlyGuard(TRUE);
      $data = $this->ParameterModel->getAllMappingKelasChat($this->input->get());
      echo json_encode(array('data' => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }
}
