<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PendaftarModel extends CI_Model
{


    public function cek_status($data)
    {
        $this->db->select('*');
        $this->db->from('user as u');
        $this->db->join('data_pendaftar as dp ', 'u.id_data = dp.id_data', 'left');
        $this->db->where('id_user', $data['id_user']);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getKelasSaya($filter = [])
    {

        $this->db->select("u.* , pjo.username , pjo.nama, ta.*, jk.* ,jj.nama_jenis_jurusan");
        $this->db->from('mapping_siswa as u');
        $this->db->join("user as pjo", "u.id_siswa = pjo.id_user");
        $this->db->join("mapping as m", "u.id_mapping = m.id_mapping");
        $this->db->join("jenis_kelas as jk", "jk.id_jenis_kelas = m.id_jenis_kelas");
        $this->db->join("jenis_jurusan as jj", "jk.id_jenis_jurusan = jj.id_jenis_jurusan");
        $this->db->join("tahun_ajaran as ta", "ta.id_tahun_ajaran = m.id_tahun_ajaran");
        if (!empty($filter['id_mapping'])) $this->db->where('u.id_mapping', $filter['id_mapping']);
        if ($this->session->userdata()['nama_role'] == 'siswa') {
            $this->db->where('u.id_siswa', $this->session->userdata()['id_user']);
        }


        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_mapping_siswa');
    }

    public function addData($data)
    {

        $dataInsert = DataStructure::slice(
            $data,
            [
                'no_ktp', 'file_ktp', 'swa_foto', 'tempat_lahir', 'nama_sekolah', 'nomor_ijazah', 'alamat_sekolah', 'nomor_ktp', 'tanggal_lahir', 'status_data',
                'file_ijazah'
            ]
        );
        $this->db->insert('data_pendaftar', $dataInsert);
        ExceptionHandler::handleDBError($this->db->error(), "Insert Data Pendaftar", "data_pendaftar");
        $id = $this->db->insert_id();

        $this->db->set('id_data', $id);
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $this->db->update('user');
        ExceptionHandler::handleDBError($this->db->error(), "Ubah  Data Pendaftar", "data_pendaftar");
    }

    public function editData($data)
    {
        $this->db->set(DataStructure::slice(
            $data,
            [
                'no_ktp', 'file_ktp', 'swa_foto', 'tempat_lahir', 'nama_sekolah', 'nomor_ijazah', 'alamat_sekolah', 'nomor_ktp', 'tanggal_lahir', 'status_data',
                'file_ijazah'
            ]
        ));
        $this->db->where('id_data', $data['id_data']);
        $this->db->update('data_pendaftar');

        ExceptionHandler::handleDBError($this->db->error(), "Ubah  Data Pendaftar", "data_pendaftar");
        // return $data['id_submit_task'];
    }
}
