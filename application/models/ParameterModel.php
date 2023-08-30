<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ParameterModel extends CI_Model
{


	public function calculateScore($data, $soal, $answer)
	{

		$query = 'SELECT sum(poin) as score from bank_soal  left join bank_opsi on bank_soal.id_bank_soal = bank_opsi.id_bank_soal 
			where 
			 bank_soal.id_bank_soal in (' . $soal . ') and bank_opsi.token_opsi in (' . $answer . ') ';
		$res = $this->db->query($query);
		$res = $res->result_array();

		$query2 = 'SELECT count(*) as benar from bank_soal  left join bank_opsi on bank_soal.id_bank_soal = bank_opsi.id_bank_soal 
			where bank_opsi.status = "Y" 
			and bank_soal.id_bank_soal in (' . $soal . ') and bank_opsi.token_opsi in (' . $answer . ') ';
		$res2 = $this->db->query($query2);
		$res2 = $res2->result_array();



		$benar = $res2[0]['benar'];
		$score = $res[0]['score'];
		if ($data['id_mapel'] == '1') {
			$bindoquery = 'SELECT sum(poin) as score from bank_soal  left join bank_opsi on bank_soal.id_bank_soal = bank_opsi.id_bank_soal 
				where id_mapel = 2 and
				 bank_soal.id_bank_soal in (' . $soal . ') and bank_opsi.token_opsi in (' . $answer . ') ';
			$bindo = $this->db->query($bindoquery);
			$bindo = $bindo->result_array();

			$bingquery = 'SELECT sum(poin) as score from bank_soal  left join bank_opsi on bank_soal.id_bank_soal = bank_opsi.id_bank_soal 
				where id_mapel = 3 and
				 bank_soal.id_bank_soal in (' . $soal . ') and bank_opsi.token_opsi in (' . $answer . ') ';
			$bing = $this->db->query($bingquery);
			$bing = $bing->result_array();

			$fisikaquery = 'SELECT sum(poin) as score from bank_soal  left join bank_opsi on bank_soal.id_bank_soal = bank_opsi.id_bank_soal 
				where id_mapel = 5 and
				 bank_soal.id_bank_soal in (' . $soal . ') and bank_opsi.token_opsi in (' . $answer . ') ';
			$fisika = $this->db->query($fisikaquery);
			$fisika = $fisika->result_array();

			$mtkquery = 'SELECT sum(poin) as score from bank_soal  left join bank_opsi on bank_soal.id_bank_soal = bank_opsi.id_bank_soal 
				where id_mapel = 6 and
				 bank_soal.id_bank_soal in (' . $soal . ') and bank_opsi.token_opsi in (' . $answer . ') ';
			$mtk = $this->db->query($mtkquery);
			$mtk = $mtk->result_array();

			$score_arr = ((string)$mtk[0]['score'] ? (string)$mtk[0]['score'] : 0) . ',' . ((string)$fisika[0]['score'] ? (string)$fisika[0]['score'] : 0) .
				',' . ((string)$bindo[0]['score'] ? (string)$bindo[0]['score'] : 0.) . ',' . ((string)$bing[0]['score'] ? (string)$bing[0]['score'] : 0.);
			$this->db->set('score_arr', $score_arr);
		}
		// $ans = explode(',', $data['answer']);

		// $count = count($ans);
		// $score = $benar / $count * 100;
		// 1Teknik Mesin
		// 2Teknik Elektro
		// 3Perancangan Teknik Mesin
		// 4Teknik Informatika
		$rek = null;
		// if ($mtk[0]['score'] > $fisika[0]['score']) {
		// 	if ($bing[0]['score'] > $bindo[0]['score']) {
		// 		$rek = 4;
		// 	} else {
		// 		$rek = 2;
		// 	}
		// } else if ($mtk[0]['score'] < $fisika[0]['score']) {
		// 	if ($bing[0]['score'] > $bindo[0]['score']) {
		// 		$rek = 3;
		// 	} else {
		// 		$rek = 1;
		// 	}
		// } else {
		// }

		// echo $mtk[0]['score'] . ',' . $fisika[0]['score'] . ',' . $bing[0]['score'] . ',' . $bindo[0]['score'];
		$pg = $this->getPassingGrade();
		// echo json_encode($data);
		if ($mtk[0]['score'] >= $pg[$data['req_jurusan']]['mtk'] && $fisika[0]['score'] >= $pg[$data['req_jurusan']]['fisika'] && $bing[0]['score'] >= $pg[$data['req_jurusan']]['bing'] && $bindo[0]['score'] >= $pg[$data['req_jurusan']]['bind']) {
			$rek = $data['req_jurusan'];
			// echo 'lulus pilihan 1';
		} else if ($mtk[0]['score'] >= $pg[$data['req_jurusan_2']]['mtk'] && $fisika[0]['score'] >= $pg[$data['req_jurusan_2']]['fisika'] && $bing[0]['score'] >= $pg[$data['req_jurusan_2']]['bing'] && $bindo[0]['score'] >= $pg[$data['req_jurusan_2']]['bind']) {
			$rek = $data['req_jurusan_2'];
		} else {
			// echo 'tidak lulus';
		}
		// die();
		if (!empty($rek))
			$this->db->set('req_exam', $rek);
		$this->db->set('score', $score);
		$this->db->set('benar', $benar);
		$this->db->set('exam_lock', 'Y');
		$this->db->where('token', $data['token']);
		$this->db->update('session_exam_user');
	}

	public function getPassingGrade()
	{
		$this->db->from('jenis_jurusan');
		$this->db->join('passing_grade', 'id_jenis_jurusan = id_jurusan', 'left');
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_jenis_jurusan');
	}

	public function getYourHistory($filter = [])
	{
		$this->db->select("u.* ,r.*");
		$this->db->from('session_exam_user as u');
		$this->db->join('session_exam as r', 'r.id_session_exam = u.id_session_exam');
		// $this->db->join('kabupaten as k', 'k.id_kabupaten = u.id_kabupaten','left');

		if (!empty($filter['id_session_exam_user'])) $this->db->where('u.id_session_exam_user', $filter['id_session_exam_user']);
		if (!empty($filter['token'])) $this->db->where('u.token', $filter['token']);
		if (!empty($filter['id_user'])) $this->db->where('u.id_user', $filter['id_user']);
		if (!empty($filter['ip_address'])) $this->db->where('u.ip_address', $filter['ip_address']);
		$res = $this->db->get();
		if (!empty($filter['token'])) {
			return DataStructure::keyValue($res->result_array(), 'token');
		}
		return DataStructure::keyValue($res->result_array(), 'id_session_exam_user');
	}

	public function getExam($filter)
	{
		$this->db->select("u.* ,(limit_time + 1 ) as limit_time, poin_mode, r.id_mapel, open_start");
		$this->db->from('session_exam_user as u');
		$this->db->join('session_exam as r', 'r.id_session_exam = u.id_session_exam');
		// $this->db->join('kabupaten as k', 'k.id_kabupaten = u.id_kabupaten','left');

		if (!empty($filter['id_session_exam_user'])) $this->db->where('u.id_session_exam_user', $filter['id_session_exam_user']);
		if (!empty($filter['token'])) $this->db->where('u.token', $filter['token']);
		if (!empty($filter['id_user'])) $this->db->where('u.id_user', $filter['id_user']);
		// if (!empty($filter['ip_address'])) $this->db->where('u.ip_address', $filter['ip_address']);
		$res = $this->db->get();
		if (!empty($filter['token'])) {
			return DataStructure::keyValue($res->result_array(), 'token');
		}
		return DataStructure::keyValue($res->result_array(), 'id_session_exam_user');
	}

	public function startExam($filter)
	{

		$this->db->set('start_time', $filter['start_time']);

		$this->db->where('id_session_exam_user', $filter['id_session_exam_user']);
		$this->db->where('token', $filter['token']);
		$this->db->where('id_user', $filter['id_user']);
		$this->db->update('session_exam_user');
		// if (!empty($filter['ip_address'])) $this->db->where('u.ip_address', $filter['ip_address']);
		// $res = $this->db->get();
		// if (!empty($filter['token'])) {
		// 	return DataStructure::keyValue($res->result_array(), 'token');
		// }
		// return DataStructure::keyValue($res->result_array(), 'id_session_exam_user');
	}

	public function getAllUser($filter = [])
	{
		if (isset($filter['isSimple'])) {
			$this->db->select('u.id_user, u.username, u.photo, u.nama, u.id_role');
		} else {
			$this->db->select("u.*, r.*");
		}
		$this->db->from('user as u');
		$this->db->join('role as r', 'r.id_role = u.id_role');
		// $this->db->join('kabupaten as k', 'k.id_kabupaten = u.id_kabupaten','left');

		if (isset($filter['username'])) $this->db->where('u.username', $filter['username']);
		if (isset($filter['id_user'])) $this->db->where('u.id_user', $filter['id_user']);
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_user');
	}


	public function getAllBankSoal($filter = [])
	{
		if (!empty($filter['full']))
			$this->db->select("*");
		else {
			$this->db->select("*");
		}
		$this->db->from('bank_soal as u');
		$this->db->join('mapel as r', 'r.id_mapel = u.id_mapel');
		$this->db->join('bank_opsi as k', 'k.id_bank_soal = u.id_bank_soal', 'left');
		$this->db->where('k.status', 'Y');
		if (!empty($filter['id_bank_soal'])) $this->db->where('u.id_bank_soal', $filter['id_bank_soal']);
		if (!empty($filter['id_mapel'])) $this->db->where('u.id_mapel', $filter['id_mapel']);
		if (!empty($filter['limit'])) $this->db->limit($filter['limit']);
		if (!empty($filter['order_random'])) $this->db->order_by('rand()');
		$res = $this->db->get();
		if (!empty($filter['result_array'])) {
			return $res->result_array();
		}
		return DataStructure::keyValue($res->result_array(), 'id_bank_soal');
	}

	public function getShuffleSoal($id, $jawabn = false)
	{
		// if (!empty($filter['full']))
		$this->db->select("u.soal, u.image");
		$this->db->from('bank_soal as u');
		if ($jawabn) {
			$this->db->select("token_opsi,name_opsi,pembahasan,pembahasan_img");
			$this->db->join('bank_opsi as k', 'k.id_bank_soal = u.id_bank_soal', 'left');
			$this->db->where('k.status', 'Y');
		}
		// else {
		// 	$this->db->select("*");
		// }
		// $this->db->join('mapel as r', 'r.id_mapel = u.id_mapel');
		$this->db->where('u.id_bank_soal', $id);

		$res = $this->db->get();
		// if (!empty($filter['result_array'])) {
		$data['soal'] = $res->result_array()[0];

		$this->db->select("name_opsi,token_opsi");
		$this->db->from('bank_opsi as s');
		$this->db->where('s.id_bank_soal', $id);

		$res = $this->db->get();
		// if (!empty($filter['result_array'])) {
		$data['opsi'] = $res->result_array();
		if ($jawabn) {
		} else {
			shuffle($data['opsi']);
		}
		return $data;
		// }
		// return DataStructure::keyValue($res->result_array(), 'id_bank_soal');
	}


	public function getAllSession($filter = [])
	{
		$this->db->select("*");
		if (!empty($filter['full'])) {
		} else {
		}
		$this->db->from('session_exam as u');
		$this->db->join('mapel as r', 'r.id_mapel = u.id_mapel');
		// $this->db->join('bank_opsi as k', 'k.id_bank_soal = u.id_bank_soal', 'left');
		// $this->db->where('k.status', 'Y');
		// if (!empty($filter['id_bank_soal'])) $this->db->where('u.id_bank_soal', $filter['id_bank_soal']);
		if (!empty($filter['id_mapel'])) $this->db->where('u.id_mapel', $filter['id_mapel']);
		if (!empty($filter['id_session_exam'])) $this->db->where('u.id_session_exam', $filter['id_session_exam']);
		// if (isset($filter['id_user'])) $this->db->where('u.id_user', $filter['id_user']);
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_session_exam');
	}

	public function getAvaliableSession($filter = [])
	{
		$cur_date = date('Y-m-d H:i:s');
		// echo $cur_date;
		// die();
		$this->db->select("u.open_end >= '" . $cur_date . "' as x ,j.nama_jenis_jurusan,exam_lock ,u.*,r.*, k.id_session_exam_user,k.token,k.id_user,k.score, k.score_arr,req_exam");
		$this->db->from('session_exam as u');
		$this->db->join('mapel as r', 'r.id_mapel = u.id_mapel');
		$this->db->join('session_exam_user as k', " (k.id_session_exam = u.id_session_exam and k.id_user = '" . $this->session->userdata('id_user') . "') OR id_session_exam_user is NULL  AND u.open_end >= '" . $cur_date . "' ", 'left');
		$this->db->join('jenis_jurusan as j', 'j.id_jenis_jurusan = k.req_exam', 'left');
		// $this->db->join('user as us', 'us.id_user = k.id_user', 'right');
		$this->db->where('( k.id_session_exam is null or k.id_user = "' . $this->session->userdata('id_user') . '" )');
		// $this->db->where('us.id_user = "null" or us.id_user = "' . $this->session->userdata('id_user') . '"');
		// if (!empty($filter['start_exam']))
		// $this->db->where('u.open_start <= "' . $cur_date . '"');
		$this->db->where('open_end >= "' . $cur_date . '"');
		$this->db->or_where('k.score is not null');

		if (!empty($filter['id_mapel'])) $this->db->where('u.id_mapel', $filter['id_mapel']);
		if (!empty($filter['id_session_exam'])) $this->db->where('u.id_session_exam', $filter['id_session_exam']);
		// if (isset($filter['id_user'])) $this->db->where('u.id_user', $filter['id_user']);
		$res = $this->db->get();
		// echo
		// $this->db->last_query();
		// die();
		return DataStructure::keyValue($res->result_array(), 'id_session_exam');
	}


	public function getOpsi($filter = [])
	{
		if (!empty($filter['full']))
			$this->db->select("*");
		else {
		}
		$this->db->from('bank_opsi as u');
		// $this->db->join('mapel as r', 'r.id_mapel = u.id_mapel');
		// $this->db->join('kabupaten as k', 'k.id_kabupaten = u.id_kabupaten','left');

		// if (isset($filter['username'])) $this->db->where('u.username', $filter['username']);
		if (!empty($filter['id_bank_soal'])) $this->db->where('u.id_bank_soal', $filter['id_bank_soal']);
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_opsi');
	}


	public function getAllTahunAjaran($filter = [])
	{
		// if(isset($filter['isSimple'])){
		//     $this->db->select('u.id_user, u.username, u.photo, u.nama, u.id_role');
		// } else {
		// }
		$this->db->select("u.*");
		$this->db->from('tahun_ajaran as u');
		// $this->db->join('role as r', 'r.id_role = u.id_role');
		// $this->db->join('kabupaten as k', 'k.id_kabupaten = u.id_kabupaten','left');

		// if(isset($filter['username'])) $this->db->where('u.username', $filter['username']);
		if (!empty($filter['id_tahun_ajaran'])) $this->db->where('u.id_tahun_ajaran', $filter['id_tahun_ajaran']);
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_tahun_ajaran');
	}




	public function getAllMapel($filter = [])
	{
		$this->db->select("u.*");
		$this->db->from('mapel as u');
		// $this->db->join('role as r', 'r.id_role = u.id_role');
		// $this->db->join('kabupaten as k', 'k.id_kabupaten = u.id_kabupaten','left');
		$this->db->where('u.status', 1);
		if (!empty($filter['id_mapel'])) $this->db->where('u.id_mapel', $filter['id_mapel']);
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_mapel');
	}

	public function getAllJurusan($filter = [])
	{
		$this->db->select("*");
		$this->db->from('jenis_jurusan as u');

		if (!empty($filter['id_jenis_jurusan'])) $this->db->where('u.id_jenis_jurusan', $filter['id_jenis_jurusan']);
		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_jenis_jurusan');
	}


	public function addMapel($data)
	{
		$dataInsert = DataStructure::slice($data, ['nama_mapel', 'status']);
		$this->db->insert('mapel', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Insert mapel", "mapel");
		return $this->db->insert_id();
	}

	public function editMapel($data)
	{
		$dataInsert = DataStructure::slice($data, ['nama_mapel', 'status']);
		$this->db->set($dataInsert);
		$this->db->where('id_mapel', $data['id_mapel']);
		$this->db->update('mapel');
		ExceptionHandler::handleDBError($this->db->error(), "Insert mapel", "mapel");

		return $data['id_mapel'];
	}


	public function deleteMapel($data)
	{
		$this->db->where('id_mapel', $data['id_mapel']);
		$this->db->delete('mapel');
		ExceptionHandler::handleDBError($this->db->error(), "Insert mapel", "mapel");

		return $data['id_mapel'];
	}

	public function addKelas($data)
	{
		$dataInsert = DataStructure::slice($data, ['nama_jenis_kelas', 'id_jenis_jurusan', 'sub_kelas']);
		$this->db->insert('jenis_kelas', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Insert mapel", "jenis_kelas");
		return $this->db->insert_id();
	}

	public function editKelas($data)
	{
		$dataInsert = DataStructure::slice($data, ['nama_jenis_kelas', 'id_jenis_jurusan', 'sub_kelas']);
		$this->db->set($dataInsert);
		$this->db->where('id_jenis_kelas', $data['id_jenis_kelas']);
		$this->db->update('jenis_kelas');
		ExceptionHandler::handleDBError($this->db->error(), "Insert mapel", "jenis_kelas");

		return $data['id_jenis_kelas'];
	}


	public function deleteKelas($data)
	{
		$this->db->where('id_jenis_kelas', $data['id_jenis_kelas']);
		$this->db->delete('jenis_kelas');
		ExceptionHandler::handleDBError($this->db->error(), "Insert mapel", "jenis_kelas");

		return $data['id_jenis_kelas'];
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

	public function addTA($data)
	{
		$dataInsert = DataStructure::slice($data, ['deskripsi', 'semester', 'start', 'end']);
		$this->db->insert('tahun_ajaran', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Add Tahun Ajaran", "tahun_ajaran");
		return $this->db->insert_id();
	}

	public function SubmitExam($data)
	{
		if ($data['autosave'] == 'false') {
			$this->db->set('exam_lock', 'Y');
		}
		if (!empty($this->session->userdata()['id_user']))
			$this->db->where('id_user', $this->session->userdata('id_user'));
		else
			$this->db->where('ip_address', $this->input->ip_address());

		$this->db->set('answer', $data['answer']);
		$this->db->where('token', $data['token']);
		$this->db->update('session_exam_user');
		ExceptionHandler::handleDBError($this->db->error(), "Save Session", "save_session");
	}

	public function createExam($data)
	{
		if (!empty($this->session->userdata()['id_user']))
			$data['id_user'] = $this->session->userdata()['id_user'];
		else
			$data['ip_address'] =  $this->input->ip_address();
		$data['token'] = bin2hex(openssl_random_pseudo_bytes(32));
		$data['start_time'] = 'null';
		$dataInsert = DataStructure::slice($data, ['id_session_exam', 'id_user', 'generate_soal', 'token', 'ip_address', 'req_jurusan', 'req_jurusan_2']);
		$this->db->insert('session_exam_user', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Create Session", "create_session");
		return $this->db->insert_id();
	}

	public function editTA($data)
	{
		$dataInsert = DataStructure::slice($data, ['deskripsi', 'semester', 'start', 'end']);
		$this->db->set($dataInsert);
		$this->db->where('id_tahun_ajaran', $data['id_tahun_ajaran']);
		$this->db->update('tahun_ajaran');
		ExceptionHandler::handleDBError($this->db->error(), "Update Tahun Ajaran", "jenis_kelas");

		return $data['id_tahun_ajaran'];
	}

	public function set_current_ta($data)
	{
		// $dataInsert = DataStructure::slice($data, ['deskripsi', 'semester', 'start' , 'end']);
		$this->db->set("current", "1");
		$this->db->where('current', "2");
		$this->db->update('tahun_ajaran');
		ExceptionHandler::handleDBError($this->db->error(), "Update Tahun Ajaran", "jenis_kelas");

		$this->db->set("current", "2");
		$this->db->where('id_tahun_ajaran', $data['id_tahun_ajaran']);
		$this->db->update('tahun_ajaran');
		ExceptionHandler::handleDBError($this->db->error(), "Update Tahun Ajaran", "jenis_kelas");


		return $data['id_tahun_ajaran'];
	}


	public function deleteTA($data)
	{
		$this->db->where('id_tahun_ajaran', $data['id_tahun_ajaran']);
		$this->db->delete('tahun_ajaran');
		ExceptionHandler::handleDBError($this->db->error(), "Delete Tahun Ajaran", "tahun_ajaran");

		return $data['id_tahun_ajaran'];
	}
}
