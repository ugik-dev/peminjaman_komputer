<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PeminjamanModel extends CI_Model
{
    public function getAllPeminjaman($filter = [])
    {
        // echo json_encode($filter);
        $this->db->select('p.*, k.id_komputer, k.id_labor, k.label_komputer ,l.*,u.nama nama_mahasiswa, j.nama_jurusan');
        $this->db->from('peminjaman as p');
        $this->db->join('user u', 'p.id_user = u.id_user');
        $this->db->join('jurusan j', 'u.id_jurusan = u.id_jurusan');
        $this->db->join('komputer k', 'p.id_komputer = k.id_komputer', 'left');
        $this->db->join('labor l', 'k.id_labor = l.id_labor', 'left');
        if (!empty($filter['id_peminjaman'])) $this->db->where('p.id_peminjaman', $filter['id_peminjaman']);
        if (!empty($filter['id_labor'])) $this->db->where('k.id_labor', $filter['id_labor']);
        if (!empty($filter['id_komputer'])) $this->db->where('k.id_komputer', $filter['id_komputer']);
        if (!empty($filter['id_user'])) $this->db->where('p.id_user', $filter['id_user']);

        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_peminjaman');
    }


    function addPeminjaman($data)
    {
        $data['id_user'] =  $this->session->userdata('id_user');

        $dataInsert = DataStructure::slice($data, ['id_komputer', 'status', 'id_user', 'time_start', 'time_end']);
        $this->db->insert('peminjaman', $dataInsert);
        ExceptionHandler::handleDBError($this->db->error(), "Menambah Peminjaman", "Peminjaman");
        return    $this->db->insert_id();
    }


    public function editPeminjaman($data)
    {
        $this->db->set(DataStructure::slice($data, [
            'id_komputer',  'status', 'id_user', 'time_start', 'time_end', 'checkout_petugas', 'checkout_time', 'checkin_petugas', 'checkin_time'

        ]));
        $this->db->where('id_peminjaman', $data['id_peminjaman']);
        $this->db->update('peminjaman');

        ExceptionHandler::handleDBError($this->db->error(), "Ubah Peminjaman", "Peminjaman");
        return $data['id_peminjaman'];
    }

    public function deletePeminjaman($data)
    {
        $this->db->where('id_peminjaman', $data['id_peminjaman']);
        $this->db->delete('peminjaman');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus Peminjaman", "Peminjaman");
    }
}
