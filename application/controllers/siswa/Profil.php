<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->session_lib->siswa();
		
		
		$this->load->library('text_html');
		
		$this->load->model('m_siswa_model');
	} 

	public function index(){
		
		$this->load->library('encrypt_decrypt');
		$this->dataSiswa		=	$this->m_siswa_model->getData($this->session->userdata('id_siswa'));
		
		if($this->input->post('pass_word')){
			
			$this->form_validation->set_rules('pass_word', 'Password', 'required');
			
			if ($this->form_validation->run() == FALSE)	{
				$this->notice->warning(validation_errors());	
				$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_siswa()."/".$this->uri->segment('2'));
			}
			else{							
			
				if ( preg_match('/\s/',$this->input->post('pass_word')) ) {
					$this->notice->warning('Proses Ubah Profil Gagal, dikarenakan Password tidak boleh ada spasi');	
					$this->session->set_flashdata($this->input->post());
					redirect($this->template_view->base_url_siswa()."/".$this->uri->segment('2'));
				}
				
				
				if($_FILES['foto_siswa']['name']){
					$config['upload_path']          = './upload/siswa/';
					$config['allowed_types']        = 'jpg|jpeg|png';
					$config['max_size'] 			= '1000';


					$this->load->library('upload', $config);

					if ( !$this->upload->do_upload('foto_siswa')){		
						$this->session->set_flashdata($this->input->post());	
						
						$this->notice->warning($this->upload->display_errors());					
						redirect($this->template_view->base_url_siswa()."/".$this->uri->segment('2'));
					}
					else{
						$fileUpload = $this->upload->data();
					
						$final_file_name = $this->session->userdata('nis')."-".time().''.$fileUpload['file_ext'];
						rename($fileUpload['full_path'],$fileUpload['file_path'].$final_file_name);
										
						$dataSiswa['photo'] = $final_file_name;
						
						
					}
				}
				
							
				$this->load->library('encrypt_decrypt');
				$pass						=	$this->encrypt_decrypt->getText('encrypt', $this->input->post('pass_word'));
				$dataSiswa['password'] 		= 	$pass;	
			
				$returnUpdate = $this->m_siswa_model->update($this->session->userdata('id_siswa'),$dataSiswa);
				
				if($returnUpdate){
					$this->notice->success("Proses Ubah Data Profil berhasil. Silahkan Login dengan Nomor Induk Siswa dan Password baru Anda.");			
					redirect(base_url().'/login');
				}
				else{				
					$this->session->set_flashdata($this->input->post());
					$this->notice->warning("Proses Ubah Profil Gagal, silahkan cek inputan Anda.");				
					redirect($this->template_view->base_url_siswa()."/".$this->uri->segment('2'));
				}
			}	
		}
		
		$this->template_view->load_siswa_view('siswa/profil_view');
	}
	
	
	
	
}
