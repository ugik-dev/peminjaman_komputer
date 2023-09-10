<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->SecurityModel->roleOnlyGuard('mahasiswa');
        $this->load->model(array('MahasiswaModel', 'PeminjamanModel'));
    }
    function cek_status()
    {
        // $status =  $this->MahasiswaModel->cek_status(['id_user' => $this->session->userdata('id_user')]);
        $status =  $this->MahasiswaModel->cek_status(['id_user' => $this->session->userdata('id_user')]);
        if (empty($status)) {
            redirect(base_url('mahasiswa/pre'));
        }
        echo json_encode($status);
    }
    public function index()
    {
        $this->SecurityModel->roleOnlyGuard('mahasiswa');
        $this->load->model('UserModel');
        $user = $this->session->userdata();
        $pageData = array(
            'title' => '',
            'content' => 'dashboard',
            'breadcrumb' =>  "Dashboard",
            'contentData' => array(),
            'ret_data' => $user
        );
        $this->load->view('Page', $pageData);
    }
    public function profile()
    {
        $this->SecurityModel->roleOnlyGuard('mahasiswa');
        $this->load->model('UserModel');
        $user = $this->session->userdata();
        $pageData = array(
            'title' => 'Profil',
            'content' => 'mahasiswa/profile',
            'breadcrumb' =>  "Mahasiswa",
            'contentData' => array(),
            'ret_data' => $user
        );
        $this->load->view('Page', $pageData);
    }
    public function getKelasSaya()
    {
        try {
            $this->SecurityModel->userOnlyGuard();
            $data = $this->SiswaModel->getKelasSaya();
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function update_profile()
    {
        try {
            $this->load->model('UserModel');
            $data =  $this->input->post();
            // var_dump($_FILES);
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

            $data['status_data'] = 1;
            $data['id_user'] = $this->session->userdata()['id_user'];
            $this->MahasiswaModel->editData($data);
            $user = $this->UserModel->getAllUser(['id_user' => $this->session->userdata()['id_user']])[$this->session->userdata()['id_user']];
            $this->session->set_userdata($user);

            echo json_encode($user);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function riwayat()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $this->SecurityModel->roleOnlyGuard('mahasiswa');

            $pageData = array(
                'title' => 'Riwayat Peminjaman',
                'breadcrumb' => 'Mahasiswa',
                'content' => 'mahasiswa/riwayat',

            );
            $this->load->view('Page', $pageData);
            // $this->load->view('test');
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }



    public function delete_task()
    {
        try {
            $this->SecurityModel->rolesOnlyGuard(array('guru'), true);
            $data = $this->input->post();
            $this->GuruModel->delete_task($data);
            // $this->KelolahmapelModel->getKelolahuser($idKelolahuser);
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function getYourHistory()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            // $filter['id_user'] = $this->session->userdata()['id_user'];
            if (!empty($this->session->userdata()['id_user']))
                $filter['id_user'] = $this->session->userdata()['id_user'];
            else
                $filter['ip_address'] = $this->input->ip_address();
            $data = $this->ParameterModel->getYourHistory($filter);
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }


    public function getRiwayat()
    {
        try {

            $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->PeminjamanModel->getAllPeminjaman(['id_user' => $this->session->userdata('id_user')]);
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function addPeminjaman()
    {

        try {
            $this->SecurityModel->roleOnlyGuard('mahasiswa');
            $this->load->model('PeminjamanModel');
            $data = $this->input->post();
            if (empty($data['select_komputer']))
                throw new UserException("Anda harus memilih komputer terlebi dahulu", USER_NOT_FOUND_CODE);
            else
                $data['id_komputer'] = $data['select_komputer'];

            $id = $this->PeminjamanModel->addPeminjaman($data);
            $data = $this->PeminjamanModel->getAllPeminjaman(array('id_peminjaman' => $id))[$id];
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function batalPeminjaman()
    {

        try {
            $this->SecurityModel->roleOnlyGuard('mahasiswa');
            $this->load->model('PeminjamanModel');
            $data = $this->input->post();

            $id = $this->PeminjamanModel->batalPeminjaman($data);
            $data = $this->PeminjamanModel->getAllPeminjaman(array('id_peminjaman' => $id))[$id];
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    // public function editPeminjaman()
    // {

    //     try {
    //         $this->SecurityModel->roleOnlyGuard('admin');
    //         $this->load->model('PeminjamanModel');
    //         $data = $this->input->post();
    //         $this->PeminjamanModel->editPeminjaman($data);
    //         $data = $this->PeminjamanModel->getAllPeminjaman(array('id_peminjaman' => $data['id_peminjaman']))[$data['id_peminjaman']];
    //         echo json_encode(array('data' => $data));
    //     } catch (Exception $e) {
    //         ExceptionHandler::handle($e);
    //     }
    // }
    public function daftarSessionExam()
    {
        try {
            $id = $this->input->post()['id_session_exam'];
            $filter['id_user'] = $this->session->userdata()['id_user'];
            $status =  $this->MahasiswaModel->cek_status(['id_user' => $this->session->userdata('id_user')])[0];
            if ($status['status_data'] != 2)
                throw new UserException("Maaf data anda belum diferivikasi", USER_NOT_FOUND_CODE);
            // echo json_encode($status);
            // die();
            $row = $this->ParameterModel->getAvaliableSession(array('id_session_exam' => $id, 'start_exam' => false));
            if (empty($row)) {
                throw new UserException("Sorry Not Avaliable", USER_NOT_FOUND_CODE);
            }
            $cur =  $row[$id];
            $i = 0;
            $shuffle = '';
            if ($cur['id_mapel'] == '1') {
                $data = $this->ParameterModel->getAllBankSoal(array('id_mapel' => '6', 'limit' => 30, 'order_random' => true, 'result_array' => true));
                shuffle($data);
                foreach ($data as $d) {
                    if ($i == 0)
                        $shuffle .= $d['id_bank_soal'];
                    else
                        $shuffle .= ',' . $d['id_bank_soal'];
                    $i++;
                }

                $data2 = $this->ParameterModel->getAllBankSoal(array('id_mapel' => '5', 'limit' => 30, 'order_random' => true, 'result_array' => true));
                shuffle($data2);
                foreach ($data2 as $d2) {
                    if ($i == 0)
                        $shuffle .= $d2['id_bank_soal'];
                    else
                        $shuffle .= ',' . $d2['id_bank_soal'];
                    $i++;
                }

                $data3 = $this->ParameterModel->getAllBankSoal(array('id_mapel' => '2', 'limit' => 20, 'order_random' => true, 'result_array' => true));
                shuffle($data3);
                foreach ($data3 as $d3) {
                    if ($i == 0)
                        $shuffle .= $d3['id_bank_soal'];
                    else
                        $shuffle .= ',' . $d3['id_bank_soal'];
                    $i++;
                }

                $data4 = $this->ParameterModel->getAllBankSoal(array('id_mapel' => '3', 'limit' => 20, 'order_random' => true, 'result_array' => true));
                shuffle($data4);
                foreach ($data4 as $d4) {
                    if ($i == 0)
                        $shuffle .= $d4['id_bank_soal'];
                    else
                        $shuffle .= ',' . $d4['id_bank_soal'];
                    $i++;
                }
            } else {
                $data = $this->ParameterModel->getAllBankSoal(array('id_mapel' => $cur['id_mapel'], 'limit' => $cur['limit_soal'], 'order_random' => true, 'result_array' => true));
                shuffle($data);
                foreach ($data as $d) {
                    if ($i == 0)
                        $shuffle .= $d['id_bank_soal'];
                    else
                        $shuffle .= ',' . $d['id_bank_soal'];
                    $i++;
                }
            }

            $create = array(
                'id_session_exam' => $id,
                'generate_soal' => $shuffle,
                'req_jurusan' => $this->input->post()['req_jurusan'],
                'req_jurusan_2' => $this->input->post()['req_jurusan_2']
            );
            $id = $this->ParameterModel->createExam($create);
            $filter['id_session_exam_user'] = $id;

            // $data = $this->ParameterModel->getExam($filter)[$id]['token'];

            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function SubmitExam()
    {
        try {
            $data = $this->input->post();
            $ans = '';
            for ($i = 0; $i < $data['count']; $i++) {
                if ($i == 0) {
                    if (!empty($data['row_' . $i])) {
                        $ans .=  $data['row_' . $i];
                    } else {
                        $ans .= '0';
                    }
                } else {
                    if (!empty($data['row_' . $i])) {
                        $ans .= ',' . $data['row_' . $i];
                    } else {
                        $ans .= ',0';
                    }
                }
            }
            $data['answer'] = $ans;
            $this->ParameterModel->SubmitExam($data);

            if ($data['autosave'] == 'false') {
                $this->calculateScore($data['token'], true);
                echo json_encode(['error' => false, 'reload' => true]);
            } else
                echo json_encode(['error' => false]);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function ujian($token)
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $filter['token'] = $token;
            // $filter['id_user'] = $this->session->userdata()['id_user'];
            if (!empty($this->session->userdata()['id_user']))
                $filter['id_user'] = $this->session->userdata()['id_user'];
            else {
                throw new UserException("Silahkan login ..", USER_NOT_FOUND_CODE);
            }

            $cur_date = date('Y-m-d H:i:s');

            $data = $this->ParameterModel->getExam($filter);
            if (!empty($data)) {
                $data = $data[$token];
                $ex_soal = explode(',', $data['generate_soal']);
            }
            // echo json_encode($data);
            // die();
            if ($data['open_start'] > $cur_date) {
                throw new UserException("Ujian belum dimulai", USER_NOT_FOUND_CODE);
            }
            if (empty($data['start_time'])) {
                $filter['start_time'] = $cur_date;
                $data['start_time'] = $cur_date;
                $filter['id_session_exam_user'] = $data['id_session_exam_user'];

                $this->ParameterModel->startExam($filter);
                // throw new UserException("Ujian belum dimulai", USER_NOT_FOUND_CODE);
            }
            // else {
            //     echo 'blm_mulai';
            // }
            // die();

            $c = count($ex_soal);
            // var_dump($data);
            $dateTime = new DateTime($data['start_time']);
            $dateTime->modify('+' . $data['limit_time'] . ' minutes');
            $t1 = ($dateTime->format("Y-m-d H:i:s"));

            $start = date_create(date("Y-m-d H:i:s"));
            // $start = date_create('2021-07-14 15:39:20');
            $end = date_create($t1);

            $start2 = strtotime(date("Y-m-d H:i:s"));
            $end2 = strtotime($t1);
            $diff = date_diff($end, $start);
            // var_dump($end2);
            // die();
            if ($end2 < $start2 or $data['exam_lock'] == 'Y') {
                if (empty($data['score']))
                    $this->calculateScore($data['token'], true);
                $this->pageresult($data);
                // $this->($data);
                // echo die();
                return;
            }
            $timer = $diff->h * 60 * 60;
            $timer = $timer + $diff->i * 60;
            $timer = $timer + $diff->s;
            // print_r($timer);
            // die();
            if (!empty($data['answer'])) {
                $ans = explode(',', $data['answer']);
            } else {
                for ($j = 0; $j < $c; $j++)
                    $ans[$j] = 0;
            }
            $i = 0;
            $btn = '';
            foreach ($ex_soal as $ex) {
                $exs = $this->ParameterModel->getShuffleSoal($ex);
                $data_soal[$i] = $exs;
                if ($ans[$i] == '0' or $ans[$i] == '-')
                    $btn .= '<a data-toggle="pill" class="nav-link btn btn-primary mr-1 mt-1" id="ans_' . $i . '" href="#soal_' . $i . '" role="tab">' . ($i + 1) . '</a>';
                else
                    $btn .= '<a data-toggle="pill" class="nav-link btn btn-success mr-1 mt-1" id="ans_' . $i . '" href="#soal_' . $i . '" role="tab">' . ($i + 1) . '</a>';
                $i++;
            }

            // echo json_encode(array('data' => $data_soal));
            // $this->SecurityModel->userOnlyGuard(TRUE);
            $pageData = array(
                'title' => 'Ujian',
                // 'content' => 'public/MyTask',
                'breadcrumb' => array(
                    'Home' => base_url(),
                ),
                'data_soal' => $data_soal,
                'btn' => $btn,
                'ans' => $ans,
                'token' => $token,
                'timer' => $timer
            );
            $this->load->view('PageExam', $pageData);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function pembahasan($token)
    {
        try {
            // $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->ParameterModel->getExam(['token' => $token])[$token];
            // echo json_encode($data);
            // die();
            if (!empty($data)) {
                $data = $data;
                $ex_soal = explode(',', $data['generate_soal']);
            }
            $c = count($ex_soal);
            // var_dump($data);

            if (!empty($data['answer'])) {
                $ans = explode(',', $data['answer']);
            } else {
                for ($j = 0; $j < $c; $j++)
                    $ans[$j] = 0;
            }
            $i = 0;
            $btn = '';
            foreach ($ex_soal as $ex) {
                $exs = $this->ParameterModel->getShuffleSoal($ex, true);
                $data_soal[$i] = $exs;
                if (empty($ans[$i]))
                    $btn .= '<a data-toggle="pill" class="nav-link btn btn-secondary mr-1 mt-1" id="ans_' . $i . '" href="#soal_' . $i . '" role="tab">' . ($i + 1) . '</a>';
                else if ($exs['soal']['token_opsi'] != $ans[$i])
                    $btn .= '<a data-toggle="pill" class="nav-link btn btn-danger mr-1 mt-1" id="ans_' . $i . '" href="#soal_' . $i . '" role="tab">' . ($i + 1) . '</a>';
                else if ($exs['soal']['token_opsi'] == $ans[$i])
                    $btn .= '<a data-toggle="pill" class="nav-link btn btn-success mr-1 mt-1" id="ans_' . $i . '" href="#soal_' . $i . '" role="tab">' . ($i + 1) . '</a>';
                $i++;
            }

            $pageData = array(
                'title' => 'Pembahasan',
                // 'content' => 'public/MyTask',
                'breadcrumb' => array(
                    'Home' => base_url(),
                ),
                'dataContent' => $data,
                'data_soal' => $data_soal,
                'btn' => $btn,
                'ans' => $ans,
            );
            $this->load->view('PagePembahasan', $pageData);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
    function pageresult($data)
    {
        try {
            // $this->SecurityModel->userOnlyGuard(TRUE);
            $pageData = array(
                'title' => 'Pre Register',
                'content' => 'mahasiswa/result',
                'breadcrumb' => array(
                    'Home' => base_url(),
                ),
                'contentData' => $data,
            );
            $this->load->view('Page', $pageData);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function calculateScore($token, $restric = false)
    {
        $data = $this->ParameterModel->getExam(array('token' => $token))[$token];
        $dateTime = new DateTime($data['start_time']);
        $dateTime->modify('+' . $data['limit_time'] . ' minutes');
        $t1 = ($dateTime->format("Y-m-d H:i:s"));


        $start2 = strtotime(date("Y-m-d H:i:s"));
        $end2 = strtotime($t1);
        if ($end2 + 6 < $start2) {
        } else {
            $i = 1;
            $ans = '';
            $ans_ex = explode(',', $data['answer']);
            $i = 0;
            foreach ($ans_ex as $an) {
                if ($i == 0) {
                    $i++;
                    $ans .= '"' . $an . '"';
                } else {
                    $ans .= ',"' . $an . '"';
                }
            }
            // var_dump($ans);
            // die();
            $this->ParameterModel->calculateScore($data, $data['generate_soal'], $ans);
        }
        // echo 'rest';
        // die();

        // $data['point_mode'] = 'avg';
        $i = 1;
        $ans = '';
        $ans_ex = explode(',', $data['answer']);
        $i = 0;
        foreach ($ans_ex as $an) {
            if ($i == 0) {
                $i++;
                $ans .= '"' . $an . '"';
            } else {
                $ans .= ',"' . $an . '"';
            }
        }
        // var_dump($ans);
        // die();
        $this->ParameterModel->calculateScore($data, $data['generate_soal'], $ans);
        if (!$restric)
            echo json_encode(array('error' => false));
        // die();
    }
}
