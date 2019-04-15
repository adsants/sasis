<?php

class M_soal_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){		
		$this->db->select("m_soal.*");						
		$this->db->select("m_mata_pelajaran.id_m_mata_pelajaran");				
		$this->db->select("m_mata_pelajaran.nm_mata_pelajaran");				
		$this->db->select("m_paket_soal.nm_paket_soal");				
		if($where){
			$this->db->where($where);
		}		
		$this->db->where('m_soal.id_user_delete', null);
		if($like){
			$this->db->like("m_soal.soal",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		
		$this->db->join('m_paket_soal','m_paket_soal.id_m_paket_soal = m_soal.id_m_paket_soal');
		$this->db->join('m_mata_pelajaran','m_mata_pelajaran.id_m_mata_pelajaran = m_paket_soal.id_m_mata_pelajaran');
		return $this->db->get("m_soal",$limit,$fromLimit)->result();
	}
	
	function getData($primaryKey){			
		$this->db->select("m_soal.*");							
		$this->db->select("m_mata_pelajaran.id_m_mata_pelajaran");
		$this->db->select("m_mata_pelajaran.nm_mata_pelajaran");	
			
		$this->db->where("m_soal.id_m_soal",$primaryKey);	
		
		$this->db->where('m_soal.id_user_delete', null);
		
		$this->db->join('m_paket_soal','m_paket_soal.id_m_paket_soal = m_soal.id_m_paket_soal');
		$this->db->join('m_mata_pelajaran','m_mata_pelajaran.id_m_mata_pelajaran = m_paket_soal.id_m_mata_pelajaran');
		return $this->db->get("m_soal")->row();
	}
	function getDatSatuTable($primaryKey){			
		$this->db->select("m_soal.*");								
			
		$this->db->where("m_soal.id_m_soal",$primaryKey);	
		return $this->db->get("m_soal")->row();
	}
	
	function getDataByArray($where){			
		$this->db->select("m_soal.*");							
		$this->db->select("m_mata_pelajaran.id_m_mata_pelajaran");
		$this->db->select("m_mata_pelajaran.nm_mata_pelajaran");	
			
		if($where){
			$this->db->where($where);
		}	
		
		$this->db->where('m_soal.id_user_delete', null);
		
		$this->db->join('m_paket_soal','m_paket_soal.id_m_paket_soal = m_soal.id_m_paket_soal');
		$this->db->join('m_mata_pelajaran','m_mata_pelajaran.id_m_mata_pelajaran = m_paket_soal.id_m_mata_pelajaran');
		return $this->db->get("m_soal")->row();
	}
	
	function soalRandomDanTidak($where,$limit,$random = null,$jenis_soal){			
		$this->db->select('*');
		if($where){
			$this->db->where($where);
		}
		
		//var_dump($random);
		
		if($random){
			$this->db->order_by('rand()');			
		}
		
		if($jenis_soal == 'G'){
			$this->db->where('m_soal.jenis_soal', $jenis_soal);
		}
		else{
			$this->db->where('m_soal.jenis_soal', $jenis_soal);
		}
		
		$this->db->where('status_soal','A');		
				
		$this->db->limit($limit);		
		
		return $this->db->get("m_soal")->result();
	}
	
	function getSoalForSiswaUjian($where,$limit){			
		$this->db->select('*');
		if($where){
			$this->db->where($where);
		}
		
		$this->db->where('status_soal','A');
		$this->db->order_by('rand()');
		$this->db->limit($limit);		
		return $this->db->get("m_soal")->result();
	}
	
	function getSoalForSiswaUjianUrut($where,$limit){			
		$this->db->select('*');
		if($where){
			$this->db->where($where);
		}
		$this->db->where('status_soal','A');
		$this->db->order_by('urut_soal');
		$this->db->limit($limit);		
		return $this->db->get("m_soal")->result();
	}
	
	function getSoalForUjian($where){			
		$this->db->select('*');
		if($where){
			$this->db->where($where);
		}		
		return $this->db->get("m_soal")->row();
	}
	
	function insert($data){
		$this->db->insert('m_soal', $data);
		return $this->db->insert_id();
	}
	function update($primaryKey,$data){
		$this->db->where("id_m_soal",$primaryKey);
		$this->db->update('m_soal', $data);
		return $this->db->affected_rows();
	}
	function delete($primaryKey){
		$this->db->where("id_m_soal",$primaryKey);
		$this->db->delete('m_soal');
		return $this->db->affected_rows();
	}

}

?>
