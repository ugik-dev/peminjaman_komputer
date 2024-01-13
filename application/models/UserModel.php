<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

	public function verifToken($data)
	{
		$this->db->from('user_reset ur');
		$this->db->join('user u', 'u.id_user = ur.id_user');
		$this->db->where('id_reset', $data['id_reset']);
		$this->db->where('token', $data['token']);

		return $this->db->get()->result_array();
	}
	public function getAllUser($filter = [], $key = true)
	{
		$this->db->select("u.*, r.*,j.*,l.*");
		$this->db->from('user as u');
		$this->db->join('role as r', 'r.id_role = u.id_role');
		$this->db->join('jurusan as j', 'j.id_jurusan = u.id_jurusan', 'LEFT');
		$this->db->join("labor as l", "l.id_labor = u.id_lab", 'left');


		if (isset($filter['username'])) $this->db->where('u.username', $filter['username']);
		if (isset($filter['ex_role'])) $this->db->where_not('u.id_role', $filter['ex_role']);
		if (isset($filter['id_user'])) $this->db->where('u.id_user', $filter['id_user']);
		if (isset($filter['id_lab'])) $this->db->where('u.id_lab', $filter['id_lab']);
		$res = $this->db->get();
		if ($key)
			return DataStructure::keyValue($res->result_array(), 'id_user');
		else
			return $res->result_array();
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

	public function changePassword($data)
	{
		$this->db->set('password', md5($data['password']));
		$this->db->where('id_user', $data['id_user']);
		$this->db->update('user');
		return 'succes';
	}
	public function editUser($tmpdata)
	{
		$data = array(
			'username' => $tmpdata['username'],
			'nama' => $tmpdata['nama'],
		);

		$this->db->set($data);
		$this->db->where('id_user', $tmpdata['id_user']);
		$this->db->update('user');

		return $tmpdata;
	}

	public function resetPass($tmpdata)
	{
		$data = array(
			'password' => md5($tmpdata['password']),
		);

		$this->db->set($data);
		$this->db->where('id_user', $tmpdata['id_user']);
		$this->db->update('user');

		return $tmpdata;
	}


	public function getUserByUsername($username = NULL)
	{
		$row = $this->getAllUser(['username' => $username]);
		if (empty($row)) {
			throw new UserException("User yang kamu cari tidak ditemukan", USER_NOT_FOUND_CODE);
		}
		return array_values($row)[0];
	}

	public function login($loginData)
	{

		$user = $this->getUserByUsername($loginData['username']);
		if (md5($loginData['password']) !== $user['password'])
			throw new UserException("Password yang kamu masukkan salah.", WRONG_PASSWORD_CODE);
		return $user;
	}

	public function resetPassword($data)
	{
		$permitted_activtor = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$data_s['token'] =  substr(str_shuffle($permitted_activtor), 0, 20);
		$data_s['id_user'] = $data['id_user'];
		$this->db->insert('user_reset', DataStructure::slice(
			$data_s,
			[
				'token', 'id_user', 'password',
			],
			TRUE
		));
		ExceptionHandler::handleDBError($this->db->error(), "Reset Password", "Reset Password");

		$data_s['id_reset']  = $this->db->insert_id();

		return $data_s;
	}

	public function registerUser($data)
	{
		$this->cekUserByUsername($data['username']);
		$this->cekUserByEmail($data);
		$data['password'] = md5($data['password']);
		$data['id_role'] = 4;
		$data['status_reg'] = 0;
		$permitted_activtor = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$data['activator'] =  substr(str_shuffle($permitted_activtor), 0, 20);
		$this->db->insert('user_register', DataStructure::slice(
			$data,
			[
				'username', 'nama', 'password',   'email', 'alamat', 'phone', 'id_jurusan', 'alamat', 'tahun_masuk', 'status_reg', 'activator'
			],
			TRUE
		));
		ExceptionHandler::handleDBError($this->db->error(), "Register", "Register");

		$data['id']  = $this->db->insert_id();

		return $data;
	}

	public function cekUserByUsername($username = NULL, $restrict = false)
	{
		$row = $this->getAllUser(['username' => $username, 'is_login' => TRUE]);
		if (!empty($row)) {
			if (!$restrict)
				throw new UserException("User yang kamu daftarkan sudah ada", USER_NOT_FOUND_CODE);
			redirect('login?activator=NIM kamu sudah diaktifkan sebelumnya');
		}
	}

	public function cekUserByEmail($data, $restrict = false)
	{
		$this->db->select("email");
		$this->db->from('user as u');
		$this->db->where('u.email', $data['email']);
		$res = $this->db->get();
		$row = $res->result_array();
		if (!empty($row)) {
			if (!$restrict)
				throw new UserException("Email yang kamu daftarkan sudah ada", USER_NOT_FOUND_CODE);
			else
				redirect('login?activator=Email kamu sudah diaktifkan sebelumnya');
		}
	}

	public function activatorUser($data)
	{
		$this->db->select("*");
		$this->db->from('user_register as u');
		$this->db->where("u.id ", $data['id']);
		$this->db->where("u.activator ", $data['activator']);
		$res = $this->db->get();
		$res = $res->result_array();
		if (empty($res)) {
			redirect('login?activator=Data tidak ditemukan atau email anda sudah diaktifkan sebelumnya');
			return;
		} else {
			$this->cekUserByEmail($res[0], true);
			$this->cekUserByUsername($res[0]['username'], true);

			$res[0]['id_role'] = '4';
			$res[0]['password'] = $res[0]['password'];
			$res[0]['id_user'] = $this->addUser($res[0], true);
			return $res[0];
		};
	}

	public function addUser($data, $hasencrpy = false)
	{
		if (!$hasencrpy) {
			$data['password'] =  md5($data['password']);
		}
		$data['status_data'] = 0;
		$dataInsert = DataStructure::slice($data, [
			'username', 'nama', 'password',   'email', 'alamat', 'phone', 'id_jurusan', 'alamat',
			'tahun_masuk', 'status_data',
			'id_role'
		]);
		$this->db->insert('user', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Insert Kelolahuser", "user");
		return $this->db->insert_id();
	}
}
