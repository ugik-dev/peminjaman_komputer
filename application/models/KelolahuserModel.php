<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelolahuserModel extends CI_Model
{



	public function getAllRoleOption($filter = [])
	{
		$this->db->select('id_role,nama_role,title_role');
		$this->db->from('role as ko');

		$res = $this->db->get();

		return DataStructure::keyValue($res->result_array(), 'id_role');
	}

	public function getAllKelolahuser($filter = [])
	{
		$this->db->select('*');
		$this->db->from('user as po');
		$this->db->join("role as pjo", "po.id_role = pjo.id_role", 'left');
		// $this->db->join("kabupaten as kab", "kab.id_kabupaten = po.id_kabupaten",'left');

		if (!empty($filter['search'])) $this->db->where('po.username LIKE "%' . $filter['search'] . '%" or po.nama LIKE "%' . $filter['search'] . '%"');
		if (!empty($filter['ex_adm'])) $this->db->where('po.id_role != "3"');
		if (!empty($filter['ex_role'])) $this->db->where('po.id_role != "4"');

		if (!empty($filter['status_data'])) $this->db->where('pjo.status_data', $filter['status_data']);
		if (!empty($filter['id_user'])) $this->db->where('po.id_user', $filter['id_user']);
		if (!empty($filter['id_role'])) $this->db->where('po.id_role', $filter['id_role']);

		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_user');
	}

	public function getAllKelolahUserPendaftaran($filter = [])
	{
		$this->db->select('*');
		$this->db->from('user as po');
		$this->db->join("jurusan as pjo", "po.id_jurusan = pjo.id_jurusan", 'left');
		// $this->db->join("kabupaten as kab", "kab.id_kabupaten = po.id_kabupaten",'left');

		if (!empty($filter['search'])) $this->db->where('(po.username LIKE "%' . $filter['search'] . '%" or po.nama LIKE "%' . $filter['search'] . '%")');
		if (!empty($filter['id_user'])) $this->db->where('po.id_user', $filter['id_user']);
		$this->db->where('po.id_role', 4);

		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_user');
	}
	public function getKelolahuser($iduser = NULL)
	{
		$row = $this->getAllKelolahuser(['id_user' => $iduser]);
		if (empty($row)) {
			throw new UserException("Kelolahuser yang kamu cari tidak ditemukan", USER_NOT_FOUND_CODE);
		}
		return $row[$iduser];
	}

	public function addKelolahuser($data)
	{
		$data['password'] =  md5($data['password']);
		$dataInsert = DataStructure::slice($data, ['password', 'username', 'nama', 'id_role', 'tahun_masuk']);
		$this->db->insert('user', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Insert Kelolahuser", "user");
		return $this->db->insert_id();
	}

	public function editKelolahuser($data)
	{
		$this->db->set(DataStructure::slice($data, ['username', 'nama', 'id_role', 'tahun_masuk']));
		$this->db->where('id_user', $data['id_user']);
		$this->db->update('user');

		ExceptionHandler::handleDBError($this->db->error(), "Ubah User", "user");
		return $data['id_user'];
	}
	public function editPassword($data)
	{
		$data['password'] =  md5($data['password']);
		$this->db->set(DataStructure::slice($data, ['password']));
		$this->db->where('id_user', $data['id_user']);
		$this->db->update('user');

		ExceptionHandler::handleDBError($this->db->error(), "Ubah User", "user");
		return $data['id_user'];
	}

	public function deleteKelolahuser($data)
	{
		$this->db->where('id_user', $data['id_user']);
		$this->db->delete('user');

		ExceptionHandler::handleDBError($this->db->error(), "Hapus Kelolahuser", "desawisata");
	}
}
