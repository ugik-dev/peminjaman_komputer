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
    );

    $this->load->view('RegisterPage', $pageData);
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
      redirect('login');
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }
  public function email_send($data, $action)
  {

    $serv = $this->PublicModel->getServerSTMP();
    $send['to'] = $data['email'];
    $send['subject'] = 'Aktifasi Sistem Pendaftaran Polman Babel';
    $url_act = site_url("/activator/{$data['id']}/{$data['activator']}");
    $content = "<br><br> Username :  {$data['username']}
    				<br> Password :  {$data['password_hash']}
    				<br> Activator :  {$data['activator']}
    				<br> 
    				<br><a href='{$url_act}' target='_blank' style='text-decoration:none;color: #60d2ff;'>Click this to activate</a>

    				<br> manual activate = {$url_act}";

    $content = "<h4>Selamat datang di sistem pendaftaran dan ujian masuk Politeknik Manufaktur Bangka Belitung
    </h4><br><br>Email anda telah berhasil didaftarkan.
                                            <br><br> Username : {$data['username']}
                                            <br> Password : {$data['password_hash']}
                                            <br> Activator : {$data['activator']}
                                            <br>
                                            <br> Untuk login harap melakukan aktivasi email terlebih dahulu dengan klik tombol aktifasi dibawah.";
    $content2 = "<a href='{$url_act}' target='_blank' class='btn-primary' style='text-decoration: none;color: #fff;background-color: #1ab394;border: solid #1ab394;border-width: 5px 10px;line-height: 2;font-weight: bold;text-align: center;cursor: pointer;display: inline-block;border-radius: 5px; text-transform: capitalize;'>Aktifkan sekarang</a>
                                            <br> atau masuk kealamat {$url_act} ";
    $send['message'] = $this->template_email($send['subject'], $content, $content2);

    // $config['smtp_host']    = $serv['url_'];
    // $config['charset']    = 'iso-8859-1';
    // $config['smtp_crypto']    = 'ssl';
    //  '' => 'ssl'
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
    // var_dump($this->email->print_debugger());

    // ini_set('display_errors', 1);
    // error_reporting(E_ALL);
    // $from = $serv['username'];
    // $to = "ugik.dev@gmail.com";
    // $subject = "Checking PHP mail";
    // $message = "PHP mail berjalan dengan baik";
    // $headers = "From:" . $from;
    // mail($to, $subject, $message, $headers);
    // echo "Pesan email sudah terkirim.";
    // die();
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
                                                                                        <td class='aligncenter content-block' style='padding: 0 0 20px;'>Follow <a style='color: #999;' href='https://instagram.com/ugikdev'>@ugikdev</a> on Instagram.</td>
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
