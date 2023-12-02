<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PublicController extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('PublicModel', 'ParameterModel'));
    $this->load->helper(array('DataStructure', 'Validation'));
  }


  public function search()
  {
    $this->load->view('PublicPage', [
      'title' => "Search",
      'content' => 'public/Search',
    ]);
  }

  public function register()
  {
    $this->SecurityModel->guestOnlyGuard();
    $pageData = array(
      'title' => 'Daftar',
      'jurusan' => $this->ParameterModel->getAllJurusan()
    );
    $this->load->view('RegisterPage', $pageData);
  }

  public function lupaPassword(){
    $this->SecurityModel->guestOnlyGuard();
    $pageData = array(
      'title' => 'Daftar',
      'jurusan' => $this->ParameterModel->getAllJurusan()
    );
    $this->load->view('LupaPasswordPage', $pageData);
  }
  
  public function reset2Process()
  {
    try {
      $this->SecurityModel->guestOnlyGuard(TRUE);
      // Validation::ajaxValidateForm($this->SecurityModel->loginValidation());
      $data = $this->input->post();
      if (empty($data['password']) or empty($data['repassword']) or ($data['repassword'] != $data['password'])) {
        throw new UserException("Password Wrong!!", USER_NOT_FOUND_CODE);
      }
    
      $this->load->model(array('UserModel'));
      $dataToken = $this->UserModel->verifToken($data);
      if(empty($dataToken))
      throw new UserException("Data tidak valid", USER_NOT_FOUND_CODE);
    $data_update['id_user'] = $dataToken[0]['id_user'];
    $data_update['password'] = $data['password'];
      $data = $this->UserModel->resetPass($data_update);
      // if(empty($data))
      // throw new UserException("Data yang kamu masukkan tidak ditemukan", USER_NOT_FOUND_CODE);
      // $data = reset($data);
      
      // $res = $this->UserModel->resetPassword($data);
      // $data['token'] = $res['token'];
      // $data['id_reset'] = $res['id_reset'];
      // $data['id'] = 99;
      // $this->email_send($data, 'reset');
      echo json_encode(array("error" => FALSE, "user" => $dataToken));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function resetProcess()
  {
    try {
      $this->SecurityModel->guestOnlyGuard(TRUE);
      // Validation::ajaxValidateForm($this->SecurityModel->loginValidation());
      $data = $this->input->post();
      $this->load->model(array('UserModel'));
      $data = $this->UserModel->getAllUser($data);
      if(empty($data))
      throw new UserException("Data yang kamu masukkan tidak ditemukan", USER_NOT_FOUND_CODE);
      $data = reset($data);
      
      $res = $this->UserModel->resetPassword($data);
      $data['token'] = $res['token'];
      $data['id_reset'] = $res['id_reset'];
      // $data['id'] = 99;
      $this->email_send($data, 'reset');
      echo json_encode(array("error" => FALSE, "user" => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function reset($id, $token)
  {
    try {
      // $this->SecurityModel->guestOnlyGuard(TRUE);
      $data['token'] = $token;
      $data['id'] = $id;

      $this->load->model(array('UserModel'));
      $pageData = array(
        'title' => 'Daftar',
        'token' => $token,
        'id_reset' => $id
      );
      $this->load->view('ResetPasswordPage', $pageData);
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }
  public function registerProcess()
  {
    try {
      $this->SecurityModel->guestOnlyGuard(TRUE);
      // Validation::ajaxValidateForm($this->SecurityModel->loginValidation());

      $data = $this->input->post();

      if (empty($data['password']) or empty($data['repassword']) or ($data['repassword'] != $data['password'])) {
        throw new UserException("Password Wrong!!", USER_NOT_FOUND_CODE);
      }
      $this->load->model(array('UserModel'));
      $data = $this->UserModel->registerUser($data);
      // $data['id'] = 99;
      $this->email_send($data, 'registr');
      echo json_encode(array("error" => FALSE, "user" => $data));
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }



  public function my_task()
  {
    try {

      $this->SecurityModel->userOnlyGuard(TRUE);
      $pageData = array(
        'title' => 'My Task',
        'content' => 'public/MyTask',
        'breadcrumb' => array(
          'Home' => base_url(),
        ),
      );
      $this->load->view('Page', $pageData);
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function activator($id, $activate)
  {
    try {
      // $this->SecurityModel->guestOnlyGuard(TRUE);
      $data['activator'] = $activate;
      $data['id'] = $id;
      $this->load->model(array('UserModel'));

      $data = $this->UserModel->activatorUser($data);
      // $this->email_send($data, 'activate');
      redirect('login?activator=1');
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function email_send($data, $action)
  {

    $serv = $this->PublicModel->getServerSTMP();
    // echo json_encode($serv);
    // die();
    $send['to'] = $data['email'];
    if($action == 'reset'){
      // $data['token'] = 'asd';
      // $data['id_reset'] = 'sadk342#';
      $send['subject'] = 'Reset Password Sistem Informasi Peminjaman Komputer Polman Babel';
      $url_act = site_url("/reset/{$data['id_reset']}/{$data['token']}");
      $content = "<h4>Sistem Informasi Peminjaman Komputer Politeknik Manufaktur Bangka Belitung
      </h4>
                                              <br><br> Username / NIM : {$data['username']}
                                              <br> Email : {$data['email']}
                                              <br> Token : {$data['token']}
                                              <br>
                                              <br> Untuk reset password silahkan klik tombol reset dibawah.";

                                              $content2 = "<a href='{$url_act}' target='_blank' class='btn-primary' style='text-decoration: none;color: #fff;background-color: #1ab394;border: solid #1ab394;border-width: 5px 10px;line-height: 2;font-weight: bold;text-align: center;cursor: pointer;display: inline-block;border-radius: 5px; text-transform: capitalize;'>Reset sekarang</a>
                                              <br> atau masuk kealamat {$url_act} ";
    
    }else{
      $send['subject'] = 'Aktifasi Sistem Informasi Peminjaman Komputer Polman Babel';
      $url_act = site_url("/activator/{$data['id']}/{$data['activator']}");
      $content = "<h4>Selamat datang di Sistem Informasi Peminjaman Komputer Politeknik Manufaktur Bangka Belitung
    </h4><br><br>Email anda telah berhasil didaftarkan.
                                            <br><br> Username / NIM : {$data['username']}
                                            <br> Email : {$data['email']}
                                            <br> Activator : {$data['activator']}
                                            <br>
                                            <br> Untuk login harap melakukan aktivasi email terlebih dahulu dengan klik tombol aktifasi dibawah.";
  
                                            $content2 = "<a href='{$url_act}' target='_blank' class='btn-primary' style='text-decoration: none;color: #fff;background-color: #1ab394;border: solid #1ab394;border-width: 5px 10px;line-height: 2;font-weight: bold;text-align: center;cursor: pointer;display: inline-block;border-radius: 5px; text-transform: capitalize;'>Aktifkan sekarang</a>
                                            <br> atau masuk kealamat {$url_act} ";
  }
    
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
    // $this->load->libraries('email');
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
