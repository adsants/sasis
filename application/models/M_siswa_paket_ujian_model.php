<?php

class M_siswa_paket_ujian_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("m_siswa_paket_ujian.*");							
		if($where){
			$this->db->where($where);
		}		
		//$this->db->where('m_siswa_paket_ujian.id_user_delete', null);
		if($like){
			$this->db->like("m_siswa_paket_ujian.nipd",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		return $this->db->get("m_siswa_paket_ujian",$limit,$fromLimit)->result();
	}
	
	function showDataKelas($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->distinct();
		$this->db->select('kelas');
					
		if($where){
			$this->db->where($where);
		}		
		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		return $this->db->get("m_siswa_paket_ujian",$limit,$fromLimit)->result();
	}
	
	function getData($where){			
		$this->db->select("m_siswa_paket_ujian.*");					
		
		if($where){
			$this->db->where($where);
		}
		
		return $this->db->get("m_siswa_paket_ujian")->row();
	}
	
	
	function insert($data){
		$this->db->insert('m_siswa_paket_ujian', $data);
		return $this->db->insert_id();
	}
	function update($where,$data){
		if($where){
			$this->db->where($where);
		}
		$this->db->update('m_siswa_paket_ujian', $data);
		return $this->db->affected_rows();
	}
	function delete($where){
		if($where){
			$this->db->where($where);
		}
		$this->db->delete('m_siswa_paket_ujian');
		return $this->db->affected_rows();
	}

}

?>
