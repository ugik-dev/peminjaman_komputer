<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SiswaModel extends CI_Model
{
    public function GetForumSaya($filter = [])
    {
        $this->db->select("u.* , pjo.nama as nama_guru");
        $this->db->from('v5_mapping as u');
        $this->db->join("user as pjo", "u.id_tenaga_kerja = pjo.id_user");

        if ($this->session->userdata()['nama_role'] == 'guru') {
            $this->db->where('u.id_tenaga_kerja', $this->session->userdata()['id_user']);
        }
        if (!empty($filter['id_tahun_ajaran'])) $this->db->where('u.id_tahun_ajaran', $filter['id_tahun_ajaran']);
        if (!empty($filter['id_mapping_kelas'])) $this->db->where('u.id_mapping_kelas', $filter['id_mapping_kelas']);

        $this->db->where('u.id_mapping', $filter['id_mapping']);
        if (!empty($filter['id_jenis_jurusan'])) $this->db->where('u.id_jenis_jurusan', $filter['id_jenis_jurusan']);
        if (!empty($filter['kelas'])) $this->db->where('u.kelas', $filter['kelas']);
        if (!empty($filter['id_mapel_jurusan'])) $this->db->where('u.id_mapel_jurusan', $filter['id_mapel_jurusan']);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function getAllSiswaMapping($filter = [])
    {
        $this->db->select("u.* , pjo.username , pjo.nama");
        $this->db->from('mapping_siswa as u');
        $this->db->join("user as pjo", "u.id_siswa = pjo.id_user");
        if (!empty($filter['id_mapping'])) $this->db->where('u.id_mapping', $filter['id_mapping']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_mapping_siswa');
    }

    public function getAllSiswaMappingTask($filter = [])
    {
        $this->db->select("*");
        $this->db->from('v7_task as u');
        $this->db->join("user as pjo", "u.id_siswa = pjo.id_user");
        $this->db->where('u.id_task', $filter['id_task']);
        if (!empty($filter['id_siswa'])) $this->db->where('u.id_siswa', $filter['id_siswa']);
        if (!empty($filter['id_mapping'])) $this->db->where('u.id_mapping', $filter['id_mapping']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_mapping_siswa');
    }

    public function getMyTask($filter = [])
    {
        $this->db->select("*");
        $this->db->from('v7_task as u');
        $this->db->join("user as pjo", "u.id_siswa = pjo.id_user");
        $this->db->where('u.id_task', $filter['id_task']);
        if ($this->session->userdata()['nama_role'] == 'siswa') {
            $this->db->where('u.id_siswa', $this->session->userdata()['id_user']);
        }
        if (!empty($filter['id_mapping'])) $this->db->where('u.id_mapping', $filter['id_mapping']);
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


    public function getAllTask($filter = [])
    {
        $this->db->select("*");
        $this->db->from('task as u');
        $this->db->join("v5_mapping as pjo", "u.id_mapping_kelas = pjo.id_mapping_kelas");

        if (!empty($filter['id_mapping_kelas'])) $this->db->where('u.id_mapping_kelas', $filter['id_mapping_kelas']);
        if (!empty($filter['id_task'])) $this->db->where('u.id_task', $filter['id_task']);
        // if ($this->session->userdata()['nama_role'] == 'guru')$this->db->where('u.id_created', $this->session->userdata()['id_user']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_task');

        // return $res->result_array();
    }

    public function getAllTaskSpek($filter = [])
    {
        $this->db->select("*");
        $this->db->from('task as u');
        if (!empty($filter['id_mapping_kelas'])) $this->db->where('u.id_mapping_kelas', $filter['id_mapping_kelas']);
        if (!empty($filter['id_task'])) $this->db->where('u.id_task', $filter['id_task']);
        if ($this->session->userdata()['nama_role'] == 'guru') $this->db->where('u.id_created', $this->session->userdata()['id_user']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_task');

        // return $res->result_array();
    }

    public function getAllSiswaTask($filter = [])
    {
        $this->db->select("u.* , pjo.nama as nama_siswa");

        $this->db->from('v7_task as u');
        $this->db->join("user as pjo", "u.id_siswa = pjo.id_user");

        // $this->db->join("user as pjo", "u.id_siswa = pjo.id_user");

        if (!empty($filter['id_mapping_kelas'])) $this->db->where('u.id_mapping_kelas', $filter['id_mapping_kelas']);
        if (!empty($filter['id_task'])) $this->db->where('u.id_task', $filter['id_task']);
        if (!empty($filter['id_siswa'])) $this->db->where('u.id_siswa', $filter['id_siswa']);
        // if (!empty($filter['id_mapel_jurusan'])) $this->db->where('u.id_mapel_jurusan', $filter['id_mapel_jurusan']);
        $res = $this->db->get();
        return DataStructure::keyValue($res->result_array(), 'id_siswa');

        // return $res->result_array();
    }

    function submit_task($data)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['submit_date'] = date('Y-m-d H:i:s');

        $dt = $this->gettask($data['id_task']);
        if ($dt[0]['end_task'] < $data['submit_date']) throw new UserException("Waktu Habis !!", USER_NOT_FOUND_CODE);

        $data['id_siswa'] = $this->session->userdata()['id_user'];

        $dataInsert = DataStructure::slice($data, ['id_task', 'submit_date', 'submit_deskripsi', 'submit_dokumen', 'id_siswa']);
        $this->db->insert('task_submit', $dataInsert);
        ExceptionHandler::handleDBError($this->db->error(), "Menambah Tugas", "task_submit");
        $this->db->insert_id();
    }

    function gettask($id_task)
    {
        $this->db->select("*");

        $this->db->from('task as u');
        $this->db->where('u.id_task', $id_task);
        // if (!empty($filter['id_mapel_jurusan'])) $this->db->where('u.id_mapel_jurusan', $filter['id_mapel_jurusan']);
        $res = $this->db->get();
        return $res->result_array();
    }


    public function update_task($data)
    {
        date_default_timezone_set('Asia/Jakarta');
        $data['submit_date'] = date('Y-m-d H:i:s');

        $dt = $this->gettask($data['id_task']);
        if ($dt[0]['end_task'] < $data['submit_date']) throw new UserException("Waktu Habis !!", USER_NOT_FOUND_CODE);

        $this->db->set(DataStructure::slice($data, ['id_task', 'submit_date', 'submit_deskripsi', 'submit_dokumen', 'id_siswa']));
        $this->db->where('id_submit_task', $data['id_submit_task']);
        $this->db->update('task_submit');

        ExceptionHandler::handleDBError($this->db->error(), "Ubah Tugas", "task_submit");
        return $data['id_submit_task'];
    }

    public function delete_task($data)
    {
        $this->db->where('id_task', $data['id_task']);
        $this->db->delete('task');

        ExceptionHandler::handleDBError($this->db->error(), "Hapus Tugas", "task");
    }

    function addEvaluasi($data)
    {
        // var_dump($data);   
        // $cek = $this->cekSiswa($data);
        // $data['id_created'] = $this->session->userdata()['id_user'];

        $dataInsert = DataStructure::slice($data, ['id_task', 'id_siswa', 'nilai', 'evaluasi']);
        $this->db->insert('task_submit', $dataInsert);
        ExceptionHandler::handleDBError($this->db->error(), "Menambah Tugas", "task_submit");
        $this->db->insert_id();
    }


    public function updateEvaluasi($data)
    {
        $this->db->set(DataStructure::slice($data, ['id_task', 'id_siswa', 'nilai', 'evaluasi']));
        $this->db->where('id_submit_task', $data['id_submit_task']);
        $this->db->update('task_submit');

        ExceptionHandler::handleDBError($this->db->error(), "Ubah Tugas", "task_submit");
        return $data['id_submit_task'];
    }
}
