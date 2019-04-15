<?php

class Kategori_user_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
		//$this->load->model('log_model');
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
		return $this->db->get("m_kategori_user",$limit,$fromLimit)->result();
	}
	function showDataNotdeveloper($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("*");		
		if($where){
			$this->db->where($where);
		}
		$this->db->where_not_in('id_kategori_user' , '1');		
		if($like){
			$this->db->like($like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		return $this->db->get("m_kategori_user",$limit,$fromLimit)->result();
	}
	
	function getData($where){
		$this->db->select("*");		
		$this->db->where($where);		
		return $this->db->get("m_kategori_user")->row();
	}
	
	function insert($data){
		$this->db->insert('m_kategori_user', $data);	
		return $this->db->insert_id();
	}
	function update($primaryKey,$data){		
		$this->db->where("id_kategori_user",$primaryKey);
		$this->db->update('m_kategori_user', $data);
	}
	function delete($primaryKey){
		$this->db->where("id_kategori_user",$primaryKey);
		$this->db->delete('m_kategori_user');		
	}
}

?>
