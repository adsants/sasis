<?php

class M_jawaban_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){		
		$this->db->select("m_jawaban.*");						
		$this->db->select("m_soal.soal");						
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like("m_jawaban.jawaban",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		$this->db->join('m_soal','m_soal.id_m_soal = m_jawaban.id_m_soal');
		return $this->db->get("m_jawaban",$limit,$fromLimit)->result();
	}
	function getDataForSoal($where,$limit,$fromLimit,$orderby){			
		$this->db->select("m_jawaban.*");				
		if($where){
			$this->db->where($where);
		}		
		if($orderby){
			$this->db->order_by($orderby);
		}		
		return $this->db->get("m_jawaban",$limit,$fromLimit)->row();
	}
	
	function showDataForUjian($where,$random = null){			
		$this->db->select("m_jawaban.*");				
		if($where){
			$this->db->where($where);
		}		
		if($random == 'Y'){			
			$this->db->order_by('rand()');
		}	
		else{
			$this->db->order_by('id_m_jawaban');
		}		
		return $this->db->get("m_jawaban")->result();
	}
	function getData($primaryKey){			
		$this->db->select("m_jawaban.*");						
		$this->db->select("m_soal.soal");		
			
		$this->db->where("m_jawaban.id_m_jawaban",$primaryKey);	
		
		$this->db->join('m_soal','m_soal.id_m_soal = m_jawaban.id_m_soal');
		return $this->db->get("m_jawaban")->row();
	}
	
	function getDataForUjian($primaryKey){			
		$this->db->select("m_jawaban.*");						
		$this->db->where("m_jawaban.id_m_jawaban",$primaryKey);	
		return $this->db->get("m_jawaban")->row();
	}
	
	function getDataArray($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){		
		$this->db->select("m_jawaban.*");		
		if($where){
			$this->db->where($where);
		}
		if($order_by){
			$this->db->order_by($order_by);
		}	
		return $this->db->get("m_jawaban")->row();
	}
	function insert($data){
		$this->db->insert('m_jawaban', $data);
		return $this->db->insert_id();
	}
	function update($where,$data){
		if($where){
			$this->db->where($where);
		}	
		$this->db->update('m_jawaban', $data);
		return $this->db->affected_rows();
	}
	function delete($where){
		if($where){
			$this->db->where($where);
		}	
		$this->db->delete('m_jawaban');
		return $this->db->affected_rows();
	}
	
	

}

?>
