<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ParameterModel extends CI_Model
{


	public function getAllUser($filter = [])
	{
		if (isset($filter['isSimple'])) {
			$this->db->select('u.id_user, u.username, u.photo, u.nama, u.id_role');
		} else {
			$this->db->select("u.*, r.*");
		}
		$this->db->from('user as u');
		$this->db->join('role as r', 'r.id_role = u.id_role');

		if (isset($filter['username'])) $this->db->where('u.username', $filter['username']);
		if (isset($filter['id_user'])) $this->db->where('u.id_user', $filter['id_user']);
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_user');
	}

	public function getAllJurusan($filter = [])
	{
		$this->db->select("*");
		$this->db->from('jurusan as u');

		if (!empty($filter['id_jurusan'])) $this->db->where('u.id_jurusan', $filter['id_jurusan']);
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_jurusan');
	}

	public function addJurusan($data)
	{
		$dataInsert = DataStructure::slice($data, ['nama_jurusan', 'id_jurusan', 'sub_jurusan']);
		$this->db->insert('jurusan', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Insert mapel", "jurusan");
		return $this->db->insert_id();
	}

	public function editJurusan($data)
	{
		$dataInsert = DataStructure::slice($data, ['nama_jurusan', 'id_jurusan', 'sub_jurusan']);
		$this->db->set($dataInsert);
		$this->db->where('id_jurusan', $data['id_jurusan']);
		$this->db->update('jurusan');
		ExceptionHandler::handleDBError($this->db->error(), "Insert mapel", "jurusan");

		return $data['id_jurusan'];
	}


	public function deleteJurusan($data)
	{
		$this->db->where('id_jurusan', $data['id_jurusan']);
		$this->db->delete('jurusan');
		ExceptionHandler::handleDBError($this->db->error(), "Insert mapel", "jurusan");

		return $data['id_jurusan'];
	}

	public function getUser($idUser = NULL)
	{
		$row = $this->getAllUser(['id_user' => $idUser]);
		if (empty($row)) {
			throw new UserException("User yang kamu cari tidak ditemukan", USER_NOT_FOUND_CODE);
		}
		return $row[$idUser];
	}

	public function editPhoto($idUser, $newPhoto)
	{
		$this->db->set('photo', $newPhoto);
		$this->db->where('id_user', $idUser);
		$this->db->update('user');
		return $newPhoto;
	}

	public function getUserByUsername($username = NULL)
	{
		$row = $this->getAllUser(['username' => $username]);
		if (empty($row)) {
			throw new UserException("User yang kamu cari tidak ditemukan", USER_NOT_FOUND_CODE);
		}
		return array_values($row)[0];
	}
}
