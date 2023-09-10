<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PublicModel extends CI_Model
{

	public function getPerformLabor()
	{
		$this->db->select("p.id_labor, nama_labor,count(k.id_komputer) jmlh_komputer");
		$this->db->from("labor p");
		$this->db->join("komputer k", 'k.id_labor = p.id_labor');
		$this->db->group_by('p.id_labor');
		$this->db->order_by('p.id_labor');
		$res = $this->db->get();
		$res = $res->result_array();

		$this->db->select("p.id_labor, nama_labor,count(l.id_peminjaman) jmlh_peminjaman");
		// $this->db->select("count(p.id_komputer),k.id_labor, l.nama_labor");
		// $this->db->from("peminjaman p");
		// $this->db->join("komputer k", 'k.id_komputer = p.id_komputer');
		// $this->db->join("labor l", 'k.id_labor = l.id_labor', 'LEFT');
		$this->db->from("labor p");
		$this->db->join("komputer k", 'k.id_labor = p.id_labor');
		$this->db->join("peminjaman l", 'k.id_komputer = l.id_komputer', 'LEFT');
		$this->db->group_by('p.id_labor');
		$this->db->order_by('p.id_labor');
		$res2 = $this->db->get();
		$res2 = $res2->result_array();

		$chart['nama_labor'] = [];
		$chart['komputer'] = [];
		$chart['peminjaman'] = [];
		foreach ($res as $key => $r) {
			// echo json_encode($key);
			// die();
			if ($key == 0) {
				$chart['nama_labor'][] = '';
				$chart['komputer'][] = $res[$key]['jmlh_komputer'];
				$chart['peminjaman'][] = $res2[$key]['jmlh_peminjaman'];
			}
			$chart['nama_labor'][] = $res2[$key]['nama_labor'];
			$chart['komputer'][] = $res[$key]['jmlh_komputer'];
			$chart['peminjaman'][] = $res2[$key]['jmlh_peminjaman'];
		}
		$chart['nama_labor'][] = '';
		$chart['komputer'][] = $res[$key]['jmlh_komputer'];
		$chart['peminjaman'][] = $res2[$key]['jmlh_peminjaman'];
		return $chart;
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
}
