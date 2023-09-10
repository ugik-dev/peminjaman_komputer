<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GeneralController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('KomputerModel',  'LaborModel', 'JurusanModel', 'PublicModel'));
    }

    public function getPerformLabor()
    {
        $filter = $this->input->get();
        $data = $this->PublicModel->getPerformLabor($filter);
        echo json_encode(array('data' => $data));
    }


    public function getAllKomputer()
    {
        $filter = $this->input->get();
        $data = $this->KomputerModel->getAllKomputer($filter);
        echo json_encode(array('data' => $data));
    }

    public function getAllLabor()
    {
        $filter = $this->input->get();
        $data = $this->LaborModel->getAllLabor($filter);
        echo json_encode(array('data' => $data));
    }
    public function getAllJurusan()
    {
        $filter = $this->input->get();
        $data = $this->JurusanModel->getAllJurusan($filter);
        echo json_encode(array('data' => $data));
    }

    public function searchReady()
    {
        $filter = $this->input->get();
        $data = $this->KomputerModel->searchReady($filter);
        echo json_encode(array('data' => $data));
    }
}
