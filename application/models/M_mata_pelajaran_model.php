<?php

class M_mata_pelajaran_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("m_mata_pelajaran.*");							
		if($where){
			$this->db->where($where);
		}		
		$this->db->where('m_mata_pelajaran.id_user_delete', null);
		if($like){
			$this->db->like("m_mata_pelajaran.nm_mata_pelajaran",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		return $this->db->get("m_mata_pelajaran",$limit,$fromLimit)->result();
	}
	
	function getData($primaryKey){			
		$this->db->select("m_mata_pelajaran.*");					
		
		$this->db->where("m_mata_pelajaran.id_m_mata_pelajaran",$primaryKey);	
		
		return $this->db->get("m_mata_pelajaran")->row();
	}
	function insert($data){
		$this->db->insert('m_mata_pelajaran', $data);
		return $this->db->insert_id();
	}
	function update($primaryKey,$data){
		$this->db->where("id_m_mata_pelajaran",$primaryKey);
		$this->db->update('m_mata_pelajaran', $data);
		return $this->db->affected_rows();
	}
	function delete($primaryKey){
		$this->db->where("id_m_mata_pelajaran",$primaryKey);
		$this->db->delete('m_mata_pelajaran');
		return $this->db->affected_rows();
	}

}

?>
