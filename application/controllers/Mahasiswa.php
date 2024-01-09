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
            'content' => 'Dashboard',
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
                'content' => 'mahasiswa/Riwayat',

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
                throw new UserException("Anda harus memilih komputer terlebih dahulu", USER_NOT_FOUND_CODE);
            else
                $data['id_komputer'] = $data['select_komputer'];

            $id = $this->PeminjamanModel->addPeminjaman($data);
            $data = $this->PeminjamanModel->getAllPeminjaman(array('id_peminjaman' => $id))[$id];
            $this->load->model('UserModel');
            $email = $this->UserModel->getAllUser(array('id_lab' => $data['id_labor']), false);
            if (!empty($email[0]['email']));
            $this->email_send($email[0]['email'], $data);
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




    public function email_send($email, $data)
    {

        $this->load->model('PublicModel');
        $serv = $this->PublicModel->getServerSTMP();
        // echo json_encode($serv);
        // die();
        $send['to'] = $email;
        $send['subject'] = 'Notifikasi Peminjaman';
        $url_act = base_url();
        // $url_act = site_url("/peminjaman/{$data['id_peminjaman']}");
        $content = "<h4>Sistem Informasi Peminjaman Komputer Politeknik Manufaktur Bangka Belitung
      </h4>
                                              <br><br> Nama Mahasiswa : {$data['nama_mahasiswa']}
                                              <br> Prodi : {$data['nama_jurusan']}
                                              <br> Laboratorium : {$data['nama_labor']}
                                              <br> Keterangan : {$data['keterangan']}
                                              <br> Komputer : {$data['label_komputer']}
                                              <br> Waktu  : {$data['time_start']} - {$data['time_end']}
                                             ";

        $content2 = "<a href='{$url_act}' target='_blank' class='btn-primary' style='text-decoration: none;color: #fff;background-color: #1ab394;border: solid #1ab394;border-width: 5px 10px;line-height: 2;font-weight: bold;text-align: center;cursor: pointer;display: inline-block;border-radius: 5px; text-transform: capitalize;'>SIPK POLMAN BABEL</a>
                                             ";


        $send['message'] = $this->template_email($send['subject'], $content, $content2);

        $config['protocol']    = 'smtp';
        $config['smtp_host']    = $serv['url_'];
        $config['smtp_port']    = $serv['port'];
        $config['smtp_timeout'] = '20';
        $config['smtp_user']    = $serv['username'];    //Important
        $config['smtp_pass']    = $serv['key'];  //Important
        $config['charset']    = 'utf-8';
        $config['newline']    = '\r\n';
        $config['smtp_crypto']    = 'tls';
        $config['mailtype'] = 'text'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not 
        $send['config'] = $config;
        $this->email->initialize($send['config']);
        $this->email->set_mailtype("html");
        $this->email->from($serv['username']);
        $this->email->to($send['to']);
        $this->email->subject($send['subject']);
        $this->email->message($send['message']);
        $this->email->send();

        ini_set('display_errors', 1);
        error_reporting(E_ALL);
        return 0;
    }

    function template_email($title, $content = '', $content2 = '')
    {
        return "<!DOCTYPE>
                <html xmlns='http://www.w3.org/1999/xhtml'>

                <head>
                <meta name='viewport' content='width=device-width' />
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <title>Actionable emails e.g. reset password</title>
                </head>

                <body style='-webkit-font-smoothing: antialiased;
                -webkit-text-size-adjust: none;
                width: 100% !important;
                height: 100%;
                line-height: 1.6;background-color: #f6f6f6;
                font-family:  Helvetica, Arial, sans-serif;'>
                <table class='body-wrap' style='background-color: #f6f6f6;	width: 100%;'>
                  <tr>
                      <td></td>
                      <td class='container' width='600' style='display: block !important;
                                    max-width: 600px !important;
                                    margin: 0 auto !important;
                                    clear: both !important;'>
                          <div class='content' style='max-width: 600px;
                                margin: 0 auto;
                                display: block;
                                padding: 20px;'>
                              <table class='main' width='100%' cellpadding='0' cellspacing='0' style='	background: #fff;
                                  border: 1px solid #e9e9e9;
                                  border-radius: 3px;'>
                                  <tr>
                                      <td class='content-wrap' style='padding: 20px;'>
                                          <table cellpadding='0' cellspacing='0'>
                                              <tr>
                                                  <td class='alert alert-good' style='background: #1ab394;font-size: 16px;	color: #fff;	font-weight: 500;
                                                      padding: 20px;
                                                      text-align: center;
                                                      border-radius: 3px 3px 0 0;'>
                                                      {$title} </td>
                                              </tr>
                                              <tr>
                                                  <td class='content-block' style='padding: 0 0 20px;'>
                                                      <br>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td class='content-block' style='padding: 0 0 20px;'>
                                                      {$content}   
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td class='content-block' style='padding: 0 0 20px;'>
                                                  </td>
                                              </tr>
                                              <tr>
                                                  <td class='content-block aligncenter' style='padding: 0 0 20px; text-align: center;'>
                                                      {$content2}                                          </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                            <div class='footer' style='width: 100%;	clear: both;	color: #999;	padding: 20px;'>
                                                                                <table width='100%'>
                                                                                    <tr style='text-align: center;'>
                                                                                        <td class='aligncenter content-block' style='padding: 0 0 20px;'>Kunjungi <a style='color: #999;' href='https://sipk-polmanbabel.my.id/'>Sistem Informasi Peminjaman Komputer Politeknik Manufaktur Bangka Belitung</a>.</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </table>

                                                        </body>

                                                        </html>";
    }
}
