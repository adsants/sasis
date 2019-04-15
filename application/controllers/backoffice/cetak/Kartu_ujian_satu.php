<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kartu_ujian_satu extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->load->library('text_html');
		$this->load->library('encrypt_decrypt');
		$this->session_lib->admin();
		
		
		$this->load->model('m_ujian_model');
		$this->load->model('m_siswa_paket_ujian_model');
	} 

	public function index($id_m_ujian, $id_m_siswa_paket_ujian){		
		/// cek Hak Akses (security)
		$this->hak_akses->cek_edit($this->uri->segment(2));
			
		if(!$id_m_siswa_paket_ujian){			
			redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2'));
		}			
		
		
		$this->dataUjian	=	$this->m_ujian_model->getData($id_m_ujian);
		
		$this->siswaKelas	=	$this->m_siswa_paket_ujian_model->getData(array('m_siswa_paket_ujian.id_m_siswa_paket_ujian' => $id_m_siswa_paket_ujian));
		
		$this->load->model('profil_aplikasi_model');	
		$this->dataProfilAplikasi = $this->profil_aplikasi_model->getData();
	
		$this->load->view('cetak/kartu_ujian_satu_view');
	}
	
}
	
	
	
