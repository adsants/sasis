<?php

class T_hak_akses_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("t_hak_akses.*");		
		$this->db->select("m_kategori_user.nm_kategori_user");		
		$this->db->select("m_menu.id_parent_menu");			
		$this->db->select("m_menu.nm_menu");			
		$this->db->select("m_menu.judul_menu");			
		$this->db->select("m_menu.link_menu");			
		$this->db->select("m_menu.icon_menu");			
		$this->db->select("m_menu.tingkat_menu");			
		$this->db->select("m_menu.urutan_menu");			
		$this->db->select("m_menu.id_parent_menu");		

		$this->db->where("m_menu.aktif_menu", "Y");
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like($like);
		}		
		
		$this->db->order_by('m_menu.urutan_menu');
			
		$this->db->join("m_menu","m_menu.id_menu = t_hak_akses.id_menu");
		$this->db->join("m_kategori_user","m_kategori_user.id_kategori_user = t_hak_akses.id_kategori_user");
		return $this->db->get("t_hak_akses",$limit,$fromLimit)->result();
	}
	
	function getData($where = null){
		$this->db->select("t_hak_akses.*");		
		$this->db->select("m_kategori_user.nm_kategori_user");		
		$this->db->select("m_menu.id_parent_menu");			
		$this->db->select("m_menu.nm_menu");			
		$this->db->select("m_menu.judul_menu");			
		$this->db->select("m_menu.link_menu");			
		$this->db->select("m_menu.icon_menu");			
		$this->db->select("m_menu.tingkat_menu");			
		$this->db->select("m_menu.urutan_menu");			
		$this->db->select("m_menu.id_parent_menu");		

		$this->db->where("m_menu.aktif_menu", "Y");	
		if($where){
			$this->db->where($where);
		}			
		
		
		
		$this->db->join("m_menu","m_menu.id_menu = t_hak_akses.id_menu");
		$this->db->join("m_kategori_user","m_kategori_user.id_kategori_user = t_hak_akses.id_kategori_user");
		return $this->db->get("t_hak_akses")->row();
	}
	
	function insert($data){
		$this->db->insert('t_hak_akses', $data);
		return $this->db->insert_id();
	}
	function update($primaryKey,$data){
		$this->db->where("id_t_hak_akses",$primaryKey);
		$this->db->update('t_hak_akses', $data);
		return $this->db->affected_rows();
	}
	function delete($primaryKey){
		$this->db->where("id_kategori_user",$primaryKey);
		$this->db->delete('t_hak_akses');
		return $this->db->affected_rows();
	}
	

}

?>
