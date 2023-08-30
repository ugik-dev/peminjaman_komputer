<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelolahmapelModel extends CI_Model
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


		if (!empty($filter['id_user'])) $this->db->where('po.id_user', $filter['id_user']);
		if (!empty($filter['id_role'])) $this->db->where('po.id_role', $filter['id_role']);

		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_user');
	}

	public function cekSiswa($filter = [])
	{
		$this->db->select('*');
		$this->db->from('mapping_siswa as po');
		// $this->db->join("role as pjo", "po.id_role = pjo.id_role",'left');
		// $this->db->join("kabupaten as kab", "kab.id_kabupaten = po.id_kabupaten",'left');


		$this->db->where('po.id_siswa', $filter['id_siswa']);
		$this->db->where('po.id_mapping', $filter['id_mapping']);

		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_siswa');
	}


	public function getKelolahuser($iduser = NULL)
	{
		$row = $this->getAllKelolahuser(['id_user' => $iduser]);
		if (empty($row)) {
			throw new UserException("Kelolahuser yang kamu cari tidak ditemukan", USER_NOT_FOUND_CODE);
		}
		return $row[$iduser];
	}

	public function create_kelas($data)
	{
		$dataInsert = DataStructure::slice($data, ['id_tahun_ajaran', 'id_jenis_kelas']);
		$this->db->insert('mapping', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Membuat Kelas", "mapping");
		return $this->db->insert_id();
	}

	public function nonactive_kelas($data)
	{
		$data['status_mapping'] = '2';
		$this->db->set(DataStructure::slice($data, ['status_mapping']));
		$this->db->where('id_mapping', $data['id_mapping']);
		$this->db->update('mapping');

		ExceptionHandler::handleDBError($this->db->error(), "Nonactive Mapping", "mapping");
		return $data['id_mapping'];
	}

	public function active_kelas($data)
	{
		$data['status_mapping'] = '1';
		$this->db->set(DataStructure::slice($data, ['status_mapping']));
		$this->db->where('id_mapping', $data['id_mapping']);
		$this->db->update('mapping');

		ExceptionHandler::handleDBError($this->db->error(), "Active Mapping", "mapping");
		return $data['id_mapping'];
	}

	public function saveMapping($data)
	{
		// $data['status_mapping'] = '1';
		$this->db->set(DataStructure::slice($data, ['id_wali_kelas']));
		$this->db->where('id_mapping', $data['id_mapping']);
		$this->db->update('mapping');

		ExceptionHandler::handleDBError($this->db->error(), "Active Mapping", "mapping");
		// return $data['id_mapping'];
		for ($i = 0; $i < $data['jumlah_mapel']; $i++) {
			// $tmp['guru'] = $data['guru_mapel_'.$i] ;
			if (!empty($data['guru_mapel_' . $i])) {
				$tmpxx = explode(" -- ", $data['guru_mapel_' . $i]);
				if (!empty($tmpxx[2])) {
					$tmp['id_tenaga_kerja'] = $tmpxx[2];
				}
				else{
					$tmp['id_tenaga_kerja'] = $data['id_guru_' . $i];
				}
			}
			else{
				$tmp['id_tenaga_kerja'] = $data['id_guru_' . $i];
			}
			if ($data['id_mapping_kelas_' . $i] == 'new') {
				// echo 'kelas baru';
				// $tmp['id_tenaga_kerja'] = $data['id_guru_' . $i];
				$tmp['id_mapping'] = $data['id_mapping'];
				$tmp['guru'] = $data['guru_mapel_' . $i];

				$tmp['id_mapel'] = $data['mapping_kelas_mapel_' . $i];
				$this->addMapping($tmp);
			} else {
				// echo 'kelas lama';
				// $tmp['id_tenaga_kerja'] = $data['id_guru_' . $i];
				$tmp['guru'] = $data['guru_mapel_' . $i];
				// $tmp['id_mapping'] = $data['id_mapping'];
				// $tmp['id_mapel'] = $data['mapping_kelas_mapel_'.$i] ;
				$tmp['id_mapping_kelas'] = $data['id_mapping_kelas_' . $i];
				$this->updateMappingKelas($tmp);
			}
		}
	}

	function updateMappingKelas($data)
	{
		$this->db->set(DataStructure::slice($data, ['id_tenaga_kerja']));
		$this->db->where('id_mapping_kelas', $data['id_mapping_kelas']);
		$this->db->update('mapping_kelas');

		ExceptionHandler::handleDBError($this->db->error(), "Active Mapping", "mapping_kelas");
		// return $data['id_mapping_kelas'];
	}

	function addMapping($data)
	{

		// var_dump($data);    
		$dataInsert = DataStructure::slice($data, ['id_tenaga_kerja', 'id_mapping', 'id_mapel']);
		$this->db->insert('mapping_kelas', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Membuat Kelas", "mapping_kelas");
		$this->db->insert_id();
	}

	function add_siswa($data)
	{
		// var_dump($data);   
		$cek = $this->cekSiswa($data);
		if (!empty($cek)) throw new UserException('Siswa sudah ada dikelas ini.', 0);
		$dataInsert = DataStructure::slice($data, ['id_siswa', 'id_mapping']);
		$this->db->insert('mapping_siswa', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Menambah Siswa", "mapping_siswa");
		$this->db->insert_id();
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

	public function delete_mapping_siswa($data)
	{
		$this->db->where('id_mapping_siswa', $data['id_mapping_siswa']);
		$this->db->delete('mapping_siswa');

		ExceptionHandler::handleDBError($this->db->error(), "Hapus Mapping Siswa", "mapping_siswa");
	}
}
