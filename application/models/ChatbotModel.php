<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ChatbotModel extends CI_Model
{

    public function add($data)
    {
        $data['id_user'] = $this->session->userdata()['id_user'];
        $dataInsert = DataStructure::slice($data, ['act', 'text_message', 'id_user']);
        $this->db->insert('chat_session', $dataInsert);
        ExceptionHandler::handleDBError($this->db->error(), "Sent Message", "chat_session");
        return $this->db->insert_id();
    }
    public function cek_user($filter = [])
    {
        $this->db->select("c1,c2,c3,c4,c5");

        $this->db->where('id_user',  $this->session->userdata()['id_user']);
        $this->db->from('user as u');
        $this->db->limit('1');
        $res = $this->db->get();
        return $res->result_array();

        // return $res->result_array();
    }
    public function getReload($filter = [])
    {
        $this->db->select("");

        $this->db->from('chat_session as u');
        // $this->db->join('user as k', 'k.id_user = u.id_user', 'Left');

        // $this->db->where('u.id_user', $filter['id_user']);
        $this->db->where('u.id_user', $this->session->userdata('id_user'));
        if (!empty($filter['last'])) $this->db->where('u.id_chat > ' . $filter['last']);
        // if (!empty($filter['kelas'])) $this->db->where('u.kelas', $filter['kelas']);
        $this->db->limit('10', 'DESC');
        $this->db->order_by('id_chat', 'DESC');
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_chat');

        // return $res->result_array();
    }
    public function spk($filter)
    {

        $this->db->select("count(*) as x");
        $this->db->from('data_survey as u');
        if (!empty($filter['ops1'])) $this->db->where('u.ops1', $filter['ops1']);
        if (!empty($filter['ops2'])) $this->db->where('u.ops2', $filter['ops2']);
        if (!empty($filter['ops3'])) $this->db->where('u.ops3', $filter['ops3']);
        $j_1 = $this->db->get()->result_array()[0]['x'];
        if ($j_1 == 0)
            return false;

        $this->db->select("(count(id)/" . $j_1 . "*100), , id_jurusan");
        $this->db->from('data_survey as u');
        if (!empty($filter['ops1']))  $this->db->where('u.ops1', $filter['ops1']);
        if (!empty($filter['ops2']))  $this->db->where('u.ops2', $filter['ops2']);
        if (!empty($filter['ops3']))  $this->db->where('u.ops3', $filter['ops3']);
        $this->db->group_by('id_jurusan');
        // if (!empty($filter['last'])) $this->db->where('u.id_chat > ' . $filter['last']);
        $res = $this->db->get();
        $res = $res->result_array();
        echo json_encode($res);
        // return DataStructure::keyValue($res->result_array(), 'id_chat');

        // return $res->result_array();
    }

    public function calculate($data)
    {
        $this->db->from('jenis_jurusan');
        $poin =  $this->db->get();
        $poin = DataStructure::keyValue($poin->result_array(), 'id_jenis_jurusan');
        foreach ($poin as $key => $p) {
            $poin[$key]['poin'] = 0;
        }

        $this->db->from('jenis_jurusan');
        $this->db->join('chat_1', 'nilai_jurusan = jenjang');
        $this->db->where('id_c1', $data['c1']);
        $c1 =  $this->db->get();
        foreach ($c1->result_array() as $cdat1) {
            $poin[$cdat1['id_jenis_jurusan']]['poin']++;
        };

        $this->db->from('chat_2');
        $this->db->where('id_c2', $data['c2']);
        $c2 =  $this->db->get();
        $poin[$c2->result_array()[0]['nilai_jurusan']]['poin']++;

        $this->db->from('chat_3');
        $this->db->where('id_c3', $data['c3']);
        $c3 =  $this->db->get();
        $poin[$c3->result_array()[0]['nilai_jurusan']]['poin']++;

        $this->db->from('chat_4');
        $this->db->where('id_c4', $data['c4']);
        $c4 =  $this->db->get();
        $poin[$c4->result_array()[0]['nilai_jurusan']]['poin']++;

        $this->db->from('chat_5');
        $this->db->where('id_c5', $data['c5']);
        $c5 =  $this->db->get();
        $poin[$c5->result_array()[0]['nilai_jurusan']]['poin']++;

        $sum = 0;
        foreach ($poin as $key => $p) {
            if ($p['poin'] > 1)
                $sum = $sum + $p['poin'];
            else
                unset($poin[$key]);
        }
        foreach ($poin as $key => $p) {
            if ($p['poin'] > 1)
                $poin[$key]['persentase'] = round((int) $p['poin'] / $sum * 100);
        }
        $tmp_poin = array_column($poin, 'poin');
        array_multisort($tmp_poin, SORT_DESC, $poin);
        // echo json_encode($poin);
        $text = 'Berikut hasil rekomendasi jurusan anda !';
        $text_adm = '';
        foreach ($poin as $p) {
            if ($p['poin'] > 1) {
                $text .= '<br>' . $p['persentase'] . '% untuk jurusan ' . $p['nama_jenis_jurusan'];
                $text_adm .= ($text_adm == '' ? '' : '<br>') . $p['nama_jenis_jurusan'] . '% ' . $p['persentase'];
            }
        }
        $this->db->set('req_c', $text_adm);
        $this->db->where('id_user', $this->session->userdata()['id_user']);
        $this->db->update('user');

        return $text;
        // $poin['sum'] = $sum;
    }
    public function reset($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->delete('chat_session');
    }

    public function get_c1()
    {
        $this->db->from('chat_1');
        $this->db->order_by('num_array');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function get_c2()
    {
        $this->db->from('chat_2 as c');
        $this->db->order_by('num_array');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function get_c3()
    {
        $this->db->from('chat_3 as c');
        $this->db->order_by('num_array');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function get_c4()
    {
        $this->db->from('chat_4 as c');
        $this->db->order_by('num_array');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function get_c5()
    {
        $this->db->from('chat_5 as c');
        $this->db->order_by('num_array');
        $res = $this->db->get();
        return $res->result_array();
    }
    public function get_jawaban($id)
    {
        $this->db->from('chat_' . $id);
        // $this->db->order_by('num_array');
        $res = $this->db->get();
        return $res->result_array();
    }
    public function get_pertanyaan($id)
    {
        $this->db->from('chat_pertanyaan as c');
        $this->db->where('id_pertanyaan', $id);
        $res = $this->db->get();
        return $res->result_array()[0];
    }
    public function set_c($data)
    {
        $this->db->where('id_user',  $this->session->userdata()['id_user']);
        $this->db->update('user', DataStructure::slice($data, ['c1', 'c2', 'c3', 'c4', 'c5']));
    }
}
