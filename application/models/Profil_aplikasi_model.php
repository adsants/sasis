<?php

class  Profil_aplikasi_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	
	function getData(){			
		$this->db->select("profil_aplikasi.*");			
		$this->db->select("date_format(profil_aplikasi.tanggal ,'%d-%m-%Y') as tanggal_indo");			
		return $this->db->get("profil_aplikasi")->row();
	}
	
	
	function update($data){
		$this->db->update('profil_aplikasi', $data);
		return $this->db->affected_rows();
	}

}

?>
