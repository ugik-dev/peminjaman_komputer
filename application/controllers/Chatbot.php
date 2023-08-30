<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chatbot extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('ChatbotModel', 'ParameterModel'));
        $this->load->helper(array('DataStructure', 'Validation'));
        $this->SecurityModel->userOnlyGuard();
    }
    public function c1($push = false)
    {
        $data['num'] = [];
        $c1_data = $this->ChatbotModel->get_c1();
        $data['text'] = '[fr]Minat berkuliah selama berapa tahun?';
        foreach ($c1_data  as $c1) {
            array_push($data['num'], $c1['num_array']);
            $data['text'] .= '<br>' . $c1['num_array'] . '. ' . $c1['jawaban'];
        }
        if ($push) {
            $this->ChatbotModel->add(['act' => 'res', 'text_message' =>  $data['text']]);
            return;
        }
        return $data;
    }

    public function func_pertanyaan($client, $push = false)
    {
        $id = $client['req'];
        $data['num'] = [];
        $data['text'] = $this->ChatbotModel->get_pertanyaan($id)['text_pertanyaan'];
        $jawaban = $this->ChatbotModel->get_jawaban($id);
        foreach ($jawaban  as $j) {
            array_push($data['num'], $j['id_c' . $id]);
            $data['text'] .= '<br>' . $j['id_c' . $id] . '. ' . $j['jawaban'];
        }
        if ($push) {
            if (in_array(preg_replace("/[^0-9]/", "", $client['text_message']), $data['num'])) {
                $this->ChatbotModel->set_c(['c' . $id => preg_replace("/[^0-9]/", "", $client['text_message'])]);
                if ($id < 5) {
                    $data_push['text'] = $this->ChatbotModel->get_pertanyaan($id + 1)['text_pertanyaan'];
                    $jawaban = $this->ChatbotModel->get_jawaban($id + 1);
                    foreach ($jawaban  as $j) {
                        array_push($data['num'], $j['id_c' . ($id + 1)]);
                        $data_push['text'] .= '<br>' . $j['id_c' . ($id + 1)] . '. ' . $j['jawaban'];
                    }
                    $this->ChatbotModel->add(['act' => 'res', 'text_message' => $data_push['text']]);
                    echo json_encode(array('data' => 'ok', 'req' => $id + 1));
                    return;
                } else {
                    $this->cek_pertanyaan();
                }
            } else {
                $this->ChatbotModel->add(['act' => 'res', 'text_message' => 'Maaf kami tidak mengerti jawaban anda']);
            }
        }
        return $data;
    }
    public function cek_pertanyaan()
    {
        $data =  $this->ChatbotModel->cek_user()[0];
        if (empty($data['c1'])) {
            $this->func_pertanyaan(['req' => 1]);
        } else if (empty($data['c2'])) {
            $this->func_pertanyaan(['req' => 2]);
        } else if (empty($data['c3'])) {
            $this->func_pertanyaan(['req' => 3]);
        } else if (empty($data['c4'])) {
            $this->func_pertanyaan(['req' => 4]);
        } else if (empty($data['c5'])) {
            $this->func_pertanyaan(['req' => 5]);
        } else {
            $this->ChatbotModel->add(['act' => 'res', 'text_message' => "baiklah tunggu beberapa saat kami akan merekomendasikan jurusan untuk anda"]);
            echo json_encode(array('data' => 'ok', 'req' => 'calculate', 'req' => '-'));
            $res =  $this->ChatbotModel->calculate($data);
            $this->ChatbotModel->add(['act' => 'res', 'text_message' => $res]);
        }
    }
    public function sent()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $data_post = $this->input->post();
            $message = $this->input->post()['text_message'];
            $data['id_user'] = $this->session->userdata('id_user');
            $data_c =  $this->ChatbotModel->cek_user();
            if (!empty($this->input->post()['text_message'])) {
                $data['text_message'] = $message;
                $data['act'] = 'sen';
                $this->ChatbotModel->add($data);
            }
            if ($message == 'reset') {
                $this->ChatbotModel->reset($data['id_user']);
                $this->session->unset_userdata('chat');
                echo json_encode(array('data' => 'reset', 'reset' => true));
                return;
            } else if ($message == 'cek') {
                echo json_encode($this->session->userdata());
                return;
            } else if ($message == 'mulai') {
                $res =  $this->func_pertanyaan(['req' => 1]);
                $this->ChatbotModel->add(['act' => 'res', 'text_message' => 'Halo !! Chatbot ini akan merekomendasikan jurusan untuk anda.
                <br>silahkan jawab bertanyaan menggunakan angka !!<br>' . $res['text']]);
                echo json_encode(array('data' => 'ok', 'req' =>  1));
                return;
            }

            if (!empty($data_post['req'])) {
                $req = [1, 2, 3, 4, 5];
                if (in_array(preg_replace("/[^0-9]/", "", $data_post['req']), $req)) {
                    $this->func_pertanyaan($data_post, true);
                    return;
                } else {
                    // echo json_encode(array('data' => 'ok',));
                    // return;
                }
            } {
                $this->ChatbotModel->add(['act' => 'res', 'text_message' => 'Halo !! Chatbot ini akan merekomendasikan jurusan untuk anda.
                    <br>ketik "mulai" untuk memulai sessi pertanyaan!!<br>ketik "reset" untuk melalukan reset chat']);
                echo json_encode(array('data' => 'ok', 'req' =>  ''));
            }
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    public function error_text($req = null)
    {
        $data['text_message'] = 'Maaf kami tidak mengerti !! <br';
        $data['act'] = 'res';
        $this->ChatbotModel->add($data);
        if (!empty($restrict)) {
            echo json_encode(array('data' => 'ok', 'req' => $restrict));
        }
    }
    public function sent2()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $message = $this->input->post()['text_message'];
            $data['id_user'] = $this->session->userdata('id_user');
            if (!empty($this->input->post()['text_message'])) {
                $data['text_message'] = $message;
                $data['act'] = 'sen';
                $this->ChatbotModel->add($data);
            }
            if ($message == 'reset') {
                $this->ChatbotModel->reset($data['id_user']);
                $this->session->unset_userdata('chat');
                echo json_encode(array('data' => 'reset', 'reset' => true));
                return;
            }
            if ($message == 'cek') {
                echo json_encode($this->session->userdata());
                return;
                // die();
            }
            // $this->session->unset_userdata('chat');
            // DEKLARASI CHAT
            $ops1 = array("1", "2", "3", "4", "5", "6", "7");
            $ops1_data = [
                '1' => 'Biologi',
                '2' => 'Kimia',
                '3' => 'Fisika',
                '4' => 'Matematika',
                '5' => 'Ilmu Sosial',
                '6' => 'Sejarah',
                '7' => 'Geografi',
            ];
            $ops1_text = 'Pilih Mata pelajaran apa yang anda sukai?';
            foreach ($ops1_data  as $key => $o1) {
                $ops1_text .= '<br>' . $key . '. ' . $o1;
            }

            $ops2 = array("1", "2", "3", "4", "5");
            $ops2_data = [
                '1' => 'Membaca',
                '2' => 'Mekanik',
                '3' => 'Komputer',
                '4' => 'Musik',
                '5' => 'Olah raga',
            ];
            $ops2_text = 'Pilih Hobi apa yang anda sukai?';
            foreach ($ops2_data  as $key => $o1) {
                $ops2_text .= '<br>' . $key . '. ' . $o1;
            }

            $ops3 = array("1", "2", "3", "4", "5");
            $ops3_data = [
                '1' => 'Bakso',
                '2' => 'Mie Ayam',
                '3' => 'Sate',
                '4' => 'Soto',
                '5' => 'Makanan Laut',
            ];
            $ops3_text = 'Pilih Makanan apa yang anda sukai?';
            foreach ($ops3_data  as $key => $o1) {
                $ops3_text .= '<br>' . $key . '. ' . $o1;
            }
            $chat['chat'] = [
                'ops1' =>  !empty($this->session->userdata('chat')['ops1']) ?  $this->session->userdata('chat')['ops1'] : '',
                'ops2' =>  !empty($this->session->userdata('chat')['ops2']) ?  $this->session->userdata('chat')['ops2'] : '',
                'ops3' =>  !empty($this->session->userdata('chat')['ops3']) ?  $this->session->userdata('chat')['ops3'] : '',
            ];
            // CEK REQUEST DATA TERHADAP JAWABAN
            if (!empty($this->input->post()['req'])) {
                $req =  $this->input->post()['req'];
                if ($req == 'ops1') {
                    if (in_array(preg_replace("/[^0-9]/", "", $message), $ops1)) {
                        $data['text_message'] = $ops2_text;
                        $data['act'] = 'res';
                        $this->ChatbotModel->add($data);
                        $chat['chat']['ops1'] = $message;
                        $this->session->set_userdata($chat);
                        echo json_encode(array('data' => 'ok', 'req' => 'ops2'));
                        return;
                    } else {
                        $data['text_message'] = 'Maaf kami tidak mengerti !! <br' . $ops1_text;
                        $data['act'] = 'res';
                        $this->ChatbotModel->add($data);
                        echo json_encode(array('data' => 'ok', 'req' => 'ops1'));
                        return;
                    }
                } else
                if ($req == 'ops2') {
                    if (in_array($message, $ops2)) {
                        // kond
                        $data['text_message'] = $ops3_text;
                        $data['act'] = 'res';
                        $this->ChatbotModel->add($data);
                        $chat['chat']['ops2'] = $message;
                        $this->session->set_userdata($chat);
                        echo json_encode(array('data' => 'ok', 'req' => 'ops3'));
                        return;
                    } else {
                        $data['text_message'] = 'Maaf kami tidak mengerti !! <br' . $ops2_text;
                        $data['act'] = 'res';
                        $this->ChatbotModel->add($data);
                        echo json_encode(array('data' => 'ok', 'req' => 'ops2'));
                        return;
                    }
                } else
                if ($req == 'ops3') {
                    if (in_array($message, $ops3)) {
                        $chat['chat']['ops3'] = $message;
                        $this->session->set_userdata($chat);
                        $this->spk($data, $ops1_text, $ops2_text, $ops3_text);
                        // echo json_encode(array('data' => 'ok', 'req' => 'ops3'));
                        // return;
                    } else {
                        $data['text_message'] = 'Maaf kami tidak mengerti !! <br' . $ops3_text;
                        $data['act'] = 'res';
                        $this->ChatbotModel->add($data);
                        echo json_encode(array('data' => 'ok', 'req' => 'ops3'));
                        return;
                    }
                }
            } else {
                $data['text_message'] = 'Hallo ' . $this->session->userdata('nama') . '!!, ini merupakan fitur chatbot untuk merekomendasi jurusan yang cocok dengan anda, silahkan balas pesan ini dengan nomor. ';
                $data['act'] = 'res';
                $this->ChatbotModel->add($data);
                $data['text_message'] = $ops1_text;
                $data['act'] = 'res';
                $this->ChatbotModel->add($data);
                echo json_encode(array('data' => 'ok', 'req' => 'ops1'));
                return;
            }
            $this->session->set_userdata($chat);
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }

    function spk($data, $ops1_text, $ops2_text, $ops3_text)
    {
        if (empty($this->session->userdata('chat')['ops1'])) {
            $data['text_message'] = $ops1_text;
            $data['act'] = 'res';
            $this->ChatbotModel->add($data);
            echo json_encode(array('data' => 'ok', 'req' => 'ops1'));
            return;
        } else if (empty($this->session->userdata('chat')['ops2'])) {
            $data['text_message'] = $ops2_text;
            $data['act'] = 'res';
            $this->ChatbotModel->add($data);
            echo json_encode(array('data' => 'ok', 'req' => 'ops2'));
            return;
        } else if (empty($this->session->userdata('chat')['ops3'])) {
            $data['text_message'] = $ops3_text;
            $data['act'] = 'res';
            $this->ChatbotModel->add($data);
            echo json_encode(array('data' => 'ok', 'req' => 'ops3'));
            return;
        } else {

            $data['text_message'] = 'anda direkomendasikan masuk jurusan _______';
            $data['act'] = 'res';
            $this->ChatbotModel->add($data);
            echo json_encode(array('data' => 'ok', 'req' => ''));
        }
    }


    public function spk_run()
    {
        $this->ChatbotModel->spk([
            'ops1' => $this->session->userdata('chat')['ops1'],
            'ops2' => $this->session->userdata('chat')['ops2'],
            'ops3' => $this->session->userdata('chat')['ops3'],
        ]);
    }

    public function getReload()
    {
        try {
            $this->SecurityModel->userOnlyGuard(TRUE);
            $data = $this->ChatbotModel->getReload($this->input->get());
            echo json_encode(array('data' => $data));
        } catch (Exception $e) {
            ExceptionHandler::handle($e);
        }
    }
}
