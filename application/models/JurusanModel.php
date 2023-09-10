<?php
defined('BASEPATH') or exit('No direct script access allowed');

class JurusanModel extends CI_Model
{
    public function getAllJurusan($filter = [])
    {
        $this->db->select('*');
        $this->db->from('jurusan as k');
        if (!empty($filter['id_jurusan'])) $this->db->where('k.id_jurusan', $filter['id_jurusan']);

        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_jurusan');
    }


    function addJurusan($data)
    {
        $dataInsert = DataStructure::slice($data, ['nama_jurusan']);
        $this->db->insert('jurusan', $dataInsert);
        ExceptionHandler::handleDBError($this->db->error(), "Menambah Jurusanatorium", "Jurusanatorium");
        return $this->db->insert_id();
    }


    public function editJurusan($data)
    {
        $this->db->set(DataStructure::slice($data, ['id_jurusan',  'nama_jurusan']));
        $this->db->where('id_jurusan', $data['id_jurusan']);
        $this->db->update('jurusan');
        ExceptionHandler::handleDBError($this->db->error(), "Ubah Jurusanatorium", "Jurusanatorium");
        return $data['id_jurusan'];
    }

    public function deleteJurusan($data)
    {
        $this->db->where('id_jurusan', $data['id_jurusan']);
        $this->db->delete('jurusan');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus Jurusanatorium", "Jurusanatorium");
    }
}
