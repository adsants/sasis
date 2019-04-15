<?php

class T_paket_soal_ujian_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("t_paket_soal_ujian.*");			
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like("t_paket_soal_ujian.nt_paket_soal_ujian",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		return $this->db->get("t_paket_soal_ujian",$limit,$fromLimit)->result();
	}
	
	function getData($where){			
		$this->db->select("t_paket_soal_ujian.*");		
		if($where){
			$this->db->where($where);
		}
		return $this->db->get("t_paket_soal_ujian")->row();
	}
	function insert($data){
		$this->db->insert('t_paket_soal_ujian', $data);
		return $this->db->insert_id();
	}
	function update($primaryKey,$data){
		$this->db->where("id_t_paket_soal_ujian",$primaryKey);
		$this->db->update('t_paket_soal_ujian', $data);
		return $this->db->affected_rows();
	}
	function delete($where){
		if($where){
			$this->db->where($where);
		}
		$this->db->delete('t_paket_soal_ujian');
		return $this->db->affected_rows();
	}

}

?>
