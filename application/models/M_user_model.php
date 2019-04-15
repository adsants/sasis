<?php

class M_user_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("m_user.id_user");				
		$this->db->select("m_user.aktif_user");				
		$this->db->select("m_user.user_name");				
		$this->db->select("m_user.pass_word");		
		$this->db->select("m_user.nama_user");		
		$this->db->select("m_user.id_kategori_user");				
		$this->db->select("date_format(m_user.login_akhir,'%d-%m-%Y %H:%i') as login_akhir_indo");				
		$this->db->select("m_kategori_user.nm_kategori_user");		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like("m_user.user_name",$like);
		}		
		
		//$this->db->where('m_user.id_user_delete' , null);	
		if($order_by){
			$this->db->order_by($order_by);
		}			
		$this->db->join("m_kategori_user","m_kategori_user.id_kategori_user = m_user.id_kategori_user");
		return $this->db->get("m_user",$limit,$fromLimit)->result();
	}
	
	function getData($where = null){
		$this->db->select("m_user.id_user");			
		$this->db->select("m_user.user_name");		
		$this->db->select("m_user.nama_user");		
		$this->db->select("date_format(m_user.login_akhir,'%d-%m-%Y %H:%i') as login_akhir_indo");	
		$this->db->select("m_user.pass_word");			
		$this->db->select("m_user.aktif_user");						
		$this->db->select("m_user.pass_word");		
		$this->db->select("m_user.id_kategori_user");				
		$this->db->select("m_user.id_kategori_user");			
		$this->db->select("m_kategori_user.nm_kategori_user");	
		if($where){
			$this->db->where($where);
		}		
		
		$this->db->join("m_kategori_user","m_kategori_user.id_kategori_user = m_user.id_kategori_user");
		return $this->db->get("m_user")->row();
	}
	
	function insert($data){
		$this->db->insert('m_user', $data);
		return $this->db->insert_id();
	}
	function update($primaryKey,$data){
		$this->db->where("id_user",$primaryKey);
		$this->db->update('m_user', $data);
		return $this->db->affected_rows();
	}
	function updateFromPegawai($primaryKey,$data){
		$this->db->where("id_pegawai",$primaryKey);
		$this->db->update('m_user', $data);
		return $this->db->affected_rows();
	}
	function delete($primaryKey){
		$this->db->where("id_user",$primaryKey);
		$this->db->delete('m_user');
		return $this->db->affected_rows();
	}
	

}

?>
