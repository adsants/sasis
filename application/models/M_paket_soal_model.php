<?php

class M_paket_soal_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("m_paket_soal.*");							
		$this->db->select("m_mata_pelajaran.nm_mata_pelajaran");							
		if($where){
			$this->db->where($where);
		}		
		$this->db->where('m_paket_soal.id_user_delete', null);
		if($like){
			$this->db->like("m_paket_soal.nm_paket_soal",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}		

		$this->db->join('m_mata_pelajaran', 'm_mata_pelajaran.id_m_mata_pelajaran = m_paket_soal.id_m_mata_pelajaran');		
		return $this->db->get("m_paket_soal",$limit,$fromLimit)->result();
	}
	
	function getData($primaryKey){			
		$this->db->select("m_paket_soal.*");			
		$this->db->select("m_mata_pelajaran.nm_mata_pelajaran");				
		
		$this->db->where("m_paket_soal.id_m_paket_soal",$primaryKey);	
		$this->db->join('m_mata_pelajaran', 'm_mata_pelajaran.id_m_mata_pelajaran = m_paket_soal.id_m_mata_pelajaran');		
		
		return $this->db->get("m_paket_soal")->row();
	}
	function insert($data){
		$this->db->insert('m_paket_soal', $data);
		return $this->db->insert_id();
	}
	function update($primaryKey,$data){
		$this->db->where("id_m_paket_soal",$primaryKey);
		$this->db->update('m_paket_soal', $data);
		return $this->db->affected_rows();
	}
	function delete($primaryKey){
		$this->db->where("id_m_paket_soal",$primaryKey);
		$this->db->delete('m_paket_soal');
		return $this->db->affected_rows();
	}

}

?>
