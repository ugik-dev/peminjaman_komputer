<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model(array('AdminModel', 'ParameterModel', 'PendaftarModel', 'UserModel', 'PublicModel'));
  }

  public function index()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Beranda',
      'content' => 'Dashboard',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function panduan()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Panduan',
      'content' => 'admin/PanduanPage',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
      'contentData' => array(),
    );
    $this->load->view('Page', $pageData);
  }


  public function Message()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Mail Box',
      'content' => 'admin/Message',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function passing_grade()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pg = $this->PublicModel->getPassingGrade();
    // echo json_encode($pg);
    $pageData = array(
      'title' => 'Passing Grade',
      'content' => 'admin/passing_grade',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
      'dataContent' => $pg
    );
    $this->load->view('Page', $pageData);
  }

  public function editPassingGrade()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pg = $this->PublicModel->getPassingGrade();
    $post = $this->input->post();
    $data = [];
    $i = 0;
    foreach ($pg as $p) {
      $data[$i] = [
        'id_pg' => $post['id_pg_' . $p['id_jenis_jurusan']],
        'id_jurusan' => $p['id_jenis_jurusan'],
        'mtk' => $post['mtk_' . $p['id_jenis_jurusan']],
        'fisika' => $post['fisika_' . $p['id_jenis_jurusan']],
        'bind' => $post['bind_' . $p['id_jenis_jurusan']],
        'bing' => $post['bing_' . $p['id_jenis_jurusan']],
      ];
      $i++;
    }
    $this->AdminModel->editPassingGrade($data);
    echo json_encode($data);
    // $pageData = array(
    //   'title' => 'Passing Grade',
    //   'content' => 'admin/passing_grade',
    //   'breadcrumb' => array(
    //     'Home' => base_url(),
    //   ),
    //   'dataContent' => $pg
    // );
    // $this->load->view('Page', $pageData);
  }


  public function SetKelas()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Setting Kelas',
      'content' => 'admin/SetKelas',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function BankSoal()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Bank Soall',
      'content' => 'admin/BankSoal',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function SetMapel()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Setting Mata Pelajaran',
      'content' => 'admin/SetMapel',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }
  public function SetTA()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Setting Tahun Ajaran',
      'content' => 'admin/SetTA',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function Kelolahuser()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Kelolah Pegawai',
      'content' => 'admin/Kelolahuser',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function DetailPendaftar($id)
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $user = $this->PendaftarModel->cek_status(['id_user' => $id])[0];
    // echo json_encode($user);
    // die();
    $ret_data = $user;
    // if (!empty($user['id_data'])) {
    // } else {
    //     $ret_data = [];
    // }

    $pageData = array(
      'title' => 'Pre Register',
      'content' => 'admin/DetailPendaftar',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
      'contentData' => array(),
      'ret_data' => $ret_data
    );
    $this->load->view('Page', $pageData);
  }
  public function Pendaftar()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Kelolah Pendaftar',
      'content' => 'admin/Kelolahpendaftar',

      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }


  public function edit_data_pendaftar()
  {
    try {
      $this->SecurityModel->roleOnlyGuard('admin');
      $data =  $this->input->post();
      $user = $this->PendaftarModel->cek_status(['id_user' => $data['id_user']])[0];
      if (!empty($_FILES['file_ktp']['name'])) {
        $config['upload_path']          = './upload/ktp';
        $config['allowed_types']        = 'jpeg|jpg|png';
        $config['encrypt_name']             = true;
        $config['max_size']             = 300;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file_ktp')) {
          throw new UserException($this->upload->display_errors(), UPLOAD_FAILED_CODE);
        } else {
          $ktp = $this->upload->data();
          $data['file_ktp'] = $ktp['file_name'];
        }
      }

      if (!empty($user['id_data'])) {
        $data['id_data'] = $user['id_data'];
        $this->PendaftarModel->editData($data);
      } else {
        $this->PendaftarModel->addData($data);
      }
      echo json_encode($user);
    } catch (Exception $e) {
      ExceptionHandler::handle($e);
    }
  }

  public function KelolahMapel()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Kelolah Mapel',
      'content' => 'admin/KelolahMapel',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }


  public function rekap($id)
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $data['parent'] = $this->ParameterModel->getAllSession(['id_session_exam' => $id]);
    $data['child'] = $this->AdminModel->getRekap($id);
    // echo json_encode($data);
    $pageData = array(
      'title' => 'Rekap Ujian',
      'content' => 'admin/rekap',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
      'dataContent' => $data
    );
    $this->load->view('Page', $pageData);
  }

  public function jadwal_ujian()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Jadwal Ujian',
      'content' => 'admin/jadwal_ujian',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function MappingMapel()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Mapping Mapel Jurusan',
      'content' => 'admin/tapmapping/MapelKelas',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function DetailMapping()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $id = $this->input->get()['id_mapping'];
    $tmp = $this->ParameterModel->getAllMapping(array('id_mapping' => $this->input->get()['id_mapping']));
    // var_dump($tmp);
    $pageData = array(
      'title' => $tmp[0]['nama_jenis_kelas'] . ' ' . $tmp[0]['nama_jenis_jurusan'] . ' ' . $tmp[0]['sub_kelas'] . ' :: ' . $tmp[0]['deskripsi'] . ' (Semester ' . $tmp[0]['semester'] . ')',
      'content' => 'admin/DetailMapping',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
      'contentData' => ['id_mapping' => $this->input->get()['id_mapping']]
    );
    $this->load->view('Page', $pageData);
  }

  public function DetailKelas()
  {
    $this->SecurityModel->roleOnlyGuard('guru');
    $id = $this->input->get()['id_mapping'];
    $tmp = $this->ParameterModel->getAllMapping(array('id_mapping' => $this->input->get()['id_mapping']));
    // var_dump($tmp);
    $pageData = array(
      'title' => $tmp[0]['nama_jenis_kelas'] . ' ' . $tmp[0]['nama_jenis_jurusan'] . ' ' . $tmp[0]['sub_kelas'] . ' :: ' . $tmp[0]['deskripsi'] . ' (Semester ' . $tmp[0]['semester'] . ')',
      'content' => 'guru/DetailKelas',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
      'contentData' => ['id_mapping' => $this->input->get()['id_mapping']]
    );
    $this->load->view('Page', $pageData);
  }

  public function Transportasi()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Transportasi',
      'content' => 'admin/Transportasi',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function Cagarbudaya()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Cagar dan Budaya',
      'content' => 'admin/Cagarbudaya',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }
  // public function statistikCagarbudaya(){
  //   $this->SecurityModel->roleOnlyGuard('admin');
  //   $pageData = array(
  //     'title' => 'Statistik Cagar Budaya',
  //     'content' => 'admin/StatistikCagarbudaya',
  //     'breadcrumb' => array(
  //       'Home' => base_url(),
  //     ),
  //   );
  //   $this->load->view('Page', $pageData);
  // }


  public function getAllBankSoal()
  {

    $this->SecurityModel->roleOnlyGuard('admin');
    $filter = $this->input->post();
    $filter['full'] = true;
    $data = $this->ParameterModel->getAllBankSoal($filter);
    echo json_encode(array('data' => $data));
    // $this->load->view('admin/Pdfallsaranaprasarana', $pageData);
  }


  public function getAllSession()
  {

    $this->SecurityModel->roleOnlyGuard('admin');
    $filter = $this->input->post();
    $filter['full'] = true;
    $data = $this->ParameterModel->getAllSession($filter);
    echo json_encode(array('data' => $data));
    // $this->load->view('admin/Pdfallsaranaprasarana', $pageData);
  }

  public function getOpsi()
  {

    $this->SecurityModel->roleOnlyGuard('admin');
    $filter = $this->input->get();
    $filter['full'] = true;
    $data = $this->ParameterModel->getOpsi($filter);
    echo json_encode(array('data' => $data));
    // $this->load->view('admin/Pdfallsaranaprasarana', $pageData);
  }


  public function addBankSoal()
  {

    $this->SecurityModel->roleOnlyGuard('admin');
    $data = $this->input->post();
    $data['pembahasan_img'] = FileIO::genericUpload('pembahasan_img', array('png', 'jpeg', 'jpg', 'pdf'), '', $data);
    $data['image'] = FileIO::genericUpload('image', array('png', 'jpeg', 'jpg', 'pdf'), '', $data);

    $id = $this->AdminModel->addBankSoal($data);
    $data = $this->ParameterModel->getAllBankSoal(array('id_bank_soal' => $id))[$id];
    echo json_encode(array('data' => $data));
  }


  public function editBankSoal()
  {

    $this->SecurityModel->roleOnlyGuard('admin');
    $data = $this->input->post();
    if (empty($data['pembahasan_imgFilename'])) {
      unset($data['pembahasan_img']);
    } else {
      $data['pembahasan_img'] = FileIO::genericUpload('pembahasan_img', array('png', 'jpeg', 'jpg', 'pdf'), '', $data);
    }

    if (empty($data['imageFilename'])) {
      unset($data['image']);
    } else {
      $data['image'] = FileIO::genericUpload('image', array('png', 'jpeg', 'jpg', 'pdf'), '', $data);
    }

    $this->AdminModel->editBankSoal($data);
    $data = $this->ParameterModel->getAllBankSoal(array('id_bank_soal' => $data['id_bank_soal']))[$data['id_bank_soal']];
    echo json_encode(array('data' => $data));
  }


  public function addSessionExam()
  {

    $this->SecurityModel->roleOnlyGuard('admin');
    $data = $this->input->post();
    $id = $this->AdminModel->addSessionExam($data);
    $data = $this->ParameterModel->getAllSession(array('id_session_exam' => $id))[$id];

    echo json_encode(array('data' => $data));
  }
  public function deleteSessionExam()
  {

    $this->SecurityModel->roleOnlyGuard('admin');
    $data = $this->input->post();
    $id = $this->AdminModel->deleteSessionExam($data);
    // $data = $this->ParameterModel->getAllSession(array('id_session_exam' => $id))[$id];
    echo json_encode(array('data' => $data));
  }


  public function editSessionExam()
  {

    $this->SecurityModel->roleOnlyGuard('admin');
    $data = $this->input->post();
    $this->AdminModel->editSessionExam($data);
    $data = $this->ParameterModel->getAllSession(array('id_session_exam' => $data['id_session_exam']))[$data['id_session_exam']];
    echo json_encode(array('data' => $data));
    // $this->load->view('admin/Pdfallsaranaprasarana', $pageData);
  }



  public function PdfAllSenibudaya()
  {
    $this->SecurityModel->roleOnlyGuard('admin');

    $data = $this->SenibudayaModel->getAllSenibudaya();
    $pageData = array(
      'data' => $data,
    );
    $this->load->view('admin/Pdfallsenibudaya', $pageData);
  }

  public function PdfAllDesawisata()
  {
    $this->SecurityModel->roleOnlyGuard('admin');

    $data = $this->DesawisataModel->getAllDesawisata();
    $pageData = array(
      'data' => $data,
    );
    $this->load->view('admin/Pdfalldesawisata', $pageData);
  }

  public function PdfAllObjek()
  {
    $this->SecurityModel->roleOnlyGuard('admin');

    $data = $this->ObjekModel->getAllObjek();
    $pageData = array(
      'data' => $data,

    );
    $this->load->view('admin/Pdfallobjek', $pageData);
  }
  public function PdfAllPenginapan()
  {
    $this->SecurityModel->roleOnlyGuard('admin');

    $data = $this->PenginapanModel->getAllPenginapan();
    $pageData = array(
      'data' => $data,

    );
    $this->load->view('admin/Pdfallpenginapan', $pageData);
  }

  public function Kalender()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Event',
      'content' => 'Kalender',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }



  public function test()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'test',
      'content' => 'admin/test',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function Penginapan()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Penginapan',
      'content' => 'admin/Penginapan',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function Biro()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Biro Wisata dan Agen',
      'content' => 'admin/Biro',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  public function Usaha()
  {
    $this->SecurityModel->roleOnlyGuard('admin');
    $pageData = array(
      'title' => 'Usaha dan Jasa',
      'content' => 'admin/Usaha',
      'breadcrumb' => array(
        'Home' => base_url(),
      ),
    );
    $this->load->view('Page', $pageData);
  }

  function preview($token)
  {
    try {
      $data = $this->ParameterModel->getExam(['token' => $token])[$token];
      if (!empty($data)) {
        $data = $data;
        $ex_soal = explode(',', $data['generate_soal']);
      }
      $c = count($ex_soal);

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

        if ($exs['soal']['token_opsi'] == $ans[$i])
          $btn .= '<a data-toggle="pill" class="nav-link btn btn-success mr-1 mt-1" id="ans_' . $i . '" href="#soal_' . $i . '" role="tab">' . ($i + 1) . '</a>';
        else   if (empty($ans[$i]))
          $btn .= '<a data-toggle="pill" class="nav-link btn btn-secondary mr-1 mt-1" id="ans_' . $i . '" href="#soal_' . $i . '" role="tab">' . ($i + 1) . '</a>';
        else if ($exs['soal']['token_opsi'] != $ans[$i])
          $btn .= '<a data-toggle="pill" class="nav-link btn btn-danger mr-1 mt-1" id="ans_' . $i . '" href="#soal_' . $i . '" role="tab">' . ($i + 1) . '</a>';
        $i++;
      }

      $pageData = array(
        'title' => 'Pembahasan',
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
}
