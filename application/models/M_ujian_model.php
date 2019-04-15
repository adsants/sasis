<?php

class M_ujian_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("m_ujian.*");							
		if($where){
			$this->db->where($where);
		}		
		$this->db->where('m_ujian.id_user_delete', null);
		if($like){
			$this->db->like("m_ujian.nm_ujian",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		return $this->db->get("m_ujian",$limit,$fromLimit)->result();
	}
	
	function getData($primaryKey){			
		$this->db->select("m_ujian.*");					
		
		$this->db->where('m_ujian.id_user_delete', null);
		$this->db->where("m_ujian.id_m_ujian",$primaryKey);	
		
		return $this->db->get("m_ujian")->row();
	}
	function insert($data){
		$this->db->insert('m_ujian', $data);
		return $this->db->insert_id();
	}
	function update($primaryKey,$data){
		$this->db->where("id_m_ujian",$primaryKey);
		$this->db->update('m_ujian', $data);
		return $this->db->affected_rows();
	}
	function delete($primaryKey){
		$this->db->where("id_m_ujian",$primaryKey);
		$this->db->delete('m_ujian');
		return $this->db->affected_rows();
	}

}

?>
