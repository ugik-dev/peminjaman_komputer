<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LaborModel extends CI_Model
{
    public function getAllLabor($filter = [])
    {
        $this->db->select('*');
        $this->db->from('labor as k');
        if (!empty($filter['id_labor'])) $this->db->where('k.id_labor', $filter['id_labor']);

        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_labor');
    }


    function addLabor($data)
    {
        $dataInsert = DataStructure::slice($data, ['nama_labor']);
        $this->db->insert('labor', $dataInsert);
        ExceptionHandler::handleDBError($this->db->error(), "Menambah Laboratorium", "Laboratorium");
        return $this->db->insert_id();
    }


    public function editLabor($data)
    {
        $this->db->set(DataStructure::slice($data, ['id_labor',  'nama_labor']));
        $this->db->where('id_labor', $data['id_labor']);
        $this->db->update('labor');
        ExceptionHandler::handleDBError($this->db->error(), "Ubah Laboratorium", "Laboratorium");
        return $data['id_labor'];
    }

    public function deleteLabor($data)
    {
        $this->db->where('id_labor', $data['id_labor']);
        $this->db->delete('labor');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus Laboratorium", "Laboratorium");
    }
}
