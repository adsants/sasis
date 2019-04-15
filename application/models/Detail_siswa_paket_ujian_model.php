<?php

class Detail_siswa_paket_ujian_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		
	}	
	
	function showData($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("detail_siswa_paket_ujian.*");							
		if($where){
			$this->db->where($where);
		}		
		//$this->db->where('detail_siswa_paket_ujian.id_user_delete', null);
		if($like){
			$this->db->like("detail_siswa_paket_ujian.nipd",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		return $this->db->get("detail_siswa_paket_ujian",$limit,$fromLimit)->result();
	}
	
	function showDataForLaporan($where = null,$like = null,$order_by = null,$limit = null, $fromLimit=null){
		
		$this->db->select("detail_siswa_paket_ujian.*");							
		$this->db->select("m_siswa_paket_ujian.nama");							
		$this->db->select("m_siswa_paket_ujian.nisn");							
		$this->db->select("m_siswa_paket_ujian.nipd");							
		$this->db->select("m_siswa_paket_ujian.kelas");								
		$this->db->select("date_format(detail_siswa_paket_ujian.tgl_mulai_pengerjaan,'%d-%m-%Y %H:%i') as tgl_mulai_pengerjaan_indo ");										
		$this->db->select("date_format(detail_siswa_paket_ujian.tgl_akhir_pengerjaan,'%d-%m-%Y %H:%i') as tgl_akhir_pengerjaan_indo ");			
		
		if($where){
			$this->db->where($where);
		}		
		if($like){
			$this->db->like("detail_siswa_paket_ujian.nipd",$like);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		
		$this->db->join('m_siswa_paket_ujian' , 'm_siswa_paket_ujian.id_m_siswa_paket_ujian = detail_siswa_paket_ujian.id_m_siswa_paket_ujian');
		
		return $this->db->get("detail_siswa_paket_ujian",$limit,$fromLimit)->result();
	}
	
	function showDataForDashboardSiswa($where = null,$like = null,$order_by = null){
		
		$this->db->select("detail_siswa_paket_ujian.*");							
		$this->db->select("m_mata_pelajaran.nm_mata_pelajaran");							
		$this->db->select("m_ujian_mapel.menit_pengerjaan");							
		$this->db->select("m_ujian_mapel.jml_soal_ganda");							
		$this->db->select("m_ujian_mapel.jml_soal_esay");							
		$this->db->select("m_ujian_mapel.id_m_ujian");							
		$this->db->select("date_format(m_ujian_mapel.tgl_pengerjaan,'%d-%m-%Y %H:%i') as tgl_pengerjaan_indo ");							
		if($where){
			$this->db->where($where);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		$this->db->join('m_ujian_mapel' , 'm_ujian_mapel.id_m_ujian_mapel = detail_siswa_paket_ujian.id_m_ujian_mapel');
		$this->db->join('m_mata_pelajaran' , 'm_ujian_mapel.id_m_mata_pelajaran = m_mata_pelajaran.id_m_mata_pelajaran');
		$this->db->join('m_ujian' , 'm_ujian_mapel.id_m_ujian = m_ujian.id_m_ujian');
		
		$this->db->where('m_ujian_mapel.id_user_delete', null);
		$this->db->where('m_ujian_mapel.status_ujian', 'A');
		$this->db->where('m_ujian.id_user_delete', null);		
		$this->db->where('detail_siswa_paket_ujian.tgl_akhir_pengerjaan', null);		
		
		$this->db->where("detail_siswa_paket_ujian.id_m_siswa_paket_ujian" , $this->session->userdata('id_m_siswa_paket_ujian'));		
		
		return $this->db->get("detail_siswa_paket_ujian")->result();
	}
	
	function showDataForRiwayat($where = null,$like = null,$order_by = null){
		
		$this->db->select("detail_siswa_paket_ujian.*");							
		$this->db->select("m_mata_pelajaran.nm_mata_pelajaran");							
		$this->db->select("m_ujian_mapel.menit_pengerjaan");							
		$this->db->select("m_ujian_mapel.jml_soal_ganda");							
		$this->db->select("m_ujian_mapel.jml_soal_esay");							
		$this->db->select("m_ujian_mapel.id_m_ujian");							
		$this->db->select("date_format(m_ujian_mapel.tgl_pengerjaan,'%d-%m-%Y %H:%i') as tgl_pengerjaan_indo ");							
		if($where){
			$this->db->where($where);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		$this->db->join('m_ujian_mapel' , 'm_ujian_mapel.id_m_ujian_mapel = detail_siswa_paket_ujian.id_m_ujian_mapel');
		$this->db->join('m_mata_pelajaran' , 'm_ujian_mapel.id_m_mata_pelajaran = m_mata_pelajaran.id_m_mata_pelajaran');
		$this->db->join('m_ujian' , 'm_ujian_mapel.id_m_ujian = m_ujian.id_m_ujian');
		
		$this->db->where('m_ujian_mapel.id_user_delete', null);
		$this->db->where('m_ujian_mapel.status_ujian', 'A');
		$this->db->where('m_ujian.id_user_delete', null);		
		$this->db->where('detail_siswa_paket_ujian.tgl_akhir_pengerjaan is not null', null);		
		
		$this->db->where("detail_siswa_paket_ujian.id_m_siswa_paket_ujian" , $this->session->userdata('id_m_siswa_paket_ujian'));		
		
		return $this->db->get("detail_siswa_paket_ujian")->result();
	}
	
	
	function showDataForResetDevice($where = null,$like = null,$order_by = null){
		
		$this->db->select("detail_siswa_paket_ujian.*");							
		$this->db->select("m_mata_pelajaran.nm_mata_pelajaran");														
		if($where){
			$this->db->where($where);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		$this->db->join('m_ujian_mapel' , 'm_ujian_mapel.id_m_ujian_mapel = detail_siswa_paket_ujian.id_m_ujian_mapel');
		$this->db->join('m_mata_pelajaran' , 'm_ujian_mapel.id_m_mata_pelajaran = m_mata_pelajaran.id_m_mata_pelajaran');
		
		$this->db->where('m_ujian_mapel.id_user_delete', null);
		$this->db->where('m_ujian_mapel.status_ujian', 'A');
		return $this->db->get("detail_siswa_paket_ujian")->result();
	}
	
	
	function loginUjian($where = null,$like = null,$order_by = null){
		
		$this->db->select("detail_siswa_paket_ujian.*");									
		$this->db->select("m_ujian_mapel.menit_pengerjaan");							
		$this->db->select("m_ujian_mapel.jml_soal_ganda");							
		$this->db->select("m_ujian_mapel.jml_soal_esay");							
		$this->db->select("m_ujian_mapel.id_m_ujian");														
		if($where){
			$this->db->where($where);
		}		
		if($order_by){
			$this->db->order_by($order_by);
		}			
		$this->db->join('m_ujian_mapel' , 'm_ujian_mapel.id_m_ujian_mapel = detail_siswa_paket_ujian.id_m_ujian_mapel');
		$this->db->join('m_ujian' , 'm_ujian_mapel.id_m_ujian = m_ujian.id_m_ujian');
		
		$this->db->where('m_ujian_mapel.id_user_delete', null);
		$this->db->where('m_ujian_mapel.status_ujian', 'A');
		$this->db->where('m_ujian.id_user_delete', null);		
		$this->db->where('detail_siswa_paket_ujian.tgl_akhir_pengerjaan', null);		
		
		$this->db->where("detail_siswa_paket_ujian.id_m_siswa_paket_ujian" , $this->session->userdata('id_m_siswa_paket_ujian'));		
		
		return $this->db->get("detail_siswa_paket_ujian")->row();
	}
	
	function getData($where){			
		$this->db->select("detail_siswa_paket_ujian.*");							
		$this->db->select("m_siswa_paket_ujian.nama");							
		$this->db->select("m_siswa_paket_ujian.kelas");							
		$this->db->select("m_siswa_paket_ujian.nisn");							
		$this->db->select("m_siswa_paket_ujian.nipd");							
		$this->db->select("date_format(detail_siswa_paket_ujian.tgl_mulai_pengerjaan,'%d-%m-%Y %H:%i') as tgl_mulai_pengerjaan_indo ");										
		$this->db->select("date_format(detail_siswa_paket_ujian.tgl_akhir_pengerjaan,'%d-%m-%Y %H:%i') as tgl_akhir_pengerjaan_indo ");						
		
		if($where){
			$this->db->where($where);
		}
		
		$this->db->join('m_siswa_paket_ujian' , 'm_siswa_paket_ujian.id_m_siswa_paket_ujian = detail_siswa_paket_ujian.id_m_siswa_paket_ujian');
		
		return $this->db->get("detail_siswa_paket_ujian")->row();
	}
	
	
	function getDataForUjian($where){			
		$this->db->select("detail_siswa_paket_ujian.*");					
		
		if($where){
			$this->db->where($where);
		}
		return $this->db->get("detail_siswa_paket_ujian")->row();
	}
	
	
	function nilaiAllMapel($where){			
		$this->db->select("sum(detail_siswa_paket_ujian.nilai) as nilai");	
		if($where){
			$this->db->where($where);
		}
		
		return $this->db->get("detail_siswa_paket_ujian")->row();
	}
	
	function insert($data){
		$this->db->insert('detail_siswa_paket_ujian', $data);
		return $this->db->insert_id();
	}
	function update($where,$data){
		if($where){
			$this->db->where($where);
		}
		$this->db->update('detail_siswa_paket_ujian', $data);
		return $this->db->affected_rows();
	}
	function delete($where){
		if($where){
			$this->db->where($where);
		}
		$this->db->delete('detail_siswa_paket_ujian');
		return $this->db->affected_rows();
	}

}

?>
