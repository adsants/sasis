<?php

class Soal_siswa_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("soal_siswa.*");			
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like("soal_siswa.soal",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		return $this->db->get("soal_siswa",$limit,$fromLimit)->result();
	}
	
	function showDataForLaporan($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("soal_siswa.*");			
		$this->db->select("m_soal.soal");			
		$this->db->select("m_soal.jenis_soal");			
		$this->db->select("m_soal.kategori_soal");			
		$this->db->select("m_paket_soal.id_m_paket_soal");			
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like("soal_siswa.soal",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		
		$this->db->join('m_soal','m_soal.id_m_soal = soal_siswa.id_m_soal');
		$this->db->join('m_paket_soal','m_paket_soal.id_m_paket_soal = m_soal.id_m_paket_soal');
		return $this->db->get("soal_siswa",$limit,$fromLimit)->result();
	}
	
	function showDataLapDetail($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("soal_siswa.*");	
		$this->db->select("detail_siswa_paket_ujian.id_m_ujian_mapel");	
		
		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like("soal_siswa.nsoal_siswa",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		
		$this->db->join('detail_siswa_paket_ujian','detail_siswa_paket_ujian.id_detail_siswa_paket_ujian = soal_siswa.id_detail_siswa_paket_ujian');
		
		
		return $this->db->get("soal_siswa",$limit,$fromLimit)->result();
	}
	
	
	function showDataGrafik($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select('DISTINCT(soal_siswa.id_m_soal)');	
		$this->db->select('m_soal.soal');	
		
		if($where){
			$this->db->where($where);
		}			
		
		$this->db->join('m_soal','m_soal.id_m_soal = soal_siswa.id_m_soal');
		$this->db->join('detail_siswa_paket_ujian','detail_siswa_paket_ujian.id_detail_siswa_paket_ujian = soal_siswa.id_detail_siswa_paket_ujian');		
		
		return $this->db->get("soal_siswa",$limit,$fromLimit)->result();
	}
	
	function showJumlahDataGrafik($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select('soal_siswa.id_m_soal');
		
		if($where){
			$this->db->where($where);
		}			
		
		$this->db->join('m_soal','m_soal.id_m_soal = soal_siswa.id_m_soal');
		$this->db->join('detail_siswa_paket_ujian','detail_siswa_paket_ujian.id_detail_siswa_paket_ujian = soal_siswa.id_detail_siswa_paket_ujian');		
		
		return $this->db->get("soal_siswa",$limit,$fromLimit)->result();
	}
	
	function showDataForKoreksi($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){		
		$this->db->select("soal_siswa.*");		
		$this->db->select("m_soal.soal");		
		$this->db->select("m_soal.kategori_soal");		
		$this->db->select("m_soal.jenis_soal");		
		if($where){
			$this->db->where($where);
		}
		if($order_by){
			$this->db->order_by($order_by);
		}	
		
		$this->db->join('m_soal','m_soal.id_m_soal = soal_siswa.id_m_soal');
		
		return $this->db->get("soal_siswa")->row();
	}
	function getData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){		
		$this->db->select("soal_siswa.*");		
		if($where){
			$this->db->where($where);
		}
		if($order_by){
			$this->db->order_by($order_by);
		}	
		return $this->db->get("soal_siswa")->row();
	}
	
	function sumNilai($where = null){		
		$this->db->select("sum(nilai_jawaban) as nilai");		
		if($where){
			$this->db->where($where);
		}	
		return $this->db->get("soal_siswa")->row();
	}
	
	function insert($data){
		$this->db->insert('soal_siswa', $data);
		return $this->db->insert_id();
	}
	function update($where,$data){
		if($where){
			$this->db->where($where);
		}
		$this->db->update('soal_siswa', $data);
		return $this->db->affected_rows();
	}
	function delete($where){
		if($where){
			$this->db->where($where);
		}
		$this->db->delete('soal_siswa');
		return $this->db->affected_rows();
	}

}

?>
