<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MahasiswaModel extends CI_Model
{


    public function cek_status($data)
    {
        $this->db->select('*');
        $this->db->from('user as u');
        $this->db->join('data_mahasiswa as dp ', 'u.id_data = dp.id_data', 'left');
        $this->db->where('id_user', $data['id_user']);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getRiwayat($filter = [])
    {

        // $this->db->select("u.* , pjo.username , pjo.nama, ta.*, jk.* ,jj.nama_jurusan");
        $this->db->from('peminjaman as p');
        if (!empty($filter['id_peminjaman'])) $this->db->where('p.id_peminjaman', $filter['id_peminjaman']);
        if ($this->session->userdata()['nama_role'] == 'mahasiswa') {
            $this->db->where('p.id_user', $this->session->userdata()['id_user']);
        } else {
            if (!empty($filter['id_user'])) $this->db->where('p.id_user', $filter['id_user']);
        }


        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_mapping_siswa');
    }

    public function addData($data)
    {

        $dataInsert = DataStructure::slice(
            $data,
            [
                'no_ktp', 'file_nim', 'swa_foto', 'tempat_lahir', 'nama_sekolah', 'nomor_ijazah', 'alamat_sekolah', 'nomor_ktp', 'tanggal_lahir', 'status_data',
                'file_ijazah'
            ]
        );
        $this->db->insert('data_mahasiswa', $dataInsert);
        ExceptionHandler::handleDBError($this->db->error(), "Insert Data Mahasiswa", "data_mahasiswa");
        $id = $this->db->insert_id();

        $this->db->set('id_data', $id);
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $this->db->update('user');
        ExceptionHandler::handleDBError($this->db->error(), "Ubah  Data Mahasiswa", "data_mahasiswa");
    }

    public function editData($data)
    {
        $this->db->set(DataStructure::slice(
            $data,
            [
                'username', 'tempat_lahir', 'tanggal_lahir', 'alamat', 'email', 'phone', 'file_nim', 'tahun_masuk', 'status_data', 'id_jurusan'
            ]
        ));
        $this->db->where('id_user', $data['id_user']);
        $this->db->update('user');

        ExceptionHandler::handleDBError($this->db->error(), "Ubah  Data Mahasiswa", "data_mahasiswa");
        // return $data['id_submit_task'];
    }
}
