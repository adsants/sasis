<?php

class M_menu_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("*");			
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		
		$this->db->order_by("urutan_menu");
		return $this->db->get("m_menu",$limit,$fromLimit)->result();
	}
	
	function getData($where = null){			
		$this->db->select("*");			
		if($where){
			$this->db->where($where);
		}		
		return $this->db->get("m_menu")->row();
	}
	
	function getDataAkses($where = null){			
		$this->db->select("*");			
		$this->db->like('link_menu', $where, 'before');
				
		return $this->db->get("m_menu")->row();
	}
	

}

?>
