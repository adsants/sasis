<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
	
	

	public function __construct() {
		parent::__construct();		
		$this->load->library("notice");		
		$this->load->library("encrypt_decrypt");
		
		$this->load->model("m_siswa_paket_ujian_model");		
	} 

	public function index(){		
	
		//var_dump($this->template_view->mac());
	
		//var_dump( $this->encrypt_decrypt->getText( 'encrypt','12345'));
		$this->template_view->load_view('template/login_siswa_view');
	}
	
	public function authentication(){
		
		$this->form_validation->set_rules('nipd', 'Nomor Induk Peserta Didik', 'required');
		$this->form_validation->set_rules('pass_word', 'Password', 'required');
		
		if ($this->form_validation->run() == FALSE)	{
			$this->notice->warning(validation_errors());	
			redirect('login');
		}
		else{							
			$pass			=	$this->encrypt_decrypt->getText( 'encrypt', $this->input->post('pass_word'));
			$where			=	array('nipd' => $this->input->post('nipd') , 'password' => $this->input->post('pass_word'));
			$cekDataSiswa	=	$this->m_siswa_paket_ujian_model->getData($where,'','id_m_siswa_paket_ujian desc');
			//var_dump($cekDataSiswa);exit();
			if($cekDataSiswa){
				$this->session->set_userdata('id_m_siswa_paket_ujian', $cekDataSiswa->id_m_siswa_paket_ujian);
				$this->session->set_userdata('nipd', $cekDataSiswa->nipd);
				$this->session->set_userdata('nm_siswa', $cekDataSiswa->nama);
				$this->session->set_userdata('kelas', $cekDataSiswa->kelas);
				$this->session->set_userdata('id_m_ujian', $cekDataSiswa->id_m_ujian);
				
				redirect('siswa/dashboard');
			}
			else{
				$this->session->set_flashdata($this->input->post());
				
				$this->session->unset_userdata('id_pegawai');
				 
				$this->notice->warning("Gagal Login, silahkan inputkan Nomot Induk Peserta Didik dan Password dengan Benar !");	
				
				redirect('Login');
			}
		}
	}
	
	
}
