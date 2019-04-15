<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {	

	public function __construct() {
		parent::__construct();
		
		/// library otomatis untuk Hak Akses
		$this->load->library('session_lib');
		$this->session_lib->admin();
		
		$this->load->model('m_user_model');
		$this->load->model('kategori_user_model');
		//$this->load->model('m_pegawai_model');
	} 

	public function index(){
		
		$this->load->library('encrypt_decrypt');
		
		$this->template_view->load_admin_view('template/dashboard_view');
	}
	public function profil(){
		
		
		
		$this->dataForUpdate = $this->m_user_model->getData(array('m_user.id_user' => $this->session->userdata('id_user')));
		
		$this->load->library('encrypt_decrypt');
		
		if($this->input->post('user_name')){
			
			$this->form_validation->set_rules('user_name', 'Username', 'required');
			$this->form_validation->set_rules('pass_word', 'Password', 'required');
			
			if ($this->form_validation->run() == FALSE)	{
				$this->notice->warning(validation_errors());	
				$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/profil");
			}
			else{							
			
				$checkUsernameSama	=	$this->m_user_model->getData(array('m_user.user_name' => $this->input->post('user_name') , "m_user.id_user != '".$this->session->userdata('id_user')."'" => null));
				
				if($checkUsernameSama){
					$this->notice->warning('Proses Ubah Profil Gagal, dikarenakan username <b>'.$this->input->post('user_name').'</b> telah digunakan. Silahkan ganti Username !');	
					$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/profil");
				}
				
				if ( preg_match('/\s/',$this->input->post('pass_word')) ) {
					$this->notice->warning('Proses Ubah Profil Gagal, dikarenakan Password tidak boleh ada spasi');	
					$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/profil");
				}
				
				if ( preg_match('/\s/',$this->input->post('user_name')) ) {
					$this->notice->warning('Proses Ubah Profil Gagal, dikarenakan Username tidak boleh ada spasi');	
					$this->session->set_flashdata($this->input->post());
				redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/profil");
				}
				
				if($_FILES['foto_pegawai']['name']){
					$config['upload_path']          = './upload/pegawai/';
					$config['allowed_types']        = 'jpg|jpeg|png';
					$config['max_size'] 			= '1000';


					$this->load->library('upload', $config);

					if ( !$this->upload->do_upload('foto_pegawai')){		
						$this->session->set_flashdata($this->input->post());	
						
						$this->notice->warning($this->upload->display_errors());					
						redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/profil");
					}
					else{
						$fileUpload = $this->upload->data();
						
						//var_dump( $fileUpload['file_ext']);
						//exit();
					
						$final_file_name = $this->input->post('nip_pegawai')."-".time().''.$fileUpload['file_ext'];
						rename($fileUpload['full_path'],$fileUpload['file_path'].$final_file_name);
										
						$dataPegawai['photo'] = $final_file_name;
						
						
						$this->m_pegawai_model->update($this->session->userdata('id_pegawai'),$dataPegawai);
					}
				}
				
				
				$data['user_name'] 				= $this->input->post('user_name');				
				$this->load->library('encrypt_decrypt');
				$pass							=	$this->encrypt_decrypt->getText('encrypt', $this->input->post('pass_word'));
				$data['pass_word'] 				= 	$pass;	
			
				$returnUpdate = $this->m_user_model->update($this->session->userdata('id_user'),$data);
				
				if($returnUpdate){
					$this->notice->success("Proses Ubah Data Profil berhasil. Silahkan Login dengan Username dan Password baru Anda.");				
					redirect(base_url().'/admin');
				}
				else{				
					$this->session->set_flashdata($this->input->post());
					$this->notice->warning("Proses Ubah Profil Gagal, silahkan cek inputan Anda.");				
					redirect($this->template_view->base_url_admin()."/".$this->uri->segment('2')."/profil");
				}
			}	
		}
		
		$this->template_view->load_admin_view('template/profil_view');
	}
	
	
	
	
}
