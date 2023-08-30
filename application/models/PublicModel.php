<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PublicModel extends CI_Model
{


	public function search($filter = [])
	{
		$this->db->select('id_user, username, nama');
		$this->db->from('user as po');
		$this->db->where('po.id_role ', '3');

		$this->db->where('po.nama like "%' . $filter['search'] . '%" OR po.username like "%' . $filter['search'] . '%" AND po.id_role = 3');
		// $this->db->where_or();

		// if(!empty($this->session->userdata('id_kabupaten'))) $this->db->where('po.id_kabupaten', $this->session->userdata('id_kabupaten'));
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_user');
	}

	public function search2($id)
	{
		$this->db->select('id_user, username, nama, photo');
		$this->db->from('user as po');
		$this->db->where('po.id_role ', '3');
		$this->db->where('po.id_user ', $id);

		// $this->db->where('po.nama like "%'. $filter['search'].'%" OR po.username like "%'. $filter['search'].'%" AND po.id_role = 3');
		// $this->db->where_or();

		// if(!empty($this->session->userdata('id_kabupaten'))) $this->db->where('po.id_kabupaten', $this->session->userdata('id_kabupaten'));
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_user');
	}


	public function searchDetail($id)
	{
		$this->db->select('po.* , ta.* , v1.id_jenis_kelas , jk.* , jj.nama_jenis_jurusan as jurusan');
		$this->db->from('mapping_siswa as po');
		$this->db->join('v1_mapping as v1', 'v1.id_mapping = po.id_mapping');
		$this->db->join('jenis_kelas as jk', 'v1.id_jenis_kelas = jk.id_jenis_kelas');
		$this->db->join('jenis_jurusan as jj', 'jj.id_jenis_jurusan = jk.id_jenis_jurusan');
		$this->db->join('tahun_ajaran as ta', 'ta.id_tahun_ajaran = v1.id_tahun_ajaran');
		$this->db->where('v1.status_mapping ', '1');
		$this->db->where('po.id_siswa ', $id['id']);
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_mapping');
	}

	public function searchSpekKelas($id)
	{
		$this->db->select('po.* , ta.* , v1.id_jenis_kelas , jk.* , jj.nama_jenis_jurusan as jurusan');
		$this->db->from('mapping_siswa as po');
		$this->db->join('v1_mapping as v1', 'v1.id_mapping = po.id_mapping');
		$this->db->join('jenis_kelas as jk', 'v1.id_jenis_kelas = jk.id_jenis_kelas');
		$this->db->join('jenis_jurusan as jj', 'jj.id_jenis_jurusan = jk.id_jenis_jurusan');
		$this->db->join('tahun_ajaran as ta', 'ta.id_tahun_ajaran = v1.id_tahun_ajaran');
		$this->db->where('v1.status_mapping ', '1');
		$this->db->where('po.id_siswa ', $id);
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_mapping');
	}

	public function searchEvaluasi($data)
	{
		$this->db->select('po.* , g.nama as nama_guru');
		$this->db->from('v7_task as po');
		$this->db->join('user as g', 'g.id_user = po.id_created');
		// $this->db->join('jenis_kelas as jk', 'v1.id_jenis_kelas = jk.id_jenis_kelas');
		// $this->db->join('jenis_jurusan as jj', 'jj.id_jenis_jurusan = jk.id_jenis_jurusan');
		// $this->db->join('tahun_ajaran as ta', 'ta.id_tahun_ajaran = v1.id_tahun_ajaran');
		// $this->db->where('v1.status_mapping ', '1');
		$this->db->where('po.id_siswa ', $data['id_siswa']);
		$this->db->where('po.id_mapping ', $data['id_kelas']);

		$res = $this->db->get();
		return $res->result_array();
	}

	public function getPassingGrade()
	{
		$this->db->from('jenis_jurusan');
		$this->db->join('passing_grade', 'id_jenis_jurusan = id_jurusan', 'left');
		$res = $this->db->get();
		return $res->result_array();
	}




	public function getServerSTMP()
	{

		$tipe = 'stmp_mail';
		$this->db->select("*");
		$this->db->from("config_email as ssk");
		$this->db->where("ssk.type", $tipe);
		$res = $this->db->get();
		$res = $res->result_array();
		// var_dump($res);
		return $res['0'];
	}
	public function getPasingGrade($data)
	{
		$this->db->from('passing_grade');
		$this->db->join('jenis_jurusan', 'id_jenis_jurusan = id_jurusan');
		$res = $this->db->get();

		$res = $res->result_array();
		echo json_encode($res);
	}
}
