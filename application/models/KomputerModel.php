<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KomputerModel extends CI_Model
{
	public function getAllKomputer($filter = [])
	{
		$this->db->select('*');
		$this->db->from('komputer as k');
		$this->db->join('labor l', 'k.id_labor = l.id_labor', 'left');
		if (!empty($filter['id_komputer'])) $this->db->where('k.id_komputer', $filter['id_komputer']);
		if (!empty($filter['id_labor'])) $this->db->where('k.id_labor', $filter['id_labor']);

		$res = $this->db->get();
		return DataStructure::keyValue($res->result_array(), 'id_komputer');
	}
	public function searchReady($filter = [])
	{
		$this->db->select('k.*,l.*,p.time_start, p.time_end, p.status');
		$this->db->from('komputer as k');
		$this->db->join('labor l', 'k.id_labor = l.id_labor');
		$this->db->join('peminjaman p', 'k.id_komputer = p.id_komputer', 'left');

		$this->db->where("(
            p.time_start BETWEEN '" . STR_REPLACE('T', ' ', $filter['time_start']) . "' AND '" . STR_REPLACE('T', ' ', $filter['time_end']) . "' OR 
            p.time_end BETWEEN '" . STR_REPLACE('T', ' ', $filter['time_start']) . "' AND '" . STR_REPLACE('T', ' ', $filter['time_end']) . "' OR
            '" . STR_REPLACE('T', ' ', $filter['time_start']) . "' BETWEEN  p.time_start  AND  p.time_end OR
            '" . STR_REPLACE('T', ' ', $filter['time_end']) . "' BETWEEN  p.time_start  AND  p.time_end  
            )");
		$this->db->order_by('k.id_labor');
		$this->db->order_by('k.label_komputer');
		$res = $this->db->get()->result_array();
		$use_komp = [];
		foreach ($res as $r) {
			$use_komp[] = $r['id_komputer'];
		}

		$this->db->select('k.*,l.*');
		$this->db->from('komputer as k');
		$this->db->join('labor l', 'k.id_labor = l.id_labor');
		if (!empty($use_komp)) $this->db->where_not_in('k.id_komputer', $use_komp);
		$this->db->where('k.status = "Y"');
		$this->db->order_by('k.id_labor');
		$this->db->order_by('k.label_komputer');
		$res = $this->db->get()->result_array();
		return $res;
	}


	function addKomputer($data)
	{
		$dataInsert = DataStructure::slice($data, ['id_labor', 'status', 'label_komputer']);
		$this->db->insert('komputer', $dataInsert);
		ExceptionHandler::handleDBError($this->db->error(), "Menambah Komputer", "Komputer");
		return	$this->db->insert_id();
	}


	public function editKomputer($data)
	{
		$this->db->set(DataStructure::slice($data, ['status', 'label_komputer']));
		$this->db->where('id_komputer', $data['id_komputer']);
		$this->db->update('komputer');

		ExceptionHandler::handleDBError($this->db->error(), "Ubah Komputer", "Komputer");
		return $data['id_komputer'];
	}

	public function deleteKomputer($data)
	{
		$this->db->where('id_komputer', $data['id_komputer']);
		$this->db->delete('komputer');

		ExceptionHandler::handleDBError($this->db->error(), "Hapus Komputer", "Komputer");
	}
}
