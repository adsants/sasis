<?php

class M_ujian_mapel_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("m_ujian_mapel.*");							
		$this->db->select("m_mata_pelajaran.nm_mata_pelajaran");							
		$this->db->select("date_format(m_ujian_mapel.tgl_pengerjaan , '%d-%m-%Y %H:%i') as tgl_pengerjaan_indo");	
		$this->db->select("date_format(m_ujian_mapel.tgl_akhir_pengerjaan , '%d-%m-%Y %H:%i') as tgl_akhir_pengerjaan_indo");							
		if($where){
			$this->db->where($where);
		}		
		$this->db->where('m_ujian_mapel.id_user_delete', null);
		if($like){
			$this->db->like("m_ujian_mapel.nm_ujian_mapel",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		$this->db->join('m_mata_pelajaran','m_ujian_mapel.id_m_mata_pelajaran = m_mata_pelajaran.id_m_mata_pelajaran');
		return $this->db->get("m_ujian_mapel",$limit,$fromLimit)->result();
	}
	
	function getData($where){			
		$this->db->select("m_ujian_mapel.*");		
		$this->db->select("m_ujian.nm_ujian");		
		$this->db->select("m_mata_pelajaran.nm_mata_pelajaran");							
		$this->db->select("date_format(m_ujian_mapel.tgl_pengerjaan , '%d-%m-%Y %H:%i') as tgl_pengerjaan_indo");	
		$this->db->select("date_format(m_ujian_mapel.tgl_akhir_pengerjaan , '%d-%m-%Y %H:%i') as tgl_akhir_pengerjaan_indo");				
		if($where){
			$this->db->where($where);
		}
		$this->db->join('m_mata_pelajaran','m_ujian_mapel.id_m_mata_pelajaran = m_mata_pelajaran.id_m_mata_pelajaran');
		$this->db->join('m_ujian','m_ujian.id_m_ujian = m_ujian_mapel.id_m_ujian');
		
		return $this->db->get("m_ujian_mapel")->row();
	}
	
	function getDataForUjian($where){			
		$this->db->select("m_ujian_mapel.*");									
		$this->db->select("date_format(m_ujian_mapel.tgl_pengerjaan , '%d-%m-%Y %H:%i') as tgl_pengerjaan_indo");	
		$this->db->select("date_format(m_ujian_mapel.tgl_akhir_pengerjaan , '%d-%m-%Y %H:%i') as tgl_akhir_pengerjaan_indo");					
		
		if($where){
			$this->db->where($where);
		}
	
		return $this->db->get("m_ujian_mapel")->row();
	}
	function insert($data){
		$this->db->insert('m_ujian_mapel', $data);
		return $this->db->insert_id();
	}
	function update($primaryKey,$data){
		$this->db->where("id_m_ujian_mapel",$primaryKey);
		$this->db->update('m_ujian_mapel', $data);
		return $this->db->affected_rows();
	}
	function delete($primaryKey){
		$this->db->where("id_m_ujian_mapel",$primaryKey);
		$this->db->delete('m_ujian_mapel');
		return $this->db->affected_rows();
	}

}

?>
